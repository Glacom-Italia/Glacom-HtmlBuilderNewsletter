<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\Core\CorePage;
use App\Models\Event\EventItem;
use App\Models\Magazine\MagazineNews;
use App\Models\Magazine\MagazineGroup;
use App\Models\Magazine\MagazineTag;
use App\Models\Event\EventCategory;
use App\Http\Controllers\Event\EventController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/app-config', function (){
    return config('app');
});

Route::post('/load-module-filter', function (Request $request) {
    $filter = array();

    if($request->module == 'magazine'){
        $filter['group'] = MagazineGroup::where('is_active', '1')->orderBy('name', 'asc')->get()->toArray();
        $filter['tag'] = MagazineTag::where('is_active', '1')->orderBy('name', 'asc')->get()->toArray();
        
    }elseif($request->module == 'event'){
        $filter['group'] = EventCategory::where('is_active', '1')->orderBy('name', 'asc')->get()->toArray();
    }

    return $filter;
});

Route::post('/load-module-data', function (Request $request) {
    //DB::enableQueryLog();
    //$start = microtime(true);
    //echo 'start > '.$start.' | ';

    $reqTmpGroup = $request->group;
    if(is_string($reqTmpGroup) && trim($reqTmpGroup) != ''){
        $reqTmpGroup = explode(',', $reqTmpGroup);
    }elseif(is_string($reqTmpGroup) && trim($reqTmpGroup) == ''){
        $reqTmpGroup = array();
    }    

    $reqTmpTag = $request->tag;
    if(is_string($reqTmpTag) && trim($reqTmpTag) != ''){
        $reqTmpTag = explode(',', $reqTmpTag);
    }elseif(is_string($reqTmpTag) && trim($reqTmpTag) == ''){
        $reqTmpTag = array();
    }
    
    // recupera i dati filtrati 
    $data = array();
    if($request->module == 'magazine'){
        
        $magazineNews = MagazineNews::where('is_active', '1')
            ->where('status', '3')
            ->where('publish_datetime', '<=', DB::raw('now()'));
            //with(['magazineGroup', 'magazineTag'])

        if(!empty($reqTmpGroup) && count($reqTmpGroup)>0){
            $magazineNews->whereHas('magazineGroup', function(Builder $query) use( $reqTmpGroup ){
                $query->whereIn('magazine_groups.id', $reqTmpGroup);
            });
        }

        if(!empty($reqTmpTag) && count($reqTmpTag)>0){
            $magazineNews->whereHas('magazineTag', function(Builder $query) use( $reqTmpTag ){
                $query->whereIn('magazine_tags.id', $reqTmpTag);
            });
        }

        if(!empty($request->dt_from)){
            $magazineNews->whereDate('publish_datetime', '>=', $request->dt_from);
        }

        if(!empty($request->dt_to)){
            $magazineNews->whereDate('publish_datetime', '<=', $request->dt_to);
        }

        $data = $magazineNews->get(); //->toArray()

    }elseif($request->module == 'event'){
        $eventController = new EventController;
        if(!$request->dt_from) $request->dt_from = date('Y-m-d');
        if(!$request->dt_to) $request->dt_to = null;
        $data = $eventController->findEventItemByDate($request->dt_from, $request->dt_to, false, $reqTmpGroup);
    }
    //dd(DB::getQueryLog());
    //$end1 = microtime(true);
    //echo 'dopo query >  '.$end1 - $start.' | ';

    // recupera template disponibili dalla directory dedicata
    $templates=array();
    $dir=base_path('resources/views/newsletter');
    if($dh = opendir($dir)){
        while(($entry = readdir($dh)) !== false){
            if($entry != "." && $entry != ".." && !is_dir($dir.'/'.$entry)){
                $templates[] = substr($entry, 0, strpos($entry, '.'));
            }
        }    
        closedir($dh);
    }
    //$end2 = microtime(true);
    //echo 'dopo opendir >  '.$end2 - $start.' | ';
    //dd();
    return [
        'moduleData' => $data,
        'template' => $templates
    ];
});

Route::post('/load-template', function (Request $request) {
    //$start = microtime(true);
    //echo 'start > '.$start.' | ';

    $reqTmpData = $request->datas;
    if(is_string($reqTmpData) && trim($reqTmpData) != ''){
        $reqTmpData = explode(',', $reqTmpData);
    }elseif(is_string($reqTmpData) && trim($reqTmpData) == ''){
        $reqTmpData = [];
    }
    
    //dd('pre page');
    $homePage = CorePage::where('is_active', '1')
        ->where('is_homepage', '1')
        ->first();

    //dd('pre select');
    // recupera i dati selezionati dall'utente
    if($request->module == 'magazine'){
        $outData = MagazineNews::where('is_active', '1')
            ->where('status', '3')
            ->where('publish_datetime', '<=', DB::raw('now()'))
            ->whereIn('id', $reqTmpData)
            ->get();
            //with(['magazineGroup'])

    }elseif($request->module == 'event'){
        $outData = EventItem::where('is_active', '1')
            ->whereIn('id', $reqTmpData)
            ->get();
    }
    //$end1 = microtime(true);
    //echo 'dopo query >  '.$end1 - $start.' | ';
    //dd('pre props');

    $outData2 = $outData->toArray();
    //$end4 = microtime(true);
    //echo 'dopo toarray >  '.$end4 - $start.' | ';

    $props = [
        "config" => config('app'),
        "homePage" => $homePage->toArray(), 
        "locale" => $request->lang,
        "data" => $outData2,
    ];
    //$end2 = microtime(true);
    //echo 'dopo props >  '.$end2 - $start.' | ';
    //dd(var_dump($props));
    $view = View::make('newsletter.'.$request->template, $props);
    //$end3 = microtime(true);
    //echo 'dopo view >  '.$end3 - $start.' | ';
    //dd($view->render());
    return $view->render();
});

Route::post('/', function (Request $request) {
    return [
        'message' => "This is a message from html builder newsletter API routes",
    ];
});

// Route::get('/', function (Request $request) {
//     //
// });

<template>
  <div>
    <Head title="Newsletter Html Builder" />

    <Heading class="mb-6">Newsletter Html Builder</Heading>

    <!--Card class="mb-6 flex flex-col items-center justify-center" style="min-height: 300px">
      <svg class="spin fill-80 mb-6" width="69" height="72" viewBox="0 0 23 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M20.12 20.455A12.184 12.184 0 0 1 11.5 24a12.18 12.18 0 0 1-9.333-4.319c4.772 3.933 11.88 3.687 16.36-.738a7.571 7.571 0 0 0 0-10.8c-3.018-2.982-7.912-2.982-10.931 0a3.245 3.245 0 0 0 0 4.628 3.342 3.342 0 0 0 4.685 0 1.114 1.114 0 0 1 1.561 0 1.082 1.082 0 0 1 0 1.543 5.57 5.57 0 0 1-7.808 0 5.408 5.408 0 0 1 0-7.714c3.881-3.834 10.174-3.834 14.055 0a9.734 9.734 0 0 1 .03 13.855zM4.472 5.057a7.571 7.571 0 0 0 0 10.8c3.018 2.982 7.912 2.982 10.931 0a3.245 3.245 0 0 0 0-4.628 3.342 3.342 0 0 0-4.685 0 1.114 1.114 0 0 1-1.561 0 1.082 1.082 0 0 1 0-1.543 5.57 5.57 0 0 1 7.808 0 5.408 5.408 0 0 1 0 7.714c-3.881 3.834-10.174 3.834-14.055 0a9.734 9.734 0 0 1-.015-13.87C5.096 1.35 8.138 0 11.5 0c3.75 0 7.105 1.68 9.333 4.319C16.06.386 8.953.632 4.473 5.057z" fill-rule="evenodd" />
      </svg>

      <h1 class="dark:text-white text-4xl font-light mb-6">
        We're in a very black hole.
      </h1>

      <p class="dark:text-white text-lg opacity-70">
        You can edit this tool's component at:
        <code class="ml-1 border border-gray-100 dark:border-gray-900 text-sm font-mono text-white bg-black rounded px-2 py-1">
          /HtmlbuilderNewsletter/resources/js/pages/Tool.vue
        </code>
      </p>
    </Card-->

    <form name="formFilter">
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-100 dark:divide-gray-700 w-full">
      <div class="w-full">
        <div class="flex flex-col md:flex-row">
          <div class="px-8 py-6 w-1/5">
            <label for="module" class="inline-block leading-tight">Scegli il modulo: <span class="text-danger text-sm">*</span></label>
          </div>
          <div class="py-6 px-8 w-1/2">
            <select @change="loadModuleFilter" id="module" dusk="module" v-model.trim="dataForm.module" class="w-full block form-control form-select form-select-bordered">
              <option disabled="" value="">Scegli un opzione</option>
              <template v-for="(modName, modCode) in configs.active_modules">
                <option :value='modCode'>{{ modName }}</option>
              </template>
            </select>
            <br>
            <span id="module_filter_error" class="hidden text-danger text-sm">Modulo non attivo per la generazione di newsletter. Contattare l'amministratore!</span>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-100 dark:divide-gray-700 w-full">
      <div class="w-full hidden" index="1" id="module_filter">
        <div class="w-6/12 hidden inline-block" id="list_groups">
          <div class="flex flex-col">
            <div class="px-8 pt-6 w-full">
              <label for="group" class="inline-block leading-tight">Categorie <!----></label>
            </div>
            <div class="py-6 px-8 w-full">
              <div class="flex items-center">
                <select id="group" dusk="group" v-model.trim="dataForm.group" class="w-full block form-control form-select form-select-bordered">
                  <option v-for="group in groups_options" :value='group.id'>{{ group.name }}</option>
                </select>
                <!--VueMultiselect id="group" name="group" @select="optionGroupSelected" @remove="optionGroupRemove" v-model="groups_selected" :options="groups_options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Seleziona..." label="name" track-by="id" /-->
              </div>
            </div>
          </div>
        </div>
        <div class="w-6/12 hidden inline-block" id="list_tags">
          <div class="flex flex-col">
            <div class="px-8 pt-6 w-full">
              <label for="tag" class="inline-block leading-tight">Tag <!----></label>
            </div>
            <div class="py-6 px-8 w-full">
              <div class="flex items-center">
                <select id="tag" dusk="tag" v-model.trim="dataForm.tag" class="w-full block form-control form-select form-select-bordered">
                  <option v-for="tag in tags_options" :value='tag.id'>{{ tag.name }}</option>
                </select>
                <!--VueMultiselect id="tag" name="tag" @select="optionTagSelected" @remove="optionTagRemove" v-model="tags_selected" :options="tags_options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Seleziona..." label="name" track-by="id" /-->
              </div>
            </div>
          </div>
        </div>
        <div class="w-4/12 inline-block">
          <div class="flex flex-col">
            <div class="px-8 pt-6 w-full">
              <label for="date_from" class="inline-block leading-tight">Data DA <!----></label>
            </div>
            <div class="py-6 px-8 w-full">
              <div class="flex items-center">
                <input type="date" v-model.trim="dataForm.dt_from" class="form-control form-input form-input-bordered" id="date_from" dusk="date_from" name="Data da" step="any">
              </div>
            </div>
          </div>
        </div>
        <div class="w-4/12 inline-block">
          <div class="flex flex-col">
            <div class="px-8 pt-6 w-full">
              <label for="date_to" class="inline-block leading-tight">Data A <!----></label>
            </div>
            <div class="py-6 px-8 w-full">
              <div class="flex items-center">
                <input type="date" v-model.trim="dataForm.dt_to" class="form-control form-input form-input-bordered" id="date_to" dusk="date_to" name="Data a" step="any">
              </div>
            </div>
          </div>
        </div>
        <div class="w-4/12 inline-block">
          <div class="flex flex-col">
            <div class="px-8 pt-6 w-full">
              <a @click.prevent="loadModuleData" size="md" class="flex-shrink-0 h-9 px-4 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring text-white dark:text-gray-800 inline-flex items-center font-bold shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0 h-9 px-4 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring text-white dark:text-gray-800 inline-flex items-center font-bold" dusk="create-button" href="">
                <span class="inline-block">Carica dati</span>
              </a>
              <!--<button @click="loadModuleData" type="button" class="btn btn-default btn-primary">Carica dati 2</button>-->
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow divide-gray-100 dark:divide-gray-700 w-full">
      <div class="w-full hidden" id="module_data_loading">
        <div class="w-full inline-block">
          <div class="flex flex-col">
              Loading...
          </div>
        </div>
      </div>  
      <div class="w-full hidden" id="module_data">
        <div class="w-full hidden inline-block" id="list_datas">
          <div class="flex flex-col">
            <div class="px-8 pt-6 w-full">
              <label for="datas" class="inline-block leading-tight">Dati: <!----></label>
            </div>
            <div class="py-6 px-8 w-full">
              <div class="flex items-center">
                <select id="group" dusk="group" v-model.trim="dataForm.datasList" class="w-full block form-control form-select form-select-bordered">
                  <option v-for="datas in datas_options" :value='datas.id'>{{ datas.name }}</option>
                </select>
                <!--VueMultiselect id="datas" name="datas" @select="optionDatasSelected" @remove="optionDatasRemove" v-model="datas_selected" :options="datas_options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Seleziona..." label="name" track-by="id" /-->
              </div>
            </div>
          </div>
        </div>
        <div class="w-4/12 inline-block">
          <div class="flex flex-col md:flex-row">
            <div class="px-8 py-6 w-full">
              <label for="template" class="inline-block leading-tight">Scegli il template: <span class="text-danger text-sm">*</span></label>
            </div>
            <div class="py-6 px-8 w-full">
              <select id="template" dusk="template" v-model.trim="dataForm.template" class="w-full block form-control form-select form-select-bordered">
                <option disabled="" value="">Scegli un opzione</option>
                <template v-for="template in templates">
                  <option :value='template'>{{ template }}</option>
                </template>
              </select>
            </div>
          </div>
        </div>
        <div class="w-4/12 inline-block">
          <div class="flex flex-col md:flex-row">
            <div class="px-8 py-6 w-full">
              <label for="lang" class="inline-block leading-tight">Scegli la lingua: <span class="text-danger text-sm">*</span></label>
            </div>
            <div class="py-6 px-8 w-full">
              <select id="lang" dusk="lang" v-model.trim="dataForm.lang" class="w-full block form-control form-select form-select-bordered">
                <option disabled="" value="">Scegli un opzione</option>
                <template v-for="lang in configs.lang">
                  <option :value='lang'>{{ lang }}</option>
                </template>
              </select>
            </div>
          </div>
        </div>
        <div class="w-4/12 inline-block">
          <div class="flex flex-col">
            <div class="px-8 pt-6 w-full">
              <a @click.prevent="loadTemplate" size="md" class="flex-shrink-0 h-9 px-4 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring text-white dark:text-gray-800 inline-flex items-center font-bold shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0 h-9 px-4 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring text-white dark:text-gray-800 inline-flex items-center font-bold" dusk="create-button" href="">
                <span class="inline-block">Genera template</span>
              </a>
              <!--<button @click="loadTemplate" type="button" class="btn btn-default btn-primary">Genera template 2</button>-->
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow divide-gray-100 dark:divide-gray-700 w-full">
      <div class="w-full hidden" id="template_loading">
        <div class="w-full inline-block">
          <div class="flex flex-col">
              Loading...
          </div>
        </div>
      </div>  
      <div class="w-full" id="template_data">
        <div class="w-8/12 inline-block">
          <div class="flex flex-col">
            <div v-html="templateOut"></div>
          </div>
        </div>
        <div class="w-4/12 inline-block">
          <div class="flex flex-col">
            <textarea v-html="templateOutSource" id="templateOutSource" name="templateOutSource" ref="templateOutSource"></textarea>
            <br><br>
            <button @click="copyText()">Click to Copy</button>
          </div>
        </div>
      </div>
    </div>

      <!--  <div class="w-full" index="1"><div class="flex flex-col md:flex-row">
          <div class="px-8 py-6 w-1/5">
            <label for="email" class="inline-block leading-tight">Email <span class="text-danger text-sm">*</span></label>
          </div>
          <div class="py-6 px-8 w-1/2">
            <div class="space-y-1">
              <input type="text" placeholder="Email" class="w-full form-control form-input form-input-bordered" id="email-aggiorna-utente-mattia-text-field" dusk="email" maxlength="-1">
            </div>
            <p class="help-text help-text mt-2"></p>
          </div>
        </div>
      </div>
      <div class="w-full" index="2">
        <div class="flex flex-col md:flex-row">
          <div class="px-8 py-6 w-1/5">
            <label for="password" class="inline-block leading-tight">Password </label>
          </div>
          <div class="py-6 px-8 w-1/2">
            <input id="password-aggiorna-utente-mattia-password-field" dusk="password" type="password" class="w-full form-control form-input form-input-bordered" placeholder="Password" autocomplete="new-password">
            <p class="help-text help-text mt-2"></p>
          </div>
        </div>
      </div>-->
    
    </form>
  </div>
</template>


<!--style src="vue-multiselect/dist/vue-multiselect.min.css"></style-->
<style>
/* Scoped Styles */
</style>

<script>
//import axios from 'axios';
//import VueMultiselect from 'vue-multiselect'

export default {
  //components: { VueMultiselect },
  data() {
    return {
      configs: [],
      groups_selected: null,
      groups_options: [],
      tags_selected: null,
      tags_options: [],
      templates: [],
      datas_selected: null,
      datas_options: [],
      templateOut: null,
      templateOutSource: null,
      dataForm: {
        module: '',
        group: [],
        tag: [],
        dt_from: '',
        dt_to: '',
        template: '',
        lang: '',
        datasList: [],
      }  
    };
  },
  mounted(){
    this.getConfig();
  },
  methods: {
    getConfig(){
      //axios.get('/nova-vendor/htmlbuildernewsletter/app-config')
      Nova.request().get('/nova-vendor/htmlbuildernewsletter/app-config')
        .then(response => {
        //console.log(response.data)
        this.configs = response.data;
      })
    },
    loadModuleFilter(){
      //Nova.request().post('/nova-vendor/htmlbuildernewsletter/load-module-filter')
      const data = new FormData();
      data.append('module', this.dataForm.module);

      document.getElementById("module_filter").classList.add("hidden");
      document.getElementById("list_groups").classList.add("hidden");
      document.getElementById("list_tags").classList.add("hidden");
      document.getElementById("module_filter_error").classList.add("hidden");

      //axios.post('/nova-vendor/htmlbuildernewsletter/load-module-filter', data)
      Nova.request().post('/nova-vendor/htmlbuildernewsletter/load-module-filter', data)
        .then(response => {
          if(this.dataForm.module == 'magazine'){
            if(response.data.group.length > 0){
              response.data.group.forEach((element) => {
                this.groups_options.push({ "id": element.id, "name": element.name });
              });
              
              document.getElementById("module_filter").classList.remove("hidden");
              document.getElementById("list_groups").classList.remove("hidden");
            }
            if(response.data.tag.length > 0){
              response.data.tag.forEach((element) => {
                this.tags_options.push({ "id": element.id, "name": element.name });
              });
            
              document.getElementById("module_filter").classList.remove("hidden");
              document.getElementById("list_tags").classList.remove("hidden");
            }
          }else if(this.dataForm.module == 'event'){
            if(response.data.group.length > 0){
              response.data.group.forEach((element) => {
                this.groups_options.push({ "id": element.id, "name": element.name });
              });
            
              document.getElementById("module_filter").classList.remove("hidden");
              document.getElementById("list_groups").classList.remove("hidden");
            }
          }else{
            document.getElementById("module_filter_error").classList.remove("hidden");
          }
        });
    },
    optionGroupSelected(option, idCur){
      this.dataForm.group.push(option.id);
    },
    optionGroupRemove(option, idCur){
      const index = this.dataForm.group.indexOf(option.id);
      this.dataForm.group.splice(index, 1);
    },
    optionTagSelected(option, idCur){
      this.dataForm.tag.push(option.id);
    },
    optionTagRemove(option, idCur){
      const index = this.dataForm.tag.indexOf(option.id);
      this.dataForm.tag.splice(index, 1);
    },
    loadModuleData(){
      const data = new FormData();
      data.append('module', this.dataForm.module);
      data.append('group', this.dataForm.group);
      data.append('tag', this.dataForm.tag);
      data.append('dt_from', this.dataForm.dt_from);
      data.append('dt_to', this.dataForm.dt_to);

      document.getElementById("module_data").classList.add("hidden");
      document.getElementById("module_data_loading").classList.remove("hidden");
      
      //axios.post('/nova-vendor/htmlbuildernewsletter/load-module-data', data)
      Nova.request().post('/nova-vendor/htmlbuildernewsletter/load-module-data', data)
        .then(response => {
          document.getElementById("module_data_loading").classList.add("hidden");

          this.templates = response.data.template;

          if(response.data.moduleData.length > 0){
            response.data.moduleData.forEach((element) => {
              this.datas_options.push({ "id": element.id, "name": element.name });
            });
          
            document.getElementById("list_datas").classList.remove("hidden");
          }

          document.getElementById("module_data").classList.remove("hidden");
          //console.log(response)
        });
    },
    optionDatasSelected(option, idCur){
      this.dataForm.datasList.push(option.id);
    },
    optionDatasRemove(option, idCur){
      const index = this.dataForm.datasList.indexOf(option.id);
      this.dataForm.datasList.splice(index, 1);
    },
    loadTemplate(){
      var _this5 = this;
      const data = new FormData();
      data.append('module', this.dataForm.module);
      data.append('template', this.dataForm.template);
      data.append('lang', this.dataForm.lang);
      data.append('datas', this.dataForm.datasList);

      document.getElementById("template_data").classList.add("hidden");
      document.getElementById("template_loading").classList.remove("hidden");

      //axios.post('/nova-vendor/htmlbuildernewsletter/load-template', data)
      Nova.request().post('/nova-vendor/htmlbuildernewsletter/load-template', data)
        .then(function (response){
          //console.log(response);
          _this5.templateOutSource = response.data;
          _this5.templateOut = response.data;

          document.getElementById("template_data").classList.remove("hidden");
          document.getElementById("template_loading").classList.add("hidden");
        });
    },
    copyText() {
      const element = this.$refs.templateOutSource;
      element.select();
      element.setSelectionRange(0, 99999);
      document.execCommand('copy');
    }
  }
}
</script>

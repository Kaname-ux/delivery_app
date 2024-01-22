<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Reglages</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 <script src="https://unpkg.com/vue@3"></script> 
<div class="wrapper" id="app">
  <!-- Navbar -->
   @include("includes.navbar")

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reglage</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Reglages</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


      <div class="row">
          <!-- left column -->
          
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Info entreprise</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                  <form method="post"  action="updatecompany">
                  @csrf
                 <div class="row">
                  <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nom </label>

                    <input name="name" class="form-control" required value="{{$company->name}}">
                    @error('name')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>                   
      </span>
      @enderror
                  </div>
                  
                  <div class="form-group">
                    <label>Adresse</label>

                    <input name="adresse" class="form-control" required value="{{$company->location}}">
                    
                  </div>

                  <div class="form-group">
                    <label>Contact</label>

                    <input name="contact" class="form-control" required value="{{$company->contact}}">
                     @error('contact')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>                   
      </span>
      @enderror
                  </div>

                   
                  </div>


                  <div class="col-sm-6">
                  

                  <div class="form-group">
                    <label>Email</label>

                    <input name="mail" class="form-control" required value="{{$company->mail}}">
                    
                  </div>

                   <div class="form-group">
                    <label>Whatsapp</label>

                    <input name="wa" class="form-control" required value="{{$company->wa}}">
                    
                  </div>

                  <button class="btn btn-block btn-primary">Modifier</button>
                  </div>
                 </div>
                 
                
              </div>
              <!-- /.card-body -->
            </div>

            </div>
            


          <!--/.col (right) -->
        </div>



       
          <div class="row">
          <!-- left column -->
          
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-4">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Automatisation</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                  
                  <div v-for="(setting, index) in settings"  class="form-group">
                    <div v-if="setting.type == 'AUTOMATION'"  class="custom-control custom-switch">
                      <input @click="switchSetting(setting.id, index, setting.switch)" :checked="setting.switch == 1" type="checkbox" class="custom-control-input" :id="'commandSwitch'+index">
                      <label class="custom-control-label" :for="'commandSwitch'+index">@{{setting.description}}</label>
                      <button @click="getText(index)" class="btn btn-sm btn-primary">Modifier message</button>
                    </div>
                  </div>
                 
                  
                 
                 
                
              </div>
              <!-- /.card-body -->
            </div>

            </div>


            <div v-if="text != null" class="col-4">
              <div  class="form-group">
                <label>@{{textTitle}}</label>
              <textarea id="text" v-model="text" rows="4" cols="4" class="form-control">@{{text}}</textarea>
              </div>

              <h5>Inserer dans le message</h5>
                    <div class="row mb-2">
              <button @click="setTextToCurrentPos('LIVREUR_CMD')" class="btn btn-secondary btn-sm mr-1 mb-1">Info Livreur</button>
              <button @click="setTextToCurrentPos('NUMERO_CMD')" class="btn btn-secondary btn-sm mr-1 mb-1">Numero Commande</button>
              <button @click="setTextToCurrentPos('TOTAL_CMD')" class="btn btn-secondary btn-sm mr-1 mb-1">Total Commande</button>
              <button @click="setTextToCurrentPos('TRACKING_CMD')" class="btn btn-secondary mr-1 mb-1 btn-sm  ">Lien de tracking</button>
               <button @click="setTextToCurrentPos('{{$company->name}}')" class="btn btn-secondary mr-1 mb-1 btn-sm  ">Nom de l'entreprise</button>


               <button @click="setTextToCurrentPos('{{$company->contact}}')" class="btn btn-secondary mr-1 mb-1 btn-sm  ">Contact l'entreprise</button>

               <button @click="setTextToCurrentPos('{{$company->location}}')" class="btn btn-secondary mr-1 mb-1 btn-sm  ">Adresse l'entreprise</button>

               

               <button @click="setTextToCurrentPos('https://wa.me/{{$company->wa}}')" class="btn btn-secondary mb-1 mr-1 btn-sm  ">Lien whatsapp l'entreprise</button>

               <button @click="setTextToCurrentPos('{{$company->mail}}')" class="btn btn-secondary mb-1 mr-1 btn-sm  ">Email l'entreprise</button>
                        
                    </div>
              <button :disabled="text == '' || text == null" @click="setText" class="mr-3 btn btn-primary">Modifier message</button>
              <button @click="resetText" class="btn btn-default">Fermer</button>
            </div>
      
          <div class="col-4">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Site e-commerce</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                  
                  <div v-for="(setting, index) in settings"  class="form-group">
                    <div v-if="setting.type == 'SHOP'"  class="custom-control custom-switch">
                      <input @click="switchSetting(setting.id, index, setting.switch)" :checked="setting.switch == 1" type="checkbox" class="custom-control-input" :id="'commandSwitch2'+index">
                      <label class="custom-control-label" :for="'commandSwitch2'+index">@{{setting.description}}</label>
                     
                    </div>
                  </div>
                 
                  
                 
                 
                
              </div>
              <!-- /.card-body -->
            </div>

            </div>

          <!--/.col (right) -->
        </div>


        <div class="row">
          <!-- left column -->
          
          <!--/.col (left) -->
          <!-- right column -->
          
          </div>
        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<script>

   const app = Vue.createApp({
    data() {
        return {
            
            settings:{!! $settings !!},
            text:null,
            textTitle: null,
            selectedId:null,
            selectedIndex:null,
            warning:"",
            
        }
    },
    methods:{ 
    getText(index){
     this.text = this.settings[index].text
     this.textTitle = "modifier message '"+ this.settings[index].description +"'"
     this.selectedId = this.settings[index].id
     this.selectedIndex = index
    },

    setTextToCurrentPos(element) {
                var curPos = 
                    document.getElementById("text").selectionStart
                console.log(curPos)
                
              
              this.text = this.text.slice(0, curPos) + element + this.text.slice(curPos)

            },


    resetText(){
     this.text = null
     this.textTitle = null
     this.selectedId = null
     this.selectedIndex = null

    },
    switchSetting(id, index, current){
      
      var vm = this
     
     

    axios.post('/switchsetting', {
           
             id: id ,
             current:current,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.settings[index].switch = response.data.switch
    


  })
  .catch(function (error) {
   alert(error)
    console.log(error);
  });
    },



     setText(){
      
      var vm = this
     
     

    axios.post('/setmessage', {
           
             id: vm.selectedId ,
             text:vm.text,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.settings[vm.selectedIndex].text = response.data.text
    alert("Action effectuee")


  })
  .catch(function (error) {
   alert(error)
    console.log(error);
  });
    }


   },
   computed:{
     
}
});

  const mountedApp = app.mount('#app') 
  </script>  
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>

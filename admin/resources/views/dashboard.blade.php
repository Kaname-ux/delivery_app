<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 <script src="https://unpkg.com/vue@3"></script>
<div class="wrapper" id="app">


  

<div class="modal fade action-sheet" id="actionsModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title">Actions livreur </h5>
                        <a  href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <strong>@{{ selectedLivreurNom}}</strong>
                      </div>
                      <div class="row">
                        @{{action_date}}
                        <div v-if="selectedLivreur" class="form-group ml-2">
                          <input v-model="actionDate" @change='getActions(selectedLivreurIndex)' type="date" class="form-control" name="">
                        </div>
                      </div>
                        <div class="action-sheet-content" id="actionsOutput">
                        
                        
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade action-sheet" id="dateModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Date</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <form  autocomplete="off"  action='?bydate' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("yesterday"))}}'   class="form-control " type="date" name="start">
                                         <input  hidden value='{{date("Y-m-d",strtotime("yesterday"))}}'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-outline-primary btn-block "   >Hier</button>

                                        </div>
                                         </form>

                                         <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("today"))}}'   class="form-control " type="date" name="start">
                                         <input  hidden value='{{date("Y-m-d",strtotime("today"))}}'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-outline-warning btn-block "   >Aujourd'hui</button>

                                        </div>
                                         </form>
                                        
                                        <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input hidden value='{{date("Y-m-d",strtotime("tomorrow"))}}'    class="form-control "  name="start">
                                         <input hidden value='{{date("Y-m-d",strtotime("tomorrow"))}}'    class="form-control "  name="end">
                                         <button class="btn btn-outline-success btn-block " type="submit"  >Demain</button>

                                        </div>
                                         </form>
                                       
                                    </div>
                                </div>
                                <div>
                              <form autocomplete="off" id="date-form" action="?">
                                @csrf
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11d">Choisir une date</label>
                                       
                                         <div  class="form-row">
                                         <div class="col">
                                         <input v-model="costumStart" value=""  class="form-control"type="date" name="start">
                                         
                                         </div>
                                         <div class="col">
                                            <button class="btn btn-primary btn-sm">Valider</button> 
                                         </div>
                                         
                                         <input hidden id="costumEnd" :value="costumStart"  class="form-control" 
                                          
                                         type="date" name="end">

                                        </div>
                                        
                                    </div>
                                </div>
                             </form>
                             </div>

                             <form autocomplete="off" id="date-form" action="?">
                                @csrf
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11d">Choisir un interval</label>
                                       
                                         <div  class="form-row">
                                         
                                         <div class="col">
                                         <input v-model="intStart" value=""  class="form-control" 
                                        
                                         type="date" name="start">
                                          </div>
                                          <div class="col">
                                         <input :disabled="!intStart" :min="intStart"  class="form-control" 
                                          
                                         type="date" name="end">
                                        </div>
                                       
                                        </div>
                                        <button class="btn btn-primary btn-sm">Valider</button> 
                                    </div>
                                </div>
                             </form>
                                

                                
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include("includes.navbar")

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard 
                      <button @click="refreshNotes" type="button" class="btn btn-tool" >
                    <i v-if="loading" class="fas  fa-sync-alt fa-spin"></i>
                    <i v-else class="fa fa-sync-alt"></i>

                  </button>
            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row mb-2">
        <button data-toggle="modal" data-target="#dateModal" class="btn btn-outline-primary mr-2 d-print-none">{{$day}}</button>
      </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>@{{total_sum}}
                 (@{{total_count}})
                </h3>

                <p>Tous les Colis</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>@{{sum_done+ ' FCFA'}} (@{{count_done}})</h3>

                <p>Colis Livrés</p>
              </div>
              <div class="icon">
                <i class="ion ion-checkmark"></i>
              </div>
              <a href="#" class="small-box-footer">info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>@{{sum_undone+ ' FCFA'}} (@{{count_undone}})</h3>

                <p>Colis en cours de livraison</p>
              </div>
              <div class="icon">
                <i class="ion ion-play"></i>
              </div>
              <a href="#" class="small-box-footer">info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
               <h3>@{{sum_encours+ ' FCFA'}} (@{{count_encours}})</h3>

                <p>Colis enregistrés et non collectés</p>
              </div>
              <div class="icon">
                <i class="ion ion-close"></i>
              </div>
              <a href="#" class="small-box-footer">info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <div class="row">

            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
               <h3>@{{sum_delai+ ' FCFA'}} (@{{count_delai}})</h3>

                <p>Colis hors delai</p>
              </div>
              <div class="icon">
                <i class="ion ion-close"></i>
              </div>
              <a href="#" class="small-box-footer">info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
               <h3>@{{sum_cancel+ ' FCFA'}} (@{{count_cancel}})</h3>

                <p>Colis annulés</p>
              </div>
              <div class="icon">
                <i class="ion ion-close"></i>
              </div>
              <a href="#" class="small-box-footer">info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


        </div>

        <!-- /.row -->
        <div class="row">
          <div class="col-md-6" >
            <div class="card" style="min-height: 400px; max-height: 400px;">
              <div class="card-header">
                <h3 class="card-title">Progression des livreurs</h3>
                <div class="card-tools">
                  <span title="3 New Messages" class="badge badge-primary"></span>
                  <button @click="refreshNotes" type="button" class="btn btn-tool" >
                    <i v-if="loading" class="fas  fa-sync-alt fa-spin"></i>
                    <i v-else class="fa fa-sync-alt"></i>

                  </button>
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive ">
                <div v-if="livreurs.length"  v-for="(livreur, index) in livreurs">
                <div v-if="livreur.commands.length > 0" class="border border-primary mb-2">
                <p>@{{livreur.nom}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  @{{doneBylivreur(livreur.commands)}}/@{{livreur.commands.length}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            </p>
                        

                <div class="progress">
                  <div class="progress-bar bg-primary progress-bar-striped" role="progressbar"
                       :aria-valuenow="Number(doneBylivreur(livreur.commands))/Number(livreur.commands.length)*100" aria-valuemin="0" aria-valuemax="100" :style="'width:'+ Number(doneBylivreur(livreur.commands))/Number(livreur.commands.length)*100 + '%'">
                    <span class="sr-only">40% Complete (success)</span>
                  </div>
                </div>

                    <p v-if='livreur.lesroutes.length > 0'>
                              Dernière action: 
                              @{{livreur.lesroutes[livreur.lesroutes.length-1].created_at.substring(8, 10)}}-
               @{{livreur.lesroutes[livreur.lesroutes.length-1].created_at.substring(5, 7)}}-
               @{{livreur.lesroutes[livreur.lesroutes.length-1].created_at.substring(0, 4)}} @{{livreur.lesroutes[livreur.lesroutes.length-1].created_at.substring(11, 16)}}  
               <span class="text-warning"> @{{livreur.lesroutes[livreur.lesroutes.length-1].observation}} </span>
                            </p>
                            <button data-toggle="modal" data-target="#actionsModal" class="btn btn-primary" @click="getActions(index)">Voir plus d'actions</button>
              
                 </div>
                 </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col (left) -->
          <div class="col-md-6">
            <div class="card" style="min-height: 400px; max-height: 400px;">
              <div class="card-header">
                <h3 class="card-title">Notes de livraison </h3>
                <div class="card-tools">
                  <span title="3 New Messages" class="badge badge-primary">@{{notes.length}}</span>
                  <button @click="refreshNotes" type="button" class="btn btn-tool" >
                    <i v-if="loading" class="fas  fa-sync-alt fa-spin"></i>
                    <i v-else class="fa fa-sync-alt"></i>

                  </button>
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive ">
                
              
                <div  class="direct-chat-messages">
                  <!-- Message. Default to the left -->
                  <div v-if="notes.length > 0" v-for="(note, index) in notes" class="direct-chat-msg">
                    <div v-if="note.command" class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">@{{note.command.livreur.nom}}</span>
                      <span class="direct-chat-timestamp float-right">@{{note.created_at}}</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    
                    <!-- /.direct-chat-img -->
                    <div v-if="note.command" class="direct-chat-text">
                     @{{note.description}} - # @{{note.command.id}} - @{{note.command.adresse}} - @{{note.command.phone}}
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                 
                
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col (right) -->
        </div>
          
        <div class="row">
          <div class="col-md-6" >
            <div class="card" style="min-height: 400px; max-height: 400px;">
              <div class="card-header">
                <h3 class="card-title">Colis par communes</h3>
                <div class="card-tools">
                  
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
               <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Commune</th>
                    <th>Quantité</th>
                    
                  </tr>
                  </thead>
                  <tbody>

                    
                  @foreach($cmds_by_city as $city)  
                  <tr>
                    <td>
                     
                      {{$city->fee->destination}}
                    </td>

                      <td>
                     {{$city->qty}}
                      
                    </td>
                    
                    
                  </tr>
                  @endforeach
               
                  
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col (left) -->
          <div class="col-md-6">
            <div class="card" style="min-height: 400px; max-height: 400px;">
              <div class="card-header">
                <h3 class="card-title">Colis par clients</h3>
                <div class="card-tools">
                  
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive ">
                
              
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Client</th>
                    <th>Quatite</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($cmds_by_client as $clt)
                  <tr>
                    <td>
                      @if($clt->client)
                      {{$clt->client->nom}}
                      @else
                      Indéfini
                      @endif
                    </td>
                    
                    <td>
                      <!-- <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        12%
                      </small> -->
                      {{$clt->qty}}
                    </td>
                    
                  </tr>
                  @endforeach
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col (right) -->
        </div>

        


        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            

            <!-- /.card -->

            
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
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
            intStart:null, 
            livreurs:{!! $livreurs !!},
            loading:null,
            notes:{!! $notes !!},

            total_sum:{!! $commands->sum("livraison") !!},
            total_count:{!! $commands->count() !!},

            sum_done:{!! $commands->where("etat", "termine")->sum("livraison") !!},
            count_done:{!! $commands->where("etat", "termine")->count() !!},

            sum_undone:{!! $commands->whereIn("etat", ["en chemin", "recupere"])->sum("livraison") !!},
            count_undone:{!! $commands->whereIn("etat", ["en chemin", "recupere"])->count() !!},

            sum_encours:{!! $commands->where("etat", "encours")->sum("livraison") !!},
            count_encours:{!! $commands->where("etat", "encours")->count() !!},

            sum_delai:{!! $commands->whereIn("etat", ["en chemin", "recupere", "encours"])->where("date_delai", "!=", null)->where("commands.delivery_date", "<", "commands.date_delai")->sum("livraison") !!},
            count_delai:{!! $commands->whereIn("etat", ["en chemin", "recupere", "encours"])->where("date_delai", "!=", null)->where("commands.delivery_date", "<", "commands.date_delai")->count() !!},

            sum_cancel:{!! $commands->where("etat", "=", "annule")->sum("livraison") !!},
            count_cancel:{!! $commands->where("etat", "=", "annule")->count() !!},


            start: {!! $start !!},
            end: {!! $end !!},
            selectedLivreur: null,
            output:"",
            selectedLivreurNom: "",
            action_date: "",
            selectedLivreurIndex: null,
            selectedLivreurId: null,
            actionDate: ""


        }
    },
    methods:{ 
     refreshNotes(){
            vm = this
         this.loading = 1
         axios.post('/refreshnotes', {
           start: vm.start,
           end: vm.end,
           _token: CSRF_TOKEN
    })

         
  .then(function (response) {
   vm.notes = response.data.notes
   vm.livreurs = response.data.livreurs
   vm.loading = 0

   vm.commands = response.data.commands
   
  })
  .catch(function (error) {
    vm.loading = 0
    console.log(error);
  });
    },

    getSelectedLivreurs(index){
      this.selectedLivreur = this.livreurs[index]
    },

     getActions(index){
            vm = this
         this.loading = 1
         this.selectedLivreur = this.livreurs[index]
         this.selectedLivreurNom = this.livreurs[index].nom
         this.selectedLivreurId = this.livreurs[index].id
         this.selectedLivreurIndex = index
         id = this.selectedLivreur.id
         action_date = null
         if(this.actionDate != ""){
          action_date = this.actionDate
         }
         
         axios.post('/getactions', {
           id: id,
           action_date: action_date,
           _token: CSRF_TOKEN
    })

         
  .then(function (response) {
  
   vm.loading = 0

   vm.output = response.data.output


  document.getElementById("actionsOutput").innerHTML = response.data.output
  vm.action_date = response.data.action_date
   
  })
  .catch(function (error) {
    vm.loading = 0
    console.log(error);
  });
    },



    refreshLivreurs(){
            vm = this
         this.loading = 1
         axios.post('/refreshlivreurs', {
           
    })

         
  .then(function (response) {
   vm.livreurs = response.data.livreurs
   vm.loading = 0
  })
  .catch(function (error) {
    vm.loading = 0
    console.log(error);
  });
    },


    doneBylivreur(commands){
      x = 0;
      for(y=0; y<commands.length; y++){
        if(commands[y].etat == 'termine'){
          x += 1
        }
      }

      return x

    },

    undoneBylivreur(commands){
      x = 0;
      for(y=0; y<commands.length; y++){
        if(commands[y].etat != 'termine'){
          x += 1
        }
      }

      return x

    }

   },
   computed:{
     
}
});

  const mountedApp = app.mount('#app')     

  </script>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<script type="text/javascript">
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
</script>
</body>
</html>

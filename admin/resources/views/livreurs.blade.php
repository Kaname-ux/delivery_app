<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Livreurs</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <style type="text/css">
    .dot {
  height: 10px;
  width: 10px;
  background-color: green;
  border-radius: 50%;
  display: inline-block;
}
  </style>
</head>
<body class="hold-transition sidebar-mini">
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 <script src="https://unpkg.com/vue@3"></script>
<div class="wrapper" id="app">
  <!-- Navbar -->
 @include("includes.navbar")
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

 <div class="modal fade" id="addLivModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Ajouter livreur</h5>
                       
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content ">
                          <form class="send" method="POST" action="/addlivreur">
                @csrf
                <div class="card">
                    <div class="card-body">

                       <div class="form-group basic">
                            

                            <div class="input-wrapper">
                                <label for="name" class="label">Nom et Prenom</label>
                                <input max="50" placeholder="Nom et Prenom" id="name" type="text" class="form-control " name="name" value="{{old('name')}}" required="" autocomplete="name" autofocus="">

                          </div>

                          @error('name')
                                   <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                        </div>



                        <div class="form-group basic">
                            

                            <div class="input-wrapper ">
                                <label for="phone" class="label">Contact</label>
                                <input maxlength="10" placeholder="Ex: 07000000" id="phone" type="number" class="form-control " name="phone" value="{{old('phone')}}" required="" autocomplete="phone" autofocus="">

                               </div>

                               @error('phone')
                                   <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                        </div>



                        <div class="form-group basic ">
                            <div class="input-wrapper">
                                <label class="label" for="email1">E-mail</label>
                                <input type="email" class="form-control " name="email" value="{{old('email')}}" id="email1" placeholder="Votre e-mail">
                                <i class="clear-input">
                                    <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                </i>

                              </div>

                              @error('email')
                                   <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                        </div>



                        

                       <?php 
                          $communes = array("Adjamé", "Cocody", "Attécoubé", "Bingerville", "Anyama", "Koumassi", "Plateau", "Treichville", "Marcory", "Port-Bouet", "Bassam", "Songon", "Abobo", "Yopougon" );


                          $pieces = array("CNI", "Permis de conduire", "Attestation d'identité", "Carte consulaire", "Carte professionelle", "Passeport");

                          sort($communes);
                          sort($pieces);
                           ?>


                            <div class="form-group">
                            <label for="phone" >Ville/Commune</label>

                           
                              <select class="form-control" name="city" required="required">
                                <option value="">
                                  Choisir une ville/commune
                                </option>
                                 
                                @foreach($communes as $commune) 
                                   <option @if($commune == old('city')) selected @endif value='{{$commune}}'>{{$commune}}</option>;
                                @endforeach
                                
                              </select>
 
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                        </div>


                         <div class="form-group basic">
                            

                            <div class="input-wrapper ">
                                <label for="adresse" class="city">Quartier</label>
                                <input max="100" placeholder="Ex: Angre 8e tranche... " id="adrssse" type="text" class="form-control " name="adresse" value="{{old('adresse')}}" required="" autocomplete="adresse" autofocus="">

                               </div>

                               @error('adresse')
                                   <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                        </div>


                      
        
                        <div class="form-group basic">
                            <div class="input-wrapper ">
                                <label class="label" for="password1">Mot de passe</label>
                                <input value="" min="8" max="20" name="password" type="password" class="form-control " required="" autocomplete="new-password" placeholder="8 caratères minimum">
                                <i class="clear-input">
                                    <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                </i>

                                                            </div>

                               @error('password')
                                   <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                                </span>
                              @enderror                             
                        </div>
        
                        <div class="form-group basic">
                            <div class="input-wrapper ">
                                <label min="8" max="20" class="label" for="password2">Confirmer mot de passe</label>
                                <input value="" type="password" class="form-control " required="" name="password_confirmation" id="password2" placeholder="Confirmer mot de passe">
                                <i class="clear-input">
                                    <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                </i>
                                                             
                            </div>

                            @error('password')
                                   <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                                </span>
                              @enderror  
                        </div>

                        
        
                    </div>
                </div>



<div o="" class="form-button-group transparent sendbtn">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Enregistrer</button>
                </div>

            </form>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Liste des livreurs</h1> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Livreurs</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
       
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des livreurs</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" >
                 

                    
                      <button data-toggle="modal" id="addBtn" data-target="#addLivModal" class="btn btn-success">
                       Ajouter un livreur
                      </button>
                   
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body  p-0" >
                <table class="table  table-responsive">
                  <thead>
                    <tr>
                      <th>
                        Nom
                      </th>
                      <th>
                        Dernière action
                      </th>
                      <th>
                        contact
                      </th>
                      <th>
                        Adresse
                      </th>

                      <th>
                        Montant non regle
                      </th>

                      
                      
                      
                      <th>
                        Numero de piece
                      </th>
                      <th>Compte</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($livreurs as $index=>$livreur)


                        <div class="modal fade" id="modalLoginForm{{$livreur->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
            <form method="POST" action="/set-livreur-account">
             @csrf
              <input hidden value="{{$livreur->id}}" type="text" name="livreur_id">
              <select name="user_id" class="form-control">
                @foreach($available_accounts as $account)
                <option value="{{$account->id}}">{{$account->name}}</option>
                @endforeach

            </select>
            <button type="submit" class="btn btn-default">Definir</button>
         </form>
             </div>
    </div>
  </div>
</div>
                      <tr>
                        
                        <td>
                      
                           @if($livreur->commands->where("delivery_date", today())->count()>0)
                          <span class="dot"></span>
                          @endif{{$livreur->nom}}<br>
                          créer le: {{$livreur->created_at->format("d-m-Y H:i:s")}}
                         
                        </td>
                          <td>
                            @if($livreur->lesroutes->count() > 0)
                           {{$livreur->lesroutes->last()->created_at->format("d-m-Y H:i:s")}} <br>
                        {{$livreur->lesroutes->last()->observation}} <br>
                        <button data-toggle="modal" data-target="#actionsModal" class="btn btn-primary" @click="getActions({{$index}})">Voir plus d'actions</button>
                        @endif
                        </td>
                        <td>
                          {{$livreur->phone}}
                        </td>
                        <td>
                          {{$livreur->adresse}}
                        </td>

                        <td>
                          {{$livreur->payments->where("etat", "en attente")->sum('montant')}}
                        </td>
                      
               

                        <td >
                          {{$livreur->pieces}}
                        </td>
                        
                        <td>
                          @if($livreur->user)
                          {{$livreur->user->email}}
                          <form method="POST" action="/unset-livreur-account/{{$livreur->user->id}}">
                            @csrf
                          <button   type="submit"   class="btn btn-succes btn-sm" >
                          </form>Dissocier</button>
                          @else

                           
                         <button   name="btn" data-toggle="modal" data-target="#modalLoginForm{{$livreur->id}}"  class="btn btn-succes btn-sm" >Associer un compte</button>
                       

                          @endif
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
<!-- ./wrapper -->
<script>
   
   const app = Vue.createApp({
    data() {
        return {
           
            livreurs:{!! $livreurs !!},
            loading:null,
            
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



  
   

   },
   computed:{
     
}
});

  const mountedApp = app.mount('#app')     

  </script>
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script type="text/javascript">
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
</script>
@if($errors->count() > 0)
<script type="text/javascript">
  $("#addBtn").click();
</script>
@endif
</body>
</html>

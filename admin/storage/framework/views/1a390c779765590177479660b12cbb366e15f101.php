<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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
 <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="modal fade action-sheet" id="actionsModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title">Actions livreur </h5>
                        <a  href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <strong>{{ selectedLivreurNom}}</strong>
                      </div>
                      <div class="row">
                        {{action_date}}
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
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-body">

                       <div class="form-group basic">
                            

                            <div class="input-wrapper">
                                <label for="name" class="label">Nom et Prenom</label>
                                <input max="50" placeholder="Nom et Prenom" id="name" type="text" class="form-control " name="name" value="<?php echo e(old('name')); ?>" required="" autocomplete="name" autofocus="">

                          </div>

                          <?php if ($errors->has('name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('name'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>



                        <div class="form-group basic">
                            

                            <div class="input-wrapper ">
                                <label for="phone" class="label">Contact</label>
                                <input maxlength="10" placeholder="Ex: 07000000" id="phone" type="number" class="form-control " name="phone" value="<?php echo e(old('phone')); ?>" required="" autocomplete="phone" autofocus="">

                               </div>

                               <?php if ($errors->has('phone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>



                        <div class="form-group basic ">
                            <div class="input-wrapper">
                                <label class="label" for="email1">E-mail</label>
                                <input type="email" class="form-control " name="email" value="<?php echo e(old('email')); ?>" id="email1" placeholder="Votre e-mail">
                                <i class="clear-input">
                                    <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                </i>

                              </div>

                              <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
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
                                 
                                <?php $__currentLoopData = $communes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commune): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                   <option <?php if($commune == old('city')): ?> selected <?php endif; ?> value='<?php echo e($commune); ?>'><?php echo e($commune); ?></option>;
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                              </select>
 
                                <?php if ($errors->has('city')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('city'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            
                        </div>


                         <div class="form-group basic">
                            

                            <div class="input-wrapper ">
                                <label for="adresse" class="city">Quartier</label>
                                <input max="100" placeholder="Ex: Angre 8e tranche... " id="adrssse" type="text" class="form-control " name="adresse" value="<?php echo e(old('adresse')); ?>" required="" autocomplete="adresse" autofocus="">

                               </div>

                               <?php if ($errors->has('adresse')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('adresse'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>


                      
        
                        <div class="form-group basic">
                            <div class="input-wrapper ">
                                <label class="label" for="password1">Mot de passe</label>
                                <input value="" min="8" max="20" name="password" type="password" class="form-control " required="" autocomplete="new-password" placeholder="8 caratères minimum">
                                <i class="clear-input">
                                    <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                </i>

                                                            </div>

                               <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>                             
                        </div>
        
                        <div class="form-group basic">
                            <div class="input-wrapper ">
                                <label min="8" max="20" class="label" for="password2">Confirmer mot de passe</label>
                                <input value="" type="password" class="form-control " required="" name="password_confirmation" id="password2" placeholder="Confirmer mot de passe">
                                <i class="clear-input">
                                    <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                </i>
                                                             
                            </div>

                            <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>  
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
                      <?php $__currentLoopData = $livreurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$livreur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                        <div class="modal fade" id="modalLoginForm<?php echo e($livreur->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
             <?php echo csrf_field(); ?>
              <input hidden value="<?php echo e($livreur->id); ?>" type="text" name="livreur_id">
              <select name="user_id" class="form-control">
                <?php $__currentLoopData = $available_accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($account->id); ?>"><?php echo e($account->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </select>
            <button type="submit" class="btn btn-default">Definir</button>
         </form>
             </div>
    </div>
  </div>
</div>
                      <tr>
                        
                        <td>
                      
                           <?php if($livreur->commands->where("delivery_date", today())->count()>0): ?>
                          <span class="dot"></span>
                          <?php endif; ?><?php echo e($livreur->nom); ?><br>
                          créer le: <?php echo e($livreur->created_at->format("d-m-Y H:i:s")); ?>

                         
                        </td>
                          <td>
                            <?php if($livreur->lesroutes->count() > 0): ?>
                           <?php echo e($livreur->lesroutes->last()->created_at->format("d-m-Y H:i:s")); ?> <br>
                        <?php echo e($livreur->lesroutes->last()->observation); ?> <br>
                        <button data-toggle="modal" data-target="#actionsModal" class="btn btn-primary" @click="getActions(<?php echo e($index); ?>)">Voir plus d'actions</button>
                        <?php endif; ?>
                        </td>
                        <td>
                          <?php echo e($livreur->phone); ?>

                        </td>
                        <td>
                          <?php echo e($livreur->adresse); ?>

                        </td>

                        <td>
                          <?php echo e($livreur->payments->where("etat", "en attente")->sum('montant')); ?>

                        </td>
                      
               

                        <td >
                          <?php echo e($livreur->pieces); ?>

                        </td>
                        
                        <td>
                          <?php if($livreur->user): ?>
                          <?php echo e($livreur->user->email); ?>

                          <form method="POST" action="/unset-livreur-account/<?php echo e($livreur->user->id); ?>">
                            <?php echo csrf_field(); ?>
                          <button   type="submit"   class="btn btn-succes btn-sm" >
                          </form>Dissocier</button>
                          <?php else: ?>

                           
                         <button   name="btn" data-toggle="modal" data-target="#modalLoginForm<?php echo e($livreur->id); ?>"  class="btn btn-succes btn-sm" >Associer un compte</button>
                       

                          <?php endif; ?>
                        </td>
                
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
           
            livreurs:<?php echo $livreurs; ?>,
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
<?php if($errors->count() > 0): ?>
<script type="text/javascript">
  $("#addBtn").click();
</script>
<?php endif; ?>
</body>
</html>
<?php /**PATH /var/www/html/jibiat/admin/resources/views/livreurs.blade.php ENDPATH**/ ?>
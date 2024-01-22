<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Utilisateurs</title>

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
<div class="wrapper">
  <!-- Navbar -->
 <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Modifier Utilisateur</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/users">Utilisateurs</a></li>
              <li class="breadcrumb-item active">Modifier Utilisateurs</li>
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
                <h3 class="card-title">Modifier Utilisateur <?php echo e($client->nom); ?></h3>

                <div class="card-tools">
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body " >
                <div class="row">
                        <div class="col-sm-6">

                    <form action="/client-update/<?php echo e($client->id); ?>"  method="POST">
                        <?php echo e(csrf_field()); ?>

                        <?php echo e(method_field('PUT')); ?>

                        <div class="card">
                            <div class="card-header">Modifier information</div>
                          <div class="card-body">

                    <div class="form-group basic ">
                        

                            <div class="input-wrapper <?php if ($errors->has('type')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('type'); ?> alert alert-outline-danger <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>">
                                <label for="city" class="label">Type d'utilisateur</label>
                                <?php if($client->client_type == "ADMIN"): ?>
                                <input  class="form-control " name="type" value="<?php echo e($client->client_type); ?>" readonly required>
                                <?php else: ?>
                                 <select  class="form-control " name="type" required>
                                    <option  value="">
                                        Choisir un type d'utilisateurs
                                    </option>
                                    <?php $__currentLoopData = $types->where("type", "!=", "ADMIN"); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php if($client->client_type == $type->type): ?> selected <?php endif; ?>  value="<?php echo e($type->type); ?>">
                                      <?php echo e($type->type); ?>

                                    </option>

                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php endif; ?>
                                <?php if ($errors->has('type')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('type'); ?>
                                    <span class="text-danger" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            </div>
                        </div>
                    <div class="card-body">

                       <div class="form-group basic">
                            

                            <div class="input-wrapper  <?php if ($errors->has('name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('name'); ?> alert alert-outline-danger <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>">
                                <label for="name" class="label">Nom et prenom</label>
                                <input max="50" placeholder="Nom et prenom" id="name" type="text" class="form-control " name="name" value="<?php echo e($client->nom); ?>" required autocomplete="name" autofocus>

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
                        </div>



                        <div class="form-group basic">
                            

                            <div class="input-wrapper <?php if ($errors->has('phone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone'); ?> alert alert-outline-danger <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>">
                                <label for="phone" class="label">Contact</label>
                                <input maxlength="10" placeholder="Ex: 07000000" id="phone" type="number" class="form-control " name="phone" value="<?php echo e($client->phone); ?>" required autocomplete="phone" autofocus>

                                <?php if ($errors->has('phone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone'); ?>
                                    <span class="text-danger" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            </div>
                        </div>



                      



                        <?php 
                          $communes = array("Adjamé", "Cocody", "Attécoubé", "Bingerville", "Anyama", "Koumassi", "Plateau", "Treichville", "Marcory", "Port-Bouet", "Bassam", "Songon", "Abobo", "Yopougon" );

                          sort($communes);
                           ?>


                       <div class="form-group basic ">
                        

                            <div class="input-wrapper <?php if ($errors->has('city')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('city'); ?> alert alert-outline-danger <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>">
                                <label for="city" class="label">Ville/Commune</label>
                                <select  class="form-control " name="city" required>
                                    <option value="">
                                        Choisir une ville/commune
                                    </option>
                                    
                                    <?php $__currentLoopData = $communes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commune): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                    <option <?php if($commune == $client->city): ?> selected <?php endif; ?> value='<?php echo e($commune); ?>'><?php echo e($commune); ?></option>
                                    
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
 
                                <?php if ($errors->has('city')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('city'); ?>
                                    <span class="text-danger" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            </div>
                        </div>


                         <div class="form-group basic">
                            

                            <div class="input-wrapper <?php if ($errors->has('adresse')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('adresse'); ?> alert alert-outline-danger <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>">
                                <label for="adresse" class="city">Précison adresse </label>
                                <input max="100" placeholder="Ex: Angre 8e tranche... " id="adrssse" type="text" class="form-control " name="adresse" value="<?php echo e($client->adresse); ?>" required autocomplete="adresse" autofocus>

                                <?php if ($errors->has('adresse')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('adresse'); ?>
                                    <span class="text-danger" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            </div>
                        </div>


                        
    
        

                       
        
                    </div>
                </div>



                <div class="form-button-group transparent">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Enregistrer</button>
                </div>
              </div>
                        
                        
                    </form>
                </div>


                <div class="col-sm-6">
                    
                    <form action="/updateuser"  method="POST">
                        <?php echo csrf_field(); ?>
                        <input hidden type="" value="<?php echo e($client->user->id); ?>" name="id">
                        <div class="card">
                            <div class="card-header">Modifier Compte</div>
                             <div class="card-body">
                                 <div class="form-group basic <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?> alert alert-outline-danger <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>">
                            <div class="input-wrapper">
                                <label class="label" for="email1">E-mail</label>
                                <input type="email" class="form-control " name="email" value="<?php echo e($client->user->email); ?>" id="email1" placeholder="Votre e-mail">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>

                                <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                                    <span class="text-danger" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            </div>
                        </div>

        
                        <div class="form-group basic">
                            <div class="input-wrapper <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?> alert alert-outline-danger <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>">
                                <label class="label" for="password1">Mot de passe</label>
                                <input value="" min="8" max="20" name="password" type="password" class="form-control " name="password" required autocomplete="new-password"placeholder="8 caratères minimum">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>

                                <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                                    <span class="text-danger" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            </div>
                        </div>
        
                        <div class="form-group basic">
                            <div class="input-wrapper <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?> alert alert-outline-danger <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>">
                                <label min="8" max="20" class="label" for="password2">Confirmer mot de passe</label>
                                <input value="" type="password" class="form-control "  required name="password_confirmation"  id="password2" placeholder="Confirmer mot de passe">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                              <?php if ($errors->has('password_confirmation')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password_confirmation'); ?>
                                    <span class="text-danger" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                               
                            </div>
                        </div>

                       <div class="form-button-group transparent">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Enregistrer</button>
                </div>
                             </div>
                              
        
                    </div>
               
                    </form>
                     </div>
  
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

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>

<?php /**PATH /var/www/html/jibiat/admin/resources/views/clientedit.blade.php ENDPATH**/ ?>
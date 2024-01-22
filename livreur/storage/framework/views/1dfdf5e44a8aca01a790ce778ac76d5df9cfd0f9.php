<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Jibiat - Certification</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Jibiat certification">
    <meta name="keywords" content="certification, livraison, livreur" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel = " manifest " href="../assets/manifest/livreur.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo.png" />
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
</style>

</head>

<body>
   
<?php if(auth::user()->usertype == "livreur"): ?>

<div class="modal fade dialogbox add-modal" id="InstalAppModal"  data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="pt-3 text-center">
                        <img src="../assets/img/logo-icon.png" alt="image" class="imaged w48  mb-1">
                    </div>
                    <div class="modal-header pt-2">
                        <h5 class="modal-title">Installer l'application Jibiat</h5>
                    </div>
                    <div class="modal-body">
                        Accedez a jibiaT en un clique!
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary " data-dismiss="modal">Plus tard</a>
                            <a href="#" class="btn btn-text-success add-button" data-dismiss="modal">Installer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

   <!-- Terms Modal -->
    <div class="modal fade modalbox" id="termsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Termes et Conditions</h5>
                    <a href="javascript:;" data-dismiss="modal">Close</a>
                </div>
                <div class="modal-body">
                    <p>
                        JibiaT est une plateforme en ligne de gestion pour e-commerçant et de mise en relation vendeur-livreur.
                    </p>
                    <p>

                        Les données collectées dans ce processus de certification serve à vérifier l'identité réelle du livreur et seront stockées par jibiat.
                    </p>
                    
                    <p>
                        Ces données peuvent être transmise à un vendeur ou à des forces de l'ordre en cas d'infraction supposées ou avérées du livreur concernés.
                    </p>

                    <p>
                        Les données utilisateurs collectées par jibiat ne sont ni vendu ni échangées, elles peuvent cependant faire l'objet d'analyse par jibiat où ses partenaires afin d'offrir des services.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- * Terms Modal -->

     <!-- App Sidebar -->
    <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <!-- profile box -->
                    <div class="profileBox pt-2 pb-2">
                        <div class="image-wrapper">
                            <img 
                             <?php if($livreur->photo != NULL): ?>
                          src="<?php echo e(Storage::disk('s3')->url($livreur->photo)); ?>" 
                         <?php else: ?> src="assets/img/sample/brand/1.jpg"  <?php endif; ?>
                        class="imaged  w36">
                        </div>
                        <div class="in">
                            <strong><?php echo e($livreur->nom); ?></strong>
                            <div class="text-muted"><?php echo e($livreur->phone); ?></div>
                        </div>
                        <a href="#" class="btn btn-link btn-icon sidebar-close" data-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon>
                        </a>
                    </div>
                    <!-- * profile box -->
                   

                    <!-- action group -->
                    <!-- <div class="action-group">
                        <a href="app-index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="add-outline"></ion-icon>
                                </div>
                                Deposit
                            </div>
                        </a>
                        <a href="app-index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="arrow-down-outline"></ion-icon>
                                </div>
                                Withdraw
                            </div>
                        </a>
                        <a href="app-index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="arrow-forward-outline"></ion-icon>
                                </div>
                                Send
                            </div>
                        </a>
                        <a href="app-cards.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                My Cards
                            </div>
                        </a>
                    </div> -->
                    <!-- * action group -->

                    <!-- menu -->
                    <!-- <div class="listview-title mt-1">Menu</div>
                    <ul class="listview flush transparent no-line image-listview">
                        <li>
                            <a href="app-index.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="pie-chart-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Overview
                                    <span class="badge badge-primary">10</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-pages.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="document-text-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Pages
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-components.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="apps-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Components
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-cards.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    My Cards
                                </div>
                            </a>
                        </li>
                    </ul> -->
                    <!-- * menu -->

                    <!-- others -->
                    <!-- <div class="listview-title mt-1">Others</div> -->
                    <ul class="listview flush transparent no-line image-listview">

                         <li>
                            <a href="livraisons" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="bicycle-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Mes livraisons
                                    
                                </div>
                            </a>
                        </li>

                          <li>
                            <a href="commencer" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="home-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Acceuil
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="difusions" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="radio-outline"></ion-icon>
                                </div>
                                <div class="in">
                                  Diffusions  
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="compte" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="person-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Mon compte
                                </div>
                            </a>
                        </li>
                      
                        <li>

                            <a href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </div>
                                <div class="in">
                                   <?php echo e(__('Deconnexion')); ?>

                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- * others -->

                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
                    <!-- * others -->

                    <!-- send money -->
                   <!--  <div class="listview-title mt-1">Send Money</div>
                    <ul class="listview image-listview flush transparent no-line">
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar2.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Artem Sazonov</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar4.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Sophie Asveld</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar3.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Kobus van de Vegte</div>
                                </div>
                            </a>
                        </li>
                    </ul> -->
                    <!-- * send money -->

                </div>
            </div>
        </div>
    </div>
    <!-- * App Sidebar -->

    
    <!-- loader -->
    <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">

<a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
            
        </div>
        
        <div class="pageTitle">
          Certification

        </div>
        <?php echo $__env->make("includes.rightmenu", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="extraHeader">
        
    </div>
    </div>
    <!-- * App Header -->


    <!-- Add Card Action Sheet -->
    
    <!-- * Add Card Action Sheet -->
     <?php echo $__env->make("includes.cmdvalidation", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div id="appCapsule" style="margin-top: 40px">
       <div class="section mt-2 text-center">
            <h1>Certification</h1>
            <h4>Certifier mon compte</h4>
        </div>
        <?php if($livreur->certified_at == null): ?>
        <div class="section mb-5 p-2">
            <?php if($current): ?>

            <?php if($current->status == "pending"): ?>
            <div class="card border border-warning">
                <div class="card-body">
            Votre demande de certification est encours de traitement.
            <strong> Demande effectuée le:
            
                <?php echo e($current->created_at->format("d-m-Y")); ?>

                </strong>
                </div>
             </div>   
            <?php else: ?>
            <div class="card border border-danger mb-2">
                <div class="card-body">
            Votre dernière demande  a été réfusée. <br>
            Raisons: <?php echo e($current->comment); ?>.
            <strong> Demande effectuée le:
            
                <?php echo e($current->created_at->format("d-m-Y")); ?>

                </strong>
               <br>
               Vous pouvez introduire une nouvelle demande en remplissant ce formulaire.
          </div></div>
               <form class="send" enctype="multipart/form-data" method="POST" action="send">
                <?php echo csrf_field(); ?>


                <div class="card">
                    <div class="card-body">

                        <div class="card border border-primary">
            <div class="card-header">Pièce d'identité</div>

            <div class="card-body">
               
                    <div class="form-group">
                        <input accept="image/*" type="file" name="piece_photo" >
                        <span class="help-block text-danger">
                             <?php if ($errors->has('piece_photo')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('piece_photo'); ?>
                            <?php echo e($errors->first('piece_photo')); ?></span>
                            <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
                                     
            </div>
        </div>

                       <div class="form-group basic">
                            

                            <div class="input-wrapper  <?php if ($errors->has('name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('name'); ?> alert alert-outline-danger <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>">
                                <label for="name" class="label">Nom complet(telque inscrit sur la pièce d'idendité)</label>
                                <input max="50" placeholder="Nom et Prenom" id="name" type="text" class="form-control " name="name" 
                                <?php if(old('name')): ?>
                                value="<?php echo e(old('name')); ?>" <?php else: ?> value="<?php echo e($livreur->nom); ?>" <?php endif; ?> required autocomplete="name" 
                                autofocus>

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
                                <input maxlength="10" placeholder="Ex: 07000000" id="phone" type="number" class="form-control " name="phone"
                                  <?php if(old('phone')): ?>
                                 value="<?php echo e(old('phone')); ?>" 
                                 <?php else: ?>
                                 value="<?php echo e($livreur->phone); ?>" 
                                 <?php endif; ?>
                                 required autocomplete="phone" autofocus>

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



                         <div class="form-group basic">
                            

                            <div class="input-wrapper <?php if ($errors->has('phone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone'); ?> alert alert-outline-danger <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>">
                                <label for="phone" class="label">Numero whatsapp</label>
                                <input maxlength="10" placeholder="Ex: 0700000000" id="phone" type="number" class="form-control " name="wphone" value="<?php echo e(old('wphone')); ?>" required autocomplete="phone" autofocus>

                                <?php if ($errors->has('wphone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('wphone'); ?>
                                    <span class="text-danger" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            </div>
                        </div>


      <div class="card border border-primary">
            <div class="card-header ">Envoyez une photo où votre visage est clairement visible</div>

            <div class="card-body">
               
                    <div class="form-group">
                        <input required accept="image/*" type="file" name="file" id="">
                         <?php if ($errors->has('file')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('file'); ?>
                        <span class="help-block text-danger"><?php echo e($errors->first('file')); ?></span>
                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
                                     
            </div>
        </div>
       
      
        
                        

                       
        
                    </div>
                </div>

              <div class="custom-control custom-checkbox mt-2 mb-1">
                            <input required type="checkbox" class="custom-control-input" id="customChecka1">
                            <label class="custom-control-label" for="customChecka1">
                                j'accepte  <a href="#" data-toggle="modal" data-target="#termsModal">les termes et conditions d'utilisation</a>
                            </label>
                        </div>


                <div class="form-button-group transparent sendbtn">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Envoyer</button>
                </div>

            </form>
        
            <?php endif; ?>
            
            
            <?php else: ?>
            <form class="send" enctype="multipart/form-data" method="POST" action="send">
                <?php echo csrf_field(); ?>


                <div class="card">
                    <div class="card-body">

                        <div class="card border border-primary">
            <div class="card-header">Pièce d'identité</div>

            <div class="card-body">
               
                    <div class="form-group">
                        <input accept="image/*" type="file" name="piece_photo" >
                        <span class="help-block text-danger">
                             <?php if ($errors->has('piece_photo')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('piece_photo'); ?>
                            <?php echo e($errors->first('piece_photo')); ?></span>
                            <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
                                     
            </div>
        </div>

                       <div class="form-group basic">
                            

                            <div class="input-wrapper  <?php if ($errors->has('name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('name'); ?> alert alert-outline-danger <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>">
                                <label for="name" class="label">Nom complet(telque inscrit sur la pièce d'idendité)</label>
                                <input max="50" placeholder="Nom et Prenom" id="name" type="text" class="form-control " name="name" 
                                <?php if(old('name')): ?>
                                value="<?php echo e(old('name')); ?>" <?php else: ?> value="<?php echo e($livreur->nom); ?>" <?php endif; ?> required autocomplete="name" 
                                autofocus>

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
                                <input maxlength="10" placeholder="Ex: 07000000" id="phone" type="number" class="form-control " name="phone"
                                  <?php if(old('phone')): ?>
                                 value="<?php echo e(old('phone')); ?>" 
                                 <?php else: ?>
                                 value="<?php echo e($livreur->phone); ?>" 
                                 <?php endif; ?>
                                 required autocomplete="phone" autofocus>

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



                         <div class="form-group basic">
                            

                            <div class="input-wrapper <?php if ($errors->has('phone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone'); ?> alert alert-outline-danger <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>">
                                <label for="phone" class="label">Numero whatsapp</label>
                                <input maxlength="10" placeholder="Ex: 0700000000" id="phone" type="number" class="form-control " name="wphone" value="<?php echo e(old('wphone')); ?>" required autocomplete="phone" autofocus>

                                <?php if ($errors->has('wphone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('wphone'); ?>
                                    <span class="text-danger" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            </div>
                        </div>


      <div class="card border border-primary">
            <div class="card-header">Envoyez une photo où votre visage est clairement visible</div>

            <div class="card-body">
               
                    <div class="form-group">
                        <input required accept="image/*" type="file" name="file" id="">
                         <?php if ($errors->has('file')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('file'); ?>
                        <span class="help-block text-danger"><?php echo e($errors->first('file')); ?></span>
                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
                                     
            </div>
        </div>
       
      
        
                        

                       
        
                    </div>
                </div>

              <div class="custom-control custom-checkbox mt-2 mb-1">
                            <input required type="checkbox" class="custom-control-input" id="customChecka1">
                            <label class="custom-control-label" for="customChecka1">
                                j'accepte  <a href="#" data-toggle="modal" data-target="#termsModal">les termes et conditions d'utilisation</a>
                            </label>
                        </div>


                <div class="form-button-group transparent sendbtn">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Envoyer</button>
                </div>

            </form>
            <?php endif; ?>
        </div>
        <?php else: ?>
        Ton compte est certifié!

        <a class="btn btn-primary btn-lg" href="livraisons">Retours à mes livraisons</a>
        <?php endif; ?>
        <div class="mb-3"></div>
       

    </div>
    <!-- * App Capsule -->


    <div></div>
    <!-- App Bottom Menu -->
    
    
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
   
   
   

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="../assets/js/lib/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="../assets/js/lib/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <!-- Owl Carousel -->
   <script src="../assets/js/owl.carousel.min.js"></script>
    <!-- Base Js File -->
    <script src="../assets/js/base.js"></script>
    <script src="../assets/js/livraisons.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"></script>
    <script src="../assets/manifest/js/app.js"></script>
  <script type="text/javascript">
      $(".send").submit(function(){
         $(".sendbtn").attr('disabled','disabled');
         $('.sendbtn').html('Envoie encours...');
        });

  




 
   
  


  </script>
  <?php else: ?>
  <div class="row">
      <div class="card">
          <div class="card-body">
              <span class="text-danger">Accès interdit</span>
               <a class="btn btn-primary" href="<?php echo e(route('logout')); ?>"
    onclick="event.preventDefault();
    document.getElementById('logout-form').submit();" class="item"><ion-icon name="log-out-outline"></ion-icon>
                                <?php echo e(__('Deconnexion')); ?>

                              </a>
                   

                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
          </div>
      </div>
  </div>
 <?php endif; ?>
</body>

</html><?php /**PATH /var/www/html/jibiat/livreur/resources/views/certification.blade.php ENDPATH**/ ?>
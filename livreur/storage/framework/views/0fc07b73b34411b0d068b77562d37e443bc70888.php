<?php if(Auth::check() && Auth::user()->usertype == 'livreur'): ?>
    <script>window.location = "/commencer";</script>
<?php endif; ?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>JibiaT - Livraison</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Se connecter - Jibiat livreur">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="keywords" content="jibiat, login, se connecter" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

     <link rel = " manifest " href="../assets/manifest/livreur.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo.png" />
    
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />
</head>

<body>

    <!-- Dialog with Image -->
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
                            <a href="#" class="btn btn-text-secondary " data-dismiss="modal">Annuler</a>
                            <a href="#" class="btn btn-text-primary add-button" data-dismiss="modal">Installer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Dialog with Image -->

    <!-- loader -->
    <!-- <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div> -->
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="register" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"></div>
        <div class="right">
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="section mt-2 text-center">
            <h1>Se connecter</h1>
            <h4>Remplissez le formulaire pour vous connecter</h4>
        </div>
        <div class="section mb-5 p-2">

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-body pb-1">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="email1">E-mail</label>
                                <input id="email" type="email" class="form-control <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>

                            <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>
        
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="password1">Password</label>
                                <input id="password" type="password" class="form-control <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="password" required autocomplete="current-password">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>

                            <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>
                    </div>
                </div>


                <div class="form-links mt-2">
                    <div>
                        <a  href="register">Cré un compte maintenant</a>
                    </div>
                    <div>
                        <?php if(Route::has('password.request')): ?>
                        <a href="<?php echo e(route('password.request')); ?>" class="text-muted">Mot de passse oublié?</a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-button-group  transparent">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Connexion</button>
                </div>

            </form>
        </div>

    </div>
    <!-- * App Capsule -->



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
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"></script>
    <script src="../assets/manifest/js/app.js"></script>

    <script type="text/javascript">
    let deferredPrompt;

  const addBtn = document.querySelector('.add-button');
  window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent Chrome 67 and earlier from automatically showing the prompt
    e.preventDefault();
    // Stash the event so it can be triggered later.
    deferredPrompt = e;
    // Update UI to notify the user they can add to home screen
    $("#InstalAppModal").modal("show");

    addBtn.addEventListener('click', (e) => {
      // hide our user interface that shows our A2HS button
      $('#InstalAppModal').modal("hide");
      // Show the prompt
      deferredPrompt.prompt();
      // Wait for the user to respond to the prompt
      deferredPrompt.userChoice.then((choiceResult) => {
          if (choiceResult.outcome === 'accepted') {
            console.log('User accepted the A2HS prompt');
          } else {
            console.log('User dismissed the A2HS prompt');
          }
          deferredPrompt = null;
        });
    });
  });

  $( "form" ).submit(function(){var submit = $(this).find(":submit");submit.attr('disabled', 'disabled');submit.html('<span  class="spinner-border  " role="status" aria-hidden="true"></span><span class="sr-only"></span>');});
</script>

</body>

</html><?php /**PATH /var/www/html/livreur/resources/views/auth/login.blade.php ENDPATH**/ ?>
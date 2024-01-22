<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Mon compte</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Finapp HTML Mobile Template">
    <meta name="keywords" content="bootstrap, mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
</head>

<body>

    <!-- loader -->
    <!-- <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div> -->
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Mon compte
        </div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        
        <div class="section mt-3 text-center">
            <div class="avatar-section">
                <a href="#">
                    <img @if($client->photo != NULL)
                          src="{{Storage::disk('s3')->url($client->photo)}}" 
                         @else src="assets/img/sample/brand/1.jpg"  @endif class="imaged w100 rounded">
                    <span class="button" data-toggle="modal" data-target="#photoForm">
                        <ion-icon name="camera-outline"></ion-icon>
                    </span>
                </a>
            </div>
        </div>

        <!-- <div class="listview-title mt-1">Notifications</div>
        <ul class="listview image-listview text inset">
            <li>
                <div class="item">
                    <div class="in">
                        <div>
                            Payment Alert
                            <div class="text-muted">
                                Send notification when new payment received
                            </div>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch4" checked/>
                            <label class="custom-control-label" for="customSwitch4"></label>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <a href="#" class="item">
                    <div class="in">
                        <div>Notification Sound</div>
                        <span class="text-primary">Beep</span>
                    </div>
                </a>
            </li>
        </ul> -->
        <div class="section mt-2">
         @include("includes.cmdvalidation")
        </div> 
        <div class="section mt-2">
            <div class="section-title">Mes informations personnelles</div>
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="editaccount" >
                       @csrf
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="userid1">Nom et prénom</label>
                                <input name="name" value="{{$client->nom}}" type="text" class="form-control" id="userid1" placeholder="Nom et premon">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="select4">Ville / Commune</label>
                                <select name="city" class="form-control custom-select" id="select4">

                                    <option value="1">Choisir</option>
                                    @foreach($communes as $commune)
                                    <option @if($commune == $client->city) selected @endif value="{{$commune}}">{{$commune}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="userid1">Adresse</label>
                                <input name="adresse" value="{{$client->adresse}}" type="text" class="form-control" id="userid1" placeholder="Votre adresse de ramassage">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>


                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="userid1">Contact</label>
                                <input name="phone" value="{{$client->phone}}" type="number"
                                oninput="javascript: if (this.value.length > 10) this.value = this.value.slice(0, this.maxLength)"
                                 maxlengh="10"  class="form-control" id="" placeholder="Votre contact: ex: 0700000000">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Enregistrer</button>
                    </form>

                </div>
            </div>
        </div>

        <div class="section mt-2"> 
        <div class="section-title">Modifier Mot de Passe</div>
            <div class="card">
                <div class="card-body">
                    
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach 
                    
                    
                    <form method="POST" action="editpassword" >
                       @csrf
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="userid1">Mot de passe actuel</label>
                                <input name="current_password" value="" type="password" class="form-control" id="userid1" placeholder="Saisir mot de passe actuel">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        

                       <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="new_password">Nouveau Mot de passe</label>
                                <input name="password" value="" type="password" class="form-control" id="userid1" placeholder="Saisir Nouveau mot de passe">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                         <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="new_password">Confirmer Nouveau Mot de passe</label>
                                <input name="confirm_password"  value="" type="password" class="form-control" id="userid1" placeholder="Confirmer Nouveau mot de passe">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Modifier</button>
                    </form>

                </div>
            </div>
        </div>
        

    </div>
    <!-- * App Capsule -->


    <!-- Dialog Form -->
        <div class="modal fade dialogbox" id="photoForm" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier photo</h5>
                    </div>
                    <form action="photo_upload" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="modal-body text-left mb-2">

                            

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" >Choisir une photo</label>
                                    <input name="file" type="file" class="form-control"  accept="image/*">
                                    <span class="help-block text-danger">{{$errors->first('file')}}</span>
                                    
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <div class="btn-inline">
                                <button type="button" class="btn btn-text-secondary"
                                    data-dismiss="modal">ANNULER</button>
                                <button  class="btn btn-text-primary" >ENVOYER</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- * Dialog Form -->


    <!-- App Bottom Menu -->
   @include("includes.bottom")
    <!-- * App Bottom Menu -->
  @include("includes.sidebar")
    <!-- ///////////// Js Files ////////////////////  -->
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
     <script src="../assets/js/commands.js"></script>
    <!-- Google map -->
    <script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"
   defer
   ></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>


</body>

</html>
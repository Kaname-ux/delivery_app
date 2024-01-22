
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Creer un compte</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Créer un compte livreur">
    <meta name="keywords" content="jibiat, Enregistrement livreur" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
</head>

<body>

    <!-- loader -->
    <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="login" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"></div>
        <div class="right">
            <a href="login" class="headerButton">
                Se connecter
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="section mt-2 text-center">
            <h1>Créer un compte Livreur</h1>
            <h4>Rentre les informations pour créer un compte</h4>
        </div>
        <div class="section mb-5 p-2">
            <form class="send" method="POST" action="{{ route('register') }}">
                @csrf


                <div class="card">
                    <div class="card-body">

                       <div class="form-group basic">
                            

                            <div class="input-wrapper  @error('name') alert alert-outline-danger @enderror">
                                <label for="name" class="label">Nom et Prenom</label>
                                <input max="50" placeholder="Nom et Prenom" id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group basic">
                            

                            <div class="input-wrapper @error('phone') alert alert-outline-danger @enderror">
                                <label for="phone" class="label">Contact</label>
                                <input maxlength="10" placeholder="Ex: 07000000" id="phone" type="number" class="form-control " name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group basic @error('email') alert alert-outline-danger @enderror">
                            <div class="input-wrapper">
                                <label class="label" for="email1">E-mail</label>
                                <input type="email" class="form-control " name="email" value="{{ old('email') }}" id="email1" placeholder="Votre e-mail">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>

                                @error('email')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <?php 
                          $communes = \App\Fee::orderBy('destination' )->get();



                          

                          
                          
                           ?>


                       <div class="form-group basic ">
                        

                            <div class="input-wrapper @error('city') alert alert-outline-danger @enderror">
                                <label for="city" class="label">Ville/Commune</label>
                                <select  class="form-control " name="city" required>
                                    <option>
                                        Choisir une ville/commune
                                    </option>
                                    
                                    @foreach($communes as $commune) 
                                    <option @if($commune->destination == old('city')) selected @endif value='{{$commune->destination}}'>{{$commune->destination}}</option>
                                    
                                    @endforeach
                                </select>
 
                                @error('city')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                         <div class="form-group basic">
                            

                            <div class="input-wrapper @error('adresse') alert alert-outline-danger @enderror">
                                <label for="adresse" class="city">Quartier</label>
                                <input max="100" placeholder="Ex: Angre 8e tranche... " id="adrssse" type="text" class="form-control " name="adresse" value="{{ old('adresse') }}" required autocomplete="adresse" autofocus>

                                @error('adresse')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                      
        
                        <div class="form-group basic">
                            <div class="input-wrapper @error('password') alert alert-outline-danger @enderror">
                                <label class="label" for="password1">Mot de passe</label>
                                <input value="{{old('password')}}" min="8" max="20" name="password" type="password" class="form-control " name="password" required autocomplete="new-password"placeholder="8 caratères minimum">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>

                                @error('password')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group basic">
                            <div class="input-wrapper @error('password') alert alert-outline-danger @enderror">
                                <label min="8" max="20" class="label" for="password2">Confirmer mot de passe</label>
                                <input value="{{old('password_confirmation')}}" type="password" class="form-control "  required name="password_confirmation"  id="password2" placeholder="Confirmer mot de passe">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                              @error('password_confirmation')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                               
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox mt-2 mb-1">
                            <input required type="checkbox" class="custom-control-input" id="customChecka1">
                            <label class="custom-control-label" for="customChecka1">
                                j'accepte  <a href="#" data-toggle="modal" data-target="#termsModal">les termes et conditions d'utilisation</a>
                            </label>
                        </div>
        
                    </div>
                </div>



<div o class="form-button-group transparent sendbtn">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">S'enregistrer</button>
                </div>

            </form>
        </div>

    </div>
    <!-- * App Capsule -->


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

                        Le vendeur est responsable des articles qu'il enregistre sur jibiat. jibiat ne peut être tenue pour responsable de la qualité, de la nature et tout autre aspect liés aux produits enregistrés par le vendeur. L'enregistrement de produits interdits par la loi est strictement interdit sur Jibiat. Tout vendeur le faisant s'expose à titre individuel aux conséquences.
                    </p>
                    
                    <p>
                        Les livreurs inscrits sur Jibiat ne sont pas sous la responsabilité de jibiat, tout acte posé par ces livreurs ne pourront en aucun cas être imputable à Jibiat. Sauf mention expliscite de jibiat  indiquant le contraire.
                    </p>

                    <p>
                        Les données utilisateurs collectées par jibiat ne sont ni vendu ni échangées, elles peuvent cependant faire l'objet d'analyse par jibiat où ses partenaires afin d'offrir des services.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- * Terms Modal -->


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
     
    <!-- Google map -->
    <script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"
   defer
   ></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>

<script type="text/javascript">
    $(".send").submit(function(){
         $(".sendbtn").attr('disabled','disabled');
         $('.sendbtn').html('Envoie encours...');
        });
</script>
</body>

</html>





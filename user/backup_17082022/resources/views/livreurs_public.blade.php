<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Livreurs</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Listes des livreurs">
    <meta name="keywords" content="livreurs, livraisons, " />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <link rel = " manifest " href="../assets/manifest/client.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo-icon.png" />
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
     
    
    
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-9429LR2VMM"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-9429LR2VMM');
</script>
    
</head>

<style type="text/css">




    * {
    margin: 0;
    padding: 0;
}

html {
    height: 100%;
}

/*Background color*/
#grad1 {
    background-color: : #9C27B0;
    background-image: linear-gradient(120deg, #FF4081, #81D4FA);
}

/*form styles*/
#msform {
    text-align: center;
    position: relative;
    margin-top: 20px;
}

#msform fieldset .form-card {
    background: white;
    border: 0 none;
    border-radius: 0px;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    padding: 20px 40px 30px 40px;
    box-sizing: border-box;
    width: 94%;
    margin: 0 3% 20px 3%;

    /*stacking fieldsets above each other*/
    position: relative;
}

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;

    /*stacking fieldsets above each other*/
    position: relative;
}

/*Hide all except first fieldset*/
#msform fieldset:not(:first-of-type) {
    display: none;
}

#msform fieldset .form-card {
    text-align: left;
    color: #9E9E9E;
}

#msform input, #msform textarea {
    padding: 0px 8px 4px 8px;
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    font-family: montserrat;
    color: #2C3E50;
    font-size: 16px;
    letter-spacing: 1px;
}

#msform input:focus, #msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: none;
    font-weight: bold;
    border-bottom: 2px solid skyblue;
    outline-width: 0;
}

/*Blue Buttons*/
#msform .action-button {
    width: 100px;
    background: skyblue;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px;
}

#msform .action-button:hover, #msform .action-button:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue;
}

/*Previous Buttons*/
#msform .action-button-previous {
    width: 100px;
    background: #616161;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px;
}

#msform .action-button-previous:hover, #msform .action-button-previous:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px #616161;
}

/*Dropdown List Exp Date*/
select.list-dt {
    border: none;
    outline: 0;
    border-bottom: 1px solid #ccc;
    padding: 2px 5px 3px 5px;
    margin: 2px;
}

select.list-dt:focus {
    border-bottom: 2px solid skyblue;
}

/*The background card*/
.card {
    z-index: 0;
    border: none;
    border-radius: 0.5rem;
    position: relative;
}

/*FieldSet headings*/
.fs-title {
    font-size: 25px;
    color: #2C3E50;
    margin-bottom: 10px;
    font-weight: bold;
    text-align: left;
}

/*progressbar*/
#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey;
}

#progressbar .active {
    color: #000000;
}

#progressbar li {
    list-style-type: none;
    font-size: 12px;
    width: 25%;
    float: left;
    position: relative;
}

/*Icons in the ProgressBar*/
#progressbar #account:before {
    font-family: FontAwesome;
    content: "\f290";
}

#progressbar #personal:before {
    font-family: FontAwesome;
    content: "\f007";
}

#progressbar #payment:before {
    font-family: FontAwesome;
    content: "\f09d";
}

#progressbar #confirm:before {
    font-family: FontAwesome;
    content: "\f00c";
}

/*ProgressBar before any progress*/
#progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 18px;
    color: #ffffff;
    background: lightgray;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px;
}

/*ProgressBar connectors*/
#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: lightgray;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1;
}

/*Color number of the step and the connector before it*/
#progressbar li.active:before, #progressbar li.active:after {
    background: skyblue;
}

/*Imaged Radio Buttons*/
.radio-group {
    position: relative;
    margin-bottom: 25px;
}

.radio {
    display:inline-block;
    width: 204;
    height: 104;
    border-radius: 0;
    background: lightblue;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
    cursor:pointer;
    margin: 8px 2px; 
}

.radio:hover {
    box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3);
}

.radio.selected {
    box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1);
}

/*Fit image in bootstrap div*/
.fit-image{
    width: 100%;
    object-fit: cover;
}

  body {
    background-color: #EDEDF5;
    border-radius: 10px
}
  
  .stats {
    background: #f2f5f8 !important;
    color: #000 !important
}

.articles {
    font-size: 10px;
    color: #a1aab9
}

.number1 {
    font-weight: 500
}

.followers {
    font-size: 10px;
    color: #a1aab9
}

.number2 {
    font-weight: 500
}

.rating {
    font-size: 10px;
    color: #a1aab9
}

.number3 {
    font-weight: 500
}
.page-item {
   background-color: #5987B3
  
}
</style>

<body>

     <?php
    $communes = array("Adjamé", "Cocody", "Biabou", "Gonzackville", "Attécoubé", "Bingerville", "Agnama", "Koumassi", "Plateau", "Treichville", "Marcory", "Port-Bouet", "Grand Bassam", "Songon", "Abobo", "Yopougon", "N'dotre","KM17", "Abobodoumé", "Azito", "Abatta", "Faya" );


                          sort($communes);
             ?>
<div class="modal fade  modalbox " id="LivChoice" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title">Livreurs à proximité</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        

                    </div>
                    
                    <div   class="modal-body">
                        <div class="action-sheet-content LivChoiceBody">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade  modalbox " id="difuseModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title difuseTitle"></h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        

                    </div>
                    
                    <div   class="modal-body">
                    <div class="difuseBody">
                               
                    </div>

                    <div class="difuseLiv">
                               
                    </div>
                    </div>
                </div>
            </div>
        </div>

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
                        Gère tes commandes facilemet, trouve des livreurs rapidement!
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



<div class="modal fade modalbox" id="AsearchModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title confirmModalTitle"></h5>
                       <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    
                    <div class="modal-body " >
                        
                        <form method="POST" action="">
                    @csrf
                    <input hidden type="" value="1" name="asearch">
                    <div class="form-check ">
  <input name="certified" class="form-check-input" type="checkbox"  value="1">
  <label class="form-check-label" >Afficher seulement les livreurs certifier</label>
  </div>
  <hr>
                    
                     <div class="mb-2 ">
                    <span style="font-weight:bold;"> Lieu d'habitation</span>
  <div class="col-12">                  

   

</div> 
               </div>
<hr>



                     
                    
                   <button type="submit"  class="btn btn-success phone">Confirmer</button>
                   <button  class="btn btn-default phone" data-dismiss="modal">Annuler</button>
                   </form>
                    </div>
                  
                </div>
            </div>
        </div>





<div class="modal fade modalbox" id="confirmModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title confirmModalTitle"></h5>
                       <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    
                    <div class="modal-body " >
                        <div class="confirmModalBody">
                          
                        </div>

                        <form method="POST" action="signal">
                    @csrf
                    
                    
                    <input  required class="form-control" id="liv_id"  name="liv_id" hidden >
                     <div class="mb-2 ">
                    <span style="font-weight:bold;"> Quelles sont les raisons du signalement </span>
                     
                   
                     <div class="form-group">
                     
                    <select name="reasons" class="form-control">
                        <option>Choisir les raisons</option>
                        <option value="Recette non versée">Recette non versée</option>
                        <option value="colis non rétournés">colis non rétournés</option>
                        <option value="Recette et colis non rétournés">Recette et colis non rétournés</option>
                    </select>
                     </div>
               </div>



                     <div class="form-group">
                      <label class="form-label">Date des faits
                      </label>
                    <input id="fact_date" required class="form-control"  type="date" name="fact_date"  >
                     </div>

                     <div class="form-group">
                      <label class="form-label">Commentaire (Facultatif)
                      </label>
                      <textarea placeholder="" class="form-control" id="comment" row="3" name="comment"></textarea>
                     </div>


                     
                    
                   <button  class="btn btn-success phone">Confirmer</button>
                   <button  class="btn btn-default phone" data-dismiss="modal">Annuler</button>
                   </form>
                    </div>
                  
                </div>
            </div>
        </div>
    <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div>
<div class="modal fade dialogbox add-modal" id="bigModal"  data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    
                    <div class="modal-header pt-2">
                        
                    </div>
                    <div class="modal-body bigModalBody">
                        
                    </div>
                   
                      <button class="close" data-dismiss="modal">&times;</button>
                    
                </div>
            </div>
        </div>
    

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Livreurs
        </div>
        <div class="right">
            
        </div>



    </div>
    

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="section mt-2">
            <div class="section-title">Vérifier l'état d'une publication</div>
             <div class="row">
            <div class="col">
                <input onchange="$('.difusecheck').val($(this).val())" type="number" class="form-control" placeholder="numero de publication" name="">
            </div>
            <div class="col">
                <button class="btn btn-primary btn sm difusecheck">Verifier</button>
            </div>
            </div>
        </div>

        <!-- Transactions -->

       <div class="section mt-2">
            <div class="section-title"></div>
            <div class="transactions">
                <!-- item -->
                
              @if (session('status') )
      <div class="alert alert-success mb-1" role="alert">
      {!! session('status') !!}
      </div>

      @endif

       
         @if (session('warning') )
      <div class="alert alert-danger mb-1" role="alert">
      {{ session('warning') }}
      </div>
      @endif

                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            Une erreur s'est produite.
        </ul>
    </div>
@endif
               
                <!-- * item -->
            </div>
        </div>



        
        <div class="section mt-2">



           <!-- MultiStep Form -->

    <div class="row justify-content-center mt-0">
        <div class="col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2><strong>Publiez vos colis</strong></h2>
                <p>Suivez les étapes pour atteindre des centaines de livreurs certifiés</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form method="POST" action="publicdifuse" id="msform">
                            @csrf
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>Colis</strong></li>
                                <li id="personal"><strong>Récuperation</strong></li>
                                <li id="payment"><strong>Destination et tarifs</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul>
                            <!-- fieldsets -->
                            <fieldset class="colis">
                                <div class="form-card">
                                    <h2 class="fs-title">Informations colis</h2>
                                    <div class="form-group">
                                    <input required name="qty" type="number" placeholder="Nombre de colis"  class="form-control qty">
                                      <span class="qty_er mt-0 text-danger"></span> 
                                    </div>

                                       <div class="form-group">
                                        <label>Data de livraison</label>
                
                                <input name="deliv_date"  type="date"   class="delivdate">
                                    <span class="delivdate_er text-danger"></span> 
                                 </div>
                                    
                                </div>
                                <input  type="button" name="next" class="next action-button btn-primary" value="Suivant"/>
                            </fieldset>
                            <fieldset class="recup">
                                <div class="form-card">
                                    <h2 class="fs-title">Récupération</h2>

                                    <div class="form-group">
                                    <select required name="from" class="list-dt lieu">
                                     <option value="">Choisir un lieu</option>
                                     @foreach($communes as $commune)
                                     <option value="{{$commune}}">{{$commune}}</option>
                                       @endforeach
                                      </select>Lieu
                                      <span class="lieu_er text-danger"></span>
                                  </div>
  
                <div class="form-group">
                
                <input required type="number" placeholder="Mon conatct"  class="form-control contact" name="contact">
                 <span class="contact_er text-danger"></span>   
                </div>
               
           
                <div class="form-group">
               
                <input required name="wa" type="number" placeholder="Mon whatsapp"  class="form-control wa">
                 <span class="wa_er text-danger"></span>   
                </div>
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous " value="Précédent"/>
                                <input type="button" name="next" class="next action-button btn-primary" value="Suivant"/>
                            </fieldset>
                            <fieldset class="dest">
                                <div class="form-card">
                                    <h2 class="fs-title">Destinations et tarifs</h2>
                                    
  <div class="form-group">
    
    <input onchange="if($(this).val()>=1) {$('.fees').attr('disabled', 'disabled');}else{$('.fees').removeAttr('disabled');} "  name="single_fee" type="number" placeholder="Saisir tarif unique"  class="form-control single_fee">
 </div>

                    <h4>Detailler par lieu de livraison</h4>
                           <button id="addRow" type="button" class="btn btn-info mb-2">Ajoueter une Destination</button>
 
                             <div id="newRow" class="mb-2"></div>
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Précédent"/>
                                <input type="button" name="make_payment" class="next action-button last" value="Confirmer"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card recap">
                                   
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Précédent"/>
                                <button type="submit" name="make_payment" class="action-button" value="Confirmer">Valider</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>







    
        </div>
        <div class="section mt-2">
            
        
              <span class="text-danger mt-2">Assurez vous que votre GPS est activé!</span>
              <button class="btn btn-primary btn-lg btn btn-block globalNearByLivreur mb-2"><ion-icon name="location-outline"></ion-icon>Voir les livreurs à proximité</button>
  
           
            <div class="transactions">
                <div class="section-title">{{$zone}}  @if( $zone == "Resultat de votre recherche").  {{$livreurs->count()}} trouvé(s) 
            <div class="left">
            <a href="livreurs" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>Revenir à la liste
            </a>
        </div>


            @endif
        </div>
                <!-- item -->
               <div style="overflow-x: auto;white-space: nowrap">{{$livreurs->links()}}</div> 

               <div class="section mt-2">
            <div class="section-title"></div>
            <div class="transactions">
                <!-- item -->
                <strong>Afficher par commune</strong>
              <form action="?" class="search-form form-inline">
                
            <div class="form-group searchbox ">
                <select required name="city" class="form-control">
                    <option value="">Choisir une commune</option>
                @foreach($communes as $commune)
                <option value="{{$commune}}">{{$commune}}</option>
                @endforeach
               </select>
            <button class="btn btn-success" type="submit"><ion-icon name="arrow-forward-outline"></ion-icon></button>

            </div>

            
            
        
        </form>

               
               
                <!-- * item -->
            </div>
        </div>
                @if($livreurs->count()>0 )

               @include("includes.livreurs_public")
                @endif
               
                <!-- * item -->
                
            </div>
        </div>
       

        <div class="row ">
           <div class="col-12">
               <div style="overflow-x: auto;white-space: nowrap">{{$livreurs->links()}}</div> 
               </div>
 
        </div>
        <div class="section mt-2">
            <div class="section-title"></div>
            <div class="transactions">
                <!-- item -->
                
              

               
               
                <!-- * item -->
            </div>
        </div>
 @include("includes.footer")

    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
   
 @include("includes.bottom_public")
    <!-- * App Bottom Menu -->

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="../assets/js/lib/jquery-3.4.1.min.js"></script>
    <script src="../assets/manifest/js/app.js"></script>
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




<script src="../assets/js/star-rating.min.js"></script>


<script type="text/javascript">



    $(document).ready(function(){
    
   
var current_fs, next_fs, previous_fs; //fieldsets
var opacity;
var errors = [];
$(".next").click(function(){


    
    current_fs = $(this).parent();

     if ( current_fs.hasClass( "colis" ) ) {
   
      if($('.qty').val() == "" )
      {
        $('.qty_er').html("Veullez Indiquer la quantité");
        errors.push(1);

      }else{
        $('.qty_er').html("");
        errors = $.grep(errors, function(value) {
  return value != 1;
});

      }
   
        var delivdate = $(".delivdate").val();

    if (!Date.parse(delivdate))
      {
        $('.delivdate_er').html("Veullez Indiquer la date de livraison");
        errors.push(2);
      }else{
        $('.delivdate_er').html("");
        errors = $.grep(errors, function(value) {
  return value != 2;});
      }


   if(errors.length == 0)
   { 

    


    next_fs = $(this).parent().next();
       
       //Add Class Active
       $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
       
       //show the next fieldset
       next_fs.show(); 
       //hide the current fieldset with style
       current_fs.animate({opacity: 0}, {
           step: function(now) {
               // for making fielset appear animation
               opacity = 1 - now;
   
               current_fs.css({
                   'display': 'none',
                   'position': 'relative'
               });
               next_fs.css({'opacity': opacity});
           }, 
           duration: 600
       });
   }
 
    }


     if ( current_fs.hasClass( "recup" ) ) {

      if($('.lieu').val() == "" )
      {
        $('.lieu_er').html("Veullez choisir le lieu de récupération");
        errors.push(1);
      }else{
        $('.lieu_er').html("");
        errors = $.grep(errors, function(value) {
          return value != 1;});
      }



      if($('.contact').val().length != 10 )
      {
        $('.contact_er').html("Veullez saisir un contact valide");
        errors.push(2);
      }else{
        $('.contact_er').html("");
        errors = $.grep(errors, function(value) {
  return value != 2;});
      }



      if($('.wa').val().length != 10 )
      {
        $('.wa_er').html("Veullez saisir un contact valide");
      }else{
        $('.wa_er').html("");
        errors = $.grep(errors, function(value) {
  return value != 3;});
      }



       if(errors.length == 0)
   { next_fs = $(this).parent().next();
       
       //Add Class Active
       $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
       
       //show the next fieldset
       next_fs.show(); 
       //hide the current fieldset with style
       current_fs.animate({opacity: 0}, {
           step: function(now) {
               // for making fielset appear animation
               opacity = 1 - now;
   
               current_fs.css({
                   'display': 'none',
                   'position': 'relative'
               });
               next_fs.css({'opacity': opacity});
           }, 
           duration: 600
       });
   }
 
    }




    if ( current_fs.hasClass( "dest" ) ) {

    next_fs = $(this).parent().next();
       
       //Add Class Active
       $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
       
       //show the next fieldset
       next_fs.show(); 
       //hide the current fieldset with style
       current_fs.animate({opacity: 0}, {
           step: function(now) {
               // for making fielset appear animation
               opacity = 1 - now;
   
               current_fs.css({
                   'display': 'none',
                   'position': 'relative'
               });
               next_fs.css({'opacity': opacity});
           }, 
           duration: 600
       });
   
 
    }



   





   
});

$(".previous").click(function(){
    
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();
    
    //Remove class active
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
    
    //show the previous fieldset
    previous_fs.show();

    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            previous_fs.css({'opacity': opacity});
        }, 
        duration: 600
    });
});


$('.last').click(function(){

    var single_fee = "";
    var cities = "";



    if($('.cities').length > 0){

        $(".cities").each(function(index){
      cities += "<div class='chip chip-media' style='margin-bottom: 3px'><i class='chip-icon bg-dark'>"+$('.qties').eq(index).val()+"</i><span class='chip-label'>"+$(this).val()+":" + $('.fees').eq(index).val()+"</span></div>" ;
  });
        
    }
    if($('.single_fee').val() != ""){
        var single_fee = ".<br> Tarif unique:"+ $('.single_fee').val() + "FCFA.";
    }
   $('.recap').html($('.qty').val()+ " colis.<br> Lieu de Récuperation: "+ $('.lieu').val() + ".<br> Date de livraison: "+$('.delivdate').val() + "<br>" + single_fee + cities);
});






$('.radio-group .radio').click(function(){
    $(this).parent().find('.radio').removeClass('selected');
    $(this).addClass('selected');
});

$(".submit").click(function(){
    return false;
})
    
});
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
spinner = '<span  class="spinner-border  siteSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>';
    $(".globalNearByLivreur").click( function() {
     
     $(this).prepend(spinner);
     $(this).attr("disabled", "disabled");

     var assign_modal = $('#LivChoice');
     var assign_body = $('.LivChoiceBody');
     var top = $('.top');


     if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
          var lat = position.coords.latitude;
          var long = position.coords.longitude;
          var accuracy = position.coords.accuracy;
          
          $.ajax({
         url: 'getglobalnearby',
         type: 'post',
         data: {_token: CSRF_TOKEN, lat:lat, long:long},
     
        
     
         success: function(response){
           
                  (assign_body).html(response.nearby);
                  
                  (assign_modal).modal('show');
                   $('.globalNearByLivreur').removeAttr('disabled');
                   $('.globalNearByLivreur').html('<ion-icon name="location-outline"></ion-icon>Voir les livreurs à proximité');

                },
     error: function(response){
                  $('.globalNearByLivreur').removeAttr('disabled');
                   $('.globalNearByLivreur').html('<ion-icon name="location-outline"></ion-icon>Voir les livreurs à proximité');
                  alert("Une erruer s'est produite");

                }
               
       });
      },
      function error(msg) {$('#position').modal('show');},
      {maximumAge:10000, timeout:5000, enableHighAccuracy: true});
  } else {
      alert("Geolocation API is not supported in your browser.");
  }
  
     });  

$('.big').click(function(){var src = $(this).attr('src');$('.bigModalBody').html("<img src='"+src+"' width='100%' height='100%'>");$("#bigModal").modal("show");});

   
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





   


$(".difusecheck").click( function() {
   id = $(this).val();
            $.ajax({
      url: 'difusecheck',
      type: 'post',
      data: {_token: CSRF_TOKEN, id:id},
      success: function(response){
        $("#difuseModal").modal("show");
        $(".difuseBody").html("<h5>"+response.difuse['description']+"</h5>");
        $(".difuseTitle").html("Numero publication: " +response.difuse['id']);

        

           $('.difuseLiv').html(response.livreurs);
       


      },

     error: function(response){
        alert("Veuillez verifier le numero ou votre connexion internet");
     }        

            
    });
}); 







$("#addRow").click(function () {
        

        $('#newRow').prepend('<div id="inputFormRow" ><div class="row mt-2" ><div class="col"><div class="form-group"> <select  required name="cities[]" class="list-dt cities"><option value="">Choisir un lieu</option> @foreach($communes as $commune3) <option value="{{$commune3}}">{{$commune3}}</option>@endforeach</select><span class="from_er text-danger"></span></div></div></div><div class="row"><div class="col"><div class="form-group"><input name="qties[]" type="number" placeholder="Nbre de colis" required class="form-control qties"><span class="contact_er text-danger"></span></div></div><div class="col"><div class="form-group"><input name="fees[]" type="number" placeholder="Tarif livraison"  class="form-control fees"><span class="contact_er text-danger"></span></div></div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm mt-1  ">Supprimer</button><hr></div></div>');

             if($('.single_fee').val() != ""){
        $(".fees").attr("disabled", "disabled");
        $(".fees").removeAttr("required");
       
    }
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });

$(".single_fee").on("change click focus keyup", function () {
    if($(this).val() != ""){
        $(".fees").attr("disabled", "disabled");
        $(".fees").removeAttr("required");
       
    }else{
        $(".fees").removeAttr("disabled");
        
        $(".fees").attr("required", "required");
    }
});
</script>

</body>

</html>
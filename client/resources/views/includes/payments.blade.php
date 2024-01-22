<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>JibiaT - Mes Payements</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Finapp HTML Mobile Template">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="bootstrap, mobile template, cordova, phonegap, mobile, html, responsive" />
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


  


    
 <!-- return modal -->
        <div class="modal fade action-sheet  " id="payModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div hidden class="left payReturn">
                        <a href="#" class="headerButton returnPay">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                        Retour
                    </a>
                    </div>
                        <h5 class="modal-title">Payements</h5>
                         
                       <span class="payLivreur"></span> <span class="payTotal float-right"></span>
                       
                    
                     
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content payBody">
                            <span  hidden="hidden" class="spinner-border  paySpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
                            
                        </div>
                        <hr>
                        <div hidden class="text-center payeur">
                           
                        <img  src='' alt='img'  class='payeurimg image-block imaged w48'>
                        <br>
                          Noter  <strong class="payeurnom"></strong>
                           
                        
                    

                    
                         <input  id='input-1' name='rate' class='rating rating-loading' data-min='1' data-max='5' data-step='1'  data-size='xs'><button type='submit' class='btn btn-success rateLivreur'>Envoyer Note</button>
                          <input class="payeurid" type='hidden' name='id' required value=''>
                            
                   
                    
                
                    </div>
                    <div class="paySuccess">
                      
                    </div>
                </div>
            </div>
        </div>
      </div>


<div class="modal fade action-sheet  " id="doneModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4>Detail payment</h4> 
                       <span class="donee"></span> 
                       
                    
                     
                        

                    </div>
                    <div   class="modal-body doneModalBody">
                        
                   
                    
                
                    </div>
                    
                </div>
            </div>
        </div>
      </div>

    

      
        

    <!-- loader -->
    <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="commencer" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        
        
        <img src="assets/img/675x175orange.png" width="67" height="17" alt="logo" class="logo">
    </div>
    <!-- * App Header -->
    <div class="extraHeader pr-0 pl-0">
        <ul class="nav nav-tabs lined" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#waiting" role="tab">
                    En attente
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#paid" role="tab">
                    Payés
                </a>
            </li>
        </ul>
    </div>
   

    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active">

        <div class="section  tab-content mt-2 mb-1">
           
            <!-- waiting tab -->
            <div class="tab-pane fade show active" id="waiting" role="tabpanel">


                <div class="section mt-2">
            <div class="section-title"></div>

            <div class="row">
              @if($unpayed->count()>0)
               @foreach($unpayed as $waiting)
               
                    <div class="col-6 mb-2">
                        <div class="bill-box">
                            <div class="img-wrapper">
                                @foreach($livreurs as $livreur)
                                @if($livreur->id == $waiting->livreur->id)
                                {{$livreur->nom}}
                                @endif
                                @endforeach
                            </div>
                            <div class="price">{{$waiting->montant}}</div>
                            
                            <button  value="{{$waiting->livreur->id}}"  class="btn btn-primary detail">DETAIL</button>

                            <button id='allPay{{$waiting->livreur_id}}' class='btn btn-success mt-1 payall' value='{{$waiting->livreur_id}}'>Tout payer</button>
                       </li></ul>

       <br>
      <span hidden id='allPayButtons{{$waiting->livreur_id}}'>
     <div class="form-group"> 
      <select class='form-control payMethod{{$waiting->livreur_id}}' >
       <option value='no'>
        Choisir mode de paiement
       </option>

       <option value='Main à main'>
       Main à main
       </option>
       <option value='Mobile money'>
       Mobile money
       </option>
       <option value='Virement bancaire'>
        Virement bancaire
       </option>
      </select>
      </div>  
      
       <button id='allPayConfirm{{$waiting->livreur_id}}' value='{{$waiting->livreur_id}}'  class='btn btn-info allPayConfirm'  data-allPayButtons='allPayButtons{{$waiting->livreur_id}}'>
        
        <span  hidden class="spinner-border spinner-border-sm allPaySpinner{{$waiting->livreur_id}}" role=status aria-hidden="true"></span><span class=sr-only></span>
       
       Confirmé</button>
       <button value='{{$waiting->livreur_id}}'  class='btn btn-danger allPayCancel{{$waiting->livreur_id}} allPayCancel'>Annuler</button>
      </span>


                        </div>
                    </div>
                
                @endforeach
                @else
              Aucun payement en attente
              @endif
        </div>


     
           </div>
            </div>
           

            <!-- * waiting tab -->



            <!-- paid tab -->
            <div class="tab-pane fade" id="paid" role="tabpanel">

                 <div class="section mt-2">
            <div class="section-title"></div>

            <div class="row">
               @foreach($payed as $done)
               
                    <div class="col-6 mb-2">
                        <div class="bill-box">
                            <div class="img-wrapper $donee{{$done->id}}">
                              {{$done->created_at->format('d-m-Y')}}
                                @foreach($livreurs as $livreur2)
                                @if($livreur2->id == $done->livreur_id)
                                {{$livreur2->nom}}
                                @endif
                                @endforeach

                            </div>
                            
                            <div class="price">{{$done->montant}}</div>
                            
                            <button data-done="{{$done->id}}" data-id="{{$done->livreur_id}}" data-montant="{{$done->montant}}" data-date="{{$done->created_at->format('d-m-Y')}}"  value="{{$done->observation}}"  class="btn btn-primary doneDetail">
                           <span  hidden class="spinner-border spinner-border-sm doneSpinner{{$done->id}}" role=status aria-hidden="true"></span><span class=sr-only></span>

                            DETAIL</button>


     


                        </div>
                    </div>
                
                @endforeach

        </div>


        </div>
    
            </div>
            <!-- * paid tab -->

        </div>

    </div>

    @include("includes.bottom")
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    <!-- <div class="appBottomMenu">
        <a href="app-index.html" class="item">
            <div class="col">
                <ion-icon name="pie-chart-outline"></ion-icon>
                <strong>Overview</strong>
            </div>
        </a>
        <a href="app-pages.html" class="item">
            <div class="col">
                <ion-icon name="document-text-outline"></ion-icon>
                <strong>Pages</strong>
            </div>
        </a>
        <a href="app-components.html" class="item">
            <div class="col">
                <ion-icon name="apps-outline"></ion-icon>
                <strong>Components</strong>
            </div>
        </a>
        <a href="app-cards.html" class="item">
            <div class="col">
                <ion-icon name="card-outline"></ion-icon>
                <strong>My Cards</strong>
            </div>
        </a>
        <a href="app-settings.html" class="item">
            <div class="col">
                <ion-icon name="settings-outline"></ion-icon>
                <strong>Settings</strong>
            </div>
        </a>
    </div> -->
    <!-- * App Bottom Menu -->


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
    <script src="../assets/js/commands.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"></script>
    <script src="../assets/manifest/js/app.js"></script>

    @if(session('note_message'))
<a hidden id="note_message" href="{{session('note_message')}}"></a>

<script type="text/javascript">
   $( document ).ready(function() {
    document.getElementById("note_message").click();
});


   
  
</script>


@endif

<script type="text/javascript">
    $('.detail').click( function() {
   var livreur_id = $(this).val();
   
   $('#payModal').modal('show');
    
   $('.payBody').html('<span   class="spinner-border spinner-border paySpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>');


     $.ajax({
       url: 'paydetail',
       type: 'post',
       data: {_token: CSRF_TOKEN,livreur_id: livreur_id},
   
       success: function(response){
                 $('.payReturn').removeAttr('hidden');
                $('.payBody').html(response.display);
                $('.payTotal').html('<strong>Total:' +response.total + '</strong>');
                 $('.payLivreur').html(response.livreur);
                 $('#singlePayScript').html(response.single_pay_script);
              },
   error: function(response){
               
                alert('Une erruer s\'est produite');
              }
             
     });
   });



    $('.allPayConfirm').click( function() {
       var livreur_id = $(this).val();
       var method = $('.payMethod'+livreur_id).val();
       var curallPaybtns = $(this).data('allPayButtons');
    
   
   $('.allPaySpinner'+livreur_id).removeAttr('hidden');

     if(method == 'no')
     {alert('veuillez choisr une methode de paiement');

      $('.allPaySpinner'+livreur_id).attr('hidden', 'hidden');}
     else {
      $.ajax({
            url: 'payall',
            type: 'post',
            data: {_token: CSRF_TOKEN,livreur_id: livreur_id, method:method},
        
            success: function(response){
                     $('#allPayButtons'+livreur_id).attr('class', 'alert alert-success');
                     $('#allPayButtons'+livreur_id).html('Payé');
                     $('#payDetail'+livreur_id).attr('hidden', 'hidden');

                     $('.payeur').removeAttr('hidden');
                     $('.payeurid').val(livreur_id);
                     $('.payeurimg').attr('src', response.src);
                     $('.payeurnom').html(response.nom);
                      
                   },
        error: function(response){
                    
                     alert('Une erruer s\'est produite');
                     $('.allPaySpinner'+livreur_id).attr('hidden', 'hidden');
                   }
                  
          });}
   });


$('.payall').click(function(){
       $(this).attr('hidden', 'hidden');
    var id = $(this).val();
  $('#allPayButtons'+id).removeAttr('hidden');
  $('.allPayCancel'+id).removeAttr('hidden');
 
});


 $(".allPayCancel").click(function(){
   id = $(this).val();
     $(this).attr('hidden', 'hidden');
   $('#allPayButtons'+id).attr('hidden', 'hidden');
   $('#allPay'+id).removeAttr('hidden');
   $('#payDetail'+id).removeAttr('hidden');
});


 $('.doneDetail').click(function(){
  
    var doneDate = $(this).data("date"); 
    var id = $(this).data("id");
    var ids = $(this).val();
    var montant = $(this).data("montant");
    var done = $(this).data("done");
    $(".doneSpinner"+done).removeAttr("hidden");

    $.ajax({
            url: 'donedetail',
            type: 'post',
            data: {_token: CSRF_TOKEN,ids: ids, id: id},
        
            success: function(response){
                     $('.doneModalBody').html(response.dones);
                     $('.donee').html(response.livreur_nom + " - "+ montant + " - "+ doneDate);
                     $('#doneModal').modal('show');
                      $('.doneSpinner'+done).attr('hidden', 'hidden');
                   },
        error: function(response){
                    
                     alert('Une erruer s est produite');
                     $('.doneSpinner'+done).attr('hidden', 'hidden');
                   }
                  
          });
  

});

</script>
</body>

</html>
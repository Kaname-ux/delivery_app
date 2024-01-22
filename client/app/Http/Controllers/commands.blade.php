<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Mes commandes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Finapp HTML Mobile Template">
    <meta name="keywords" content="bootstrap, mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
</style>

</head>

<body>

@include("includes.commands_modal")
    
    <!-- loader -->
    <!-- <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div> -->
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">

<a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
            
        </div>
        <div class="pageTitle">
            Mes commandes 
        </div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>

        <div class="extraHeader">
        <form class="search-form">
            <div class="form-group searchbox">
                <input onkeyup="search()" id="Search" type="text" class="form-control">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
            </div>
        </form>
    </div>
    </div>
    <!-- * App Header -->


    <!-- Add Card Action Sheet -->
    
    <!-- * Add Card Action Sheet -->

    <!-- App Capsule -->
    <div id="appCapsule" style="margin-top: 40px">
      <div class="section full mt-4">
            <div class="section-heading padding">
                <h2 class="title">Commande à venir</h2>
                <span style="font-size:20px" class="link text-success ">
                    @if($upcomings->count()>0)
                {{$upcomings->sum('montant')}}F ({{$upcomings_count->sum('nbre')}})
                @endif
            </span>
                
            </div>
            
            <div class="item">
                <div class="card">
                    <div class="card-body">
             @if($upcomings->count()>0)
      
         
         @foreach($upcomings  as $x=>$upcoming)

         
            <a class="btn-group" href="commands?bydate&route_day={{$upcoming->delivery_date->format('Y-m-d')}}">
  <button style="margin-bottom: 5px; border-top-left-radius: 20px; border-bottom-left-radius: 20px" style=" border-radius: 20px;"  class="btn btn-secondary btn-sm ">{{$upcoming->delivery_date->format('d-m-Y')}}</button>
  <button style="margin-bottom: 5px; border-top-right-radius: 20px; border-bottom-right-radius: 20px" type="button" class="btn btn-success btn-sm " >
    {{$upcoming->montant}}F ({{$upcomings_count[$x]->nbre}})
  </button>
  </a>



         
         @endforeach
         @else
         Aucune commande dans les prochains jours
      
      @endif   
          </div>  
          </div>    
            </div>
        </div>

             <div class="section  pt-1" >
            <div class="wallet-card">
                <!-- Balance -->
                <div class="balance">
                    <div class="left">
                        <span class="title">Total commandes 
                                  @if($state) 
            <span
        @if($state == 'encours')     
      class="badge badge-danger"
      @endif

      @if($state == 'recupere')
      class="badge badge-warning"
      @endif

      @if($state == 'en chemin')
      class="badge badge-info"
      @endif

      @if($state == 'termine')
      class="badge badge-success"
      @endif
      
      @if($state == 'annule')
      class="badge badge-secondary"
      @endif

      >
      @if($state == 'encours' && $attente)
      En attente 
      @else
      @if($state == 'termine' )
      Livrés 
      @else
      {{$state}}
      @endif
      @endif 
      

      
      @endif
      </span>

                          @if($day != "Aujourd'hui")
                                         {{date_create($day)->format('d-m-Y')}}
                                        @else
                                        {{$day}}
                                        @endif
                        </span>
                        <h5 class="total"> {{$total}} @if($state)
                            ({{$commands->count()}})
                            @else
                            ({{$all_commands->count()}}) 
                            @endif </h5>
                    </div>

                    <div class="right">
                        <a href="#" class="button" data-toggle="modal" data-target="#depositActionSheet">
                            <ion-icon name="add-outline"></ion-icon>
                        </a>
                    </div>
                    
                </div>
                
                <!-- * Balance -->
                <!-- Wallet Footer -->
                <div class="wallet-footer">
                    <div class="item">
                        <a href="#" data-toggle="modal" data-target="#withdrawActionSheet">
                            <div class="icon-wrapper bg-primary">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </div>
                            <strong>Date</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" class="pay">
                            <div class="icon-wrapper badge-warning" >
                                <ion-icon name="cash-outline"></ion-icon>
                            </div>
                            <strong>Payement</strong>
                             @if($payments_by_livreurs->count()>0)<span style="color: red; font-size: 15px"> {{$payments_by_livreurs->count()}}</span>
                                @endif
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" class="cmdRtrn">
                            <div class="icon-wrapper bg-danger">
                                <ion-icon name="return-down-back-outline"></ion-icon>
                            </div>
                           <strong>Retours</strong> 
                                @if($undone_by_livreurs->count()>0)<span style="color: red; font-size: 15px"> {{$undone_by_livreurs->count()}}</span>
                                @endif
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" class="bulkaction" >
                            <div class="icon-wrapper bg-success">
                                <ion-icon name="list-outline"></ion-icon>
                            </div>
                            <strong>Action groupée</strong>
                        </a>
                    </div>

                </div>
                <!-- * Wallet Footer -->
            </div>
        </div>
        
      @if($client->manager && $client->manager->count() == 1)
      <div class="section mt-2">
        <div class="card">
          <div class="card bg-success">
      <h3 class="text-white ml-1">Vos Commandes sont gérées par <strong>{{$client->manager->nom}}</strong></h3>
      <button class="btn btn-primary">modifier</button>
      </div>
    </div>
      </div>
      @endif
    
        

        <div class="section mt-2">
        
       
            <div class="section full mb-3">
            <div class="section-title"></div>

            <div class="carousel-multiple owl-carousel owl-theme">


              <div class="item">
                    <div class="card">
                       <a id="dashboard_btn" data-state="all"> 
                        <div class="card-body " >
                            <h5 >Tout  {{$all_commands->sum('montant')}} ({{$all_commands->count()}})</h5>
                            
                        </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                       <a class="state_btn" data-state="termine"> 
                        <div class="card-body " >
                            <h5 >Terminé {{$all_commands->where('etat', 'termine')->sum('montant')}} ({{$all_commands->where('etat', 'termine')->count()}})</h5>
                            
                        </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="enattente_btn" > 

                        <div class="card-body">
                            <h5 >En attente {{$all_commands->where('livreur_id', 11)->where('etat','=', 'encours')->sum('montant')}}({{$all_commands->where('livreur_id', 11)->where('etat','=', 'encours')->count()}})</h5>
                           
                        </div>
                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="state_btn" data-state="encours"> 
                        <div class="card-body">
                            <h5 >Encours {{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'encours')->sum('montant')}}({{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'encours')->count()}})</h5>
                            
                        </div>
                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="state_btn" data-state="recupere"> 
                        <div class="card-body">
                            <h5 >Récupéré {{$all_commands->where('etat', 'recupere')->sum('montant')}} ({{$all_commands->where('etat', 'recupere')->count()}})</h5>
                            
                        </div>
                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="state_btn" data-state="en chemin"> 
                        <div class="card-body">
                            <h5 >En chemin  {{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'en chemin')->sum('montant')}}({{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'en chemin')->count()}})</h5>
                           
                        </div>
                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="state_btn" data-state="annule"> 
                        <div class="card-body">
                            <h5 >Annulé {{$all_commands->where('etat','=', 'annule')->sum('montant')}}({{$all_commands->where('etat','=', 'annule')->count()}})</h5>
                            
                        </div>
                    </a>
                    </div>
                </div>
            </div>
        </div>



       

                        

                      
       


       @include('includes.cmdvalidation')

       @if(count($final_destinations)>0)    
               @foreach($final_destinations as $destination=> $nomber)
               

               <div class="chip chip-media" style="margin-bottom: 3px">
                        <i class="chip-icon bg-dark">
                            {{ $nomber}}
                        </i>
                        <span class="chip-label">{{$destination}}</span>
                    </div>
               @endforeach
               
               @endif

       <!-- Monthly Bills -->
        <div class="section full mt-4">
            <div class="section-heading padding">
                <h2 class="title">Enregitrement rapide</h2>
                <a href="#" class="link text-warning " data-toggle="modal" data-target="#addNewFast">Ajouter</a>
            </div>


            <div class="item">
                <div class="card">
                    <div class="card-body">
             @if( $client->fast_commands->count()>0)
      
         
         @foreach($client->fast_commands  as $fast)

          <div id="fast{{$fast->id}}" class="btn-group">
  <button style="margin-bottom: 5px; border-top-left-radius: 20px; border-bottom-left-radius: 20px" style=" border-radius: 20px;" data-desc2="{{$fast->description}}" data-id2="" data-date2="{{date('Y-m-d')}}" data-montant2="{{$fast->price}}" data-fee2="{{$fast->fee_id}}" data-adrs2="" data-phone2="" data-observation2=""  data-price="{{$fast->price}}" data-description="{{$fast->description}}" class="btn btn-secondary btn-sm duplicate">{{$fast->description}} : {{$fast->fee->destination}} </button>
  <button style="margin-bottom: 5px; border-top-right-radius: 20px; border-bottom-right-radius: 20px" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a class="delete_fast" data-id='{{$fast->id}}' data-curfast="#fast{{$fast->id}}" href="#">Supprimer de la liste</a></li>
  </ul>
</div>


         
         @endforeach
      
      @endif   
          </div>  
          </div>    
            </div>
        </div>




        <!-- * Monthly Bills -->
    
            <!-- card block -->
            <div class="commands">
               @if($commands->count()>0)
                
               @foreach($commands->sortBy("adresse") as $x=>$command)
                

                 @include("includes.commandlist")
                 <?php $chk++; ?>
                 @endforeach


                  <!-- by state -->
               
                @endif
                </div> 
            <!-- * card block -->
          
        </div>
        <div class="mb-3"></div>
       @include("includes.footer")

    </div>
    <!-- * App Capsule -->


    <div></div>
    <!-- App Bottom Menu -->
    @include("includes.bottom")
    @include("includes.sidebar")
    
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
     <script src="../assets/js/commands.js"></script>
     
    <!-- Google map -->
    <script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"
   defer
   ></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>

  <script src="../assets/js/star-rating.min.js"></script>
  
  <script type="text/javascript">


  $(".cmd_detail").click(function(){
var description = $(this).data('desc');
     var date = $(this).data('date');
     var montant = $(this).data('montant');
     var fee = $(this).data('fee');
     var com = $(this).data('com');
     var adresse = $(this).data('adrs');
     var phone = $(this).data('phone');
     var id = $(this).data('id');
     var etat = $(this).data('etat');
     var observation = $(this).data('observation');
     var livphone = $(this).data('livphone');
     var livnom = $(this).data('livnom');
     var livraison = $(this).data('liv');
     var total = $(this).data('total');
     var notes = $(this).data('notes');
     var created = $(this).data('created');
     var updated = $(this).data('updated');

     if(etat == 'en chemin')
    {var i = '<i   class="fas fa-walking text-warning "></i>';}
                          
if(etat == 'recupere')
    {var i = '<i   class="fas fa-dot-circle text-warning "></i>';}

if(etat == 'encours')
{var i = '<i    class="fas fa-dot-circle text-danger "></i>';}
                           
if(etat == 'annule')
 {var i = '<i  class="fas fa-window-close  "></i>';}
                          
     
     livcall = ""

     if(livnom !== "Non assigné"){
        livcall = "<br>Contact:"+livphone+" <a  href='tel:"+livphone+ "' class='btn btn-outline-primary '><ion-icon name='call-outline'></ion-icon>Appeler</a>"
     }

     $("#cmdDetailModal").modal("show");
     $(".detailBody").html("<span class='mr-3'>Commande Numero: "+id+ "</span><br>"+i+etat+" "+updated+"<br> enregistrée le "+created+ "<br><ion-icon class='text-danger mr-1' name='information-circle-outline'></ion-icon>" +observation+"<br><br><span>Adresse de livraison:<br></span><span style='font-weight: bold'> "+adresse+"<br>Contact: "+phone+" <a  href='tel:"+phone+ "' class='btn btn-outline-primary '><ion-icon name='call-outline'></ion-icon>Appeler</a></span><br><br><span>Description:</span><br><span style='font-weight: bold'>"+description+"</span><br><br><span>Livreur:</span><br><span style='font-weight: bold'>"+livnom+livcall+"</span><br><br><span style='font-weight: bold'>Total: "+total+"</span><br><span>Prix: "+montant+". Livraison: "+livraison+"</span><br><br><span>Notes</span><br><ul>"+notes+"</ul>");


});


   

  $(".duplicate").click( function() {
     var description = $(this).data('desc2');
     var date = $(this).data('date2');
     var montant = $(this).data('montant2');
     var fee = $(this).data('fee2');
     var adresse = $(this).data('adrs2');
     var phone = $(this).data('phone2');
     var id = $(this).data('id2');
     var observation = $(this).data('observation2');

     
     $('.duplicateBody1').html(' <div class="form-group"> <label class="form-label">Nature du colis</label><input required value="'+description+'"  name="type" class="form-control" type="text" placeholder="Nature du colis" ></div><input value="'+id+'" hidden name="command_id"><div class="form-group"><label class="form-label">Date de livraison<input  required type="date" value="'+date+'" name="delivery_date" class="form-control" type="text" ></label>  </div> <div class="form-group"><label class="form-label">Prix(sans la livraison)</label><input type="number" value="'+montant+'"  name="montant" class="form-control" > </div>');
     
     $('.duplicateBody2').html('<div class="form-group"><label class="form-label">Précision sur l\'adresse de livraison</label><input value="'+adresse+'"  name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." ></div><div class="form-group"><label class="form-label">Contact(ex: 07000000)</label><input value="'+phone+'" required  name="phone" class="form-control" type="number" placeholder="Contact du client">  </div><div class="form-group"><label class="form-label"> Information supplementaire.</label><input maxlength="150"   name="observation" class="form-control" type="text" placeholder="Information supplementaire"></div></div>');
     
     $(".duplicateFee").val(fee);
     $('.duplicateTitle').html('Nouvelle Commande');
     
     $("#duplicateModal").modal('show');
     
     
     });



 $(".rateLivreur").click( function() {
  
   id = $('.payeurid').val();
   rate = $('#input-1').val();
   $(this).prepend('<span  class="spinner-border  " role="status" aria-hidden="true"></span><span class="sr-only"></span>');


     $.ajax({
       url: 'ratelivreur',
       type: 'post',
       data: {_token: CSRF_TOKEN,id: id, rate: rate},
   
       success: function(response){
               $('.payeur').attr('hidden', 'hidden');
               $('.paySuccess').html("<strong class='fadein'>Votre note a été prise en compte. Merci pour votre contribution.</strong>");
              },
   error: function(response){
               
                 toastbox('toast-err', 2000);
              }
             
     });
   });



   $(".cmd_menu").click(function(){
var description = $(this).data('desc');
     var date = $(this).data('date');
     var montant = $(this).data('montant');
     var fee = $(this).data('fee');
     var com = $(this).data('com');
     var adresse = $(this).data('adrs');
     var phone = $(this).data('phone');
     var id = $(this).data('id');
     var etat = $(this).data('etat');
     var observation = $(this).data('observation');
     var livphone = $(this).data('livphone');
     var livraison = $(this).data('liv');
     var total = $(this).data('total');



     var stats = ['encours', 'recupere', 'en chemin','livre' ,'annule'];
   stats = jQuery.grep(stats, function(value) {
      return value != etat;
    });

     let actual_stats = "<select class='form-control status'><option >Modifier statut</option>";
  for(let i=0; i < stats.length; i++){
  actual_stats += "<option value='"+stats[i]+"'> Marquer "+ stats[i] + "</option>";  
}

actual_stats += "<select>"
     $(".cmdMenumodalTitle").html("Menu commande n° "+ id );

     

    
      
     $("#shareBill").val("Commande n°"+ id + ". " +description+ ". "+adresse +". contact:"+phone +". Total:"+total + "cliquez ici pour le tracking. https://client.livreurjibiat.site/tracking/"+id);
    
      
      
     
    
  $(".cmdMenumodalCalls").html("<a  href='tel:"+phone+ "' class='btn btn-outline-primary btn-block'><ion-icon name='call-outline'></ion-icon>Appeler client</a> <a  href='tel:"+livphone+ "' class='btn btn-outline-primary btn-block'><ion-icon name='call-outline'></ion-icon>Appeler livreur</a> ");
   
    $('.editBody1').html(' <div class="form-group"> <label class="form-label">Nature du colis</label><input required value="'+description+'"  name="type" class="form-control" type="text" placeholder="Nature du colis" ></div><input value="'+id+'" hidden name="command_id"><div class="form-group"><label class="form-label">Date de livraison<input  required type="date" value="'+date+'" name="delivery_date" class="form-control" type="text" ></label>   </div> <div class="form-group"><label class="form-label">Prix(sans la livraison)</label><input type"numric"  value="'+montant+'"  name="montant" class="form-control  type="text" placeholder="Prix(sans la livraison)">  </div>');
     
     $('.editBody2').html('<div class="form-group"><label class="form-label">Précision sur l adresse de livraison</label><input value="'+com+'"  name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." ></div><div class="form-group"><div class="form-row"><div class="col "><label class="form-label">Indicatif</label><select class="form-control"><option>+225</option> </select></div><div class="col-8"><label class="form-label">Contact</label><input value="'+phone+'" required  name="phone" class="form-control" type="text" placeholder="Contact du client"></div></div>  </div><div class="form-group"><label class="form-label"> Information supplementaire.</label><input maxlength="150" value="'+observation+'"  name="observation" class="form-control" type="text" placeholder="Information supplementaire"></div></div>');
     
     $(".editFee").val(fee);
     
     if(livraison !== 'no'){
      
      if(livraison != "1000" && livraison != "1500" && livraison != "2000" && livraison != "2500" && livraison != "3000")
       {
        $('.livraison').val('autre');
        $('.autre').removeAttr("hidden");
        $('.tarif').val(livraison);
       }else{$('.livraison').val(livraison);}
     }






$('.editModalTitle').html('Modifier commande '+id)


     $('.duplicateBody1').html(' <div class="form-group"> <label class="form-label">Nature du colis</label><input required value="'+description+'"  name="type" class="form-control" type="text" placeholder="Nature du colis" ></div><input value="'+id+'" hidden name="command_id"><div class="form-group"><label class="form-label">Date de livraison<input  required type="date" value="'+date+'" name="delivery_date" class="form-control" type="text" ></label>   </div> <div class="form-group"><label class="form-label">Prix(sans la livraison)</label><input  value="'+montant+'"  name="montant" class="form-control " type="number" placeholder="Prix(sans la livraison)">  </div>');
     
     $('.duplicateBody2').html('<div class="form-group"><label class="form-label">Précision sur l\'adresse de livraison</label><input value="'+adresse+'"  name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." ></div><div class="form-group"><div class="form-row"><div class="col"><label class="form-label">Indicatif</label><select class="form-control"><option>+225</option> </select></div><div class="col-8"><label class="form-label">Contact</label><input value="'+phone+'" required  name="phone" class="form-control" type="number" placeholder="Contact du client"></div></div>  </div><div class="form-group"><label class="form-label"> Information supplementaire.</label><input maxlength="150"   name="observation" class="form-control" type="text" placeholder="Information supplementaire"></div></div>');
     
     $(".duplicateFee").val(fee);
     $('.duplicateTitle').html('Nouvelle Commande');
     
      $(".add_fast").attr("value", id);
       $("#billInput").attr("value", "Votre commande n°"+ id + " à été enregistrée. cliquez ici pour voir son statut: https://client.livreurjibiat.site/tracking/"+id);

  $("#cancel_btn").removeAttr("hidden");
      $("#cancel_btn").data("id", id);
      $("#cancel_btn").val('annule');
      $("#cancel_btn").html("<ion-icon class='text-danger'  name='close-outline'></ion-icon>Annuler");
       $("#rpt").val(id);
       $("#rpt").removeAttr("hidden");
       $("#del").attr("hidden", "hidden");
     $("#cmdResetForm").html("<input type='text' name='_token' value='"+CSRF_TOKEN+"' hidden ><input value="+id+"' type='text' name='id' hidden> <input type='text' value='no' name='cancel' hidden><button type='submit' class='btn btn-outline-primary btn-block'><ion-icon name='refresh-outline'></ion-icon>Réinitialiser</button>");
     

    if(etat == 'annule')
    {
      $("#cancel_btn").removeAttr("hidden");
      $("#del").removeAttr("hidden");
      $("#del").val(id);
      $("#cancel_btn").data("id", id);
      $("#cancel_btn").val('encours');
      $("#cancel_btn").html("<ion-icon class='text-success'  name='power-outline'></ion-icon>Activer");

     
    }

  if(etat == 'termine')
    {
      $("#rpt").attr("hidden", "hidden");
      $("#cancel_btn").attr("hidden", "hidden");
      $("#del").attr("hidden", "hidden");
    } 


    $("#cmdMenumodal").modal("show");

  });




    $(".edit").click( function() {
   var description = $(this).data('desc');
   var date = $(this).data('date');
   var montant = $(this).data('montant');
   var fee = $(this).data('fee');
   var adresse = $(this).data('adrs');
   var phone = $(this).data('phone');
   var id = $(this).data('id');
   var observation = $(this).data('observation');
   var livraison =  $(this).data('livraison');
   
   $('.editBody1').html(' <div class="form-group"> <label class="form-label">Nature du colis</label><input required value="'+description+'" id="type" name="type" class="form-control" type="text" placeholder="Nature du colis" ></div><input value="'+id+'" hidden name="command_id"><div class="form-group"><label class="form-label">Date de livraison<input  required type="date" value="'+date+'" name="delivery_date" class="form-control" type="text" ></label> @error("delivery_date")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror  </div> <div class="form-group"><label class="form-label">Prix(sans la livraison)</label><input type"numric"  value="'+montant+'"  name="montant" class="form-control @error("montant") is-invalid @enderror" type="text" placeholder="Prix(sans la livraison)"> @error("montant")<span class="invalid-feedback" role="alert"><strong>{{$massage}}</strong></span>@enderror </div>')
   
   $('.editBody2').html('<div class="form-group"><label class="form-label">Précision sur l\'adresse de livraison</label><input value="'+adresse+'" id="lieu" name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." ></div><div class="form-group"><input value="'+phone+'" required  name="phone" class="form-control" type="text" placeholder="Contact du client"> @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror </div><div class="form-group"><label class="form-label"> Information supplementaire.</label><input maxlength="150" value="'+observation+'"  name="observation" class="form-control" type="text" placeholder="Information supplementaire"></div></div>')
   
   $(".editFee").val(fee);
   $(".livraison").val(livraison);
   $('.editTitle').html('Modifier commande '+ id)
   
   $("#editModal").modal('show');
   
   
   });



     $('.bulkaction').on('click', function(e) {


              var allVals = [];  
              $(".cmd_chk:checked").each(function() {  
                  allVals.push($(this).attr('data-id'));
              });  


              if(allVals.length <=0)  
              {  
                  $("#assignError").attr("class", "alert alert-danger");
                 $("#stateModalBody").html("Veuillez selectionner au moins une commande"); 

                 $('#stateModal').modal("show")
              } else
              {
                $('#bulkModal').modal("show");
              }
  });

  function search() {
    
    var input = document.getElementById("Search");
    var filter = input.value.toLowerCase();
    var nodes = document.getElementsByClassName('target');
    for (i = 0; i < nodes.length; i++) {
      if (nodes[i].innerText.toLowerCase().includes(filter)) {
        nodes[i].style.display = "block";
      } else {
        nodes[i].style.display = "none";
      }
    }

    $('html, body').animate({
  scrollTop: $(".commands").offset().top
});
  }



  $(".bulkReset").click( function() {
   
  
          var cmd_ids = [];  
              $(".cmd_chk:checked").each(function() {  
                  cmd_ids.push($(this).attr('data-id'));
              });
        $(this).prepend(spinner);

     $.ajax({
       url: 'bulkreset',
       type: 'post',
       data: {_token: CSRF_TOKEN, cmd_ids: cmd_ids},
   
       success: function(response){
                
                $(".siteSpinner").attr('hidden', 'hidden');
                        $("#bulkModal").modal('hide');
                        $('.toasText').text('Selection Reinitialisée. Actualisation...');
                         toastbox('toast-8', 2000);

                         setTimeout(function(){
                  location.reload(true);
                }, 2000);
              },
   error: function(response){
            $(".siteSpinner").attr('hidden', 'hidden');
               $("#stateModalBody").html("Une erruer s'est produite");
                $("#stateModal").modal('show');
               
              }
             
     });
   });   


  $(".add_fast").click( function() {
   
  
   var cmd_id = $(this).val();
   
   $(".addFastSpinner").removeAttr('hidden');


     $.ajax({
       url: 'addfast',
       type: 'post',
       data: {_token: CSRF_TOKEN, cmd_id: cmd_id},
   
       success: function(response){
                
                $(".addFastSpinner").attr('hidden', 'hidden');
                $("#stateModalBody").html("Ajouté à la liste d'Enregistrement rapide");
                $("#stateModal").modal('show');
              },
   error: function(response){
               $("#stateModalBody").html("Une erruer s'est produite");
                $("#stateModal").modal('show');
               
              }
             
     });
   });   



  $(".status").click( function() {
   
  
   var cmd_id = $(this).val();
   
   $(".stausFastSpinner").removeAttr('hidden');


     $.ajax({
       url: 'addfast',
       type: 'post',
       data: {_token: CSRF_TOKEN, cmd_id: cmd_id},
   
       success: function(response){
                
                $(".addFastSpinner").attr('hidden', 'hidden');
                $("#stateModalBody").html("Ajouté à la liste d'Enregistrement rapide");
                $("#stateModal").modal('show');
              },
   error: function(response){
               $("#stateModalBody").html("Une erruer s'est produite");
                $("#stateModal").modal('show');
               
              }
             
     });
   });   





  shareButton = document.getElementById("shareBill");


shareButton.addEventListener('click', event => {
  if (navigator.share) {
    navigator.share({
      title: 'Facture',
      text: $("#shareBill").val(),
      
    }).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }
});



  
  
$("#bulk_rpt_btn").click( function() {



              var cmd_ids = [];  
              $(".cmd_chk:checked").each(function() {  
                  cmd_ids.push($(this).attr('data-id'));
              });  
             

             rprt_date = $("#bulk_rpt_date").val();
             if(rprt_date == ""){
              $(".date_err").html("Veuillez choisir une date");

             }
             else
              
      {
        var assign = 0;
       var assign = 0;
       if($('#ynbassign').is(':checked')){var assign = 1;}
        $.ajax({
                 url: 'bulkreport',
                 type: 'post',
                 data: {_token: CSRF_TOKEN,cmd_ids: cmd_ids, rprt_date: rprt_date, assign: assign},
             
                 success: function(response){
                           $(".siteSpinner").attr('hidden', 'hidden');
                        $("#bulkRptModal").modal('hide');
                        $('.toasText').text('Selection réportée');
                         toastbox('toast-8', 2000);
      
                         for (i = 0; i < cmd_ids.length; i++)
                         {$("#"+cmd_ids[i]).css("display", "none");}
      
                           
                        },
             error: function(response){
                         $(".spinnerbulk").attr('hidden', 'hidden');
                          alert("Une erruer s'est produite");
                        }
                       
               });}
     });


$("#rpt_btn").click( function() {
     
    $(this).prepend(spinner);
     var cmd_id = $(this).val();
     var assign = 0;
       if($('#ynassign').is(':checked')){var assign = 1;}

     var date = $("#rpt_date").val();

     
       $.ajax({
         url: 'report',
         type: 'post',
         data: {_token: CSRF_TOKEN, cmd_id: cmd_id, rprt_date: date, assign: assign},
     
         success: function(response){
                  $("#ynassign" ).prop( "checked", false );
                  $(".siteSpinner").attr('hidden', 'hidden');
                  $("#rptModal").modal('hide');
                  $('.toasText').text('Commande reportée');
                   toastbox('toast-8', 2000);
                   $("#"+cmd_id).css("display", "none");
                },
     error: function(response){
      $(".siteSpinner").attr('hidden', 'hidden');
                 $("#stateModalBody").html("Une erruer s'est produite");
                  $("#stateModal").modal('show');
                 
                }
               
       });
     });


$(".ready").change( function() {
  var cmd_id = $(this).val();if($(this).is(":checked")){var ready = "yes";
  var text =  'Commande prête pour récuperation!';
}
     else{var ready = "no"; var text =  'Commande pas prête!';}
    
  $.ajax({
         url: 'ready',
         type: 'post',
         data: {_token: CSRF_TOKEN,cmd_id: cmd_id,ready: ready},
         success: function(response){
         $('.toasText').text(text);
                   toastbox('toast-8', 2000);
         },
         error : function(response)
         {$("#stateModalBody").html("Une erreur s'est produite");
         
        $("#stateModal").modal("show");
        setTimeout(function(){$('#stateModal').modal('hide')}, 2000);}
       });
     });

  </script>
</body>

</html>
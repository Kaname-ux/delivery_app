 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    // Note: This example requires that you consent to location sharing when
   // prompted by your browser. If you see the error "The Geolocation service
   // failed.", it means you probably did not give permission for the browser to
   // locate you.
   let map, infoWindow;
   
   function initMap() {
      $("#mapModal").modal('show');
   map = new google.maps.Map(document.getElementById("map"), {
     center: { lat: 5.3718386, lng: -4.0033868
   },
     zoom: 16,
   });
   infoWindow = new google.maps.InfoWindow();
   
   // Try HTML5 geolocation.
   if (navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(
       (position) => {
         const pos = {
           lat: position.coords.latitude,
           lng: position.coords.longitude,
         };
         infoWindow.setPosition(pos);
         infoWindow.setContent("Vous êtes ici.");
         infoWindow.open(map);
         map.setCenter(pos);
       },
       () => {
         handleLocationError(true, infoWindow, map.getCenter());
       }
     );
   } else {
     // Browser doesn't support Geolocation
     handleLocationError(false, infoWindow, map.getCenter());
   }
   }
   
   $(".dayly").change(function(){
      
   $("#date-form").submit();
   });


   $(".ready").change( function() {
   var cmd_id = $(this).val();
   if($(this).is(":checked")  )
   {var ready = "yes"; }
   else  
    {var ready = "no";}
  
$.ajax({
       url: 'ready',
       type: 'post',
       data: {_token: CSRF_TOKEN,cmd_id: cmd_id,ready: ready},
       success: function(response){
       
       },
       error : function(response)
       {$("#stateModalBody").html("Une erreur s'est produite");
       
      $("#stateModal").modal("show");
      setTimeout(function(){$('#stateModal').modal('hide')}, 2000);
    }
     });
   });


   $(".state_btn").click(function(){
    var state = $(this).data('state');
    $("#state").val() = state;
   $("#stateForm").submit();


   });


   $(".showLivreur").click( function() {
   var cmd_id = $(this).val();
   var cur_liv = $(this).data('livid');
   var cur_liv_name =  $(this).data('livname');
   var assign_modal = $('#LivChoice');
   var assign_body = $('.LivChoiceBody');
   var top = $('.top');
   
   $(".spinner"+cmd_id).removeAttr('hidden');


     $.ajax({
       url: 'assign',
       type: 'post',
       data: {_token: CSRF_TOKEN,cmd_id: cmd_id},
   
       success: function(response){
                $(".spinner"+cmd_id).attr('hidden', 'hidden');
                (assign_body).html(response.title1+ "<br>" +response.zone_output +"<br>"+response.title2+"<br>"+ response.other_output + response.assign_script);
                if(cur_liv != "11"){$('.curLiv').html("livreur actuel: "+ cur_liv_name);}
                (top).text('Assigner Commande '+cmd_id);
                (assign_modal).modal('show');
                 $('#loader').attr('hidden', 'hidden');
              },
   error: function(response){
               $(".spinner"+cmd_id).attr('hidden', 'hidden');
                alert("Une erruer s'est produite");
              }
             
     });
   });  





$(".showLivreur2").click( function() {

var cmd_id = $(this).val();
   var cur_liv = $(this).data('livid');
   var cur_liv_name =  $(this).data('livname');
   var assign_modal = $('#LivChoice');
   var assign_body = $('.LivChoiceBody');
   var top = $('.top');


            var cmd_id = [];  
            $(".cmd_chk:checked").each(function() {  
                ids.push($(this).attr('data-id'));
            });  


            if(cmd_id.length <=0)  
            {  
                
               $("#stateModalBody").html("Veuillez selectionner au moins une commande"); 

               $('#stateModal').modal("show")
            } 
  else 
  { 
     $(".spinnerbulk").removeAttr('hidden');
  
  
       $.ajax({
         url: 'showlivreurs',
         type: 'post',
         data: {_token: CSRF_TOKEN,cmd_id: cmd_id},
     
         success: function(response){
                  $(".spinner"+cmd_id).attr('hidden', 'hidden');
                  (assign_body).html(response.title1+ "<br>" +response.zone_output +"<br>"+response.title2+"<br>"+ response.other_output + response.assign_script);
                  if(cur_liv != "11"){$('.curLiv').html("livreur actuel: "+ cur_liv_name);}
                  (top).text('Assigner Commande '+cmd_id);
                  (assign_modal).modal('show');
                   $('#loader').attr('hidden', 'hidden');
                },
     error: function(response){
                 $(".spinner"+cmd_id).attr('hidden', 'hidden');
                  alert("Une erruer s'est produite");
                }
               
       });}
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
   
   
   function setGeoloc(){
    x = navigator.geolocation;
    x.getCurrentPosition(success, failure);
   function success (position) {
   
     lat = position.coords.latitude;
     long = position.coords.longitude;
     
    
    $.ajax({
       url: 'setloc',
       type: 'post',
       data: {_token: CSRF_TOKEN,lat: lat, long:long},
   
        
       success: function(response){
         
                alert('Position associée à votre adresse');
              }
   
             
     });
    
   }
   
   function failure (position) {
   
     
     
    alert('Geolocation failed');
    
   }
   }


   $(".nearByLivreur").click( function() {
   var cmd_id = $(this).val();
   
   var assign_modal = $('#LivChoice');
   var assign_body = $('.LivChoiceBody');
   var top = $('.top');


   if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        var accuracy = position.coords.accuracy;
        
        $.ajax({
       url: 'getnearby',
       type: 'post',
       data: {_token: CSRF_TOKEN,cmd_id: cmd_id, lat:lat, long:long},
   
      
   
       success: function(response){
         
                (assign_body).html(response.nearby +"<br>"+response.title2+"<br>"+ response.assign_script);
                (top).text('Assigner Commande '+cmd_id+'<br>Livreurs à proximité');
                (assign_modal).modal('show');
                 $('#loader').attr('hidden', 'hidden');
              },
   error: function(response){
         
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
   

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: La localisation a échoué."
      : "Error: Votre navigateur ne prend pas en compte la géolocalisation."
  );
  infoWindow.open(map);
}
  

$(".cmdRtrn").click( function() {
   
   
   $("#cmdRtrnModal").modal("show");
   
   $(".cmdRtrnSpinner").removeAttr('hidden');
  
    $(".cmdRtrnLivreur").html('');
    $(".cmdRtrnTotal").html('');

     $.ajax({
       url: 'cmdrtrn',
       type: 'post',
       data: {_token: CSRF_TOKEN},
   
       success: function(response){
                $(".cmdRtrnSpinner").attr('hidden', 'hidden');
                $(".cmdRtrnBody").html(response.cmd_return );
                
              },
   error: function(response){
               
                alert("Une erruer s'est produite");
              }
             
     });
   });






   $(".cmdRtrnBack").click( function() {
   
   $('.cmdRtrnReturn').attr('hidden', 'hidden');
   $("#cmdRtrnModal").modal("show");
   
   $(".cmdRtrnSpinner").removeAttr('hidden');
   $(".cmdRtrnReturnSpinner").removeAttr('hidden');
    $(".cmdRtrnLivreur").html('');
    $(".cmdRtrnTotal").html('');

     $.ajax({
       url: 'cmdrtrn',
       type: 'post',
       data: {_token: CSRF_TOKEN},
   
       success: function(response){
                $(".cmdRtrnSpinner").attr('hidden', 'hidden');
                $(".cmdRtrnReturnSpinner").attr('hidden', 'hidden');
                $(".cmdRtrnBody").html(response.cmd_return );
                
              },
   error: function(response){
               
                alert("Une erruer s'est produite");
              }
             
     });
   });    


  $(".pay").click( function() {
   
  
   $("#payModal").modal("show");
   
   $(".paySpinner").removeAttr('hidden');


     $.ajax({
       url: 'currentpay',
       type: 'post',
       data: {_token: CSRF_TOKEN},
   
       success: function(response){
                $(".payLivreur").html('');
              $(".payTotal").html('');
                 $(".payReturn").attr('hidden', 'hidden');
                $(".paySpinner").attr('hidden', 'hidden');
                $(".payBody").html(response.payed_field);
                
              },
   error: function(response){
               
                alert("Une erruer s'est produite");
              }
             
     });
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
   
   $('.editBody1').html(' <div class="form-group"> <label class="form-label">Nature du colis</label><input required value="'+description+'" id="type" name="type" class="form-control" type="text" placeholder="Nature du colis" ></div><input value="'+id+'" hidden name="command_id"><div class="form-group"><label class="form-label">Date de livraison<input  required type="date" value="'+date+'" name="delivery_date" class="form-control" type="text" ></label> @error("delivery_date")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror  </div> <div class="form-group"><label class="form-label">Prix(sans la livraison)</label><input type"numric"  value="'+montant+'"  name="montant" class="form-control @error("montant") is-invalid @enderror" type="text" placeholder="Prix(sans la livraison)"> @error("montant")<span class="invalid-feedback" role="alert"><strong>{{$massage}}</strong></span>@enderror </div>');
   
   $('.editBody2').html('<div class="form-group"><label class="form-label">Précision sur l adresse de livraison</label><input value="'+adresse+'" id="lieu" name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." ></div><div class="form-group"><input value="'+phone+'" required  name="phone" class="form-control" type="text" placeholder="Contact du client"> @error("phone")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror </div><div class="form-group"><label class="form-label"> Information supplementaire.</label><input maxlength="150" value="'+observation+'"  name="observation" class="form-control" type="text" placeholder="Information supplementaire"></div></div>');
   
   $(".editFee").val(fee);
   $('.editTitle').html('Modifier commande '+ id);
   
   $("#editModal").modal('show');
   
   
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
   
   $('.duplicateBody1').html(' <div class="form-group"> <label class="form-label">Nature du colis</label><input required value="'+description+'" id="type" name="type" class="form-control" type="text" placeholder="Nature du colis" ></div><input value="'+id+'" hidden name="command_id"><div class="form-group"><label class="form-label">Date de livraison<input  required type="date" value="'+date+'" name="delivery_date" class="form-control" type="text" ></label> @error("delivery_date")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror  </div> <div class="form-group"><label class="form-label">Prix(sans la livraison)</label><input  value="'+montant+'"  name="montant" class="form-control @error("montant") is-invalid @enderror" type="text" placeholder="Prix(sans la livraison)"> @error("montant")<span class="invalid-feedback" role="alert"><strong>{{$massage}}</strong></span>@enderror </div>');
   
   $('.duplicateBody2').html('<div class="form-group"><label class="form-label">Précision sur l\'adresse de livraison</label><input value="'+adresse+'" id="lieu" name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." ></div><div class="form-group"><label class="form-label">Contact(ex: 07000000)</label><input value="'+phone+'" required  name="phone" class="form-control" type="number" placeholder="Contact du client"> @error("phone")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror </div><div class="form-group"><label class="form-label"> Information supplementaire.</label><input maxlength="150"   name="observation" class="form-control" type="text" placeholder="Information supplementaire"></div></div>');
   
   $(".duplicateFee").val(fee);
   $('.duplicateTitle').html('Nouvelle Commande');
   
   $("#duplicateModal").modal('show');
   
   
   });


 $("#dashboard_btn").click(function(){
   $("#dashboard").submit();
   });




$(".note").click( function() {
   var cmd_id = $(this).data('id');
   
   $("#noteViewModal").modal("show");
   
   $(".noteViewBody").html('<span  hidden="hidden" class="spinner-border  cmdRtrnSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>');
  
    

     $.ajax({
       url: 'getnote',
       type: 'post',
       data: {_token: CSRF_TOKEN, cmd_id: cmd_id},
   
       success: function(response){
                
                $(".noteViewBody").html(response.result);
                
              },
   error: function(response){
               
                alert("Une erruer s'est produite");
              }
             
     });
   });
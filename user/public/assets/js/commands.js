var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');var spinner = '<span  class="spinner-border  siteSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>';

$('.big').click(function(){var src = $(this).attr('src');$('.bigModalBody').html("<img src='"+src+"' width='100%' height='100%'>");$("#bigModal").modal("show");});

$( "form" ).submit(function(){
  var submit = $(this).find(":submit");
  if(!submit.hasClass("phone"))
  {submit.attr('disabled', 'disabled');
  submit.html('<span  class="spinner-border  " role="status" aria-hidden="true"></span><span class="sr-only"></span>');}});

$("a").click(function(){
      var link = $(this).attr("href");
      if(link != "#" && link != "javascript:;" && ! $(this).hasClass("phone"))
     {
        toastbox('toast-11', 4000); 
    }
   });





       


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
     

     

  $(".dayly").change(function(){$("#date-form").submit();});


  

  $(".state_btn").click(function(){
      var state = $(this).data('state');
      $("#state").attr("value", state);
     $("#stateForm").submit(); });

  $(".enattente_btn").click(function(){$("#enattenteForm").submit();});


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
                   if(cur_liv != "11"){$('.curLiv').html("livreur actuel: "+ cur_liv_name + response.unassign_btn);}
                  (assign_body).html(response.title1+ "<br>" +response.zone_output +"<br>"+response.title2+"<br>"+ response.other_output + response.assign_script);
                 
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

  $(".showLivreurs").click( function() {
var assign_modal = $('#LivChoice');
     var assign_body = $('.LivChoiceBody');
     var top = $('.top');


              var cmd_ids = [];  
              $(".cmd_chk:checked").each(function() {  
                  cmd_ids.push($(this).attr('data-id'));
              });  


              
       $(".spinnerbulk").removeAttr('hidden');
      $.ajax({
           url: 'showlivreurs',
           type: 'post',
           data: {_token: CSRF_TOKEN,cmd_ids: cmd_ids},
       
           success: function(response){
                    $(".spinnerbulk").attr('hidden', 'hidden');
                    (assign_body).html(response.title+ "<br>" +response.output +"<br>"+ response.assign_script);
                    
                    (top).text('Assigner la selection');
                     $('#bulkModal').modal("hide");
                    (assign_modal).modal('show');

                     
                  },
       error: function(response){
                   $(".spinnerbulk").attr('hidden', 'hidden');
                    alert("Une erruer s'est produite");
                  }
                 
         });
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
                  (top).text('Assigner Commande '+cmd_id+' Livreurs à proximité');
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



  $(".returnPay").click( function() {
     
    
     
     
     $(".returnPaySpinner").removeAttr('hidden');
     
      $(".payLivreur").html('');
      $(".payTotal").html('');
      $(".rtrnTotal").html('');
       $.ajax({
         url: 'currentpay',
         type: 'post',
         data: {_token: CSRF_TOKEN},
     
         success: function(response){
                  $(".returnPaySpinner").attr('hidden', 'hidden');
                  $(".payReturn").attr('hidden', 'hidden');
                  $(".payBody").html(response.payed_field);
                  
                },
     error: function(response){
                 
                  alert("Une erruer s'est produite");
                }
               
       });
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


  


  







  $(".del").click( function() {
    $("#cmdMenumodal").modal("hide");
    $("#delModal").modal("show");
     var cmd_id = $(this).val();
     $("#delModalBody").html("Cette action supprimera définitivement la commande <strong> "+cmd_id+"</strong>.Souhaitez-vous Confirmer? ");
     $("#del_btn").val(cmd_id);
     }); 



     $(".rpt").click( function() {
    $("#cmdMenumodal").modal("hide");
    $("#rptModal").modal("show");
     var cmd_id = $(this).val();
      $("#rptModalBody").html("Reporter commande n° "+cmd_id);
     $("#rpt_btn").val(cmd_id);
     });  

  $(".activate").click( function() {
    var cmd_id = $(this).val();
    $(".activateValue").attr("value", cmd_id);
     $("#activateForm").submit();
     });  


  $("#del_btn").click( function() {
    $(this).prepend(spinner);
     var cmd_id = $(this).val();
     
       $.ajax({
         url: 'cmddel',
         type: 'post',
         data: {_token: CSRF_TOKEN, cmd_id: cmd_id},
     
         success: function(response){
                  
                  $(".siteSpinner").attr('hidden', 'hidden');
                  $("#delModal").modal('hide');
                  $('.toasText').text('Commande supprimée');
                   toastbox('toast-8', 2000);
                   $("#"+cmd_id).css("display", "none");
                },
     error: function(response){
                 $("#stateModalBody").html("Une erruer s'est produite");
                  $("#stateModal").modal('show');
                 
                }
               
       });
     });



  





   $(".delete_fast").click( function() {
     
    
     var fast_id = $(this).data('id');
     
     var curfast = $(this).data('curfast');


       $.ajax({
         url: 'deletefast',
         type: 'post',
         data: {_token: CSRF_TOKEN, fast_id: fast_id},
     
         success: function(response){
                  
                  
                  $("#stateModalBody").html("Supprimé de la liste d'Enregistrement rapide");
                  $("#stateModal").modal('show');

                    $(curfast).attr('hidden', 'hidden');
                },
     error: function(response){
                 $("#stateModalBody").html("Une erruer s'est produite");
                  $("#stateModal").modal('show');
                 
                }
               
       });
     });


   


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


  $(".livraison").change(function(){
     
     if($(this).val() == 'autre'){$(".autre").removeAttr('hidden');
        $(".autre").attr('riquired', 'riquired');}
     else{$(".autre").attr('hidden', 'hidden');
       $(".autre").removeAttr('required'); }


     });





  $('#cancel_btn').click(function(){
var state =$(this).val();
var cmd_id = $(this).data('id');

    
    var btn = $(this);

    $("#cancel_btn").html('<span  class="spinner-border  " role="status" aria-hidden="true"></span><span class="sr-only"></span>')
      $.ajax({
        url: 'cancel_cmd',
        type: 'post',
        data: {_token: CSRF_TOKEN,cmd_id: cmd_id,state: state},
        success: function(response){
          if(response.state == 'annule')
         {  
          btn.html("<ion-icon class='text-success'  name='power-outline'></ion-icon>Activer");
           btn.val('encours');


            $("#del").val(cmd_id);
           $("#del").removeAttr("hidden");

            $("#cmd_state"+cmd_id).attr("class", "badge badge-secondary"); 

          $('.stateToastText').text('Commande annulée');
           toastbox('stateToast', 2000);
                
           


         }
              if(response.state == 'encours')
              {
                
                btn.html("<ion-icon class='text-danger'  name='close-outline'></ion-icon>Annuler");
                btn.val('annule');
                $("#cmd_state"+cmd_id).attr("class", "badge badge-danger");
                


                $('.stateToastText').text('Commande activée');
                toastbox('stateToast', 2000); $("#del").attr("hidden",
                "hidden"); }

              $("#cmd_state"+cmd_id).text(state);
             $("#cmd_menu"+cmd_id).data("etat", state); 
              
                
         
      }
  });
     
  }); 

  

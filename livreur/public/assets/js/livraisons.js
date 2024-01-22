 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   

    $(".recup").click( function() {
   var pending =Number($('.pending').data("total"));   
   var cmd_id = $(this).data('id');
   var etat = $(this).val();
   var rt_count = Number($("#rt_count").val());
   var btn = $(this);
   if(etat == "recupere")
   {var wait = "Récuperation...";}
    else
    {var wait = "Mise en chemin...";}
  $(this).html('<span id="recupSpin'+cmd_id+'"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only"></span><span id="wait">'+wait);
  btn.attr('disabled', 'disabled');
     $.ajax({
       url: 'recup',
       type: 'post',
       data: {_token: CSRF_TOKEN,cmd_id: cmd_id, etat:etat},
       success: function(response){
        if(etat == 'recupere')   
       {(btn).attr('hidden', 'hidden');
               $('#scndDep'+cmd_id).removeAttr("hidden");
               
               $("#stateModalBody").html(response.message);
               $("#stateModal").modal("show");
               $("#state_c"+cmd_id).attr("class", "fas fa-ellipsis-h text-warning fa-2x")
               if(Number(response.total_pending)+1-pending>0)
               {
                
                $("#newPending").html(Number(response.total_pending)+1-pending);

                $("#pendingModal").modal("show");
                setTimeout(function(){location.reload();}, 2000);
               }
                
               

               $('.pending').html(pending-1);
                $("#rt_count").html(rt_count+1);
                 $("#rt_count").val(rt_count+1);
                 $("#retours").prepend(response.retour);

               set();

               $(".visible"+cmd_id).removeAttr("hidden");
           }
        else if(etat == 'en chemin')
        {
          
          $('#scndDep'+cmd_id).html('<span id="recupSpin'+cmd_id+'"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only"></span><span id="wait">Prêt pour le départ...</span>');
          $('#scndDep'+cmd_id).attr("class", "btn btn-success");
               
               setTimeout(function(){location.reload();}, 1000);
        }

        else
        {
          
          $('#liv'+cmd_id).html('<span id="livSpin'+cmd_id+'"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only"></span><span id="wait">Une livraison de plus...</span>');
          $('#liv'+cmd_id).attr("class", "btn btn-success");
               
               setTimeout(function(){location.reload();}, 1000);
        }
  



      },
      error: function(response){

      }
     });
   });  

  



     


     $(".noteBtn").click(function(){
       var phone = $(this).data("phone");
       var client_phone = $(this).data("clientphone");
       var id = $(this).data("id");
          $("#noteModal").modal("show");
           $("#commandId").val(id);
           $("#commandPhone").val(phone);
           $("#clientPhone").val(client_phone);

});


 


    
  function set(){
 var state = "set";
   if (navigator.geolocation) {  
    navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        var accuracy = position.coords.accuracy;
        
        $.ajax({
      url: 'setloc',
      type: 'post',
      data: {_token: CSRF_TOKEN,lat: lat, long:long, state:state},
      success: function(response){
      
var reverseGeocoder=new BDCReverseGeocode();
   
    reverseGeocoder.getClientLocation(function(result) {
        console.log(result);
        $(".location").html(result.city + " "+ result.locality);
    });

      },

     error: function(response){}        

            
    });
    },
    function error(msg) {},
    {maximumAge:10000, timeout:5000, enableHighAccuracy: true});
} else {
    alert("Geolocation API is not supported in your browser.");
}
}

set();


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

$("#day").change(function(){
    $("#submit_day").click();
   });


$("a").click(function(){
  var link = $(this).attr("href");
      if(link != "#" && link != "javascript:;" && ! $(this).hasClass("phone"))
     {
        toastbox('toast-11', 4000); 
    }
   });


 
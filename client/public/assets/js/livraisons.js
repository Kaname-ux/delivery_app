 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   

    $(".recup").click( function() {
   var pending =Number($('.pending').data("total"));   
   var cmd_id = $(this).data('id');
   var etat = $(this).val();
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


               set();
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

  



     $("#d2").change(function(){
          if($(this).children("option:selected").val() == "Reporté par le client")
           {$("#report_date_div").removeAttr("hidden");
             $("#report_date").attr("required", "required");}

             else{
              $("#report_date_div").attr("hidden", "hidden");
             $("#report_date").removeAttr("required");
             }
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
      success: function(response){},

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
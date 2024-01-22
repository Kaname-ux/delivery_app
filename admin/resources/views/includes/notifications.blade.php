 <script>

    // Enable pusher logging - don't include this in production
    



     Pusher.logToConsole = true;

    var pusher = new Pusher("{{config('app.pusherkey')}}", {
      cluster: 'eu'
    });

    var channel = pusher.subscribe('my-channel');
    
    channel.bind('my-event', function(data) {
      document.getElementById("myAudio").play();

      $("#modal-success").modal("show");

      $(".successBody").html(data.message);
    });
  </script>


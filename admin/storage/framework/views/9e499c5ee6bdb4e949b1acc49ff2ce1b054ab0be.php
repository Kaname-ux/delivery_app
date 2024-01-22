 <script>

    // Enable pusher logging - don't include this in production
    



     Pusher.logToConsole = true;

    var pusher = new Pusher("<?php echo e(config('app.pusherkey')); ?>", {
      cluster: 'eu'
    });

    var channel = pusher.subscribe('my-channel');
    
    channel.bind('my-event', function(data) {
      document.getElementById("myAudio").play();

      $("#modal-success").modal("show");

      $(".successBody").html(data.message);
    });
  </script>

<?php /**PATH /var/www/html/jibiat/admin/resources/views/includes/notifications.blade.php ENDPATH**/ ?>
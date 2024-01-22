
      <?php if(session('status') && session('status')): ?>
      <div class="section full mt-4">
      <div class="alert alert-success mb-1" role="alert">
      <?php echo e(session('status')); ?>

      </div>
  </div>
      <?php endif; ?>
      <?php /**PATH /var/www/html/livreur/resources/views/includes/cmdvalidation.blade.php ENDPATH**/ ?>
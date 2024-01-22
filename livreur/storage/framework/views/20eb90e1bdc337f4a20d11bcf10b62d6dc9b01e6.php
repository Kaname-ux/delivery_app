

<div id="<?php echo e($difusion->id); ?>" class="section full target  mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                <?php echo e($difusion->created_at->format('d-m-Y H:i')); ?>

                </div>
                
                <div id="status<?php echo e($difusion->id); ?>" class="col  <?php if($difusion->status == 'encours'): ?> text-danger <?php else: ?> text-success <?php endif; ?>"><?php echo e($difusion->status); ?></div>

                <div class="col float-right">
                  <button class="btn btn-light share"  value="<?php echo e(strip_tags($difusion->description)); ?>" ><ion-icon  name="share-social-outline"></ion-icon>
                  </button>
                </div>
            </div>
            <div class=" row mt-2">
               
              <?php echo $difusion->description; ?><br>
              <?php if($difusion->cient): ?>
              Diffusé par: <?php echo e($difusion->client->nom); ?><br>
              <?php endif; ?>
              
                
            </div>
           
                
                
                <div class="row">

                 <div class="col">   
                <a class="btn btn-outline-success btn-sm "  id="wa<?php echo e($difusion->id); ?>" href="https://wa.me/225<?php echo e($difusion->wa); ?>"><ion-icon name="logo-whatsapp"></ion-icon></a>
                 </div>

                 <div class="col">
                <a class="btn btn-outline-success btn-sm"  id="call<?php echo e($difusion->id); ?>" href="tel:<?php echo e($difusion->ram_phone); ?>"><ion-icon name="call-outline"></ion-icon></a>

            </div>
            <div class="col">
                <?php if(!$difusion->livreurs->contains($livreur->id)): ?>
                <button  id="" data-id="<?php echo e($difusion->id); ?>" value="postule" class="btn btn-success btn-sm postule postule<?php echo e($difusion->id); ?>">Postuler</button>
                
            
                <?php else: ?>
                <button id="cancel<?php echo e($difusion->id); ?>"  data-id="<?php echo e($difusion->id); ?>"  value="cancel" class="btn btn-danger postule btn-sm postule<?php echo e($difusion->id); ?>">Me rétirer</button>
                
                <?php endif; ?>
            </div>
                </div>

                
                
                <div class="row mt-2">
                   <div class="col">
                
                <?php if(!$difusion->livreurs->contains($livreur->id)): ?>
                
                
                <span class="contact_status<?php echo e($difusion->id); ?>"></span>
                <?php else: ?>
                
                <span class="contact_status<?php echo e($difusion->id); ?>">Je suis intéréssé</span>
                <?php endif; ?>
            </div>
               </div>
                

             
       </div>
         
      </div>   
</div>



























<?php /**PATH /htdocs/clients/logistica/livreur/resources/views/includes/difusionlist.blade.php ENDPATH**/ ?>
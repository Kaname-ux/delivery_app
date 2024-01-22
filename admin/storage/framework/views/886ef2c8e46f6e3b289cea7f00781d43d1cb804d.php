<?php $__env->startSection("title"); ?>
dvl system
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
<style type="text/css">
  
  th { white-space: nowrap; }

  .dot {
  height: 10px;
  width: 10px;
  background-color: green;
  border-radius: 50%;
  display: inline-block;
}
</style>
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                <!-- <h6 class="card-title">Liste des livreurs <a href="/livreur-form" class="btn">Ajouter</a></h6> -->
               
              </div>

                
              
              <div class="card-body">
                <div class="table-responsive">
                 
                          



                          <div class="container box">
   
                   <div>
                   
                   <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirmer
            </div>
            <div class="modal-body">
                <h4>Voulez-vous vraiment supprimer Ce livreur?</h4>

                

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <a href="#" id="submit" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
    </div>
</div>




 <div class="modal fade" id="reliabilityModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Choisir
            </div>
            <div class="modal-body">
                <form method="POST" action="setreliability">
                  <?php echo csrf_field(); ?>
                  <div class="form-group">
                  <select required class="form-control" name="note">
                    <option value="">Choisir la note</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                  </div>
                

                

            </div>
              <input id="livreur_id" type="text" name="id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button  type="submit" class="btn btn-success">Confirmer</button>
            </div>
            </form>
        </div>
    </div>
</div>





                  

                  <table id="myTable" >
                    <thead class=" text-primary">
                      <!-- <th></th> -->
                      <th>
                        Nom
                      </th>
                      <th>
                        contact
                      </th>
                      <th>
                        Adresse
                      </th>

                      <th>
                        Montant non regle
                      </th>

                      <th>
                        Date de création
                      </th>
                      
                      
                      <th>
                        Numero de piece
                      </th>
                      <th>Compte</th>
                     
                      <!-- <th>Reliability</th> -->
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $livreurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $livreur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                        <div class="modal fade" id="modalLoginForm<?php echo e($livreur->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
            <form method="POST" action="/set-livreur-account">
             <?php echo csrf_field(); ?>
              <input hidden value="<?php echo e($livreur->id); ?>" type="text" name="livreur_id">
              <select name="user_id" class="form-control">
                <?php $__currentLoopData = $available_accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($account->id); ?>"><?php echo e($account->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </select>
            <button type="submit" class="btn btn-default">Definir</button>
         </form>
             </div>
    </div>
  </div>
</div>







                      <tr>
                        
                        <!-- <td>
                          <a href="/livreuredit/<?php echo e($livreur->id); ?>" ><i class="fas fa-edit"></i></a>

                          <form  id="myForm"   method="POST" action="/livreur-delete/<?php echo e($livreur->id); ?>">
                            <?php echo e(csrf_field()); ?>

                        <?php echo e(method_field('DELETE')); ?>

                         <input onclick="myFunction<?php echo e($livreur->id); ?>()" type="button" name="btn" value="Supprimer" id="submitBtn"  class="btn btn-danger" />
                       </form>
                            <script>
                    function myFunction<?php echo e($livreur->id); ?>() {
                       confirm("Confirmer!");
                     }
                          </script>
                        </td> -->
                        <td>
                         
                           <form action="dashboard">
                              
                            <input hidden type="" value="<?php echo e($livreur->id); ?>" name="livreurs[]">
                            <button class="btn  btn-light" type="submit"><?php if($livreur->commands->where("delivery_date", today())->count()>0): ?>
                          <span class="dot"></span>
                          <?php endif; ?><?php echo e($livreur->nom); ?></button>
                          </form>
                          <!-- <a class="badge badge-primary badge-sm" href="/livreur-stat/<?php echo e($livreur->id); ?>">Stats</a> -->
                          
                        </td>
                        <td>
                          <?php echo e($livreur->phone); ?>

                        </td>
                        <td>
                          <?php echo e($livreur->adresse); ?>

                        </td>

                        <td>
                          <?php echo e($livreur->payments->where("etat", "en attente")->sum('montant')); ?>

                        </td>
                        <td>
                          <?php echo e($livreur->created_at); ?>

                        </td>

                        
                        <td >
                          <?php echo e($livreur->pieces); ?>

                        </td>
                        
                        <td>
                          <?php if($livreur->user): ?>
                          <?php echo e($livreur->user->email); ?>

                          <form method="POST" action="/unset-livreur-account/<?php echo e($livreur->user->id); ?>">
                            <?php echo csrf_field(); ?>
                          <button   type="submit"   class="btn btn-succes btn-sm" >
                          </form>Dissocier</button>
                          <?php else: ?>

                           
                         <button   name="btn" data-toggle="modal" data-target="#modalLoginForm<?php echo e($livreur->id); ?>"  class="btn btn-succes btn-sm" >Associer un compte</button>
                       

                          <?php endif; ?>
                        </td>
                       <!--  <td>
                           <?php echo e($livreur->jibiat_reliability); ?> <br>
                           <button value="<?php echo e($livreur->id); ?>"  class="btn btn-default btn-sm setrely">Set</button>
                        </td> -->
                        
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                   
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="col-md-12">
            <div class="card card-plain">
              <div class="card-header">
                <h4 class="card-title"> Table on Plain Background</h4>
                <p class="category"> Here is a subtitle for this table</p>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Name
                      </th>
                      <th>
                        Country
                      </th>
                      <th>
                        City
                      </th>
                      <th class="text-right">
                        Salary
                      </th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          Dakota Rice
                        </td>
                        <td>
                          Niger
                        </td>
                        <td>
                          Oud-Turnhout
                        </td>
                        <td class="text-right">
                          $36,738
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Minerva Hooper
                        </td>
                        <td>
                          Curaçao
                        </td>
                        <td>
                          Sinaai-Waas
                        </td>
                        <td class="text-right">
                          $23,789
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Sage Rodriguez
                        </td>
                        <td>
                          Netherlands
                        </td>
                        <td>
                          Baileux
                        </td>
                        <td class="text-right">
                          $56,142
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Philip Chaney
                        </td>
                        <td>
                          Korea, South
                        </td>
                        <td>
                          Overland Park
                        </td>
                        <td class="text-right">
                          $38,735
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Doris Greene
                        </td>
                        <td>
                          Malawi
                        </td>
                        <td>
                          Feldkirchen in Kärnten
                        </td>
                        <td class="text-right">
                          $63,542
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Mason Porter
                        </td>
                        <td>
                          Chile
                        </td>
                        <td>
                          Gloucester
                        </td>
                        <td class="text-right">
                          $78,615
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Jon Porter
                        </td>
                        <td>
                          Portugal
                        </td>
                        <td>
                          Gloucester
                        </td>
                        <td class="text-right">
                          $98,615
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> -->
        </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("script"); ?>
<script type="text/javascript">
  $(document).ready(function() {



   

$('#submitBtn').click(function() {
     /* when the button in the form, display the entered values in the modal */
     
});


$('.setrely').click(function() {
   var id = $(this).val();

   $("#livreur_id").val(id);  
     $("#reliabilityModal").modal("show");
});

$('#submit').click(function(){
     /* when the submit button in the modal is clicked, submit the form */
    
    $('#myForm').submit();
});
     
} );


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /htdocs/clients/logistica/admin/resources/views/livreur.blade.php ENDPATH**/ ?>
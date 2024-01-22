<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Boutiques</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <style type="text/css">
    .dot {
  height: 10px;
  width: 10px;
  background-color: green;
  border-radius: 50%;
  display: inline-block;
}
  </style>
</head>
<body class="hold-transition sidebar-mini">
  <script src="https://unpkg.com/vue@3"></script> 

  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<div id="app" class="wrapper">
   <div class="modal fade modalbox" id="subscribeModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title refusedModalTitle"></h5>
                       <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    
                    <div class="modal-body " >
                        <div class="refusedModalBody">
                          
                        </div>

                        <form target="_blank" method="POST" action="/subscribe">
                    <?php echo csrf_field(); ?>
                    
            

                     <div class="form-group">
                      <label class="form-label">Formule
                      </label>
                    <select required class="form-control" name="amount">
                        <option value="">Choisir une formule</option>
                        <option value="1000">1000FCFA - 100 SMS</option>
                        <option value="2000">2000FCFA - 200 SMS</option>
                        <option value="3000">3000FCFA - 300 SMS</option>
                        <option value="4000">4000FCFA - 400 SMS</option>
                        <option value="5000">5000FCFA - 500 SMS</option>
                         <option value="10000">10000FCFA - 1000 SMS</option>
                          
                    </select>
                     </div>

                     
                    
                   <button type="submit" class="btn btn-success  phone">Souscrire</button>
                   <button  class="btn btn-default phone" data-dismiss="modal">Fermer</button>
                   </form>
                    </div>
                  
                </div>
            </div>
        </div>

  <!-- Navbar -->
 <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Marketing</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Marketing</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
       <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Espace marketing</h3>

                <div class="card-tools">
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <div class="card bg-success mb-2">
                    <div class="card-header">
                    <h3>Mes SMS </h3>
                    
                </div>
                    <div class="card-body">
                        Vous avez <?php echo e($smscount); ?> SMS disponibles
                    </div>

                    <div class="card-footer">
                        <button data-toggle="modal" data-target="#subscribeModal" class="btn btn-light btn-block">Souscrire</button>
                    </div>
                </div>





               <form method="POST" action="sendsms">
                <?php echo csrf_field(); ?>
                <div class="card mb-2">
                    <div class="card-header">
                    <h3>Message </h3>
                    
                </div>
                
                    <div class="card-body">
                        <div class="form-outline">
  <textarea v-model="message" :maxlength="messageMax" name="message" class="form-control" id="textAreaExample1" rows="4"></textarea>
  <label class="form-label" for="textAreaExample">{{messageMax}} carateres maximum ({{messageMax-message.length}})</label>
</div>
                    </div>
                </div>
             
                <div class="card">
                    <div class="card-header">
                    <h3>Criteres </h3>
                    <h5 class="float-right">{{prospects}}</h5>
                </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Status</label>
                            <select @change="countProspects" name="status" v-model="status" class="form-control">
                                <option>Tout</option>
                                <option value="termine">Livré uniquement</option>
                            </select>
                        </div>

                       

                        <div class="form-group">
                            <label>Commune</label>
                            <select @change="countProspects" v-model="cities"   title="Choisir communes..." id="city-select" class=" selectpicker form-control" multiple="multiple"  name="cities[]">
                                 
                                
                                 <?php $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($fee->id); ?>"><?php echo e($fee->destination); ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                 </select>
                        </div>


                         <div class="form-group">
                            <label>Achat superieur ou egal a</label>
                            <select @change="countProspects" v-model="amount"  class="form-control"   name="amount">
                                <option>Tout les montants</option>
                                 <?php for($x=5000; $x<=100000;$x+=5000): ?>
                                <option><?php echo e($x); ?></option>
                                <?php endfor; ?>
                                
                                 </select>
                        </div>

                         <div class="form-group">
                            <label>Date d'achat</label>
                            <label class="label" for="text11d">Choisir un interval</label>
                            <div class="form-row">
                               <div class="form-check">
              <input @change="countProspects" v-model="allDates"  class="form-check-input" type="checkbox" value="1" >
            <label class="form-check-label" for="flexCheckDefault">
                 Toutes les dates
               </label>
</div>
                            </div>
                                       
                                         <div   class="form-row">
                                         
                                         <div class="col">
                                         <input @change="countProspects" v-model="intStart" :disabled="allDates == 1" value=""  class="form-control" 
                                        
                                         type="date" name="start">
                                          </div>
                                          <div class="col">
                                         <input @change="countProspects" v-model="intEnd" :disabled="!intStart || allDates == 1" :min="intStart"  class="form-control" 
                                          
                                         type="date" name="end">
                                        </div>
                                       
                                        </div>
                        </div>


                        <div class="form-group">
                            <label>A combien de contacts souhaitez vous envoyer (Laisser vide pour envoyer a un maximum)</label>
                            <input   class="  form-control"  name="limit" type="number">
                                 
                        </div>

                    </div>
                    
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        <h5>Tester sur mon numero</h5>
                    </div>
                    <div class="card-body">
                        
                      
                        <div  class="row">
                            <div class="col">
                                <input type="" name="" v-model="phone" class="form-control">
                            </div>

                            <div class="col">
                                <button :disabled='message.length < 1 || Number(smscount) < 1' @click="testsms" type="button" class="btn btn-primary">Tester</button>
                            </div>
                            
                        </div>
                        <div class="row">
                            {{status}}
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    
                    <div class="card-body">
                        <button v-if="confirm == null" @click="confirm = 1" type="button" :disabled='message.length < 1 || Number(smscount) < 1' class="btn btn-primary btn-block">Envoyer message </button>

                        <div v-if="confirm == 1" class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success">Confirmer</button>
                            </div>

                            <div class="col">
                                <button @click="confirm = null" type="button" class="btn btn-light">Annuler</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
                 
             </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->

  <script>

   const app = Vue.createApp({
    data() {
        return {
            
            
            intEnd:null,
            intStart:null,
            allDates:null,
            status:"",
            cities:[],
            amount:"",
            prospects: '<?php echo e($prospects); ?>' ,
            message:"",
            messageMax:500,
            smscount:"<?php echo e($smscount); ?>",
            confirm:null,
            phone:"<?php echo e($client->phone); ?>"
            
            
        }
    },
    methods:{ 
    countProspects(){
         var vm = this
         this.prospects = 'Chargement...'

    axios.post('/countprospects', {
             end:vm.intEnd,
            start:vm.intStart,
            alldates:vm.allDates,
            status:vm.status,
            cities:vm.cities,
            amount:vm.amount,
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
   
    vm.prospects = response.data.prospects+ " Contacts."
   


  })
  .catch(function (error) {
    alert("une erreur s'est produite")
    console.log(error);
  });
    },

    testsms(){
         var vm = this
         this.status = 'Envoi encous...'

    axios.post('/testsms', {
             phone: vm.phone,
             message:vm.message,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
   
    vm.status = response.data.status
   


  })
  .catch(function (error) {
    alert("une erreur s'est produite")
    console.log(error);
  });
    }
   
   },
   computed:{
   
    
}
});

  const mountedApp = app.mount('#app')     

   
 
  </script>
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="../../plugins/select2/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       shareButton = document.getElementById("share");
       $('#city-select').selectpicker();
</script>

</body>
</html>
<?php /**PATH /htdocs/clients/logistica/admin/resources/views/marketing.blade.php ENDPATH**/ ?>
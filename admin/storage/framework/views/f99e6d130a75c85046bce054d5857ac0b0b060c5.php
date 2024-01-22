<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Permissions</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 <script src="https://unpkg.com/vue@3"></script> 
<div class="wrapper" id="app">
  <!-- Navbar -->
   <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Permissions  <?php echo e($client_type->type); ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/roles">Groupe</a></li>
              <li class="breadcrumb-item active">Permissions</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       
          <div class="row">
          <!-- left column -->
          
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-3">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Commandes</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form>
                  
                  <div v-for="(role, index) in roles"  class="form-group">
                    <div v-if="role.antity == 'COMMAND'" class="custom-control custom-switch">
                      <input @click="switchPermission(role.id, index, role.switch)" :checked="role.switch == 1" type="checkbox" class="custom-control-input" :id="'commandSwitch'+index">
                      <label class="custom-control-label" :for="'commandSwitch'+index">{{role.description}}</label>
                    </div>
                  </div>
                 
                  
                 
                  <div class="form-group">
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>

            </div>


             <!-- <div class="col-3">
           
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Mis à disposition</h3>
              </div>
             
              <div class="card-body">
                <form>
                  
                  <div v-for="(role, index) in roles"  class="form-group">
                    <div v-if="role.antity == 'MAD'" class="custom-control custom-switch">
                      <input @click="switchPermission(role.id, index, role.switch)" :checked="role.switch == 1" type="checkbox" class="custom-control-input" :id="'commandSwitch'+index">
                      <label class="custom-control-label" :for="'commandSwitch'+index">{{role.description}}</label>
                    </div>
                  </div>
                 
                  
                 
                  <div class="form-group">
                  </div>
                </form>
              </div>
             
            </div>

            </div>
 -->

             <div class="col-3">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Payements</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form>
                  
                  <div v-for="(role, index) in roles"  class="form-group">
                    <div v-if="role.antity == 'PAYMENT'" class="custom-control custom-switch">
                      <input @click="switchPermission(role.id, index, role.switch)" :checked="role.switch == 1" type="checkbox" class="custom-control-input" :id="'commandSwitch'+index">
                      <label class="custom-control-label" :for="'commandSwitch'+index">{{role.description}}</label>
                    </div>
                  </div>
                 
                  
                 
                  <div class="form-group">
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>

            </div>


            <div class="col-3">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Client </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form>
                  
                  <div v-for="(role, index) in roles"  class="form-group">
                    <div v-if="role.antity == 'CLIENT'" class="custom-control custom-switch">
                      <input @click="switchPermission(role.id, index, role.switch)" :checked="role.switch == 1" type="checkbox" class="custom-control-input" :id="'commandSwitch'+index">
                      <label class="custom-control-label" :for="'commandSwitch'+index">{{role.description}}</label>
                    </div>
                  </div>
                 
                  <div class="form-group">
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
            <div class="col-3">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Tarifs</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form>
                  
                 <div v-for="(role, index) in roles"  class="form-group">
                    <div v-if="role.antity == 'TARIF'" class="custom-control custom-switch">
                      <input @click="switchPermission(role.id, index, role.switch)" :checked="role.switch == 1" type="checkbox" class="custom-control-input" :id="'commandSwitch'+index">
                      <label class="custom-control-label" :for="'commandSwitch'+index">{{role.description}}</label>
                    </div>
                  </div>
                 
                  <div class="form-group">
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
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
<script>

   const app = Vue.createApp({
    data() {
        return {
            
            roles:<?php echo $roles; ?>

            
        }
    },
    methods:{ 
    
    switchPermission(id, index, current){
      
      var vm = this
     
     

    axios.post('/switchrole', {
           
             id: id ,
             current:current,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.roles[index].switch = response.data.switch
    


  })
  .catch(function (error) {
 
    console.log(error);
  });
    }


   },
   computed:{
     
}
});

  const mountedApp = app.mount('#app') 
  </script>  
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
<?php /**PATH /var/www/html/jibiat/admin/resources/views/permissions.blade.php ENDPATH**/ ?>
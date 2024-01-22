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
<div class="wrapper">
  <!-- Navbar -->
 <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Liste des boutique</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Boutiques</li>
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
                <h3 class="card-title">Liste des boutiques</h3>

                <div class="card-tools">
                  <a href="shop-form"  class="btn btn-success">Nouvelle Boutique</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-nowrap">
                  <thead class=" text-primary">
                    <th></th>
                      <th>ID</th>

                      <th>
                        Nom
                      </th>
                      <th>
                        Proprietaire
                      </th>
                     <th>
                       Adresse
                     </th>

                     <th>
                       Contact
                     </th>
                     <th>
                       Nombre de produits
                     </th>
                      
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        
                        <td>
                          

                          <form  id="myForm<?php echo e($shop->id); ?>"   method="POST" action="/shop-delete/<?php echo e($shop->id); ?>">
                            <?php echo e(csrf_field()); ?>

                        <?php echo e(method_field('DELETE')); ?>

                        <a href="/shop-edit-form/<?php echo e($shop->id); ?>" ><i class="fas fa-edit"></i></a>
                        <button id="submitBtn<?php echo e($shop->id); ?>" onclick="myFunction<?php echo e($shop->id); ?>()" class="btn btn-danger btn-sm" type="submit"><i   name="btn" value="Supprimer"  class="fas fa-times"  ></i></button>
                       </form>



                      <script>
                   function myFunction<?php echo e($shop->id); ?>() {
                confirm("Confirmer!");
                            }
            </script>
                          
                        </td>
                        <td><?php echo e($shop->id); ?></td>
                        <td>
                          <?php echo e($shop->name); ?>

                        </td>
                        <td>
                          <?php echo e($shop->owner); ?>

                        </td>

                        <td>
                          <?php echo e($shop->adresse); ?>

                        </td>
                        <td>
                          <?php echo e($shop->contact); ?>

                        </td>

                        <td>
                          <?php echo e(count($shop->products)); ?>

                        </td>
                        

                        
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
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
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
<?php /**PATH /htdocs/clients/logistica/admin/resources/views/shops.blade.php ENDPATH**/ ?>
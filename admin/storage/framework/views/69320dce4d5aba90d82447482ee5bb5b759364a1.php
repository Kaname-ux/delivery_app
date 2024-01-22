
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ajouter Tarif</title>

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
            <h1>Ajouter Tarif</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/fees">Tarifs</a></li>
              <li class="breadcrumb-item active">Ajouter Tarif</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
       
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Ajouter tarifs</h3>

                <div class="card-tools">
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body " style="height: 300px;">
              	<div class="row">
              		<div class="col-md-6">
                <form action="/fee-register" method="POST">
			   			<?php echo e(csrf_field()); ?>

			   			<?php echo e(method_field('PUT')); ?>

						<div class="form-group">
                            <input value="" name="destination" class="form-control" type="text" placeholder="Destination" required>
						</div>

						<div class="form-group">
                            <input  value="" name="price" class="form-control" type="number" placeholder="Price">
                            <span>Facultatif. Vous pouvez definir le prix manuellement pour chaque commande</span>
						</div>

						<div class="form-group">
                            <select required name="zone" class="form-control">
                            	<option value="">Choisir une zone</option>
                            	<option value="ABJ_NORD">Abidjan Nord</option>
                            	<option value="ABJ_SUD">Abidjan Sud</option>
                            	<option value="ABOBO">Abobo</option>
                            	<option value="COCODY2">Cocody</option>
                            	<option value="COCODY1">Rivera-Bingerville</option>
                            	<option value="YOPOUGON">Yopougon</option>
                            	<option value="INTERIEUR">Interieur</option>
                            	
                            	
                            </select>
						</div>

						

						<button type="submit" class="btn btn-success">Valider</button>
						<a href="/fees" class="btn btn-danger">Annuler</a>
						
						
					</form>
					</div>
				</div>
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
<?php /**PATH /htdocs/clients/logistica/admin/resources/views/feeregister.blade.php ENDPATH**/ ?>
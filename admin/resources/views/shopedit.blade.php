
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modifier Boutique</title>

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
 @include("includes.navbar")

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Modifier Boutique {{$shop->name}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/shops">Boutique</a></li>
              <li class="breadcrumb-item active">Modifier Boutique</li>
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
            @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Modifier boutique {{$shop->name}}</h3>

                <div class="card-tools">
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body " >
              	<div class="row">
              		<div class="col-md-6">
                <form action="/shop-edit" method="POST">
                  <input hidden type="" name="id" value="{{$shop->id}}">
			   			{{csrf_field()}}
			   			
						<div class="form-group">
              <label>Nom de la boutique</label>
                            <input value="{{$shop->name}}" name="name" class="form-control" type="text" placeholder="Nom de la boutique" required>
						</div>

						<div class="form-group">
               <label>Adresse de la boutique</label>
                            <input  value="{{$shop->adresse}}" name="adresse" class="form-control"  placeholder="Saisir le nom de la boutique">
                           
						</div>



            <div class="form-group">
               <label>Proprietaire</label>
                            <input  value="{{$shop->owner}}" name="owner" class="form-control"  placeholder="Saisir le nom du Proprietaire">
                           
            </div>

            <div class="form-group">
               <label>Contact</label>
                            <input  value="{{$shop->contact}}" name="contact" class="form-control"  placeholder="Contact de la boutique">
                           
            </div>


						

						

						<button type="submit" class="btn btn-success">Valider</button>
						<a href="/shops" class="btn btn-danger">Annuler</a>
						
						
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

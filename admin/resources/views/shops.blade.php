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
 @include("includes.navbar")

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
        
       @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
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
                      @foreach($shops as $shop)
                      <tr>
                        
                        <td>
                          

                          <form  id="myForm{{$shop->id}}"   method="POST" action="/shop-delete/{{$shop->id}}">
                            {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <a href="/shop-edit-form/{{$shop->id}}" ><i class="fas fa-edit"></i></a>
                        <button id="submitBtn{{$shop->id}}" onclick="myFunction{{$shop->id}}()" class="btn btn-danger btn-sm" type="submit"><i   name="btn" value="Supprimer"  class="fas fa-times"  ></i></button>
                       </form>



                      <script>
                   function myFunction{{$shop->id}}() {
                confirm("Confirmer!");
                            }
            </script>
                          
                        </td>
                        <td>{{$shop->id}}</td>
                        <td>
                          {{$shop->name}}
                        </td>
                        <td>
                          {{$shop->owner}}
                        </td>

                        <td>
                          {{$shop->adresse}}
                        </td>
                        <td>
                          {{$shop->contact}}
                        </td>

                        <td>
                          {{count($shop->products)}}
                        </td>
                        

                        
                      </tr>
                      @endforeach
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

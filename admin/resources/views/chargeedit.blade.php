<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modifier Charge</title>

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
            <h1>Modifier Charge</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/charge">Chatges</a></li>
              <li class="breadcrumb-item active">Modifier Charge</li>
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
                <h3 class="card-title">Modifier charge</h3>

                <div class="card-tools">
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body " >
                <div class="row">
                  <div class="col-md-6">
                <form action="/charge-update/{{$charge->id}}"  method="POST">
              {{csrf_field()}}
              {{method_field('PUT')}}
            

            <div class="form-group">
              <label>Montant*</label>
                            <input required value="{{$charge->montant}}" name="montant" class="form-control" type="text" placeholder="Montant">
            </div>

            <div class="form-group">
               <label>Date*</label>
                            <input required value={{Str::before($charge->charge_date, ' 00:00:00')}} name="charge_date" class="form-control" type="date" placeholder="Date de livraison">
            </div>

       
            <div class="form-group">
               <label>Boutique</label>
                            <select class="form-control" name="shop">
                            <option 
                              value="">Boutique</option>
                              
                              <option {{($charge->shop_id == null) ? 'selected' : ''}} value="">Tout</option>
                              @foreach($shops as $shop)
                              <option
                              {{($shop->id == $charge->shop_id) ? 'selected' : ''}}

                               value="{{$shop->id}}">{{$shop->name}}</option>
                        
                              @endforeach
                            </select>
            </div>
            

          
                       
            <div class="form-group">
               <label>Source*</label>
                            <select required class="form-control" name="source">
                            <option 
                              value="">selectionner Source</option>
                              
                              <option {{($charge->source == 'Global') ? 'selected' : ''}} value="Global">Global</option>
                              @foreach($sources as $source)
                              <option
                              {{($source->type. "_".$source->antity == $charge->source) ? 'selected' : ''}}

                               value="{{$source->type. "_".$source->antity}}">{{$source->type. "_".$source->antity}}</option>
                        
                              @endforeach
                            </select>
            </div>


                  <div class="form-group">
                     <label>Type de charge*</label>
                            <select required class="form-control" name="type">
                            <option 
                              value="">selectionner un type</option>
                              @foreach($charge_types as $charge_type)
                              <option
                              {{($charge_type == $charge->type) ? 'selected' : ''}}

                               value="{{$charge_type}}">{{$charge_type}}</option>
                        
                              @endforeach
                            </select>
                     </div>

                      <div id="periode" @if($charge->type != "Fixe") hidden @endif class="form-group">
                        <label>Periodicite*</label>
                            <select id="periodicite" class="form-control" name="periode">
                            <option 
                              value="">selectionner periodicite</option>
                              
                          <option value="52">Hebdomadiare</option>
                        <option value="12">Mensuel</option>
                          <option value="6">Bi-Mensuel</option>
                       <option value="4">Trimestriel</option>
                       <option value="2">Semestriel</option>
                        <option value="1">Annuel</option>
                        
                            
                            </select>
                     </div>

                       <div class="form-group">
                        <label>Nature de la charge*</label>
                            <select required  class="form-control" name="nature">
                            <option 
                              value="">selectionner la nature de la charge</option>
                              @foreach($charge_natures as $charge_nature)
                              <option
                              
                               {{($charge_nature == $charge->nature) ? 'selected' : ''}} 
                               value="{{$charge_nature}}">{{$charge_nature}}</option>
                        
                              @endforeach
                            </select>
                     </div>


            <div class="form-group">
                <label>Details</label>
                            <input value="{{$charge->detail}}" name="detail" class="form-control" type="text" placeholder="Detail">
            </div>

            <button type="submit" class="btn btn-success">Modifier</button>
            <a href="/charge" class="btn btn-danger">Annuler</a>
            
            
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
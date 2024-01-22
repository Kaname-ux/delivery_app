<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Roles</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <script src="https://unpkg.com/vue@3"></script> 
<div class="wrapper" id="app">
   <div class="modal fade " id="role-modal" aria-modal="true" role="dialog" >
        <div class="modal-dialog">
          <form method="post" action="addrole">
            @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Nouveau groupe</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            
            <div class="modal-body">

              <div class="form-group">
                <label>Titre</label>
                <input maxlength="50" required class="form-control" type="" name="type">
              </div>
              <div class="form-group">
                <label>Description</label>
                <input maxlength="150" required class="form-control" type="" name="description">
              </div>

              <div class="form-group">
                <label>Objectif mensuel(nombre de commandes)</label>
                <input  required class="form-control" type="number" name="goal">
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
              <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
          
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


      <div class="modal fade " id="goal-modal" aria-modal="true" role="dialog" >
        <div class="modal-dialog">
          <form method="post" action="setgoal">
            @csrf
            <input type="" name="id" hidden :value="roleId">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Definir objectif mensuel du groupe</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            
            <div class="modal-body">

              <div class="form-group">
                <label>Objectif mensuel(nombre de commandes)</label>
                <input :value="goal" required class="form-control" type="number" name="goal">
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
              <button  type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
          
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  
  <!-- Navbar -->
   @include("includes.navbar")
  <!-- /.navbar -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Groupe d'utilisateurs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Groupe d'utilisateurs</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
          @if (session('status'))
         <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> {{ session('status') }}</h5>
                  
                </div>
          @endif      
      <div class="container-fluid">
       
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Groupe d'utilisateurs</h3>

                <div class="card-tools">
                  <button data-toggle='modal' data-target="#role-modal" class="btn btn-primary" type="button">
                    <i class="fas fa-plus"></i> Ajouter un groupe
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      
                      <th>Titre</th>
                      <th>Description</th>
                      <th>Permissions</th>
                      <th>Objectif mensuel</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($roles as $role)
                    <tr>
                     
                      <td>{{$role->type}}</td>
                      <td>{{$role->description}}</td>
                      <td>
                        <form action="permissions" method="post">
                          @csrf
                          <input hidden type="" name="id" value="{{$role->id}}">
                          <button type="submit" class="btn btn-default">Gerer les permissions</button>
                        </form>
                        <a href="permisions">
                        
                      </a>
                    </td>
                    <td>
                      {{$role->mensual_goal}} <br>
                      <button @click="setId({{$role->id}},{{$role->mensual_goal}})" data-toggle="modal" data-target="#goal-modal" class="btn btn-primary">Redefinir</button>
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


 <script>

   const app = Vue.createApp({
    data() {
        return {
            
            roleId : 0,
            goal: 0
        }
    },
    methods:{ 
     setId(id, goal){
      this.roleId = id
      this.goal = goal
     }
    }
    });

  const mountedApp = app.mount('#app')  
    </script>
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

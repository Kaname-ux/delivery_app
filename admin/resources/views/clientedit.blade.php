<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Utilisateurs</title>

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
            <h1>Modifier Utilisateur</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/users">Utilisateurs</a></li>
              <li class="breadcrumb-item active">Modifier Utilisateurs</li>
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
                <h3 class="card-title">Modifier Utilisateur {{$client->nom}}</h3>

                <div class="card-tools">
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body " >
                <div class="row">
                        <div class="col-sm-6">

                    <form action="/client-update/{{$client->id}}"  method="POST">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <div class="card">
                            <div class="card-header">Modifier information</div>
                          <div class="card-body">

                    <div class="form-group basic ">
                        

                            <div class="input-wrapper @error('type') alert alert-outline-danger @enderror">
                                <label for="city" class="label">Type d'utilisateur</label>
                                @if($client->client_type == "ADMIN")
                                <input  class="form-control " name="type" value="{{$client->client_type}}" readonly required>
                                @else
                                 <select  class="form-control " name="type" required>
                                    <option  value="">
                                        Choisir un type d'utilisateurs
                                    </option>
                                    @foreach($types->where("type", "!=", "ADMIN") as $type)
                                    <option @if($client->client_type == $type->type) selected @endif  value="{{$type->type}}">
                                      {{$type->type}}
                                    </option>

                                  @endforeach
                                </select>
                                @endif
                                @error('type')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    <div class="card-body">

                       <div class="form-group basic">
                            

                            <div class="input-wrapper  @error('name') alert alert-outline-danger @enderror">
                                <label for="name" class="label">Nom et prenom</label>
                                <input max="50" placeholder="Nom et prenom" id="name" type="text" class="form-control " name="name" value="{{ $client->nom }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group basic">
                            

                            <div class="input-wrapper @error('phone') alert alert-outline-danger @enderror">
                                <label for="phone" class="label">Contact</label>
                                <input maxlength="10" placeholder="Ex: 07000000" id="phone" type="number" class="form-control " name="phone" value="{{ $client->phone }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                      



                        <?php 
                          $communes = array("Adjamé", "Cocody", "Attécoubé", "Bingerville", "Anyama", "Koumassi", "Plateau", "Treichville", "Marcory", "Port-Bouet", "Bassam", "Songon", "Abobo", "Yopougon" );

                          sort($communes);
                           ?>


                       <div class="form-group basic ">
                        

                            <div class="input-wrapper @error('city') alert alert-outline-danger @enderror">
                                <label for="city" class="label">Ville/Commune</label>
                                <select  class="form-control " name="city" required>
                                    <option value="">
                                        Choisir une ville/commune
                                    </option>
                                    
                                    @foreach($communes as $commune) 
                                    <option @if($commune == $client->city) selected @endif value='{{$commune}}'>{{$commune}}</option>
                                    
                                    @endforeach
                                </select>
 
                                @error('city')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                         <div class="form-group basic">
                            

                            <div class="input-wrapper @error('adresse') alert alert-outline-danger @enderror">
                                <label for="adresse" class="city">Précison adresse </label>
                                <input max="100" placeholder="Ex: Angre 8e tranche... " id="adrssse" type="text" class="form-control " name="adresse" value="{{ $client->adresse }}" required autocomplete="adresse" autofocus>

                                @error('adresse')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        
    
        

                       
        
                    </div>
                </div>



                <div class="form-button-group transparent">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Enregistrer</button>
                </div>
              </div>
                        
                        
                    </form>
                </div>


                <div class="col-sm-6">
                    
                    <form action="/updateuser"  method="POST">
                        @csrf
                        <input hidden type="" value="{{$client->user->id}}" name="id">
                        <div class="card">
                            <div class="card-header">Modifier Compte</div>
                             <div class="card-body">
                                 <div class="form-group basic @error('email') alert alert-outline-danger @enderror">
                            <div class="input-wrapper">
                                <label class="label" for="email1">E-mail</label>
                                <input type="email" class="form-control " name="email" value="{{ $client->user->email }}" id="email1" placeholder="Votre e-mail">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>

                                @error('email')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

        
                        <div class="form-group basic">
                            <div class="input-wrapper @error('password') alert alert-outline-danger @enderror">
                                <label class="label" for="password1">Mot de passe</label>
                                <input value="" min="8" max="20" name="password" type="password" class="form-control " name="password" required autocomplete="new-password"placeholder="8 caratères minimum">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>

                                @error('password')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group basic">
                            <div class="input-wrapper @error('password') alert alert-outline-danger @enderror">
                                <label min="8" max="20" class="label" for="password2">Confirmer mot de passe</label>
                                <input value="" type="password" class="form-control "  required name="password_confirmation"  id="password2" placeholder="Confirmer mot de passe">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                              @error('password_confirmation')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                               
                            </div>
                        </div>

                       <div class="form-button-group transparent">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Enregistrer</button>
                </div>
                             </div>
                              
        
                    </div>
               
                    </form>
                     </div>
  
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


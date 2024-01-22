<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Facture {{$offer->description}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
 <!-- use the latest vue-select release -->

<div id="app" class="wrapper">



  <!-- Navbar -->
 @include("includes.navbar")
 <div class="modal fade action-sheet  " id="saveBillModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Enregistrer facture</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                        

                    </div>
                    <div   class="modal-body">
                             {{$client->nom}}<br>
                             {{$offer->subscription_type}}<br>
                             {{$offer->description}}<br>
                             Montant TTC: {{ceil($cost*1.18)}}<br>
                             Période: du  {{date_create($offer->start)->format("d-m-Y")}} au {{date_create($offer->end)->format("d-m-Y")}}

                             <form method="POST" action="savebill">
                              <div hidden>
                              <input type="" name="subscription_id" value="{{$offer->id}}">
                              <input type="" name="subscription_type" value="{{$offer->subscription_type}}">
                              <input type="" name="description" value="{{$offer->description}}">
                              <input type="" name="cost" value="{{$offer->cost}}">
                              <input type="" name="client" value="{{$client->nom}}">
                              <input type="" name="phone" value="{{$client->phone}}">
                              <input type="" name="adresse" value="{{$client->adresse}}">

                              <input type="" name="qty" value="{{$offer->qty}}">

                              <input type="" name="done" value="{{$offer->commands()->count()}}">

                              <input type="" name="extra" value="{{$extra}} {{$extra_details}}">

                              <input type="" name="extra_cost" value="{{$extra_cost}}">

                              <input type="" name="periode" value="{{date_create($offer->start)->format('d-m-Y')}} au {{date_create($offer->end)->format('d-m-Y')}}">

                              <input type="" name="ht" value=" {{ceil($cost)}}">

                               <input type="" name="tva" value="{{ceil($cost*18/100)}}">

                               <input type="" name="ttc" value="{{ceil($cost*1.18)}}">
                                
                                 @if($offer->subscription_type == "MAD")
                          
                          <input type="" name="livreurs" value="{{$offer->livreurs()->count()}}">
                          @endif
                               
                              </div>
                               @csrf
                               <button class="btn btn-success btn-block">Valider</button>
                             </form>
                    </div>
                </div>
            </div>
        </div>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Facture {{$offer->description}}</h1><button onclick="printElement('bill')">Imprimer</button>
            <button data-toggle="modal" data-target="#saveBillModal">Enregistrer</button>
            <div class="card">
              <div class="card-header">Regénérer</div>
              <div class="card-body">
            <form class="" action="bill">

               <input hidden value="{{$offer->id}}" name="id">
              <div class="form-group">
                <label class="form-label">Entre le {{date_create($offer->start)->format("d-m-Y")}} et le  {{date_create($offer->end)->format("d-m-Y")}}</label><br>
                <button type="button" onclick="document.getElementById('billdate').value = '{{$offer->end}}';" class="btn btn-primary">Toute la durée de l'abonnement</button>
                <input id="billdate" max="{{$offer->end}}"  min="{{$offer->start}}" value="{{Request('billdate')}}" class="form-control" type="date" name="billdate">
              </div>
              <button class="btn btn-success">Valider</button>
            </form>
            </div>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Abonnés</a></li>
              <li class="breadcrumb-item active">facture</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div id="bill"  class="container-fluid">
        
     
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Facture {{$offer->description}}

            </h3><br>
            <h3 class="card-title">Numero: {{$offer->id}}

            </h3><br>

             <h3 class="card-title">Période: du  {{date_create($offer->start)->format("d-m-Y")}} au {{date_create(Request('billdate'))->format("d-m-Y")}}

            </h3>
             

                <div class="card-tools">
                  {{$client->nom}} <br>
                    
                  {{$client->adresse}}<br>
                  {{$client->phone}}

                   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body  p-0" >
                <table class="table table-responsive ">
                  <thead class=" text-primary">
                     
                       <th>
                        Description
                      </th>
                     
                      <th>Prise en charge mensuelle</th>
                      
                     
                      <th>
                        Quantité
                      </th>
                      <th>
                     Coût unitaire
                     </th>
                     <th>
                       Limitation
                     </th>
                     <th>
                       Effectué
                     </th>
                     <th>
                       Extra
                     </th>
                     <th>
                       Jours consommés
                     </th>
                     <th>
                       Cout extra
                     </th>
                     <th>
                      Total Hors taxe
                     </th>
                     <th>
                       TVA 18%
                     </th>
                     <th>
                       Total TTC
                     </th>
                     
                     
                      
                    </thead>
                    <tbody>
                     
                      <tr >
                        
                       
                         <td> {{$offer->subscription_type}}<br>
                            
                             {{$offer->description}}
                         </td>
                          
                        <td>
                          
                          {{$offer->cost}}
                          
                        </td>
                       
                        <td>
                          @if($offer->subscription_type == "MAD")
                          {{$offer->livreurs()->count()}}
                          @endif
                        </td>

                        <td>
                          {{$offer->cost}}
                          
                        </td>
                        <td>
                          {{$offer->qty}}
                        </td>
                        <td>
                          {{$offer->commands()->count()}}
                        </td>
                          
                         <td>
                          {{$extra}} {{$extra_details}}
                        </td>
                        <td>
                          @if($interval->days == $globalinterval->days)
                          Totalité
                          @else
                          {{$interval->days}}
                          @endif
                        </td>
                        <td>
                          {{$extra_cost}}
                        </td>

                        <td>

                           {{ceil($cost)}}
                          
                        </td>

                        
                         <td>
                          {{ceil($cost*18/100)}}
                          </td>

                          <td>
                          {{ceil($cost*1.18)}}
                          </td>
                         
                        
                        
                      </tr>
                     
                     
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




      


       <button hidden id="addCostumerBtn" data-toggle="modal" data-target="#offerModal"></button>
</div>
<!-- ./wrapper -->


<script>

   const app = Vue.createApp({
    data() {
        return {

          

              }
    },
    methods:{



    },
   computed:{
   
     
}
});

  const mountedApp = app.mount('#app')     
</script>
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript">var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');</script>
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript">
  $('#livreur-select').select2();
    $('#zone-select').select2();

      function printElement(elementToPrint) {
    // Get the element with the desired ID
    const element = document.getElementById(elementToPrint);

    // Check if the element exists
    if (element) {
        // Print the innerHTML of the element
        old = document.body.innerHTML
        document.body.innerHTML = element.innerHTML
          window.print();
          location.reload()
        console.log(element.innerHTML);
    } else {
        console.log('Element not found.');
    }
}
</script>
</body>
</html>

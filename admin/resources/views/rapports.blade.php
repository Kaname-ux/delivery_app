<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Rapport</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

  <style type="text/css">
    .emphasize{
      font-size: 22;
      font-weight: bold;
    }

    .info-box{
      
      height: 1px !important; 
    } 
  </style>
</head>
<body class="hold-transition sidebar-mini">
  <?php    
    $clientsData = array();
               $montantData =  array(); 
               
               $livreursData = array();
               $montant6Data =  array();


               $feesData = array();
               $montant3Data =  array();

               ?>
            @foreach($command_by_clients as $command)
         @foreach($clients as $client)
         @if($client->id == $command->client_id)
         <?php $clientsData[] = $client->nom;
               $montantData[] =  $command->montant; ?>
           @endif
           @endforeach
          @endforeach   

           @foreach($command_by_fees as $command_by_fee)
         @foreach($all_fees as $one_fee)
         @if($one_fee->id == $command_by_fee->fee_id)

         <?php $feesData[] = $one_fee->destination;
               $montant3Data[] =  $command_by_fee->montant; ?>

           @endif
           @endforeach
          @endforeach   


          @foreach($command_by_livreurs as $command_by_livreur)
         

         <?php $livreursData[] = $command_by_livreur->livreur->nom;
               $montant6Data[] =  $command_by_livreur->qty; ?>

           
          @endforeach         
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 <script src="https://unpkg.com/vue@3"></script> 
<div class="wrapper" id="app">

   <div class="modal fade " id="clientsModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@{{title}}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                      <div class="row mb-2">
                        <div style="font-weight: bold; font-size: 18px" class="col">
                          @{{day}}
                        </div>
                      </div>

                      <div v-if="notes" >

                         <div v-for="note in notes" class="row">
                          <div class="col">
                            @{{note.commands}}: @{{note.description}}
                          </div>
                      </div>
                      </div>
                   
                    </div>
                </div>
            </div>
        </div>




  <div class="modal fade " id="dateModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Date</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            
                                <div class="form-group basic">
                                    <div class="input-wrapper">


                                           <form  autocomplete="off"  action='?bydate' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("yesterday"))}}'   class="form-control " type="date" :name="'start'+dateName">
                                         <input  hidden value='{{date("Y-m-d",strtotime("yesterday"))}}'   class="form-control " type="date" :name="'end'+dateName">
                                         <button type="submit" class="btn btn-secondary btn-block "   >Hier</button>

                                        </div>
                                         </form>

                                         <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("today"))}}'   class="form-control " type="date" :name="'start'+dateName">
                                         <input  hidden value='{{date("Y-m-d",strtotime("today"))}}'   class="form-control " type="date" :name="'end'+dateName">
                                         <button type="submit" class="btn btn-secondary btn-block "   >Aujourd'hui</button>

                                        </div>
                                         </form>




                                          <form  autocomplete="off"  action='?bydate' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("first day of last veek"))}}'   class="form-control " type="date" :name="'start'+dateName">
                                         <input  hidden value='{{date("Y-m-d",strtotime("last day of last week"))}}'   class="form-control " type="date" :name="'end'+dateName">
                                         <button type="submit" class="btn btn-secondary btn-block "   >La semaine dernière</button>

                                        </div>
                                         </form>

                  <form  autocomplete="off"  action='?' >
                                         @csrf
                 <div  class="form-group ">
                                         
                <input  hidden value='{{date("Y-m-d",strtotime("first day of this week"))}}'   class="form-control " type="date" :name="'start'+dateName">
                                         <input  hidden value='{{date("Y-m-d",strtotime("last day of this week"))}}'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-secondary btn-block "   >Cette semaine</button>

                                        </div>
                                         </form>



                                        <form  autocomplete="off"  action='?bydate' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("first day of last month"))}}'   class="form-control " type="date" :name="'start'+dateName">
                                         <input  hidden value='{{date("Y-m-d",strtotime("last day of last month"))}}'   class="form-control " type="date" :name="'end'+dateName">
                                         <button type="submit" class="btn btn-secondary btn-block "   >Le mois dernier</button>

                                        </div>
                                         </form>

                                         <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("first day of this month"))}}'   class="form-control " type="date" :name="'start'+dateName">
                                         <input  hidden value='{{date("Y-m-d",strtotime("last day of this month"))}}'   class="form-control " type="date" :name="'end'+dateName">
                                         <button type="submit" class="btn btn-secondary btn-block "   >Ce mois</button>

                                        </div>
                                         </form>
                                        
                                        <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("first day of january this year"))}}'   class="form-control " type="date" :name="'start'+dateName">
                                         <input  hidden value='{{date("Y-m-d",strtotime("last day of december this year"))}}'   class="form-control " type="date" :name="'end'+dateName">
                                         <button type="submit" class="btn btn-secondary btn-block "   >Cette annee</button>

                                        </div>
                                         </form>

                                         <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("first day of january last year"))}}'   class="form-control " type="date" :name="'start'+dateName">
                                         <input  hidden value='{{date("Y-m-d",strtotime("last day of december last year"))}}'   class="form-control " type="date" :name="'end'+dateName">
                                         <button type="submit" class="btn btn-secondary btn-block "   >L'annee derniere</button>

                                        </div>
                                         </form>
                                       
                                    </div>
                                </div>
                                <div>
                              <form autocomplete="off" id="date-form" action="?">
                                @csrf
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11d">Choisir une date</label>
                                       
                                         <div  class="form-row">
                                         <div class="col">
                                         <input v-model="costumStart" value=""  class="form-control"type="date" :name="'start'+dateName">
                                         
                                         </div>
                                         <div class="col">
                                            <button class="btn btn-primary btn-sm">Valider</button> 
                                         </div>
                                         
                                         <input hidden id="costumEnd" :value="costumStart"  class="form-control" 
                                          
                                         type="date" :name="'end'+dateName">

                                        </div>
                                        
                                    </div>
                                </div>
                             </form>
                             </div>

                             <form autocomplete="off" id="date-form" action="?">
                                @csrf
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11d">Choisir un interval</label>
                                       
                                         <div  class="form-row">
                                         
                                         <div class="col">
                                         <input v-model="intStart" value=""  class="form-control" 
                                        
                                         type="date" :name="'start'+dateName">
                                          </div>
                                          <div class="col">
                                         <input :disabled="!intStart" :min="intStart"  class="form-control" 
                                          
                                         type="date" :name="'end'+dateName">
                                        </div>
                                       
                                        </div>
                                        <button class="btn btn-primary btn-sm">Valider</button> 
                                    </div>
                                </div>
                             </form>
                                

                                
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
  <!-- Navbar -->
       @include("includes.navbar")

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Rapports</h1>
             <!-- <button @click="getDateName('')" data-toggle="modal" data-target="#dateModal" class="btn btn-primary btn-sm">{{$day}}</button> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Rapports</li>
            </ol>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3 col-6">
             <button @click="getDateName('1')" data-toggle="modal" data-target="#dateModal" class="btn btn-light">{{$day1}}</button>
             <div class="card" >
             <div class="card-body">
                   <div class="row">
           <div class="col-4">
            Total <br>
             <button class="btn btn-primary btn-block"><span class="emphasize">{{$command_by_clients1->sum("montant")}} ({{$command_by_clients1->sum("qty")}})</span></button>
           </div>

           <div class="col-4"> Livré <br>
             <button class="btn btn-success btn-block"><span class="emphasize">{{$command_by_clients_delivered1->sum("montant")}} ({{$command_by_clients_delivered1->sum("qty")}})</span></button>
           </div>

             <div class="col-4"> Annulé <br>
             <button data-toggle="modal" data-target="#clientsModal" @click='getCancelReasons("{{$start1}}", "{{$end1}}", "{{$day1}}")' class="btn btn-danger btn-block"><span class="emphasize">{{$command_by_clients_undelivered1->sum("montant")}} ({{$command_by_clients_undelivered1->sum("qty")}})</span> </button>
           </div>
         </div>




             </div>
                 
             </div>
          


             <div class="row">

          <div class="col-12 col-sm-6 col-md-12">
            <div class="info-box">
              

              <div class="info-box-content">
                <span class="info-box-text">temps moyen par livraison</span>
                <span class="info-box-number">
                 @if(is_array($result1))
                  {{ round($result1['hours'])}}h : {{ round($result1['remaining_minutes'])}} mns  
                                 @endif
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        

         
          <!-- /.col -->
        </div>
          </div>
     
        <div class="col-lg-3 col-6">
             <button @click="getDateName('2')" data-toggle="modal" data-target="#dateModal" class="btn btn-light float-right">{{$day2}}</button>
           <div class="info-box mb-3 bg-light">
            

              <div class="info-box-content">
               
               <div class="row">
           <div class="col-4">Total<br>
             <button class="btn btn-primary btn-block"> <span class="emphasize">{{$command_by_clients2->sum("montant")}} ({{$command_by_clients2->sum("qty")}})</span></button>
           </div>

           <div class="col-4">Livré<br>
             <button class="btn btn-success btn-block"> <span class="emphasize">{{$command_by_clients_delivered2->sum("montant")}} ({{$command_by_clients_delivered2->sum("qty")}})</span></button>
           </div>

             <div class="col-4"> Annulé <br>
             <button data-toggle="modal" data-target="#clientsModal" @click='getCancelReasons("{{$start2}}", "{{$end2}}", "{{$day2}}")' class="btn btn-danger btn-block"><span class="emphasize">{{$command_by_clients_undelivered2->sum("montant")}} ({{$command_by_clients_undelivered2->sum("qty")}})</span> </button>
           </div>
         </div>   
              </div>
              <!-- /.info-box-content -->


            </div>
             <div class="row">

          <div class="col-12 col-sm-6 col-md-12">
            <div class="info-box">
              

              <div class="info-box-content">
                <span class="info-box-text">temps moyen par livraison</span>
                <span class="info-box-number">
                 @if(is_array($result2))
                  {{ round($result2['hours'])}}h : {{ round($result2['remaining_minutes'])}} mns  
                                 @endif
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        

         
          <!-- /.col -->
        </div>
          </div>



          <!-- Month -->
          <div class="col-lg-3 col-6">
             <button @click="getDateName('3')" data-toggle="modal" data-target="#dateModal" class="btn btn-light float-right">{{$day3}}</button>
           <div class="info-box mb-3 bg-light">
            

              <div class="info-box-content">
               
               <div class="row">
           <div class="col-4">Total<br>
             <button class="btn btn-primary btn-block"> <span class="emphasize">{{$command_by_clients3->sum("montant")}} ({{$command_by_clients3->sum("qty")}})</span></button>
           </div>

           <div class="col-4">Livré<br>
             <button class="btn btn-success btn-block"> <span class="emphasize">{{$command_by_clients_delivered3->sum("montant")}} ({{$command_by_clients_delivered3->sum("qty")}})</span></button>
           </div>

             <div class="col-4">Annulé<br>
             <button data-toggle="modal" data-target="#clientsModal" @click='getCancelReasons("{{$start3}}", "{{$end3}}", "{{$day3}}")' class="btn btn-danger btn-block"><span class="emphasize">{{$command_by_clients_undelivered3->sum("montant")}} ({{$command_by_clients_undelivered3->sum("qty")}})</span> </button>
           </div>
         </div>   
              </div>
             
          </div>

           <div class="row">

          <div class="col-12 col-sm-6 col-md-12">
            <div class="info-box">
              

              <div class="info-box-content">
                <span class="info-box-text">temps moyen par livraison</span>
                <span class="info-box-number">
                 @if(is_array($result3))
                  {{ round($result3['hours'])}}h : {{ round($result3['remaining_minutes'])}} mns  
                                 @endif
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        

         
          <!-- /.col -->
        </div>

            </div>
              <!-- /Month -->
 
         <div class="col-lg-3 col-6">
             <button @click="getDateName('')" data-toggle="modal" data-target="#dateModal" class="btn btn-light float-right">{{$day}}</button>
           <div class="info-box mb-3 bg-light">
              

              <div class="info-box-content">
               
               <div class="row">
           <div class="col-4">Total<br>
             <button class="btn btn-primary btn-block"><span class="emphasize">{{$command_by_clients->sum("montant")}} ({{$command_by_clients->sum("qty")}})</span></button>
           </div>

           <div class="col-4">Livré<br>
             <button class="btn btn-success btn-block"> <span class="emphasize">{{$command_by_clients_delivered->sum("montant")}} ({{$command_by_clients_delivered->sum("qty")}})</span></button>
           </div>

             <div class="col-4">Annulé<br>
             <button data-toggle="modal" data-target="#clientsModal" @click='getCancelReasons("{{$start}}", "{{$end}}", "{{$day}}")' class="btn btn-danger btn-block"><span class="emphasize">{{$command_by_clients_undelivered->sum("montant")}} ({{$command_by_clients_undelivered->sum("qty")}})</span> </button>
           </div>
         </div>   
              </div>
              <!-- /.info-box-content -->
            </div>

             <div class="row">

          <div class="col-12 col-sm-6 col-md-12">
            <div class="info-box">
              

              <div class="info-box-content">
                <span class="info-box-text">temps moyen par livraison</span>
                <span class="info-box-number">
                  @if(is_array($result))
                  {{ round($result['hours'])}}h : {{ round($result['remaining_minutes'])}} mns  
                                 @endif
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        

         
          <!-- /.col -->
        </div>
          </div>
        
        </div>
        
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="mb-2">
        <h1>Clients</h1>
           <div class="row">
            <div class="col">
           <div class="card card-secondary" >
              
              <div class="card-body">

                <div class="row ">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Nombre de client</span>
                <span class="info-box-number">
                  {{$clients->count()}}
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box ">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Clients Actifs</span>
                <span class="info-box-number">{{$all_actifs}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box ">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-down"></i></span>

              <div class="info-box-content">
               <span class="info-box-text">Clients Inactifs</span>
                <span class="info-box-number">{{$all_inactifs}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         
          <!-- /.col -->
        </div>
                 
                <!-- <div class="chart">
                  <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div> -->
              </div>


                 </div>
                 </div>
              <!-- /.card-body -->
            </div>

       
        <div class="row">


        <div class="col-md-3">
            
            <div class="card card-secondary" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;">
              <div class="card-header border-0">
                <h3 class="card-title">Chiffre d'affaire par client</h3>
                <div class="card-tools">
               
                 <!--  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->

                  <button @click="getDateName('1')" data-toggle="modal" data-target="#dateModal" class="btn btn-light btn-sm">{{$day1}}</button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Client</th>
                    <th>Qté</th>
                    <th>CA</th>
                    <!-- <th>mns/livré</th> -->
                    
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($command_by_clients_delivered1 as $byp1)
                  <tr>
                    

                    <td>
                     <!--  <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        12%
                      </small> -->
                     {{$byp1->client->nom}}
                    </td>
                    <td>
                      {{$byp1->qty}}
                    </td>
                    <td>
                      {{$byp1->montant}}
                    </td>
                   <!--  <td>
                      {{round($int1/$byp1->qty)}}
                    </td> -->
                  </tr>
                 @endforeach
                  
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
             

              <div class="info-box-content">
                <span class="info-box-text">Nouveaux</span>
                <span class="info-box-number">
                  {{$clients->where("created_at", today())->count()}}
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              

              <div class="info-box-content">
                <span class="info-box-text">Actifs</span>
                <span class="info-box-number">{{$actifs1->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
             

              <div class="info-box-content">
               <span class="info-box-text">Inactifs</span>
                <span class="info-box-number">{{$inactifs1->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         
          <!-- /.col -->
        </div>

            <!-- /.card -->

            
          </div>
         

         
         <div class="col-md-3">
           
            <div class="card card-secondary" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;">
              <div class="card-header border-0">
                <h3 class="card-title">Chiffre d'affaire par client</h3>
                <div class="card-tools">
               
                 <!--  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->
                  <button @click="getDateName('2')" data-toggle="modal" data-target="#dateModal" class="btn btn-light btn-sm">{{$day2}}</button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Client</th>
                    <th>Qté</th>
                    <th>CA</th>
                    <!-- <th>Mns/livré</th> -->
                    
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($command_by_clients_delivered2 as $byp2)
                  <tr>
                    

                    <td>
                     <!--  <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        12%
                      </small> -->
                     {{$byp2->client->nom}}
                    </td>
                    <td>
                      {{$byp2->qty}}
                    </td>
                    <td>
                      {{$byp2->montant}}
                    </td>

                    <!--  <td>
                      {{round($int2/$byp2->qty)}} mns
                    </td> -->
                  </tr>
                 @endforeach
                  
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
             
              <div class="info-box-content">
                <span class="info-box-text">Nouveaux</span>
                <span class="info-box-number">
                  {{$clients->whereBetween("created_at", [date("Y-m-d",strtotime("first day of this week")), today()])->count()}}
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              

              <div class="info-box-content">
                <span class="info-box-text">Actifs</span>
                <span class="info-box-number">{{$actifs2->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
             

              <div class="info-box-content">
               <span class="info-box-text">Inactifs</span>
                <span class="info-box-number">{{$inactifs2->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         
          <!-- /.col -->
        </div>

       

            <!-- /.card -->
          </div>






          <div class="col-md-3">
           
            <div class="card card-secondary" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;">
              <div class="card-header border-0">
                <h3 class="card-title">Chiffre d'affaire par client</h3>
                <div class="card-tools">
               
                 <!--  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->
                  <button @click="getDateName('3')" data-toggle="modal" data-target="#dateModal" class="btn btn-light btn-sm">{{$day3}}</button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Client</th>
                    <th>Qté</th>
                    <th>CA</th>
                    <!-- <th>Mns/livré</th> -->
                    
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($command_by_clients_delivered3 as $byp3)
                  <tr>
                    

                    <td>
                     <!--  <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        12%
                      </small> -->
                     {{$byp3->client->nom}}
                    </td>
                    <td>
                      {{$byp3->qty}}
                    </td>
                    <td>
                      {{$byp3->montant}}
                    </td>
                     <!-- <td>
                      {{round($int2/$byp2->qty)}}
                    </td> -->
                  </tr>
                 @endforeach
                  
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
             

              <div class="info-box-content">
                <span class="info-box-text">Nouveaux</span>
                <span class="info-box-number">
                  {{$clients->whereBetween("created_at", [date("Y-m-d",strtotime("first day of this month")), today()])->count()}}
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
             
              <div class="info-box-content">
                <span class="info-box-text">Actifs</span>
                <span class="info-box-number">{{$actifs3->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              
              <div class="info-box-content">
               <span class="info-box-text">Inactifs</span>
                <span class="info-box-number">{{$inactifs3->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         
          <!-- /.col -->
        </div>

       

            <!-- /.card -->
          </div>


      
          <div class="col-md-3">
           
            <div class="card card-secondary" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;">
              <div class="card-header border-0">
                <h3 class="card-title">Chiffre d'affaire par client </h3>

                <div class="card-tools">
               
                 <!--  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->
                  <button data-toggle="modal" data-target="#dateModal" class="btn btn-light btn-sm">{{$day}}</button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Client</th>
                    <th>Qté</th>
                    <th>CA</th>
                    <!-- <th>Mns/livré</th> -->
                    
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($command_by_clients_delivered as $byp)
                  <tr>
                    

                    <td>
                     <!--  <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        12%
                      </small> -->
                     {{$byp->client->nom}}
                    </td>
                    <td>
                      {{$byp->qty}}
                    </td>
                    <td>
                      {{$byp->montant}}
                    </td>
                    <!--  <td>
                      {{round($int/$byp->qty)}}
                    </td> -->
                  </tr>
                 @endforeach
                  
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              

              <div class="info-box-content">
                <span class="info-box-text">Nouveaux</span>
                <span class="info-box-number">
                  {{$clients->whereBetween("created_at", [$start, $end])->count()}}
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
             

              <div class="info-box-content">
                <span class="info-box-text">Actifs</span>
                <span class="info-box-number">{{$actifs->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
            

              <div class="info-box-content">
               <span class="info-box-text">Inactifs</span>
                <span class="info-box-number">{{$inactifs->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         
          <!-- /.col -->
        </div>


     
            <!-- /.card -->
          </div>

         




          
          <!-- /.col (RIGHT) -->
        </div>
        </div>







          <div class="mb-2">
        <h1>Livreurs</h1>
           <div class="row">
            <div class="col">
           <div class="card card-secondary" >
              
              <div class="card-body">

                <div class="row ">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Nombre de livreurs</span>
                <span class="info-box-number">
                  {{$all_livreurs->count()}}
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box ">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Livreurs Actifs</span>
                <span class="info-box-number">{{$all_actifsl}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box ">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-down"></i></span>

              <div class="info-box-content">
               <span class="info-box-text">Livreurs Inactifs</span>
                <span class="info-box-number">{{$all_inactifsl}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         
          <!-- /.col -->
        </div>
                 
                <!-- <div class="chart">
                  <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div> -->
              </div>


                 </div>
                 </div>
              <!-- /.card-body -->
            </div>

       
        <div class="row">


        <div class="col-md-3">
            
            <div class="card card-secondary" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;">
              <div class="card-header border-0">
                <h3 class="card-title">Chiffre d'affaire par livreur  </h3>
                <div class="card-tools">
               
                 <!--  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->

                  <button @click="getDateName('1')" data-toggle="modal" data-target="#dateModal" class="btn btn-light btn-sm">{{$day1}}</button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Livreur</th>
                    <th>Qté</th>
                    <th>CA</th>
                    <th>TMPL</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($command_by_livreurs_delivered1 as $byl1)
                  <tr>
                    

                    <td>
                     <!--  <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        12%
                      </small> -->
                     {{$byl1->livreur->nom}}
                    </td>
                    <td>
                      {{$byl1->qty}}
                    </td>
                    <td>
                      {{$byl1->montant}}
                    </td>
                    <td>
                        @if($byl1->qty > 0)
                     {{floor(($int1/$byl1->qty) / 60)}} h:
                        {{($int1/$byl1->qty) % 60}} mns
                        @endif
                    </td>
                  </tr>
                 @endforeach
                  
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
             

              <div class="info-box-content">
                <span class="info-box-text">Nouveaux</span>
                <span class="info-box-number">
                  {{$all_livreurs->where("created_at", today())->count()}}
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              

              <div class="info-box-content">
                <span class="info-box-text">Actifs</span>
                <span class="info-box-number">{{$actifsl1->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
             

              <div class="info-box-content">
               <span class="info-box-text">Inactifs</span>
                <span class="info-box-number">{{$inactifsl1->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         
          <!-- /.col -->
        </div>

            <!-- /.card -->

            
          </div>
         

         
         <div class="col-md-3">
           
            <div class="card card-secondary" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;">
              <div class="card-header border-0">
                <h3 class="card-title">Chiffre d'affaire par Livreur</h3>
                <div class="card-tools">
               
                 <!--  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->
                  <button @click="getDateName('2')" data-toggle="modal" data-target="#dateModal" class="btn btn-light btn-sm">{{$day2}}</button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Client</th>
                    <th>Qté</th>
                    <th>CA</th>
                    <th>TMPL</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($command_by_livreurs_delivered2 as $byl2)
                  <tr>
                    

                    <td>
                     <!--  <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        12%
                      </small> -->
                     {{$byl2->livreur->nom}}
                    </td>
                    <td>
                      {{$byl2->qty}}
                    </td>
                    <td>
                      {{$byl2->montant}}
                    </td>

                     <td>
                      @if($byl2->qty > 0)
                     {{floor(($int2/$byl2->qty) / 60)}} h:
                        {{($int2/$byl2->qty) % 60}} mns
                        @endif
                    </td>
                  </tr>
                 @endforeach
                  
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
             
              <div class="info-box-content">
                <span class="info-box-text">Nouveaux</span>
                <span class="info-box-number">
                  {{$clients->whereBetween("created_at", [date("Y-m-d",strtotime("first day of this week")), today()])->count()}}
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              

              <div class="info-box-content">
                <span class="info-box-text">Actifs</span>
                <span class="info-box-number">{{$actifsl2->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
             

              <div class="info-box-content">
               <span class="info-box-text">Inactifs</span>
                <span class="info-box-number">{{$inactifsl2->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         
          <!-- /.col -->
        </div>

       

            <!-- /.card -->
          </div>






          <div class="col-md-3">
           
            <div class="card card-secondary" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;">
              <div class="card-header border-0">
                <h3 class="card-title">Chiffre d'affaire par livreur</h3>
                <div class="card-tools">
               
                 <!--  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->
                  <button @click="getDateName('3')" data-toggle="modal" data-target="#dateModal" class="btn btn-light btn-sm">{{$day3}}</button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Livreur</th>
                    <th>Qté</th>
                    <th>CA</th>
                    <th>TMPL</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($command_by_livreurs_delivered3 as $byl3)
                  <tr>
                    

                    <td>
                     <!--  <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        12%
                      </small> -->
                     {{$byl3->livreur->nom}}
                    </td>
                    <td>
                      {{$byl3->qty}}
                    </td>
                    <td>
                      {{$byl3->montant}}
                    </td>

                    <td>
                         @if($byl3->qty > 0)
                     {{floor(($int3/$byl3->qty) / 60)}} h:
                        {{($int3/$byl3->qty) % 60}} mns
                        @endif
                    </td>
                  </tr>
                 @endforeach
                  
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
             

              <div class="info-box-content">
                <span class="info-box-text">Nouveaux</span>
                <span class="info-box-number">
                  {{$all_livreurs->whereBetween("created_at", [$start3, $end3])->count()}}
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
             
              <div class="info-box-content">
                <span class="info-box-text">Actifs</span>
                <span class="info-box-number">{{$actifsl3->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              
              <div class="info-box-content">
               <span class="info-box-text">Inactifs</span>
                <span class="info-box-number">{{$inactifsl3->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         
          <!-- /.col -->
        </div>

       

            <!-- /.card -->
          </div>


      
          <div class="col-md-3">
           
            <div class="card card-secondary" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;">
              <div class="card-header border-0">
                <h3 class="card-title">Chiffre d'affaire par livreur </h3>

                <div class="card-tools">
               
                 <!--  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->
                  <button data-toggle="modal" data-target="#dateModal" class="btn btn-light btn-sm">{{$day}}</button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Client</th>
                    <th>Qté</th>
                    <th>CA</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($command_by_livreurs_delivered as $byl)
                  <tr>
                    

                    <td>
                     <!--  <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        12%
                      </small> -->
                     {{$byl->livreur->nom}}
                    </td>
                    <td>
                      {{$byl->qty}}
                    </td>
                    <td>
                      {{$byl->montant}}
                    </td>
                  </tr>
                 @endforeach
                  
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              

              <div class="info-box-content">
                <span class="info-box-text">Nouveaux</span>
                <span class="info-box-number">
                  {{$clients->whereBetween("created_at", [$start, $end])->count()}}
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
             

              <div class="info-box-content">
                <span class="info-box-text">Actifs</span>
                <span class="info-box-number">{{$actifs->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
            

              <div class="info-box-content">
               <span class="info-box-text">Inactifs</span>
                <span class="info-box-number">{{$inactifs->sum('qty')}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         
          <!-- /.col -->
        </div>


      

            <!-- /.card -->
          </div>

         




          
          <!-- /.col (RIGHT) -->
        </div>
        </div>

        <!-- /.row -->
        <div class="row">
          <div class="col-md-12">
           
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Graphique mensuel</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart4" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
             
            </div>
         

          </div>
        </div>


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
    <!-- Add Content Here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
   const app = Vue.createApp({
    data() {
        return {
           
            costumStart:"",
            intStart:null,
            dateName: "",
            notes: null,
            day : "",
            title: "",



        }
    },
    methods:{ 
    
    getDateName(name){
      this.dateName = name
    },


    getCancelReasons(start, end, day){

       vm = this
       this.day = day
       this.title = "Detail Courses annulées"

        axios.post('/getcancelreasons', {
            start:start,
            end:end,
             _token: CSRF_TOKEN
            
  })

         
  .then(function (response) {
    
        vm.notes = response.data.notes 
      
  
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
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../../plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  $(function () {
 

    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------
 
    // Get context with jQuery - using jQuery's .get() method.
    // var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    // var areaChartData = {
    //   labels  : [@foreach($clientsData as $cData)'{{$cData}}',@endforeach],
    //   datasets: [
    //     {
    //       label               : 'Ventes',
    //       backgroundColor     : 'rgba(60,141,188,0.9)',
    //       borderColor         : 'rgba(60,141,188,0.8)',
    //       pointRadius          : false,
    //       pointColor          : '#3b8bba',
    //       pointStrokeColor    : 'rgba(60,141,188,1)',
    //       pointHighlightFill  : '#fff',
    //       pointHighlightStroke: 'rgba(60,141,188,1)',
    //       data                : [@foreach($montantData as $mData){{$mData}},@endforeach]
    //     }
    //   ]
    // }

    // var areaChartOptions = {
    //   maintainAspectRatio : false,
    //   responsive : true,
    //   legend: {
    //     display: false
    //   },
    //   scales: {
    //     xAxes: [{
    //       gridLines : {
    //         display : false,
    //       }
    //     }],
    //     yAxes: [{
    //       gridLines : {
    //         display : false,
    //       }
    //     }]
    //   }
    // }

    // This will get the first returned node in the jQuery collection.
    // new Chart(areaChartCanvas, {
    //   type: 'bar',
    //   data: areaChartData,
    //   options: areaChartOptions
    // })



    

    // var areaChartCanvas6 = $('#areaChart6').get(0).getContext('2d')

    // var areaChartData6 = {
    //   labels  : [@foreach($livreursData as $lData)'{{$lData}}',@endforeach],
    //   datasets: [
    //     {
    //       label               : 'Courses',
    //       backgroundColor     : 'rgba(60,141,188,0.9)',
    //       borderColor         : 'rgba(60,141,188,0.8)',
    //       pointRadius          : false,
    //       pointColor          : '#3b8bba',
    //       pointStrokeColor    : 'rgba(60,141,188,1)',
    //       pointHighlightFill  : '#fff',
    //       pointHighlightStroke: 'rgba(60,141,188,1)',
    //       data                : [@foreach($montant6Data as $m6Data){{$m6Data}},@endforeach]
    //     }
    //   ]
    // }

    // var areaChartOptions6 = {
    //   maintainAspectRatio : false,
    //   responsive : true,
    //   legend: {
    //     display: false
    //   },
    //   scales: {
    //     xAxes: [{
    //       gridLines : {
    //         display : false,
    //       }
    //     }],
    //     yAxes: [{
    //       gridLines : {
    //         display : false,
    //       }
    //     }]
    //   }
    // }

    // This will get the first returned node in the jQuery collection.
    // new Chart(areaChartCanvas6, {
    //   type: 'bar',
    //   data: areaChartData6,
    //   options: areaChartOptions6
    // })





    //  var areaChartCanvas3 = $('#areaChart3').get(0).getContext('2d')

    // var areaChartData3 = {
    //   labels  : [@foreach($feesData as $fData)'{{$fData}}',@endforeach],
    //   datasets: [
    //     {
    //       label               : 'Ventes',
    //       backgroundColor     : 'rgba(60,141,188,0.9)',
    //       borderColor         : 'rgba(60,141,188,0.8)',
    //       pointRadius          : false,
    //       pointColor          : '#3b8bba',
    //       pointStrokeColor    : 'rgba(60,141,188,1)',
    //       pointHighlightFill  : '#fff',
    //       pointHighlightStroke: 'rgba(60,141,188,1)',
    //       data                : [@foreach($montant3Data as $m3Data){{$m3Data}},@endforeach]
    //     }
    //   ]
    // }

    // var areaChartOptions3 = {
    //   maintainAspectRatio : false,
    //   responsive : true,
    //   legend: {
    //     display: false
    //   },
    //   scales: {
    //     xAxes: [{
    //       gridLines : {
    //         display : false,
    //       }
    //     }],
    //     yAxes: [{
    //       gridLines : {
    //         display : false,
    //       }
    //     }]
    //   }
    // }

    // This will get the first returned node in the jQuery collection.
    // new Chart(areaChartCanvas3, {
    //   type: 'bar',
    //   data: areaChartData3,
    //   options: areaChartOptions3
    // })



    var areaChartCanvas4 = $('#areaChart4').get(0).getContext('2d')

    var areaChartData4 = {
      labels  : ['Janvier' , 'Fevrier' ,'Mars' ,'Avril' ,'Mai' ,'Juin' ,'Juillet' ,'Aout' ,'Septembre' ,'Octobre' ,'Novemvre' ,'Decembre'],
      datasets: [
        {
          label               : '{{$currentY}}',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [{{$januarycmds}},{{$februarycmds}},{{$marchcmds}},{{$aprilcmds}},{{$maycmds}},{{$juncmds}},{{$julycmds}},{{$augustcmds}},{{$septembercmds}},{{$octobercmds}},{{$novembercmds}},{{$decembercmds}},]
        },

        {
          label               : '{{$previousY}}',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [{{$pjanuarycmds}},{{$pfebruarycmds}},{{$pmarchcmds}},{{$paprilcmds}},{{$pmaycmds}},{{$pjuncmds}},{{$pjulycmds}},{{$paugustcmds}},{{$pseptembercmds}},{{$poctobercmds}},{{$pnovembercmds}},{{$pdecembercmds}},]
        },
      ]
    }

    var areaChartOptions4 = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas4, {
      type: 'bar',
      data: areaChartData4,
      options: areaChartOptions4
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Chrome',
          'IE',
          'FireFox',
          'Safari',
          'Opera',
          'Navigator',
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>
</body>
</html>

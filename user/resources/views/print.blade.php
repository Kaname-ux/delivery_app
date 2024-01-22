<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Commande - {{$day}}</title>
    <link rel="stylesheet" href="../assets/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <meta name="viewport"
        content="width=device-width,  viewport-fit=cover" />
    <meta name="description" content=" Système de gestion pour vendeur en ligne">
    <meta name="keywords" content="venl.n ligne, livraison, livreur" />
    <link rel="apple-touch-icon" size="180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href=".../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../img/favicon.png">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-print-css/css/bootstrap-print.min.css" media="print">

    
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }


 
@media print {
 
  .noprint{
    display: none;
  }
}
 
</style>
 <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

</head>

<body>
 
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule mt-0">
       <div class="section-full">
             
             @if(request()->has("print"))
             <div class="section-title ">{{$day}}</div>
            <table id="myTable" class="table table-striped" >
                    <thead class=" text-primary">
                     
                      <th>Etat</th>
                      
                      <th> Numero</th>
                      <th> Description</th>
                      <th>
                        adresse
                      </th>
                      <th>
                        Contact  
                      </th>
                        
                      <th>
                        Date de livraison
                      </th>

                      <th>
                        Montant
                      </th>

                      <th>
                        livraison
                      </th>

                      <th>
                        Total
                      </th>
                       
                      <th>
                        Livreur
                      </th>
                      <th>
                        Derniere note
                      </th>
                    </thead>
                    <tbody>
                      @foreach($commands as $command)

                    
                      <tr>
                        
                        <td>
                             <span 

                        
                          @if($command->etat == 'encours') 
                          class="badge badge-danger"
                          @endif

                          @if($command->etat == 'en attente') 
                          class="badge badge-warning"
                          @endif

                          @if($command->etat == 'recupere')
                          class="badge badge-warning"
                          @endif

                          @if($command->etat == 'en chemin')
                          class="badge badge-warning"
                          @endif


                          @if($command->etat == 'termine')
                          class="badge badge-success"
                          @endif
                          >{{$command->etat}}</span>

                          @if($command->ready == 'yes') 
                          <img width="30" height="30" src="/assets/img/packing.ico">
                          @endif 
                           @if($command->loc == 'retour')
                        <strong style="color: red">Retour en attente</strong>
                        @endif
                        </td>

                        <td>
                           {{$command->id}}
                        </td>
                        

                        <td>
                            <span class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                        Via: {{$command->canal}}
                        </span><br>
                           {{$command->description}}
                      
                        </td>


                        <td>
                        
                          <strong>

                          <span class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                        Client: {{$command->nom_client}}
                        </span><br>
                          {{$command->adresse}}<br>
                          @if($command->observation)
                          Info: {{$command->observation}}
                          @endif 
                           </strong>
                          
                           
                        </td>
                        <td>
                           {{$command->phone}} 
                        </td>
                       

                        <td>
                          {{$command->delivery_date->format('d/m/Y')}}
                        </td>
                        <td >
                          {{$command->montant}}
                        </td>
                        <td>
                         
                          {{$command->livraison}}
                         
                        </td>

                        <td>
                         
                          {{$command->livraison + $command->montant}}
                          
                        </td>
                        
                        
                        <td >
                          @if($command->livreur_id != 11)
                          {{$command->livreur->nom}}
                          @else
                          Non assigne
                          @endif
                        </td>

                        <td>
                          @if($command->note->count() > 0)
                          {{$command->note->last()->description}} - {{$command->note->last()->updated_at->format('d/m/Y')}}
                          @else
                          @endif 
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
            <tr>
                <th colspan="4" style="text-align:right"></th>
                <th></th>
                 <th></th>
                 <th></th>

            </tr>


        </tfoot>
                  </table>
                  @else
                  
                   <div class="container mb" >
                    <div class="row d-print-none">
                    <div class="col"> <a class="btn" href="javascript:window.print();">Imprimer</a></div>
                  <div class="form-group searchbox col ">
                <!-- <input onkeyup="search()" id="Search" type="text" class="form-control">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i> -->
            </div>

            </div>
                     <div class="row target" >
                       @foreach($commands as $x=>$command)
                   
                       <div class="col-3 border position-relative"  style="height: 13cm">
                        
                                <span 

                          @if($command->etat == 'encours') 
                          class="badge badge-danger"
                          @endif

                          @if($command->etat == 'en attente') 
                          class="badge badge-warning"
                          @endif

                          @if($command->etat == 'recupere')
                          class="badge badge-warning"
                          @endif

                          @if($command->etat == 'en chemin')
                          class="badge badge-warning"
                          @endif


                          @if($command->etat == 'termine')
                          class="badge badge-success"
                          @endif
                          >{{$command->etat}}
                      </span> 
                          <strong>{{$command->id}}</strong> <br>
                          Date de livraison:  {{$command->delivery_date->format('d/m/Y')}}<br>
                          prix: {{$command->montant-$command->remise}}. Livraison: {{$command->livraison}}<br>
                         
                          <strong>Total: {{$command->livraison + $command->montant}}</strong><br>
                            
                           Colis:  {{$command->description}}<br><br>

                        <span>

                          Expéditeur: 
                          @if($command->client ) 
                           {{$command->client->nom}} <br><br>
                          @endif 
                          Destinataire:<br>
                           <strong>{{$command->phone}}</strong><br>
                           @if($command->nom_client)
                          <span class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                         {{$command->nom_client}}
                        </span><br>
                        @endif
                          {{$command->adresse}}<br>
                          @if($command->observation)
                          Info: {{$command->observation}}<br>
                          @endif 
                           </span> 
                           <ion-icon class="" name="bicycle-outline"></ion-icon> 
                            @if($command->livreur_id != 11)
                          {{$command->livreur->nom}}
                          @else
                          Non assigne
                          @endif <br>
                           
                          
                        <div class="position-absolute bottom-0 end-0"><img width="64" height="64"  src="assets/img/logo.png"></div>
                          
                   </div>
                      @endforeach
                       
                      </div>
                      </div>
                  @endif
            
        </div>
        </div>
       

    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    
    @include("includes.sidebar")
    <!-- * App Bottom Menu -->


    <!-- ========= JS Files =========  -->
    <!-- Bootstrap -->
     <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
     <script src="../assets/manifest/js/app.js"></script>
    <!-- Bootstrap-->
    <script src="../assets/js/lib/popper.min.js"></script>
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <!-- Ionicons -->
   
    <!-- Owl Carousel -->
    <script src="../assets/js/owl.carousel.min.js"></script>
    <!-- Base Js File -->
    <script src="../assets/js/base.js"></script>
   
 
 
 <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 
 
 <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>







     
    <!-- Google map -->
   
 

  
  
  <script type="text/javascript">
     
$('#myTable').DataTable(  {

        select: true,
        dom: 'Bfrtip',
         buttons: [
        {
            extend: 'print',
            text: 'Imprimer'
        },
        'excel',
        
    ]
        
    });


function search() {
    
    var input = document.getElementById("Search");
    var filter = input.value.toLowerCase();
    var nodes = document.getElementsByClassName('target');
    for (i = 0; i < nodes.length; i++) {
      if (nodes[i].innerText.toLowerCase().includes(filter)) {
        nodes[i].style.display = "block";
      } else {
        nodes[i].style.display = "none";
      }
    }

    
  }
 </script>

</body>

</html>  
@extends("layouts.master")

@section("title")
Rapport
@endsection




@section("content")
<style type="text/css">
  
  th { white-space: nowrap; }
</style>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 <script src="https://unpkg.com/vue@3"></script> 

<div class="content">

        <?php $clientsData = array();
               $montantData =  array(); 
               
               $livreursData = array();
               $montant2Data =  array();


               $feesData = array();
               $montant3Data =  array();

               ?>
<div id="app">
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
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("first day of last month"))}}'   class="form-control " type="date" name="start">
                                         <input  hidden value='{{date("Y-m-d",strtotime("last day of last month"))}}'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-secondary btn-block "   >Le mois dernier</button>

                                        </div>
                                         </form>

                                         <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("first day of this month"))}}'   class="form-control " type="date" name="start">
                                         <input  hidden value='{{date("Y-m-d",strtotime("last day of this month"))}}'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-secondary btn-block "   >Ce mois</button>

                                        </div>
                                         </form>
                                        
                                        <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("first day of january this year"))}}'   class="form-control " type="date" name="start">
                                         <input  hidden value='{{date("Y-m-d",strtotime("last day of december this year"))}}'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-secondary btn-block "   >Cette annee</button>

                                        </div>
                                         </form>

                                         <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("first day of january last year"))}}'   class="form-control " type="date" name="start">
                                         <input  hidden value='{{date("Y-m-d",strtotime("last day of december last year"))}}'   class="form-control " type="date" name="end">
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
                                         <input v-model="costumStart" value=""  class="form-control"type="date" name="start">
                                         
                                         </div>
                                         <div class="col">
                                            <button class="btn btn-primary btn-sm">Valider</button> 
                                         </div>
                                         
                                         <input hidden id="costumEnd" :value="costumStart"  class="form-control" 
                                          
                                         type="date" name="end">

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
                                        
                                         type="date" name="start">
                                          </div>
                                          <div class="col">
                                         <input :disabled="!intStart" :min="intStart"  class="form-control" 
                                          
                                         type="date" name="end">
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

        <div class="row">
          <div class="col-md-12">
            <div class="card">
             
                
                <!-- <a target="top" href="https://maps.app.goo.gl/NtXUbskFr6R9F1t37">Sur sur google map</a> -->
                
                
            
               <div >
                 
                 <button data-toggle="modal" data-target="#dateModal" class="btn btn-outline-primary btn-sm">{{$day}}</button>
               </div>



            
                   

                
              

              
                
          
                
               
                 

                       
   
                   <div>
                     <meta name="csrf-token" content="{{ csrf_token() }}" />

                       <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Bilan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Par utilisateur</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Par adresse</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="livreur-tab" data-toggle="tab" href="#livreur" role="tab" aria-controls="livreur" aria-selected="false">Par livreur</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">

  <!--Livrison -->
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          
<div class="row">
  <div class="col-sm-6 ">
    <div class="card  ">
          <div class="card-body">
         <div class="card-title"><h3>Bilan</h3></div>
          <h6>Chiffre d'affaire: <strong class="float-right">{{ number_format($commands->sum("montant"),0,',',' ')}}</strong></h6>
          <h6>Charges <strong class="float-right">{{number_format($charges,0,',',' ')}}</strong></h6><br>
          <h6>Resultat <strong class="float-right">{{ number_format(($commands->sum("montant")-$charges),0,',',' ')}}</strong></h6>
         </div>
         <!-- <div class="card-footer">
           <h6>Moyenne <strong class="float-right"></strong></h6>
         </div> -->
              </div>
         </div>

         <div class="col-sm-6 ">
    <div class="card  ">
          <div class="card-body">
         <div class="card-title"><h3></h3></div>
         <div id="chart5">
         </div>
          
         </div>
         
              </div>
         </div>
             
             </div>

             <div class="row">
                <div class="card">
                    <div class="card-header">
                        Graphique mensuel {{date("Y")}}
                    </div>

                    <div class="card-body">
                            <div id="chart4">
                            </div>
                        </div>
                        
                    
                </div>
             </div>
         
               
                  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <div class="row">
     <div class="col ">
    <div class="card  ">
          <div class="card-body">
         <div class="card-title"><h3>Par utilisateur</h3></div>
         @foreach($command_by_clients as $command)
         @foreach($clients as $client)
         @if($client->id == $command->Client_id)
         <?php $clientsData[] = $client->nom;
               $montantData[] =  $command->montant; ?>
          <h6>{{$client->nom}} <strong class="float-right">{{number_format($command->montant,0,',',' ')}}</strong></h6>
          @endif
           @endforeach
          @endforeach
          
         </div>
         
              </div>
         </div>

         <div class="col">

            <div id="chart">
                
            </div>
         </div> 

       </div>  
  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    
<div class="row">
<div class="col ">
    <div class="card  ">
          <div class="card-body">
         <div class="card-title"><h3>Par commune</h3></div>
         @foreach($command_by_fees as $command_by_fee)
         @foreach($all_fees as $one_fee)
         @if($one_fee->id == $command_by_fee->fee_id)

         <?php $feesData[] = $one_fee->destination;
               $montant3Data[] =  $command_by_fee->montant; ?>
          <h6>{{$one_fee->destination}} <strong class="float-right">{{$command_by_fee->montant}}</strong></h6>
          @endif
           @endforeach
          @endforeach
          
         </div>
         
              </div>
         </div> 
     </div>
     <div class="col">
        <div id="chart3">
            
        </div>
         
     </div>
  </div>


  <div class="tab-pane fade" id="livreur" role="tabpanel" aria-labelledby="livreur-tab">
    
<div class="row">
<div class="col ">
    <div class="card  ">
          <div class="card-body">
         <div class="card-title"><h3>Par livreur </h3></div>
         @foreach($command_by_livreurs as $command_by_livreur)
         @foreach($all_livreurs as $one_livreur)
         @if($one_livreur->id == $command_by_livreur->livreur_id)


           <?php $livreursData[] = $one_livreur->nom;
               $montant2Data[] = $command_by_livreur->montant; ?>

          <h6>{{$one_livreur->nom}} <strong class="float-right">{{$command_by_livreur->montant}}</strong></h6>
          @endif
           @endforeach
          @endforeach
          
         </div>
         
              </div>
         </div> 


         <div class="col">

            <div id="chart2">
                
            </div>
         </div> 

       </div>  
  </div>

  
  </div>
</div>
                  
             
           
          </div>
         <!-- Modal -->

          

        </div>
 </div> </div>
</div> 

<script>
   const app = Vue.createApp({
    data() {
        return {
           
            costumStart:"",
            intStart:null

        }
    },
    methods:{ 


  


   },
   computed:{
     
}
});

  const mountedApp = app.mount('#app')     
  </script>
@endsection

@section("script")
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript">


    var options = {
  chart: {
    type: 'bar'
  },
  series: [{
    name: 'ventes',
    data: [@foreach($montantData as $mData){{$mData}},@endforeach]
  }],
  xaxis: {
    categories: [@foreach($clientsData as $cData)'{{$cData}}',@endforeach] 
  }
}

var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();



 var options5 = {
  chart: {
    type: 'bar'
  },
  series: [{
    name: 'Montant',
    data: [{{$commands->sum("montant")}},{{$charges}}]
  }],
  xaxis: {
    categories: ["Chiffre d'affaire","Charges"] 
  },

  fill: {
  colors: ['#3FB827', '#D91D10']
}
}

var chart5 = new ApexCharts(document.querySelector("#chart5"), options5);

chart5.render();




var options2 = {
  chart: {
    type: 'bar'
  },
  series: [{
    name: 'ventes',
    data: [@foreach($montant2Data as $m2Data){{$m2Data}},@endforeach]
  }],
  xaxis: {
    categories: [@foreach($livreursData as $lData)'{{$lData}}',@endforeach] 
  }
}

var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);

chart2.render();



var options3 = {
  chart: {
    type: 'bar'
  },
  series: [{
    name: 'ventes',
    data: [@foreach($montant3Data as $m3Data){{$m3Data}},@endforeach]
  }],
  xaxis: {
    categories: [@foreach($feesData as $fData)'{{$fData}}',@endforeach] 
  }
}

var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);

chart3.render();





var options4 = {
  chart: {
    type: 'line'
  },
  series: [{
    name: 'ventes',
    data: [{{$januarycmds}},{{$februarycmds}},{{$marchcmds}},{{$aprilcmds}},{{$maycmds}},{{$juncmds}},{{$julycmds}},{{$augustcmds}},{{$septembercmds}},{{$octobercmds}},{{$novembercmds}},{{$decembercmds}},]
  }],
  xaxis: {
    categories: ['Janvier' , 'Fevrier' ,'Mars' ,'Avril' ,'Mai' ,'Juin' ,'Juillet' ,'Aout' ,'Septembre' ,'Octobre' ,'Novemvre' ,'Decembre'] 
  }
}

var chart4 = new ApexCharts(document.querySelector("#chart4"), options4);

chart4.render();
  $(document).ready(function() {



    // $('#myTable').DataTable(  {

     


        
    // }  );



 $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);  
         } else {  
            $(".sub_chk").prop('checked',false);  
         }  
        });


        $('.delete_all').on('click', function(e) {


            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  


            if(allVals.length <=0)  
            {  
                alert("Veuillez seletionner commande.");  
            }  else {  


                var check = confirm("Confirmer?");  
                if(check == true){  


                    var join_selected_values = allVals.join(","); 


                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['status']) {
                                $(".sub_chk:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                                alert(data['status']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                  
                }  
            }  
        });


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });


        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });


            return false;
        });
} );


setTimeout(function(){
       location.reload();
   },2000000);

</script>

@endsection










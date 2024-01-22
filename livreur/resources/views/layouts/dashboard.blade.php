@extends("layouts.master")

@section("title")
dvl system
@endsection




@section("content")
<style type="text/css">
  
  th { white-space: nowrap; }
</style>



<div class="content">



        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <h6 class="card-title">Liste de livraison: {{Auth::user()->name}}</h6>
               
              </div>

                
              
              <div class="card-body">
                <div class="table-responsive">
                



                          <div class="container box">
   
                   <div>
                    
                  
             @if($commands->count()>0)     
             
           <button  class="btn btn-danger btn-sm delete_all" data-url="{{ url('bulk-recup') }}">J'ai recupéré les selectionnés</button>
           <meta name="csrf-token" content="{{ csrf_token() }}" />
               <p>Vous avez {{$commands->count()}} Commande à livrer aujourd'hui.</p>
                  <table id="myTable" class="table">
                    <thead class=" text-primary">
                      <th><input type="checkbox" id="master"></th>
                      <th>
                       
                      
                        Action
                      </th>
                      <th>
                       Commande
                      </th>

                      
                    </thead>
                    <tbody>
                      
                      @foreach($commands as $command)

                      <tr id="tr_{{$command->id}}">
                        <td>
                        
                         <input  data-id="{{$command->id}}" type="checkbox" class="sub_chk">
                         
                        </td>
                        <td>
                          
                          
                          @if($command->etat == 'encours')

                         
                          


                          <form method="POST" action='command-update/{{$command->id}}'>
                            @csrf
                            <button value="recupere" name="etat" type="submit" class="btn btn-danger" type="">Recuperer</button>
                            
                          </form>

                          @endif

                          @if($command->etat == 'recupere')
                          <form  method="POST" action='command-update/{{$command->id}}'>
                            @csrf
                            <button value="en chemin" name="etat" type="submit" class="btn btn-warning" type="">Depart</button>
                            
                          </form>

                            <p></p>
                          
                            <button class="btn btn-default" data-toggle="modal" data-target="#myModal{{$command->id}}" type="button">Relayer</button>
                            
                          

                          @endif

                          @if($command->etat == 'en chemin')
                          <form method="POST" action='command-update/{{$command->id}}'>
                            @csrf
                            <button value="termine" name="etat" type="submit" class="btn btn-success" type="">Livrer</button>
                            
                          </form>

                          @endif
                      </td>
                        <td>

                         <p> 
                           <span 
                          @if($command->etat == 'encours') 
                          class="badge badge-danger"
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
                          >{{$command->etat}}</span><br>
                          <strong>
                            Livrer ici:
                          #{{$command->id}}
                          {{$command->adresse}}<br> 
                          {{$command->phone}}<br> {{$command->delivery_fee + $command->montant}}CFA
                           </strong>
                           </p>
                           Recuperer ici
                            @if($command->client)
                           
                           #{{$command->client->id}}
                          {{$command->client->nom}}<br>
                          {{$command->client->phone}}<br>
                          {{$command->client->adresse}}

                          @else
                          Client non defini: contacté Admin
                          @endif
                         
                        </td>
                        
                      </tr>


                      <div id="myModal{{$command->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Je remet le colis à</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="relay/{{$command->id}}">
          @csrf
          <div class="form-group">
          <select name="relais" required class="form-control">
            <option>Choisir un livreur</option>
          @foreach($livreurs as $livreur)
          <option value="{{$livreur->id}}">{{$livreur->nom}}</option>
          @endforeach
          </select>
          </div>
          <div class="form-group">
          <input placeholder="Lieu du relais" class="form-control" type="text" name="lieu">
        </div>

        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success" >Confirmer</button>
      </div>
      </form>
    </div>

  </div>
</div>
                      @endforeach

                    </tbody>
                   
                  </table>
                  @else
                      Vous n'avez aucune livraison aujourd'hui
                      @endif
                </div>
              </div>
            </div>
          </div>
         <!-- Modal -->

          

        </div>


@endsection

@section("script")
<script type="text/javascript">
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


</script>

@endsection










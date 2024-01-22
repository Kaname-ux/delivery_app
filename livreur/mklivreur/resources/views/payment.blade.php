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

                <h6 class="card-title">Liste de Payment: {{Auth::user()->name}}</h6>
               
              </div>

                
              
              <div class="card-body">
                <div class="table-responsive">
                



                          <div class="container box">
   
                   <div>
                    
                  
             @if($payments->count()>0)     
             
           
          
               <p>Il vous reste {{$payments->count('client_id')}} clients à payer.</p>
                  <table id="myTable" class="table">
                    <thead class=" text-primary">
                      <th><input type="checkbox" id="master"></th>
                      <th>
                       
                      
                        Action
                      </th>
                      <th>
                       Payment
                      </th>

                      
                    </thead>
                    <tbody>
                      
                      @foreach($payments as $payment)
                    
                      @foreach($clients as $client)
                      @if($client->id == $payment->client_id)
                      <tr id="tr_{{$payment->id}}">
                        
                        <td>
                        
                          
                           <button class="btn btn-default" data-toggle="modal" data-target="#myModal{{$payment->client_id}}" type="button">Payer</button>

                          
                      </td>
                        <td>

                        
                           
                           #{{$payment->client_id}}
                          {{$client->nom}}<br>
                          {{$client->phone}}<br>
                          {{$client->adresse}}<br>
                          <strong>{{$payment->montant}}</strong>
                         <!--  <a class="badge badge-success" href="#">Voir détail</a> -->





                          
                         
                        </td>
                        
                      </tr>


                      <div id="myModal{{$payment->client_id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Payment</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="pay-update/{{$payment->client_id}}">
          @csrf
          <div class="form-group">
          <select name="pay_methode" required class="form-control">
            <option value="">Choisir moyen de payement</option>
         
          
          <option value="Main a Main">Main à main</option>
          <option value="Mobile money">Mobile money</option>
          
          </select>

          <p>Pour les payement mobile money exiger un reçu.</p>
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
  @endif                    
                     
      @endforeach
                      

                      @endforeach

                    </tbody>
                   
                  </table>
                  @else
                      Vous n'avez aucun payement aujourd'hui
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
                alert("Veuillez seletionner un payment.");  
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










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

                <h6 class="card-title">Payments <a href="/payment-form" class="btn">Ajouter</a></h6>
               
              </div>

                
              
              <div class="card-body">
                <div class="table-responsive">
                 
                          



                          <div class="container box">
   
                   <div>
                   
                   <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirmer
            </div>
            <div class="modal-body">
                <h4>Voulez-vous vraiment supprimer Ce payment?</h4>

                

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <a href="#" id="submit" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
    </div>
</div>
                  

                  <table id="myTable" >
                    <thead class=" text-primary">
                      <th></th>
                      <th>
                        Client
                      </th>
                      <th>
                        Date
                      </th>
                      <th>
                        Montant
                      </th>

              
                      <th>
                        Effectué par
                      </th>
                      <th>
                        Assigné à
                      </th>
                     
                     
                      
                    </thead>
                    <tbody>
                      @foreach($payments as $payment)
                      <tr>
                        
                        <td>
                          <span 
                          @if($payment->etat == 'en attente') 
                          class="badge badge-warning"
                          @endif

                         


                          @if($payment->etat == 'termine')
                          class="badge badge-success"
                          @endif
                          >{{$payment->etat}}</span> <br>
                          <!-- <a href="/paymentedit/{{$payment->id}}" ><i class="fas fa-edit d-inline"></i></a>

                          <form class="d-inline" id="myForm"   method="POST" action="/payment-delete/{{$payment->id}}">
                            {{csrf_field()}}
                        {{method_field('DELETE')}}
                         <input onclick="myFunction{{$payment->id}}()" type="button" name="btn" value="Supprimer"  class="btn btn-danger" />
                       </form> -->
                          <script>
                   function myFunction{{$payment->id}}() {
                confirm("Confirmer!");
                            }


                     function myFunction2{{$payment->id}}() {
                confirm("Confirmer!");
                            }       
                    </script>
                    @if($payment->etat == 'en attente')
                     <a href="#" class="badge badge-primary"   onclick="myFunction2{{$payment->id}}()" href="/paymentdone/{{$payment->id}}" >Payer</a>

                     <a href="#" class="badge badge-primary"   data-toggle="modal" data-target="#myModal{{$payment->id}}" >Assigner</a>
                     

                    @endif
                        </td>
                        <td>
                           

                          @if($payment->client)
                          {{$payment->client->nom}}
                          @else
                          Client
                          @endif
                          

                        </td>
                        <td>@if($payment->etat == 'termine')
                          {{$payment->updated_at->format('d/m/Y')}}
                          @endif
                        </td>
                        <td>
                          {{$payment->montant}}
                        </td>
                        
                        <td>
                          
                           
                           @endif
                          @if($payment->livreur)
                          Assigné à: {{$payment->livreur->nom}}
                          @endif
                        </td>
                        <td>
                          @if($payment->user)
                          {{$payment->user->name}}
                        </td>

                        
                      </tr>
                      @endforeach
                    </tbody>
                   
                  </table>


                   <div id="myModal{{$payment->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">assigner payment</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="payment-assign/{{$payment->id}}">
          @csrf
          <div class="form-group">
          <select name="livreur_id" required class="form-control">
            <option>Choisir un livreur</option>
          @foreach($livreurs as $livreur)
          <option value="{{$livreur->id}}">{{$livreur->nom}}</option>
          @endforeach
          </select>
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
              </div>
            </div>
          </div>
         <!--  <div class="col-md-12">
            <div class="card card-plain">
              <div class="card-header">
                <h4 class="card-title"> Table on Plain Background</h4>
                <p class="category"> Here is a subtitle for this table</p>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Name
                      </th>
                      <th>
                        Country
                      </th>
                      <th>
                        City
                      </th>
                      <th class="text-right">
                        Salary
                      </th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          Dakota Rice
                        </td>
                        <td>
                          Niger
                        </td>
                        <td>
                          Oud-Turnhout
                        </td>
                        <td class="text-right">
                          $36,738
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Minerva Hooper
                        </td>
                        <td>
                          Curaçao
                        </td>
                        <td>
                          Sinaai-Waas
                        </td>
                        <td class="text-right">
                          $23,789
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Sage Rodriguez
                        </td>
                        <td>
                          Netherlands
                        </td>
                        <td>
                          Baileux
                        </td>
                        <td class="text-right">
                          $56,142
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Philip Chaney
                        </td>
                        <td>
                          Korea, South
                        </td>
                        <td>
                          Overland Park
                        </td>
                        <td class="text-right">
                          $38,735
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Doris Greene
                        </td>
                        <td>
                          Malawi
                        </td>
                        <td>
                          Feldkirchen in Kärnten
                        </td>
                        <td class="text-right">
                          $63,542
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Mason Porter
                        </td>
                        <td>
                          Chile
                        </td>
                        <td>
                          Gloucester
                        </td>
                        <td class="text-right">
                          $78,615
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Jon Porter
                        </td>
                        <td>
                          Portugal
                        </td>
                        <td>
                          Gloucester
                        </td>
                        <td class="text-right">
                          $98,615
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> -->
        </div>
@endsection

@section("script")
<script type="text/javascript">
  $(document).ready(function() {



    $('#myTable').DataTable({

          dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                text: 'Imprimer tout',
                
                exportOptions: {
                    modifier: {
                        selected: null
                    }


                }
            },
            {
                extend: 'print',
                text: 'Imprimer selection'
            }
        ],
        select: true
    }  );


$('#submitBtn').click(function() {
     /* when the button in the form, display the entered values in the modal */
     
});

$('#submit').click(function(){
     /* when the submit button in the modal is clicked, submit the form */
    
    $('#myForm').submit();
});
     
} );


</script>

@endsection
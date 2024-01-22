@extends("layouts.master")

@section("title")
dvl system
@endsection

@section("content")
<style type="text/css">
  
  th { white-space: nowrap; }


.dot {
  height: 10px;
  width: 10px;
  background-color: green;
  border-radius: 50%;
  display: inline-block;
}

</style>
<div class="content">
  <div class="modal fade dialogbox" id="stateModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"></h5>
                       

                    </div>
                    
                    <div class="modal-body" id="stateModalBody">
                        
                    </div>
                   
                </div>
            </div>
        </div>




        <div class="modal fade dialogbox" id="confirmModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title confirmModalTitle"></h5>
                       

                    </div>
                    
                    <div class="modal-body " >
                        <div class="confirmModalBody">
                          
                        </div>

                        <form method="POST" action="confirm">
                    @csrf
                    <div class="form-group">
                      <label class="form-label">Id utilisateur
                      </label>
                    <input required class="form-control" id="user_id" type="" name="user_id" readonly >
                     </div>
                    
                    <div class="form-group">
                      <label class="form-label">Formule</label>
                    <input required class="form-control" id="formula" type="" name="formula" readonly >
                     </div>

                     <div class="form-group">
                      <label class="form-label">Id demande</label>
                    <input id="in_id" required class="form-control" type="text" name="in_id" readonly >
                  </div>

                    <div class="form-group">
                      <select required class="form-control" name="pay_method">
                        <option>Methode de payment</option>
                        <option value="mm">
                          Mobile money
                        </option>

                        <option value="cash">
                          Main à main
                        </option>

                        <option value="bt">
                          Tranfert bancaire
                        </option>
                      </select>
                      
                    </div>
                    <div class="form-group">
                      <label class="form-label">Reférence de payement</label>
                      <input class="form-control" type="text" name="pay_ref">
                    </div>

                    <div class="form-group">
                      <label class="form-label">Date de payement</label>
                      <input class="form-control" type="date" name="pay_date">
                    </div>
                   <button class="btn btn-success confirm">Confirmer</button>
                   <button  class="btn btn-default" data-dismiss="modal">Annuler</button>
                   </form>
                    </div>
                  
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <h6 class="card-title">Demande de souscription<!-- <a href="/client-form" class="btn">Ajouter</a> --></h6>
               
              </div>

                
              
              <div class="card-body">
                <div class="table-responsive">
                 
                          



                          <div class="container box">
   
                   <div>
                   
                   <!-- <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirmer
            </div>
            <div class="modal-body">
                <h4>Voulez-vous vraiment supprimer Ce client?</h4>

                

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <a href="#" id="submit" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
    </div>
</div> -->
                  

                  <table id="myTable" >
                    <thead class=" text-primary">
                      <th>Id</th>
                      
                      <th>
                        Id client
                      </th>
                      <th>
                      	 Nom
                      </th>
                      <th>
                        contact
                      </th>
                      
                      <th>
                        Date 
                      </th>
                      <th>
                        Formula
                      </th>
                      <th>
                     Action
                      </th>
                     
                      
                    </thead>
                    <tbody>
                      @foreach($incommings as $incomming)
                      <tr>
                        
                        <td>
                           
                          {{$incomming->id}} 
                          

                        
                         
                        </td>
                        
                        <td>
                           {{$incomming->user_id}}</a>

                        </td>
                        <td>
                        	{{$incomming->nom}}
                        </td>
                        
                          
                        <td>
                          {{$incomming->phone}}
                        </td>
                        <td>
                          {{$incomming->created_at}}
                        </td>
                        
                        <td >
                          {{$incomming->formula}}
                        </td>
                        <td>
                         <button value="{{$incomming->user_id}}" 
                          data-inid="{{$incomming->id}}"
                          data-formula="{{$incomming->formula}}" data-name="{{$incomming->nom}}"
                       data-phone="{{$incomming->phone}}" class="btn btn-success validate">Valider</button>
                          
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

                  {{ $incommings->links() }}
                </div>
              </div>
            </div>
          </div>
        
        </div>
@endsection

@section("script")
<script type="text/javascript">
  $(document).ready(function() {



     $('#myTable').DataTable(  {

     


       
        "bSort" : false,
                
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                text: 'Imprimer tout',
                footer: true,
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




    $(".validate").click( function() {
   
   var formula = $(this).data("formula");
   var in_id = $(this).data("inid");
   var user_id = $(this).val();
   var phone = $(this).data("phone");
   var name = $(this).data("name");
   if(formula == "monthly"){var title = "Formule mensuelle";}
    if(formula == "yearly"){var title = "Formule annuelle";}
     
     $("#formula").val(formula);
     $("#user_id").val(user_id);
     $("#in_id").val(in_id)

    $(".confirmModalTitle").html(title);
    $(".confirmModalBody").html("Client:"+ name+"<br>"+"contact:"+phone)

    $("#confirmModal").modal("show");
    
   }); 



    $(".confirm").click( function() {
   
   var formula = $(this).data("formula");
   var client_id = $(this).val();
   if(formula == "monthly"){var title = "Formule mensuelle";}
    if(formula == "yearly"){var title = "Formule annuelle";}


     $.ajax({
       url: 'checksubscription',
       type: 'post',
       data: {_token: CSRF_TOKEN, formula: formula},
   
       success: function(response){
               $("#subscribeModal").modal("show");
               $(".message").html(response.message);
               $(".modal-title").html(title);
               $('#formula_btn').val(formula);
              },
   error: function(response){
               $("#stateModalBody").html("Une erruer s'est produite");
                $("#stateModal").modal('show');
               
              }
             
     });
   }); 
     
} );


</script>

@endsection
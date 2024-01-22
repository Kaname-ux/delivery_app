
@include ("qrcode.qrlib")
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
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <h6 class="card-title">Liste des clients <a href="/client-form" class="btn">Ajouter</a></h6>
               
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
                     
                      
                      <th>
                        Nom
                      </th>
                      <th>
                      	Total Achat
                      </th>
                      <th>
                        contact
                      </th>
                      <th>
                        Adresse
                      </th>
                      
                      
                      
                    </thead>
                    <tbody>
                      @foreach($clients as $client)
                      <tr>
                        
                        <td>
                         {{$client->nom_client}}
                         
                        </td>
                        
                        <td>
                          {{$client->montant}}

                        </td>
                        <td>
                        	{{$client->phone}}
                        </td>
                        <td>
                          {{$client->adresse}}
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

                  
                </div>
              </div>
            </div>
          </div>
         
            </div>
          </div> 
        </div>
        </div>
@endsection

@section("script")
<script type="text/javascript">
  $(document).ready(function() {



    



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
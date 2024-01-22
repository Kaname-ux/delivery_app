

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

                <h6 class="card-title">Liste des client {{$vendeurs->count()}} </h6>

                <form>
                  <select class="form-control" name="fee">
                    <option value="">Choisir commune</option>
                    @foreach($fees as $fee)
                     <option value="{{$fee->id}}">{{$fee->destination}}</option>
                    

                    @endforeach


                  </select>
                  <button class="btn btn-primary" type="submit">Valider</button>
                </form>
               
              </div>

                
              
              <div class="card-body">
                <div class="table-responsive">
                 
                          



                          <div class="container box">
   
                   <div>
                   
               
                  

                  <table id="myTable" >
                    <thead class=" text-primary">
                      <th>Id</th>
                      
                     
                      <th>
                        contact
                      </th>
                      <th>
                        Commune
                      </th>
                      <th>
                        Adresse
                      </th>
                     
                      
                    </thead>
                    <tbody>
                      @foreach($vendeurs as $vendeur)
                      <tr>
                        
                        <td>
                           
                          {{$vendeur->id}} 
                          <a href="/clientedit/{{$vendeur->id}}" ><i class="fas fa-edit"></i></a>

                        
                         
                        </td>
                        
                       
                       
                        <td>
                          {{$vendeur->phone}}
                        </td>
                        <td>
                          
                        </td>
                        <td>
                          {{$vendeur->adresse}}
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
@endsection

@section("script")
<script type="text/javascript">
  $(document).ready(function() {



     $('#myTable').DataTable(  {

     


       "bPaginate": false,
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
     
} );


</script>

@endsection
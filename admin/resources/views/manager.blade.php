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

                <h6 class="card-title">Liste des Manager <!-- <a href="/client-form" class="btn">Ajouter</a></h6> -->
               
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
                        Nom
                      </th>
                      <th>
                      	Total cmds
                      </th>
                      <th>
                        contact
                      </th>
                      <th>
                        Adresse
                      </th>
                      <th>
                        Date d'incription
                      </th>
                      <th>
                         Montant actif
                      </th>
                      <th>
                     whatsapp
                      </th>
                     
                      
                    </thead>
                    <tbody>
                      @foreach($managers as $manager)
                      <tr>
                        
                        <td>
                           
                          {{$manager->id}} 
                          
                         
                        </td>
                        
                        <td>
                          {{$manager->company}} - {{$manager->nom}}

                        </td>
                        <td>
                        	
                        </td>
                        <td>
                          {{$manager->phone}}
                        </td>
                        <td>
                          {{$manager->adresse}}
                        </td>
                        <td>
                          {{$manager->created_at}}
                        </td>
                        
                        <td >
                          
                        </td>
                        <td>
                          <a target="blank" class="text-success" href="https://wa.me/225{{$manager->phone}}?text=Bonjour {{$manager->nom}} de {{$manager->company}}. Je suis Mohamed Adamu, le concepteur de JibiaT-Manager Votre application pour manager de structure de livraison. Merci de votre inscription sur notre plateform. Avez-Vous des questions concernant l'utilisation de votre application?"><i class="fas fa-whatsapp" aria-hidden="true"></i>WhatsApp</a>
                        
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

                  {{ $managers->links() }}
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
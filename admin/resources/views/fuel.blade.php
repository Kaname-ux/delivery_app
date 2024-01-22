@extends("layouts.master")

@section("title")
Gestion carburant
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

                <h6 class="card-title">Gestion carburant  <td><a href="" class="btn btn-default  mb-2" data-toggle="modal" data-target="#add">Ajouter</a></td></h6>
               
              </div>
             


               <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Nouveau mouvement</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <form method="POST" action="/fuel-add">
            @csrf

            
          <select name="card_number" class="md-form mb-4" required>
            <option>Choisir numero de carte</option>
            @foreach($cards as $card)
            <option value="{{$card}}">{{$card}}</option>
            @endforeach
          </select>
          <label data-error="wrong" data-success="right" >Numero de carte</label>
        </div>

        <div class="md-form mb-4">
          <input class="form-control" type="date" name="fuel_date">
              
        </div>

         <div class="md-form mb-4">
          <input class="form-control" type="text" name="montant">
          <label data-error="wrong" data-success="right" >Montant</label>    
        </div>

        <div class="md-form mb-4">
          
          <select name="type" required>
            <option>Sens</option>
            
            <option value="entree">Entrée</option>
            <option value="sortie">Sortie</option>
            
          </select>
          <label data-error="wrong" data-success="right" for="defaultForm-pass">Sens du mouvement</label>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-default">Valider</button>
      </form>
      </div>
    </div>
  </div>
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
                <h4>Voulez-vous vraiment supprimer Ce moto?</h4>

                

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
                      <th></th>
                      <th>
                        Carte
                      </th>
                      <th>
                        Entrée
                      </th>
                      <th>
                       Sortie
                      </th>
                      <th>
                        Solde
                      </th>
                      <th>
                        Livreur
                      </th>
                      
                     
                      
                    </thead>
                    <tbody>
                      @foreach($fuels as $fuel)
                      <tr>
                        
                        <td>
                          <a href="/motoedit/{{$fuel->id}}" ><i class="fas fa-edit"></i></a>

                          <form  id="myForm"   method="POST" action="/moto-delete/{{$fuel->id}}">
                            {{csrf_field()}}
                        {{method_field('DELETE')}}
                        
                         <input onclick="myFunction{{$fuel->id}}()" type="button" name="btn" value="Supprimer"  class="btn btn-danger" />
                       </form>
                          <script>
                   function myFunction{{$fuel->id}}() {
                    confirm("Confirmer!");
                            }
                    </script>
                        </td>
                        <td>
                          {{$fuel->card_number}}
                        </td>
                        <td>
                        @foreach($total_entree as $entree)
                      @if($entree->card_number == $fuel->card_number)
                      {{$entree->montant}}
                      @endif
                          @endforeach
                         
                         
                        </td>
                        <td>
                          @foreach($total_sortie as $sortie)
                      @if($sortie->card_number == $fuel->card_number)
                      {{$sortie->montant}}
                      @endif
                          @endforeach
                        </td>
                        <td>
                          {{$fuel->montant}}
                        </td>
                        <td>
                          @foreach($livreurs as $livreur)
                          @if($livreur->card_number == $fuel->card_number)
                          {{$livreur->nom}}
                          @endif
                          @endforeach 
                        </td>

                        
                        
                       
                        
                      </tr>






                    
                      @endforeach
                    </tbody>
                   
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="col-md-12">
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


// $('#submitBtn').click(function() {
//      /* when the button in the form, display the entered values in the modal */
     
// });

// $('#submit').click(function(){
//      /* when the submit button in the modal is clicked, submit the form */
    
//     $('#myForm').submit();
// });
     
} );


</script>

@endsection
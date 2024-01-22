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

                <!-- <h6 class="card-title">Liste des livreurs <a href="/livreur-form" class="btn">Ajouter</a></h6> -->
               
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
                <h4>Voulez-vous vraiment supprimer Ce livreur?</h4>

                

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <a href="#" id="submit" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
    </div>
</div>




 <div class="modal fade" id="reliabilityModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Choisir
            </div>
            <div class="modal-body">
                <form method="POST" action="setreliability">
                  @csrf
                  <div class="form-group">
                  <select required class="form-control" name="note">
                    <option value="">Choisir la note</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                  </div>
                

                

            </div>
              <input id="livreur_id" type="text" name="id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button  type="submit" class="btn btn-success">Confirmer</button>
            </div>
            </form>
        </div>
    </div>
</div>





                  

                  <table id="myTable" >
                    <thead class=" text-primary">
                      <!-- <th></th> -->
                      <th>
                        Nom
                      </th>
                      <th>
                        contact
                      </th>
                      <th>
                        Adresse
                      </th>

                      <th>
                        Montant non regle
                      </th>

                      <th>
                        Date de création
                      </th>
                      
                      
                      <th>
                        Numero de piece
                      </th>
                      <th>Compte</th>
                     
                      <!-- <th>Reliability</th> -->
                    </thead>
                    <tbody>
                      @foreach($livreurs as $livreur)


                        <div class="modal fade" id="modalLoginForm{{$livreur->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
            <form method="POST" action="/set-livreur-account">
             @csrf
              <input hidden value="{{$livreur->id}}" type="text" name="livreur_id">
              <select name="user_id" class="form-control">
                @foreach($available_accounts as $account)
                <option value="{{$account->id}}">{{$account->name}}</option>
                @endforeach

            </select>
            <button type="submit" class="btn btn-default">Definir</button>
         </form>
             </div>
    </div>
  </div>
</div>







                      <tr>
                        
                        <!-- <td>
                          <a href="/livreuredit/{{$livreur->id}}" ><i class="fas fa-edit"></i></a>

                          <form  id="myForm"   method="POST" action="/livreur-delete/{{$livreur->id}}">
                            {{csrf_field()}}
                        {{method_field('DELETE')}}
                         <input onclick="myFunction{{$livreur->id}}()" type="button" name="btn" value="Supprimer" id="submitBtn"  class="btn btn-danger" />
                       </form>
                            <script>
                    function myFunction{{$livreur->id}}() {
                       confirm("Confirmer!");
                     }
                          </script>
                        </td> -->
                        <td>
                         
                           <form action="dashboard">
                              
                            <input hidden type="" value="{{$livreur->id}}" name="livreurs[]">
                            <button class="btn  btn-light" type="submit">@if($livreur->commands->where("delivery_date", today())->count()>0)
                          <span class="dot"></span>
                          @endif{{$livreur->nom}}</button>
                          </form>
                          <!-- <a class="badge badge-primary badge-sm" href="/livreur-stat/{{$livreur->id}}">Stats</a> -->
                          
                        </td>
                        <td>
                          {{$livreur->phone}}
                        </td>
                        <td>
                          {{$livreur->adresse}}
                        </td>

                        <td>
                          {{$livreur->payments->where("etat", "en attente")->sum('montant')}}
                        </td>
                        <td>
                          {{$livreur->created_at}}
                        </td>

                        
                        <td >
                          {{$livreur->pieces}}
                        </td>
                        
                        <td>
                          @if($livreur->user)
                          {{$livreur->user->email}}
                          <form method="POST" action="/unset-livreur-account/{{$livreur->user->id}}">
                            @csrf
                          <button   type="submit"   class="btn btn-succes btn-sm" >
                          </form>Dissocier</button>
                          @else

                           
                         <button   name="btn" data-toggle="modal" data-target="#modalLoginForm{{$livreur->id}}"  class="btn btn-succes btn-sm" >Associer un compte</button>
                       

                          @endif
                        </td>
                       <!--  <td>
                           {{$livreur->jibiat_reliability}} <br>
                           <button value="{{$livreur->id}}"  class="btn btn-default btn-sm setrely">Set</button>
                        </td> -->
                        
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



   

$('#submitBtn').click(function() {
     /* when the button in the form, display the entered values in the modal */
     
});


$('.setrely').click(function() {
   var id = $(this).val();

   $("#livreur_id").val(id);  
     $("#reliabilityModal").modal("show");
});

$('#submit').click(function(){
     /* when the submit button in the modal is clicked, submit the form */
    
    $('#myForm').submit();
});
     
} );


</script>

@endsection
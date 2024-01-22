
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

                <h6 class="card-title">Liste des Utilisateur <a href="/client-form" class="btn">Ajouter</a></h6>
               
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
                      <th>Type</th>
                      
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
                        Commune
                      </th>
                      <th>
                        Adresse
                      </th>
                      <th>
                        Date d'inscription
                      </th>
                      <th>
                         Montant actif
                      </th>
                      <th>
                     Compte
                      </th>
                   <th>Whatsapp</th>
                      
                    </thead>
                    <tbody>
                      @foreach($clients as $client)
                      <tr>
                        
                        <td>
                           
                          {{$client->id}} 
                          <a href="/clientedit/{{$client->id}}" ><i class="fas fa-edit"></i></a>

                         <!--  <form  id="myForm"   method="POST" action="/client-delete/{{$client->id}}">
                            {{csrf_field()}}
                        {{method_field('DELETE')}}
                         <input onclick="myFunction{{$client->id}}()" name="btn" value="Supprimer" size="7px" id="submitBtn" data-toggle="modal"  class="btn btn-danger btn-sm" />
                       </form>


                      <script>
function myFunction{{$client->id}}() {
  confirm("Confirmer!");
}
</script> -->
                         
                        </td>
                        <td>
                          {{$client->client_type}}
                        </td>
                        
                        <td>
                          
                          <form action="dashboard">
                            
                            <input hidden type="" value="{{$client->id}}" name="clients[]">
                            <button class="btn  btn-light" type="submit"> @if($active_commands->count()>0)
                          @foreach($active_commands as $active)
                          @if($active->client_id == $client->id)
                          <span class="dot"></span>
                          @endif
                          @endforeach
                          @else
                          @endif{{$client->nom}}</button>
                          </form>
                          

                        </td>
                        <td>
                        	{{$client->command->count()}}
                        </td>
                        <td>
                          {{$client->phone}}
                        </td>
                        <td>
                          {{$client->city}}
                        </td>
                        <td>
                          {{$client->adresse}}
                        </td>
                        
                        <td>
                          {{$client->created_at}}
                        </td>
                        
                        <td >
                          @if($active_commands->count()>0)
                          @foreach($active_commands as $active)
                          @if($active->client_id == $client->id)
                          {{$active->montant}}
                          @endif
                          @endforeach
                          @else
                          @endif
                        </td>
                        <td>
                         @if($client->user)
                          {{$client->user->email}}
                          <form method="POST" action="/unset-client-account/{{$client->user->id}}">
                            @csrf
                          <button   type="submit"   class="btn btn-success btn-sm" >
                            Dissocier</button>
                          </form>
                          @else

                           
                         <button   name="btn" data-toggle="modal" data-target="#modalLoginForm{{$client->id}}"  class="btn btn-succes btn-sm" >Associer un compte</button>
                       

                          @endif



                          @if($client->is_certifier == NULL)
                          
                          <form method="POST" action="/makecertifier">
                            @csrf
                            <input  name="client_id" value="{{$client->id}}">
                          <button   type="submit"   class="btn btn-success btn-sm" >
                            Rendre certificateur</button>
                          </form>
                          @else

                           
                          <form method="POST" action="/unset-certifier">
                            @csrf
                           <input type="" hidden name="client_id" value="{{$client->id}}">
                          <button   type="submit"   class="btn btn-danger btn-sm" >Ne plus certifier</button>
                          </form>
                       

                          @endif
                         </td>
                        <td>
                          <a target="blank" class="text-success" href="https://wa.me/225{{$client->phone}}?text=Bonjour {{$client->nom}}. Merci de votre inscription sur notre plateform. Retrouvez ici une liste de livreurs certifiés(pièces d'identite et photos vérifiées et stockées dans la base de donnée)
                            https://client.livreurjibiat.site/livreurs_public" aria-hidden="true"></i>WhatsApp</a>
                        </td>
                      </tr>




                      <div class="modal fade" id="modalLoginForm{{$client->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
            <form method="POST" action="/set-client-account">
             @csrf
              <input hidden value="{{$client->id}}" type="text" name="client_id">
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

                  {{ $clients->links() }}
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
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

                <h6 class="card-title">Liste des tarifs <a href="/fee-form" class="btn">Ajouter</a></h6>
               
              </div>

                
              
              <div class="card-body">
                <div class="table-responsive">
                 
                          



                        <!--   <div class="container box">
   
                   <div>
                   
                   <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirmer
            </div>
            <div class="modal-body">
                <h4>Voulez-vous vraiment supprimer Ce tarif?</h4>

                

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
                        Destination
                      </th>
                      <th>
                        Tarif
                      </th>
                     <th>
                       nbre de commande
                     </th>
                      
                    </thead>
                    <tbody>
                      @foreach($fees as $fee)
                      <tr>
                        
                        <td>
                          <a href="/feeedit/{{$fee->id}}" ><i class="fas fa-edit"></i></a>

                          <form  id="myForm{{$fee->id}}"   method="POST" action="/fee-delete/{{$fee->id}}">
                            {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <button id="submitBtn{{$fee->id}}" onclick="myFunction{{$fee->id}}()" class="btn btn-danger btn-sm" type="submit"><i   name="btn" value="Supprimer"  class="fas fa-times"  ></i></button>
                       </form>



                      <script>
                   function myFunction{{$fee->id}}() {
                confirm("Confirmer!");
                            }
            </script>
                          
                        </td>
                        <td>
                          {{$fee->destination}}
                        </td>
                        <td>
                          {{$fee->price}}
                        </td>

                        <td>
                          {{count($fee->command)}}
                        </td>
                        

                        
                      </tr>
                      @endforeach
                    </tbody>
                   
                  </table>
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



    


</script>

@endsection
            
        {{ $commands->links() }}         
<table id="myTable" class="table table-striped" >
  <thead class=" text-primary">
        <th>
          <input type="checkbox" id="master">
           </th>
           <th> Action</th>
            <th>Etat</th>
                      
            <th> Numero</th>
            <th> Description</th>
            <th>adresse</th>
            <th>Contact</th>
            <th>Date de livraison</th>
            <th>Montant</th>
            <th>livraison</th>
            <th>Total</th>
            <th>Livreur</th>
            <th>Derniere note</th>
      </thead>
      <tbody>
 
    @foreach($commands->sortBy("adresse")->chunk(20) as $chunks)
                
                @foreach($chunks as $command)
     <tr>
      <td>
        <input onclick="add{{$command->id}}()" id="d{{$command->id}}"   type="checkbox" >
             <script type="text/javascript">
                           function add{{$command->id}}()
                           {
                            var bulkDiv = document.getElementById("bulkDiv");
                            var bulkReport = document.getElementById("bulkReport");

                            var bulkStatus = document.getElementById("bulkStatus");
                            var node = document.getElementById("d{{$command->id}}");
                            
                             var x = document.createElement("INPUT");
                                x.setAttribute("type", "checkbox");
                                x.setAttribute("name", "commands[]");
                                x.setAttribute("value", "{{$command->id}}");
                                x.setAttribute("checked", "checked");
                                x.setAttribute("id", "{{$command->id}}");

                                var r = document.createElement("INPUT");
                                r.setAttribute("type", "checkbox");
                                r.setAttribute("name", "commands[]");
                                r.setAttribute("value", "{{$command->id}}");
                                r.setAttribute("checked", "checked");
                                r.setAttribute("id", "r{{$command->id}}");

                                var s = document.createElement("INPUT");
                                s.setAttribute("type", "checkbox");
                                s.setAttribute("name", "commands[]");
                                s.setAttribute("value", "{{$command->id}}");
                                s.setAttribute("checked", "checked");
                                s.setAttribute("id", "s{{$command->id}}");


                            if (node.checked == true){
                                                     
                                    bulkDiv.appendChild(x);
                                    bulkReport.appendChild(r);
                                    bulkStatus.appendChild(s);
                           
                                                    } else {
                           
                                                       document.getElementById("{{$command->id}}").remove();
                                                       document.getElementById("r{{$command->id}}").remove();

                                                       document.getElementById("s{{$command->id}}").remove();
                                                             }
                            }
                           
                         </script>
                   
                          
                        </td>

                        <td>
                           <div class="d-inline">
                           @if($livreurs->count()>0)
                           <button  class="showLivreur"  value="{{$command->id}}" data-livid="{{$command->livreur->id}}"
         data-livname="{{$command->livreur->nom}}">
      <span  hidden="hidden" class="spinner-border spinner-border-sm spinner{{$command->id}}" role="status" aria-hidden="true"></span><span class="sr-only"></span>
                           <i style="color:blue" class="fas fa-bicycle"></i>
                             </button>
                            @endif


                          <button class="edit" id="cmd_menu{{$command->id}}" 
          data-desc="{{$command->description}}" data-id="{{$command->id}}" data-date="{{$command->delivery_date->format('Y-m-d')}}" data-date2="{{$command->delivery_date->format('d-m-Y')}}" data-montant="{{$command->montant}}" data-livreur="{{$command->livreur_id}}" data-fee="{{$command->fee_id}}" 
          data-com="{{substr($command->adresse,strlen($command->fee->destination)+1)}}" 
          data-adrs="{{$command->adresse}}" data-phone="{{$command->phone}}" data-observation="{{$command->observation}}"
          data-etat="{{$command->etat}}" data-livphone ="{{$command->livreur->phone}}" data-costumer="{{$command->nom_client}}" data-remise="{{$command->remise}}"  @if($sources->count() > 0) data-canal="{{$command->canal}}" @else data-canal="none" @endif data-total="@if($command->livraison != NULL) {{$command->montant+$command->livraison}}  @else {{$command->montant+$command->fee->price}} @endif" @if($command->livraison == NULL) data-liv="no" @else data-liv="{{$command->livraison}}" @endif>
                            <i style="color:blue" class="fas fa-edit"></i></button>
                          </div>
                          


                        


                         <div class="d-inline">
                          <button data-toggle="modal" data-target="#delete{{$command->id}}" >
                            <i style="color:red" class="fas fa-times"></i></button>
                          </div>
                      
                        </td>

                        <td>
                             <span 
                            data-toggle="modal" data-target="#etatModal" @click="updateSelectedState('{{$command->etat}}','{{$command->id}}','{{$command->livreur_id}}')"
                        
                          @if($command->etat == 'encours') 
                          class="badge badge-danger"
                          @endif

                          @if($command->etat == 'en attente') 
                          class="badge badge-warning"
                          @endif

                          @if($command->etat == 'recupere')
                          class="badge badge-warning"
                          @endif

                          @if($command->etat == 'en chemin')
                          class="badge badge-warning"
                          @endif


                          @if($command->etat == 'termine')
                          class="badge badge-success"
                          @endif
                          >{{$command->etat}}</span>

                          @if($command->ready == 'yes') 
                          <img width="30" height="30" src="/assets/img/packing.ico">
                          @endif 
                           @if($command->loc == 'retour')
                        <strong style="color: red">Retour en attente</strong>
                        @endif
                        </td>

                        <td>
                           
                           {{$command->id}}
                        </td>
                        

                        <td>
                          @if($command->client)
                              <span class="col" style="font-size: 13px;  line-height: 1.6; font-style: italic;"> 
                              by: {{$command->client->nom}}
                        </span><br>
                           @endif
                            <span class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                        Via: {{$command->canal}}
                        </span><br>

                        <span style="font-weight: bold;">{{$command->description}}</span>
                           
                      
                        </td>


                        <td>
                        
                          <strong>

                          <span class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                        Client: {{$command->nom_client}}
                        </span><br>
                          {{$command->adresse}}<br>
                          @if($command->observation)
                          Info: {{$command->observation}}
                          @endif 
                           </strong>
                          
                           
                        </td>
                        <td>
                           {{$command->phone}} 
                        </td>
                       

                        <td>
                          {{$command->delivery_date->format('d/m/Y')}}
                        </td>
                        <td >
                          {{$command->montant}}
                        </td>
                        <td>
                         
                          {{$command->livraison}}
                         
                        </td>

                        <td>
                         
                          {{$command->livraison + $command->montant}}
                          
                        </td>
                        
                        
                        <td >
                          @if($command->livreur_id != 11)
                          {{$command->livreur->nom}}
                          @else
                          Non assigne
                          @endif
                        </td>

                        <td>
                          @if($command->note->count() > 0)
                          {{$command->note->last()->description}} - {{$command->note->last()->updated_at->format('d/m/Y')}}
                          @else
                          @endif 
                        </td>
                      </tr>
                

                 



    <!-- Delete -->


     <div id="delete{{$command->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Supprimer {{$command->id}}</h4>
      </div>
       <form class="d-inline"  id="myForm{{$command->id}}"   method="POST" action="/command-delete/{{$command->id}}">
                            {{csrf_field()}}
                        {{method_field('DELETE')}}
              
      <div class="modal-body">
     

       

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success" >Confirmer</button>
      </div>
      </form>
    </div>

  </div>
</div>





        

                      @endforeach
                      @endforeach
                    </tbody>
                    <tfoot>
            <tr>
                <th colspan="4" style="text-align:right"></th>
                <th></th>
                 <th></th>
                 <th></th>
                 
                <th></th>
                 <th></th>
                 <th></th>
                 <th></th>
                 <th></th>
                 <th></th>
                 <th></th>
                 <th></th>
                 
            </tr>

        </tfoot>
                  </table>
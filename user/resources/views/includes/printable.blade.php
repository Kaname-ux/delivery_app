<table id="printable" class="d-none  table table-bordered table-striped">
                
                  <thead>
                  <tr>
                    
                    <th>Numero</th>
                     
                     <th>Client </th>
                    <th>Description</th>
                    <th>Date de livraison</th>
                    <th>Ramassage</th>
                    <th>Destination</th>
                    <th>Livreur</th>
                    <th>Prix</th>
                    <th>Livraison</th>
                    <th>Total</th>
                    <th>Info</th>
                  </tr>
                  </thead>
                  <tbody>
                   <tr  v-for="(command, index) in commands" :key="command.id" @mouseover="updateVariant(index)" >
                       
                        
                       <td>
                           <span v-if="command.user">Enregistrée par @{{command.user.name}}</span>
                        <span v-else>Enregistrée par le client</span><br>

                        # <strong>@{{command.id}}</strong><br>
                            <span v-if="command.etat == 'en chemin'"   class="text-warning">
                 <i   class="fas fa-walking text-warning "></i>En chemin
                </span>
                <span v-if="command.etat == 'recupere'"    value="" class="text-warning">
                <i   class="fas fa-dot-circle text-warning "></i>Récupéré
                </span>
                <span v-if="command.etat == 'encours'"    value="" class="text-danger">
                <i id=""   class="fas fa-dot-circle text-danger "></i>
                <span v-if="command.livreur_id == 11">En Attente</span>
                <span v-else>Encours</span>
                </span>
                <span v-if="command.etat == 'annule'"     value="" class="text-secondary">      
                <i id="state_c"   class="fas fa-window-close  "></i>Annulé
                </span>
                <span v-if="command.etat == 'termine'"   value="" class="text-success">
                <i   class="fa fa-check text-success "></i>Livré
                </span> 
                       </td>

                       <td>
                          @{{command.client.nom}}<br>
                         @{{command.client.adresse}} 
                        @{{command.client.phone}}  
                       </td>

                       <td>
                           @{{command.description}}
                       </td>

                       <td>
                          @{{command.delivery_date.substring(8, 10)}}-
                             @{{command.delivery_date.substring(5, 7)}}-
                            @{{command.delivery_date.substring(0, 4)}} 
                       </td>

                       <td>
                          @{{command.ram_commune}} 
                          @{{command.ram_adresse}}<br>
                          @{{command.ram_phone}} 
                       </td>

                       <td>
                           <span  style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                        Nom: @{{command.nom_client}}
                        </span><br>
                        <strong>
                          @{{command.adresse}}<br>
                          @{{command.phone}} / @{{command.phone2}}
                        </strong> 
                       </td>

                       <td>
                         @if($command_roles->contains('action', 'LIVREUR_R'))
                           <button @click="updateVariant(index)"  data-toggle="modal" data-target="#cmdDetailModal"  class="btn btn-primary btn-sm d-print-none" >
                      <span v-if="command.livreur_id == '11'">Non assigne</span>
                      <span v-if="command.livreur && command.livreur_id != '11'">@{{command.livreur.nom}}</span>
                    </button>

                    <span class="d-none d-print-block" v-if="command.livreur_id == '11'">Non assigne</span>
                      <span class="d-none d-print-block" v-if="command.livreur && command.livreur_id != '11'">@{{command.livreur.nom}}</span>
                      @endif
                       </td>

                       <td>
                            @{{command.montant}}
                       </td>

                       <td>
                           @{{command.livraison}} 
                       </td>

                       <td>
                          @{{command.montant-command.remise+command.livraison}} 
                       </td>

                       <td>
                          @{{command.observation}} 
                       </td>
                   </tr>
                  </tbody>
                  
                </table>
<table id="printable" class="d-none d-print-block table table-bordered table-striped">
                  <thead>
                  <tr>
                   
                    <th>Numero</th>
                     <th>Client</th>
                    <th>Description</th>
                    <th>Date de livraison</th>
                    <th>Acheteur</th>
                    <th>Livreur</th>
                    <th>Prix</th>
                    <th>Livraison</th>
                    <th>Total</th>
                    <th>Info</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr  v-for="(command, index) in commands">
                    
                    <td>
                 # <strong>@{{command.id}}</strong><br>
                <span v-if="command.etat == 'en chemin'"   class="text-warning">
                 <i   class="fas fa-walking text-warning "></i>En chemin
                </span>
                <span v-if="command.etat == 'recupere'"    value="" class="text-warning">
                <i   class="fas fa-dot-circle text-warning "></i>Récupéré
                </span>
                <span v-if="command.etat == 'encours'"    value="" class="text-danger">
                <i id=""   class="fas fa-dot-circle text-danger "></i>
                <span v-if="command.livreur.id == 11">En Attente</span>
                <span v-else>Encours</span>
                </span>
                <span v-if="command.etat == 'annule'"     value="" class="text-secondary">      
                <i id="state_c"   class="fas fa-window-close  "></i>Annulé
                </span>
                <span v-if="command.etat == 'termine'"   value="" class="text-success">
                <i   class="fa fa-check text-success "></i>Livré
                </span>
                <span v-if="command.note.length > 0"><br>
                 @{{command.note[command.note.length-1].created_at.substring(8, 10)}}-
               @{{command.note[command.note.length-1].created_at.substring(5, 7)}}-
               @{{command.note[command.note.length-1].created_at.substring(0, 4)}} @{{command.note[command.note.length-1].created_at.substring(11, 16)}}  
                @{{command.note[command.note.length-1].description}} 
                </span>
            </td>
            <td>
                @{{command.client.nom}}
            </td> 
            <td>@{{command.description}}
                     </td>
                    <td>   
                            @{{command.delivery_date.substring(8, 10)}}-
                             @{{command.delivery_date.substring(5, 7)}}-
                            @{{command.delivery_date.substring(0, 4)}}
                      
                    </td>
                    <td>
 
                        Nom: @{{command.nom_client}}
                        <br>
                        <strong>
                          @{{command.adresse}}<br>
                          @{{command.phone}} / @{{command.phone2}}
                        </strong>
                     
                    </td>
                    <td>
                      
                      <span v-if="command.livreur_id == '11'">Non assigne</span>
                      <span v-else>@{{command.livreur.nom}}</span>
                   

                   
                  </td>
                  <td> 
                     @{{command.montant}}
                     </td>
                    <td> 
                     @{{command.livraison}}
                     </td>
                    <td>@{{command.montant-command.remise+command.livraison}}</td>
                    <td>  
                        @{{command.observation}}
                    </td>
                  </tr>
                  
                  </tfoot>
                </table>
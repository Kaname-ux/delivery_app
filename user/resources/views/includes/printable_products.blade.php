<table id="printable" class=" d-print-block table table-bordered table-striped">
                  <thead>
                  <tr>
                   
                    <th>Code</th>
                     <th>Image</th>
                    <th>Nom</th>
                    <th>Prix de vente</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  <tr  v-for="(product, index) in products">
                    
                    <td>
                 # <strong>@{{product.id}}</strong><br>
                
            </td>
            <td>
                <img  :src="findImage(product.photo)" alt="img" style="width: 50px; height: 50px;">
            </td> 
            <td>@{{product.name}}
                     </td>
                    <td>   
                            @{{product.price}}
                      
                    </td>
                    
                  </tr>
              </tbody>

              <tfoot>
            


        </tfoot>
                  
                </table>
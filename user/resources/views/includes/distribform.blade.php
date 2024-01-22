    <form id="cmdForm" onsubmit="return false;">






           <div class="card mb-1">

          <div class="card-body">

              

          

      <h3 >Client </h3><div class="bg-warning" style="font-weight: bold; color: black;">@{{clientTip}}</div>



      <div   class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="basic-addon1">Client*</span>

  </div><input placeholder="Commencer à taper le nom"  @input="handleProvInput('distribproviders')" id="distrbprovider"  v-model="distribProviderName" 

    class="form-control" >

    

      

      </div>

      

      <div v-if="showProvSuggestions" id="suggestions">

    <span v-for="suggestion in filteredProvSuggestions" class="badge badge-primary" :key="suggestion" class="suggestion" @click="selectProvSuggestion(suggestion)">

      @{{ suggestion.nom }}

    </span>

  </div>





      <div  class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="basic-addon1">Nom*</span>

  </div>

      <input v-model="provName" id="povname" maxlength="150"     class="form-control" type="text" placeholder="Nom du client" aria-label="Client" aria-describedby="basic-addon1" >

      </div>

       <div v-if="departments" class="input-group mb-3 livreurInput">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Department</span>

</div>

      <select  v-model="department"    class="form-control livreur" name="">

        <option value="">Choisir departement</option>

       

      <option v-for="dep in departments" :value="dep.name">@{{dep.name}}</option>

    

      </select>

    

      </div>




        <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Contact*</span>

  </div>

      <input v-model="provPhone"   required  name="phone" class="form-control" type="tel" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">

      @error('phone')

      <span class="invalid-feedback" role="alert">

      <strong>{{ $message }}</strong>                   

      </span>

      @enderror

      <span class="contact_div text-warning"></span> 

      </div>





      <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Commune de ramassage*</span>

  </div>

      <select v-model="provCity"   required  class="form-control" >

      <option  value="">selectionner Une ville/commune</option>

      @foreach($fees as $fee)

      <option 

     

      value="{{$fee->destination}}">{{$fee->destination}}</option>

      <div id="fee_price"></div>

      @endforeach

      </select>

      

      </div>



      <div  class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="basic-addon1">Adresse de ramassage*</span>

  </div>

      <input v-model="provAdresse" id="povadresse" maxlength="150"     class="form-control" type="text" placeholder="Adresse du client" aria-label="Client" aria-describedby="basic-addon1" >

      </div>



     

     </div>

 </div>

        

      <div class="card mb-1">

          <div class="card-body">

      <h3>Destinataire</h3>

      <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="basic-addon1">Nom</span>

  </div>

      <input @input="handleInput" v-model="costumer" id="distribcostumer" maxlength="150"    name="costumer" class="form-control" type="text" placeholder="Nom du client" aria-label="Client" aria-describedby="basic-addon1" >

      </div>



       <div v-if="showSuggestions" id="suggestions">

    <span v-for="suggestion in filteredSuggestions" class="badge badge-primary" :key="suggestion" class="suggestion" @click="selectSuggestion(suggestion)">

      @{{ suggestion.nom }}

    </span>

  </div>



      <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Contact1*</span>

  </div>

      <input v-model="phone"   required  name="phone" class="form-control" type="text" pattern="[0-9]+" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">

      @error('phone')

      <span class="invalid-feedback" role="alert">

      <strong>{{ $message }}</strong>                   

      </span>

      @enderror

      <span class="contact_div text-warning"></span> 

      </div>



      <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Contact2</span>

  </div>

      <input pattern="[0-9]+" v-model="phone2"   required   class="form-control" type="text" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">

      @error('phone')

      <span class="invalid-feedback" role="alert">

      <strong>{{ $message }}</strong>                   

      </span>

      @enderror

      <span class="contact_div text-warning"></span> 

      </div>



      <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Commune*</span>

  </div>

      <select @change="getTarif" v-model="fee"   required  class="form-control" name="fee">

      <option  value="">selectionner Une ville/commune</option>

      @foreach($fees as $fee)

      <option 

      @if(old('fee') == $fee->id) selected @endif

      value="{{$fee->id}}">{{$fee->destination}}</option>

      <div id="fee_price"></div>

      @endforeach

      </select>

      @error('fee')

      <span class="invalid-feedback" role="alert">

      <strong>{{ $message }}</strong>

      </span>

      @enderror

      </div>



      <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Adresse</span>

  </div>

      <input v-model="adresse"  maxlength="150" value="{{ old('lieu') }}" id="cmdlieu" name="adresse" class="form-control" type="text" placeholder="Ex: grand carrefour... pharmacie... rivera jardin..." autocomplete="off">

      </div>



      <span hidden v-if="tarif != null && feeTarifs == null">

       <button v-if="livraison == tarif" @click="fastTarif(tarif)" type="button" class="btn btn-primary mr-1 mb-1">@{{tarif}}f Normal(48h)</button>

       <button v-else @click="fastTarif(tarif, 2)" type="button" class="btn btn-secondary mr-1 mb-1">@{{tarif}}f Normal(48h)</button>

       </span>

       <span hidden v-if="feeTarifs != null" v-for="feeTarif in feeTarifs">

         <button v-if="livraison == feeTarif.price" @click="fastTarif(feeTarif.price, feeTarif.delai)" type="button" class="btn btn-primary mr-1 mb-1">@{{feeTarif.price}}f @{{feeTarif.description}}</button>

       <button v-else @click="fastTarif(feeTarif.price, feeTarif.delai)" type="button" class="btn btn-secondary mr-1 mb-1">@{{feeTarif.price}}f @{{feeTarif.description}}</button>

           

       </span>



   </div>

</div>





<div class="card mb-1">

          <div class="card-body">

            <div class="row">

           <div class="col"> <h3>Colis</h3></div>

           <div class="col"> 



            <button v-if="products.length > 0"  data-target="#newCmdProdModal" data-toggle="modal"  type="button"  class="btn btn-primary btn-sm" ><ion-icon name="add-circle-outline"></ion-icon>Ajouter des produits</button>

        </div>

       </div>

       <div class="row mb-2" v-if="productPlus.length > 0" v-for="(fields, index) in productPlus">

          

           <div class="col-8">

           <select  data-live-search="true" :id="'prod-select'" :class="'selectpicker form-control'" >

               <option :data-tokens="field.name" v-for="field in fields" >@{{field.name}}</option>

           </select>

           </div>

           <div class="col-2">

           <input min="1" type="number" class="form-control " >

       </div>

       <div @click="removeField(index)" class="col-2">

           <ion-icon name="close-circle-outline"></ion-icon>

       </div>



       </div>



       


     


        <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Nature*</span>

  </div>

      <input v-model="nature"   id="cmdnature" maxlength="150" required   name="type"  class="form-control" type="text" placeholder="Nature du colis" >

      <strong class="text-dark">@{{getSelectedProducts}}</strong>

      

      </div>


       <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Nombre de plis*</span>

  </div>

      <input  v-model="plis"   id="cmdplis" max="150" required   name="plis"  class="form-control" type="number" placeholder="Nombre de plis" >

     

      

      </div>

      <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Type*</span>

  </div>

      <select v-model="type"   id="cmdtype" required   name="type"  class="form-control" type="text"  >
        <option value="">Choisir type de coli</option>
        <option value="Courier">Courier</option>
        <option value="Courier">Coli</option>
      </select>

      </div>

       <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Poids en gramme*</span>

  </div>

      <input   v-model="poids" id="cmdpoids"     class="form-control " type="number" placeholder="Poids en gramme" autocomplete="off">


      @error('montant')

      <span class="invalid-feedback" role="alert">

      <strong>{{$massage}}</strong>

      </span>

      @enderror

      </div>



      @if($sources->count() > 0)



      <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Canal</span>

  </div>

      <select v-model="source"  id="cmdsource"    class="form-control" name="source">

        <option value="">Choisir un canal</option>

        @foreach($sources as $source)

      <option value="{{$source->type. '_'.$source->antity}}">{{$source->type. "_".$source->antity}}</option>

      @endforeach

      </select>

      @error('source')

      <span class="invalid-feedback" role="alert">

      <strong>{{ $message }}</strong>

      </span>

      @enderror

      </div>

      @endif

      



    



      <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Prix*</span>

  </div>

      <input   v-model="montant" id="cmdprice"     class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Prix (sans la livraison)" autocomplete="off">



      

      

      @error('montant')

      <span class="invalid-feedback" role="alert">

      <strong>{{$massage}}</strong>

      </span>

      @enderror

      </div>



      <div :hidden="cart < 1" class="input-group input-group-lg mb-2"> 

      <div class="input-group-prepend">

    <span class="input-group-text" id="">Remise</span>

  </div>

      <input v-model="remise" id="cmdremise"  value="{{ old('montant') }}"  name="remise" class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Remise" autocomplete="off">

      @error('montant')

      <span class="invalid-feedback" role="alert">

      <strong>{{$massage}}</strong>

      </span>

      @enderror

      </div>



        
        <div class="form-check">

  <input v-model="distribdecherge" value="1" class="form-check-input" type="checkbox" value="1" id="distribdecharge">

  <label class="form-check-label" for="flexCheckDefault">

    Deja dechargé?

  </label>

</div>



 </div>

 </div>           



         

      <hr>

       <div class="row">

           <div class="col"> <h3>Livraison</h3></div>

           

       </div>

      
    <div   class="input-group  mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Type livraison*</span>

  </div>

      <select  v-model="delivType"   required   class="form-control " >

        <option value="">Choisir type</option>

      <option value="Standard">Standard</option>

      <option value="Urgent">Urgent</option>

   

      </select>

      </div>
      <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Date livraison*</span>

  </div>

      <input 

          required type="date" value="{{ old('delivery_date') }}" name="delivery_date" v-model="delivery_date" class="form-control"  id="cmddate" >

      @error('delivery_date')

      <span class="invalid-feedback" role="alert">

      <strong>{{ $message }}</strong>

      </span>

      @enderror

      </div>


     <div hidden  class="input-group  mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Tarif livraison*</span>

  </div>

      <select  v-model="livraison"   required   class="form-control livraison" name="livraison">

        <option value="">Choisir tarif</option>

      <option value="1000">1000f</option>

      <option value="1500">1500f</option>

      <option value="2000">2000f</option>

      <option value="2500">2500f</option>

      <option value="3000">3000f</option>

      <option  value="0">Gratuit</option>

      <option value="autre">Autre tarif</option>

      </select>

      @error('fee')

      <span class="invalid-feedback" role="alert">

      <strong>{{ $message }}</strong>

      </span>

      @enderror

      </div>

     





     <div v-if="livraison == 'autre'" class="input-group mb-2 " >

       <div class="input-group-prepend">

    <span  class="input-group-text" id="">Autre Tarif*</span>

  </div>

     

      <input :required="livraison == 'autre'" v-model="oth_fee" name="other_liv"  value="{{ old('other_liv') }}" id="cmdothfee"  class="form-control tarif" type="number" placeholder="" >

      </div>




 <div class="input-group input-group-lg mb-2">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Delai de livraison(en jour)</span>

  </div>

      <input 

         required type="number" value="2" name="delai" v-model="delai" class="form-control"  id="cmdddlai" >

      @error('delivery_date')

      <span class="invalid-feedback" role="alert">

      <strong>{{ $message }}</strong>

      </span>

      @enderror

      </div>
    

@if($command_roles->contains('action', 'ASSIGN'))

@if($livreurs->count() > 0)

 <div class="input-group mb-3 livreurInput">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Livreur</span>

</div>

      <select  v-model="livreur"    class="form-control livreur" name="livreur">

        <option value="">Choisir livreur</option>

        @foreach($livreurs as $livreur)

      <option value="{{$livreur->id}}">{{$livreur->nom}}</option>

      @endforeach

      </select>

      @error('livreur')

      <span class="invalid-feedback" role="alert">

      <strong>{{ $message }}</strong>

      </span>

      @enderror

      </div>



      @else





      <div hidden class="input-group mb-3 livreurInput">

       <div class="input-group-prepend">

    <span class="input-group-text" id="">Livreur</span>

</div>

      <select class="form-control livreur" name="livreur">

        <option value="">Choisir livreur</option>

       

      </select>

      @error('livreur')

      <span class="invalid-feedback" role="alert">

      <strong>{{ $message }}</strong>

      </span>

      @enderror

      </div>



      @endif

  @endif





      <div class="form-group">

      <label  class="form-label">Information supplementaire.</label>

      

      <textarea v-model="observation" id="comobservation" maxlength="150" value="{{ old('observation') }}"  name="observation" class="form-control" type="text" placeholder="Information supplementaire" rows="4" cols="4">

      </textarea>

      </div>

                         

               <div>

                   <span style="font-weight: bold; font-size: 22px; color:black">Total: @{{ Number(greatTotal)+Number(livraison) }}</span>

               </div>

                          



            <span v-if="cmdError" class="mb-2 alert alert-danger" >@{{cmdError}}</span>



                            <div v-if="confirm">

                               <strong class="text-warning">Il existe deja @{{confirm}}  commande(s) enregistree avec ce numero @{{phone}}. Souhaitez vous confirmer?</strong><br>



                               <button v-if="livraison =='autre'" type="button" @click="confirmCmd" :disabled="nature == '' || delivery_date == '' ||  destination == ''|| fee == '' || phone == '' || livraison == '' || provider == '' || provAdresse == '' || provPhone == '' || provName == '' || provCity == '' || livreur == '' || plis == ''"   class="btn btn-success  mr-2" 

                                        >Oui confirmer</button>



                               <button v-else type="button" @click="confirmCmd" :disabled="nature == '' || delivery_date == '' ||  destination == ''|| fee == '' || phone == '' || livraison == '' || provider == '' || provAdresse == '' || provPhone == '' || provName == '' || provCity == '' || livreur == '' || plis == ''"  class="btn btn-success  mr-2" 

                                        >Oui confirmer</button>         



                               <button @click="cancelCmd" type="button"  class="btn btn-danger" >Non Annuler</button>         

                           </div>



                                <div v-else  class="form-group basic">







                                    <button v-if="livraison =='autre'" type="button" @click="newCmd" :disabled="nature == '' || delivery_date == '' ||  destination == ''|| fee == '' || phone == ''  || provider == '' || provAdresse == '' || provPhone == '' || provName == '' || provCity == '' || plis == '' "   class="btn btn-primary btn-block btn-lg" id="addCmd"

                                        >Enregister</button>





                                    <button v-else type="button" @click="newCmd" :disabled="nature == '' || delivery_date == '' ||  destination == ''|| fee == '' || phone == '' ||  provider == '' || provAdresse == '' || provPhone == '' || provName == '' || provCity == '' || plis == ''"   class="btn btn-primary btn-block btn-lg" id="addCmd"

                                        >Enregister</button>    

                                </div>



                            

                           </form> 
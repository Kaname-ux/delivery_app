
 @include ("qrcode.qrlib")

 

@extends("layouts.master")

@section("title")
JibiaT Livraison
@endsection

@section("content")
<style type="text/css">
  
  th { white-space: nowrap; }
  .modal { overflow: auto !important; }
</style>
 

<div class="content">


  <div class="modal fade action-sheet  " id="LivChoice" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">Assinger</h5>
                        <div class="top"></div>
                        <div class="curLiv"></div>

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content LivChoiceBody">
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

  <div id="app">


    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Filter</h5>
                        
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content ">
                            <form action="?">
                                <div hidden>
                                     <input value="{{$state}}" type="text" name="state">
                                       <input value="{{$start}}" type="text" name="start">
                                    <input value="{{$end}}"  type="text" name="end">
                                </div>
                                    
                                
                            @if($livreurs->count() > 0)
                          <div class="form-group">
                            <label class="form-label ">Filter par livreur</label>
                              <select data-style="btn-dark" v-model="livreurs" title="Choisir livreurs..." id="livreur-select" class="selectpicker form-control" multiple  name="livreurs[]">
                               
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
                          @endif

                           <div class="form-group">
                            <label class="form-label">Filter par commune</label>
                              <select data-style="btn-dark" v-model="fees" title="Choisir communes..." id="fee-select" class=" selectpicker form-control" multiple  name="fees[]">
                               
                                 @foreach($fees as $fee2)
                                  <option value="{{$fee2->id}}">{{$fee2->destination}}
                                  </option>
                                 @endforeach
                                 </select>
                                 @error('fee')
                                   <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                          </div>


                          <div class="form-group">
                            <label class="form-label">Filter par source</label>
                              <select data-style="btn-dark" v-model="sources" title="Choisir sources..." id="source-select" class=" selectpicker form-control" multiple  name="sources[]">
                                 <option value="catalogue">Catalogue</option>
                                 @if($sources->count() > 0)
                                 @foreach($sources as $source)
                                  <option value="{{$source->type. '_'.$source->antity}}">{{$source->type. '_'.$source->antity}}</option>
                                 @endforeach
                                 @endif
                                 </select>
                                

                          </div>


                           <div class="form-group">
                            <label class="form-label">Filter par utilisateur</label>
                              <select data-style="btn-dark" v-model="clients" title="Choisir utilisateur..." id="client-select" class=" selectpicker form-control" multiple  name="clients[]">
                                
                                 @if($clients->count() > 0)
                                 @foreach($clients as $clt)
                                  <option value="{{$clt->id}}">{{$clt->nom}}</option>
                                 @endforeach
                                 @endif
                                 </select>
                                

                          </div>

                          <button :disabled="livreurs.length == 0 && fees.length == 0 && sources.length == 0 && clients.length == 0" class="btn btn-primary btn-block">Filtrer</button>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
   <div style="height: 100rem" class="modal fade" id="depositActionSheet" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title cmdModalTitle">Nouvelle commande</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content">
        <form id="cmdform" action="command-fast-register" method="POST">
      @csrf


             

      <input id="cmdid" value="" hidden name="command_id">

      <div class="form-group">
      <label class="form-label">Nom du client</label>
      <input id="cmdcostumer" maxlength="150"  value="{{ old('costumer') }}"  name="costumer" class="form-control" type="text" placeholder="Nom du client" >
      </div>
      <div class="form-group">
      <label class="form-label">Nature du colis</label>
      <input id="cmdnature" maxlength="150" required value="{{ old('type') }}"  name="type" class="form-control" type="text" placeholder="Nature du colis" >
      </div>

      @if($sources->count() > 0)
<div class="form-group">
      <label class="form-label">Canal(Vous pouvez le faire plustard)</label>
      <select  id="cmdsource"    class="form-control" name="source">
        <option value="">Chosir le canal</option>
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
      <div class="form-group">
      <label class="form-label">Date de livraison</label>
      <input 
         min="
         <?php
            echo date('Y-m-d');
            ?>
         " required type="date" value="{{ old('delivery_date') }}" name="delivery_date" class="form-control" type="text" id="cmddate" >
      @error('delivery_date')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      <div class="form-group"> 
      <label class="form-label">Prix(sans la livraison)</label>
      <input id="cmdprice"  value="{{ old('montant') }}"  name="montant" class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Prix (sans la livraison)" autocomplete="off">
      @error('montant')
      <span class="invalid-feedback" role="alert">
      <strong>{{$massage}}</strong>
      </span>
      @enderror
      </div>

      <div class="form-group"> 
      <label class="form-label">Remise</label>
      <input id="cmdremise"  value="{{ old('montant') }}"  name="remise" class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Remise" autocomplete="off">
      @error('montant')
      <span class="invalid-feedback" role="alert">
      <strong>{{$massage}}</strong>
      </span>
      @enderror
      </div>

      <div class="form-group">
      <div class="form-row">
       <div class="col-8">
      <label class="form-label ">Ville/commune</label>
      <select id="cmddestination"  required  class="form-control" name="fee">
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
      

      <div class="col">
      <label class="form-label">Tarif livrai.</label>
      <select   required   class="form-control livraison" name="livraison">
        <option value="">Chosir</option>
      <option value="1000">1000f</option>
      <option value="1500">1500f</option>
      <option value="2000">2000f</option>
      <option value="2500">2500f</option>
      <option value="3000">3000f</option>
      <option value="0">Gratuit</option>
      <option value="autre">Autre</option>
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
     </div> 
   </div>


     <div hidden class="form-group autre">
      <label class="form-label"> Saisir tarif de livraison</label>
      <input name="other_liv"  value="{{ old('other_liv') }}" id="cmdothfee"  class="form-control tarif" type="number" placeholder="" >
      </div>


      <div class="form-group">
      <label class="form-label"> Précision sur l'adresse de livraison</label>
      <input maxlength="150" value="{{ old('lieu') }}" id="cmdlieu" name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." >
      </div>
      <div class="form-row">
        <div class="col">
          <label class="form-label">Indicatif</label>
          <select class="form-control">
            <option>+225</option>
          </select>
        </div>
        <div class="col-8">
      <label class="form-label">Contact</label>
      <input id="cmdphone" value="{{ old('phone') }}" required  name="phone" class="form-control" type="number" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">
      @error('phone')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div> 
      <span class="contact_div"></span>        
      </div>




@if($livreurs->count() > 0)
<div class="form-group">
      <label class="form-label">Livreur(Vous pouvez le faire plustard)</label>
      <select      class="form-control livreur" name="livreur">
        <option value="">Chosir</option>
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
      @endif



      <div class="form-group">
      <label  class="form-label"> Information supplementaire.</label>
      <input id="comobservation" maxlength="150" value="{{ old('observation') }}"  name="observation" class="form-control" type="text" placeholder="Information supplementaire">
      </div>


                                <div class="form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"
                                        >Enregister</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade " id="dateModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Date</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <form  autocomplete="off"  action='?bydate' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("yesterday"))}}'   class="form-control " type="date" name="start">
                                         <input  hidden value='{{date("Y-m-d",strtotime("yesterday"))}}'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-outline-primary btn-block "   >Hier</button>

                                        </div>
                                         </form>

                                         <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("today"))}}'   class="form-control " type="date" name="start">
                                         <input  hidden value='{{date("Y-m-d",strtotime("today"))}}'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-outline-warning btn-block "   >Aujourd'hui</button>

                                        </div>
                                         </form>
                                        
                                        <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input hidden value='{{date("Y-m-d",strtotime("tomorrow"))}}'    class="form-control "  name="start">
                                         <input hidden value='{{date("Y-m-d",strtotime("tomorrow"))}}'    class="form-control "  name="end">
                                         <button class="btn btn-outline-success btn-block " type="submit"  >Demain</button>

                                        </div>
                                         </form>
                                       
                                    </div>
                                </div>
                                <div>
                              <form autocomplete="off" id="date-form" action="?">
                                @csrf
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11d">Choisir une date</label>
                                       
                                         <div  class="form-row">
                                         <div class="col">
                                         <input v-model="costumStart" value=""  class="form-control"type="date" name="start">
                                         
                                         </div>
                                         <div class="col">
                                            <button class="btn btn-primary btn-sm">Valider</button> 
                                         </div>
                                         
                                         <input hidden id="costumEnd" :value="costumStart"  class="form-control" 
                                          
                                         type="date" name="end">

                                        </div>
                                        
                                    </div>
                                </div>
                             </form>
                             </div>

                             <form autocomplete="off" id="date-form" action="?">
                                @csrf
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11d">Choisir un interval</label>
                                       
                                         <div  class="form-row">
                                         
                                         <div class="col">
                                         <input v-model="intStart" value=""  class="form-control" 
                                        
                                         type="date" name="start">
                                          </div>
                                          <div class="col">
                                         <input :disabled="!intStart" :min="intStart"  class="form-control" 
                                          
                                         type="date" name="end">
                                        </div>
                                       
                                        </div>
                                        <button class="btn btn-primary btn-sm">Valider</button> 
                                    </div>
                                </div>
                             </form>
                                

                                
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}  
                        </div>
                    @endif

                       @if($all_commands->where("livreur_id", 11)->count() > 0)
                        <div class="alert alert-danger" role="alert">
                             {{$all_commands->where("livreur_id", 11)->count()}} 
                            
                             commande(s) en attente d'assignation.   
                        </div>
                      @endif
            
                <h6 class="card-title">Liste des commandes <button data-toggle="modal" onclick="$('#cmdform').trigger('reset'); $('.cmdModalTitle').html('Nouvelle commande'); $('#cmdform').attr('action', 'command-fast-register');" data-target="#depositActionSheet" class="btn">Nouvelle Commande</button></h6>
                 
                 @if($filter != "")
<div class="row ml-2">
  {!! $filter !!} 
   <form action="?">
   <input hidden name="state" value="{{$state}}">
   <input hidden name="start" value="{{$start}}">
   <input hidden name="end" value="{{$end}}">
    <button class="btn btn-primary btn-sm">Retour aux commandes</button>
    </form>
 </div>
@endif

                <button data-toggle="modal" data-target="#dateModal" class="btn btn-outline-primary btn-sm">{{$day}}</button>

                <div class="float-right">Total : <strong>{{$all_commands->sum("montant")}}</strong><br>
                  Total livre : <strong>{{$all_commands->where("etat", "termine")->sum("montant")}}</strong>


                </div>
              </div>

                
              
              <div class="card-body">
                <div class="table-responsive">
                 
                  <br><br>
                   @if(count($final_destinations)>0) 
                    <div class="chip chip-media" style="margin-bottom: 3px">   
               @foreach($final_destinations as $destination=> $nomber)
               
                            {{ $nomber}}
                        
                        <span class="chip-label">{{$destination}}</span>|
                    
               @endforeach
               </div>
               @endif


                           <div id="bulkAssign" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
     <form class="d-inline"    method="POST" action="bulk-assign">
                            @csrf
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assigner</h4>
      </div>
      <div class="modal-body">
     

       
              
       <div hidden id="bulkDiv"></div>

       <div class="form-group">
        <select name="livreur" class="form-control">
          <option>Choisir un livreur</option>
         @foreach($livreurs as $livreur)
         <option value="{{$livreur->id}}" >{{$livreur->nom}}</option>
         @endforeach
         </select>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success" >Confirmer</button>
      </div>
     
    </div>
     </form>
  </div>
</div>







<div id="bulkRep" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
     <form class="d-inline"    method="POST" action="bulk-report">
                            @csrf
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reporter selection</h4>
      </div>
      <div class="modal-body">
     

       
              
       <div hidden id="bulkReport"></div>

       <div class="form-group">
        <input class="form-control" type="date" name="report_date">
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success" >Confirmer</button>
      </div>
      
    </div>
</form>
  </div>
</div>

<div class="modal fade modalbox" id="etatModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Modifier etat Commande @{{selectedCommand}}</h5>
                       <a href="javascript:;" data-dismiss="modal">Fermer</a>
 
                    </div>
                    
                    <div class="modal-body" >
                        <form method="post" action="updatestatus">
                            @csrf
                            <input hidden type="" :value="selectedCommand" name="cmdid">
                        <div class="row mb-2">
                          Etat actuel: <strong class="text-dark" style="font-weight: bold;">@{{state}}</strong>  
                        </div>
                        <div class="form-group">
                            <label>Choisir nouvel etat</label>
                            <select  name="etat"  v-model="etat" class="form-control" >
                                <option v-for="(status, index) in states" v-bind:key="index"  :selected="status.value == state" :value="status.value">@{{status.text}}</option>
                                
                            </select>
                        </div>

                            <div v-if="etat == 'termine' && state != etat" class="form-check">
                                  <input name="payed" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault">
                                   <label class="form-check-label" for="flexCheckDefault">
                                          Commande encaissée
                                     </label>
                                  </div>
                             

                        <div v-if="etat == 'termine' && livreur == '11'" class="row">
                            <span class="text-warning" style="font-weight: bold;">Attention!! Cette commande n'est assignee a aucun livreur, si elle a ete effectuee par un livreur de votre liste, veuillez l'assigner a ce dernier.</span>

                             

                            @if($livreurs->count() > 0)
                            <button type="button" @click="updateAssign(1)" v-if="!assign" class="btn btn-primary mb-2">Assigner a un livreur</button>
                            <button type="button" @click="updateAssign(null)" v-else class="btn btn-primary mb-2">Ne pas assigner</button>
                             <div v-if="assign" class="form-group">
                               <label class="form-label">Livreur</label>
                                  <select v-model="selectedLivreur" :required="assign == 1" class="form-control livreur" name="livreur">
                                    <option value="">Choisir un livreur</option>
                                    @foreach($livreurs as $livreur)
                                    <option value="{{$livreur->id}}">{{$livreur->nom}}</option>
                                     @endforeach
                                 </select>
                             </div>
                            
                                 
                             @else
                             Il n'y a pas de livreur dans votre liste. 
                             <a class="btn btn-primary btn-block" href="livreurs">Voir la liste des livreur</a>
                            @endif
                            

                        </div>

                        
                        <button :disabled="etat == '' || etat == state" class="btn btn-primary btn-block">Valider</button>

                    </form>
                    </div>
                   
                </div>
            </div>
        </div>


<div id="bulkSts" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
     <form class="d-inline"    method="POST" action="bulk-status">
                            @csrf
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">changer status selection</h4>
      </div>

              
      <div class="modal-body">
     

       
       <div hidden id="bulkStatus"></div>

       <div class="form-group">
        
                            <select  class="form-control" name="etat">
                            <option 
                              value="">selectionner état</option>
                              
                            </select>
            
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success" >Confirmer</button>
      </div>
      
    </div>
</form>
  </div>
</div>



                    <!-- <button  class="btn btn-default btn-sm delete_allenattente" data-url="{{ url('bulk-attente') }}">Marquer En attente </button>

                   <button value="annulé" name="etat" class="btn btn-default btn-sm delete_allannule" data-url="{{ url('bulk-annule') }}">Marquer annulé </button> -->

                    
                   

                   

                 @include('includes.tabletop')
                 

                  @include('includes.cmdtable')
                
                </div>
              </div>
            </div>
          </div>
        
        </div>
       </div>

       <script>
   const app = Vue.createApp({
    data() {
        return {
            
            selectedVariant: 0,
            selectedCommand:"",
            total:0,
            cartProducts: [],
            cart:0,
            products: {!! $products !!},
            assignBody: "",
            state:"",
            states:[{"text":"Encours", "value":"encours"},{"text":"Livre", "value":"termine"},{"text":"Annule", "value":"annule"},],
            assign:null,
            livreur:"",
            livreur2:"",
            etat:"",
            selectedLivreur:null,
            fees:[],
            sources:[],
            livreurs:[],
            clients:[],
            allVals:[],
            costumStart:"",
            intStart:null

        }
    },
    methods:{ 
    
    
    updateAssign(index){
        this.assign = index
    },  

    updateVariant(index) {
        this.selectedVariant = index
        
    },

   


    addToCart() {
          this.cart += 1 
          this.products[this.selectedVariant].qty += 1
          this.products[this.selectedVariant].stock -= 1
           this.total += this.products[this.selectedVariant].price 
 

    },
 
   removeFromCart() {
        this.cart -= 1
        this.products[this.selectedVariant].qty -= 1
         this.products[this.selectedVariant].stock += 1
        this.total -= this.products[this.selectedVariant].price 
      
    },

    findImage(productImg){
        if(productImg == null){
            src = "assets/img/sample/brand/1.jpg"
        }
        else{
            src = "https://livreurjibiat.s3.eu-west-3.amazonaws.com/"+productImg
        }

        return src
    },
  

    updateProducts(productIds = {}, commandid = 0) {
         this.total = 0
         this.selectedCommand = commandid

        for (a=0; a <  this.products.length; a++) {
            
                
                this.products[a].qty = 0
               
            
        }
        
        for (i=0; i < productIds.length; i++) {
            
            for (y=0; y <  this.products.length; y++) {
            if(this.products[y].id == productIds[i].product_id){
                
                this.products[y].qty = productIds[i].qty
                this.total += this.products[y].price*this.products[y].qty

                console.log(this.products[y].qty)
            }
            
        }
      }
      

    },

    updateSelectedState(state, commandId, livreur){
        this.state = state
        this.livreur = livreur
        this.selectedCommand = commandId
    }

   },
   computed:{
     
}
});

  const mountedApp = app.mount('#app')     
  </script>
      <div>
       
@endsection

@section("script")
<script src="https://unpkg.com/html5-qrcode" type="text/javascript">
</script>
<script type="text/javascript">
    $('#livreur-select').selectpicker();
$('#fee-select').selectpicker();
$('#source-select').selectpicker();
 $('#client-select').selectpicker();

</script>


@endsection
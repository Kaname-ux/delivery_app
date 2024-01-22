<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Ma boutique</title>
     <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content=" Système de gestion pour vendeur en ligne">
    <meta name="keywords" content="vente en ligne, livraison, livreur" />
    <link rel="apple-touch-icon" size="180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href=".../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../img/favicon.png">
   
    

     <link rel = " manifest " href="../assets/manifest/client.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo-icon.png" />
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }


 
</style>




</head>

<body>
    <script src="https://unpkg.com/vue@3.0.11/dist/vue.global.js" ></script>
  <div id="app">
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


        <div class="modal fade action-sheet  " id="moovingModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">Mouvement @{{ productName }}</h5>
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content ">
                        <form method="post" action="mooving">
                            @csrf
                            <input hidden :value="productId" type="" name="id">
                            
                             <div class="form-group">
                                <label>Type de mouvement</label>
                                <select name="type"  class="form-control border border-primary" required >
                                    <option value="">Choisir</option>
                                    <option value="IN">ENTREE</option>
                                    <option value="OUT">SORTIE</option>
                                </select>
                                
                            </div>

                            <div class="form-group">
                               <label>Quantite</label>
                                <input required min="1" type="number" name="qty" class="form-control border border-primary">
                                
                            </div>

                            <div class="form-group">
                               <label>Description</label>
                                <textarea required name="description" class="form-control border border-primary" rows="4" cols="4"></textarea>
                                
                            </div>
                           <input type="submit" name="">
                        </form>
                    </div>
                </div>
               </div>
            </div>
        </div>
    <!-- loader -->
    <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Ma boutique
        </div>
        <div class="right">
            <a href="#" data-toggle="modal" data-target="#cmd" class="headerButton">
                <ion-icon class="icon" name="cart-outline"></ion-icon>
                <span   class="badge badge-danger">@{{ cart }}</span>

            </a>
            <br>@{{ total }}
        </div>
    </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule">
         @include('includes.cmdvalidation')
         <div class="row mb-2">
            <button v-on:click="addProduct" class="btn btn-primary" data-toggle="modal" data-target="#addProduct">+ Nouveau produit</button>
             <div class="col float-right">
             <button v-if="cart > 0" data-toggle="modal" data-target="#cmd" class="btn btn-success " >
            <ion-icon name="cart-outline"></ion-icon>@{{cart}} dans le panier</button>

             <button v-else data-toggle="modal" data-target="#cmd" class="btn btn-warning " >
            <ion-icon name="cart-outline"></ion-icon>@{{cart}} dans le panier</button>
            </div>
          </div>
          <div class="row">
          <div class="col">   
         <a target="_blank" class="btn btn-primary ml-1" href="catalog?client={{$client->id}}">Mon catalogue en ligne</a>
         </div>
         <div class="col">
         <button id="shareCatalog" class="btn btn-primary " >
            <ion-icon name="share-outline"></ion-icon>Partager mon catalogue</button>
        </div>

        
         </div>
         <div class="section">
         

         <div class="form-group searchbox mt-2">
                <input onkeyup="search2()" id="Search2" type="text" class="form-control">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
            </div>
         </div> 




        <div   class="modal fade modalbox" id="addProduct"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addProduct" class="modal-title editModalTitle">@{{ productTitle }}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <form method="post" enctype="multipart/form-data" :action="productAction" >
                            @csrf

                            <input hidden :value="productId" name="id">
                            <div class="form-group">
                                <label>Nom du produit</label>
                                <input :value="productName" autocomplete="off" placeholder="Saisir le nom du produit" class="form-control border border-primary" type="" name="name">
                                
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea :value="productDescription" name="description" class="form-control border border-primary" rows="4" cols="4"></textarea>
                                
                            </div>

                            <div class="form-group">
                                <label>Prix</label>
                                
                                <input :value="productPrice" autocomplete="off" placeholder="Saisir le prix du produit" class="form-control border border-primary" type="" name="price">
                                
                            </div>


                             <div class="form-group">
                                <label>Quantite</label>
                                
                                <input :value="productStock" autocomplete="off" placeholder="Saisir le stock initial" class="form-control border border-primary" type="" name="qty">
                                
                            </div>


                             <div class="form-group">
                                <label>Photo</label>
                                
                                <input accept="image/png, image/jpeg" class="form-control" type="file" name="file">
                                
                            </div>

                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                        
                </div>
            </div>
        </div>

      </div>


      <div   class="modal fade " id="productDetail"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addProduct" class="modal-title editModalTitle">Details produit</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                       <div class="row">
                         <img :src="findImage(productPhoto)" style="width: 100%; height: 30%;" alt="img">
                           
                       </div> 

                       <div class="row mt-2">
                        Nom du produit: <span style="font-weight: bold;">@{{ productName }}</span>  

                           
                       </div>

                       <div class="row mt-2">
                        
                        Prix: @{{ productPrice }} <br>
                        Stock: @{{ productStock }} <br>
                        Description: @{{ productDescription }} <br>

                           
                       </div>


                        
                        
                </div>
            </div>
        </div>

      </div>




        <div   class="modal fade " id="cmd"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title editModalTitle">Panier</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <div  class="action-sheet-content selectedProducts">
                            <form id="cmdForm" onsubmit="return false;">
                            <div  id="cmdSuccess"  class="card mb-2">

            <div v-if="newR" class="card-body">
               <span class="alert alert-success mb-2">Commande enregistree</span>
               Numero:<span style="color:red; font-size: 20px; font-weight: bold;">@{{newR.id}}</span>(a inscrire sur votre colis)

               <button type="button" @click="shareBill('Commande'+ ' '+ newR.id+'. '+newR.description+ '. Total:'+ (Number(newR.montant)+Number(newR.livraison))+'. '+newR.adresse+ '. '+newR.phone+ '. Plus de detail sur https://client.livreurjibiat.site/tracking/'+newR.id)" class="btn btn-primary btn-block mt-2 squared" id="bill">ENVOYER FACTURE</button>
           </div>
            </div>

                    
           <h3>Client</h3>
            <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Client</span>
  </div>
      <input v-model="custumer" id="cmdcostumer" maxlength="150"    name="costumer" class="form-control" type="text" placeholder="Nom du client" >
      </div>

       <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Contact*</span>
  </div>
      <input v-model="phone"  id="cmdphone" value="{{ old('phone') }}" required  name="phone" class="form-control contact" type="tel" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">
      @error('phone')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>                   
      </span>
      @enderror
      <span class="contact_div text-warning"></span> 
      </div>

      <div hidden class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Contact2</span>
  </div>
      <input id="cmdphone2" value="{{ old('phone2') }}"   name="phone2" class="form-control contact" type="number" placeholder="Second Numero du client sans l'indicatif(225)"  autocomplete="off">
      @error('phone2')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>                   
      </span>
      @enderror
      <span class="contact_div text-warning"></span> 
      </div>

      <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Commune*</span>
  </div>
      <select v-model="fee"   required  class="form-control" name="fee">
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

       <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Adresse</span>
  </div>
      <input  v-model="adresse"  maxlength="150" id="cmdlieu" name="adresse" class="form-control" type="text" placeholder="Ex: grand carrefour... pharmacie... rivera jardin..." autocomplete="off">
      </div>
       
       <hr>
       <div class="row">
           <div class="col"> <h3>Colis</h3></div>
           <div class="col float-right"> <h3 :class="danger">Total: @{{ greatTotal }} </h3></div>
       </div>
      
       <div style="font-weight: bold;" class="row"  v-for="product in products">
         <span v-if="product.qty>0">@{{product.qty + ' ' +product.name}}.</span>
      </div>

          @if($client->sources->count() > 0)
<div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Canal</span>
  </div>
      <select   v-model="source"  id="cmdsource"   class="form-control livreur" name="source">
        <option value="">Chosir le canal</option>
        @foreach($client->sources as $source)
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
     
      <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Date Livraison</span>
  </div>
      <input 
         min="
         <?php
            echo date('Y-m-d');
            ?>
         " required type="date" v-model="delivery_date" name="delivery_date" class="form-control "  id="cmddate"  >
      @error('delivery_date')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      

      


      <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Remise</span>
  </div>
      <input required v-model="remise" id="cmdremise"  value="{{ old('montant') }}"  name="remise" class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Remise" autocomplete="off">
      @error('montant')
      <span class="invalid-feedback" role="alert">
      <strong>{{$massage}}</strong>
      </span>
      @enderror
      </div>

       <div class="input-group  mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Tarif livraison*</span>
  </div>
      <select v-model="livraison"  class="form-control livraison" name="livraison">
        <option  value="">Choisir tarif</option>
      <option value="1000">1000f</option>
      <option value="1500">1500f</option>
      <option value="2000">2000f</option>
      <option value="2500">2500f</option>
      <option value="3000">3000f</option>
      <option value="0">Gratuit</option>
      <option value="autre">Autre tarif</option>
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>

      <div class="input-group mb-2 autre" v-if="livraison == 'autre'" >
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Autre Tarif*</span>
  </div>
      <input :required="livraison == 'autre'" v-model="oth_fee" name="other_liv"  value="{{ old('other_liv') }}" id="cmdothfee"  class="form-control tarif" type="number" placeholder="" >
      </div>

    


     
     



@if($client->livreurs->count() > 0)
 <div class="input-group mb-3 livreurInput">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Livreur</span>
</div>
      <select  v-model="livreur"    class="form-control livreur" name="livreur">
        <option value="">Choisir livreur</option>
        <option value="">Choisir plutard</option>
        @foreach($client->livreurs as $livreur)
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


      <div class="form-group">
      <label  class="form-label">Information supplementaire.</label>
      <input v-model="observation" id="comobservation" id="comobservation" maxlength="150" value="{{ old('observation') }}"  name="observation" class="form-control border border-primary" type="text" placeholder="Information supplementaire">
      </div>
      <span v-if="cmdError" class="mb-2 alert alert-danger" >@{{cmdError}}</span>
         <div v-if="confirm">
           <strong class="text-warning">Il existe deja @{{confirm}}  commande(s) enregistree avec ce numero @{{phone}}. Souhaitez vous confirmer?
           </strong><br>
            <button type="button" @click="confirmCmd" :disabled="delivery_date == ''  || destination == ''|| livraison == '' || phone == '' || total <= 0 || products.length == 0" id="addCmd"  class="btn btn-success  mr-2">
            Oui confirmer
           </button>

           <button @click="editCmd" type="button"  class="btn btn-warning mr-1" >
            Modifier
           </button>
            <button @click="cancelCmd" type="button"  class="btn btn-danger" >
            Non Annuler
           </button> 

                     
         </div>
      <div v-else  class="form-group basic">
         <button type="button" @click="newCmd" :disabled="delivery_date == ''  || destination == ''|| livraison == '' || phone == '' || total <= 0 || products.length == 0"  class="btn btn-primary btn-block btn-lg" id="addCmd">Enregister
         </button>
       </div>
  </form>
      <div v-if="cart>0" v-for="(product, index) in products" :key="product.id" @mouseover="updateVariant(index)"  class="transactions mb-2">
       <!-- item -->
         <div class="item" v-if="product.qty > 0">
            <div class="detail">
                <img :src="findImage(product.photo)" alt="img" class="image-block imaged w48">
            <div>
              <strong>@{{ product.name }}</strong>
             
            @{{ product.qty }} * @{{ product.price }} = @{{ product.price* product.qty}}<br>
            <button :disabled="product.stock > 0 ? false : true" v-on:click="addToCart()" class="btn btn-success mr-1 btn-sm">+ Panier</button>
             <button v-if="product.qty > 0" v-on:click="removeFromCart()" class="btn btn-danger btn-sm ">-  Panier</button>
              <span :class="product.stock > 0 ? 'text-success' : 'text-danger'">Stock @{{ product.stock }}</span>
            </div>
            
            </div>

                
            
            
            
           </div>

           
        </div>
    <div v-else>
       Aucum produit dans le panier
    </div>
         </div>
      </div>
    </div>
   </div>
</div>

        <!-- Transactions -->
        <div class="section mt-2">
           

           <div class="transactions">
            <div class="row">
            <div v-for="(product, index) in products" :key="product.id" @mouseover="updateVariant(index)" class="col-md-6 target2">
                <!-- item -->
                <div class="item  mb-2">
                <a href="#" >
                    <div v-on:click="editProduct" data-toggle="modal" data-target="#productDetail" class="detail">
                        <img
                        :src="findImage(product.photo)"

                        alt="img" 
                         
                        

                         class="image-block imaged w48">
                        <div >
                           <p class="text-success" v-if="product.qty > 0"> @{{ product.qty }} dans le panier </p>
                            <strong>@{{ product.name }}</strong>
                            <p>@{{ product.description.substring(0,20) }}</p>
                        </div>
                    </div>
                    <button data-toggle="modal" data-target="#addProduct" v-on:click="editProduct" class="btn btn-primary btn-sm mr-1"><ion-icon name="pencil-outline"></ion-icon></button>
                      <button  :disabled="product.stock > 0 ? false : true"  v-on:click="addToCart()" class="btn btn-success btn-sm mr-1 mt-1">+ Panier</button>
                     <button v-if="product.qty > 0" v-on:click="removeFromCart()" class="btn btn-danger btn-sm  mt-1">- Panier</button>
                       
                    </a>
                    <div class="right">

                    Prix:  @{{ product.price }} F<br>
                     
                      <span :class="product.stock > 0 ? 'text-success' : 'text-danger'">Stock @{{ product.stock }}</span><br>
                      <button v-on:click="editProduct"  data-toggle="modal" data-target="#moovingModal" class="btn btn-primary btn-sm mr-1">Gerer</button>
                      
                      
                        
                        
                    </div>

                  
                
                </div>
            </div>
           </div>
       </div>
                <!-- * item -->
                
                
                            </div>
        </div>
        

        <!-- <div class="section mt-2 mb-2">
            <a href="#" class="btn btn-primary btn-block btn-lg">Load More</a>
        </div> -->


    </div>
</div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
     @include("includes.bottom")
    @include("includes.sidebar")
    <!-- * App Bottom Menu -->


    <!-- ========= JS Files =========  -->
    <!-- Bootstrap -->
     <script src="../assets/js/lib/jquery-3.4.1.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/cesiumjs/1.78/Build/Cesium/Cesium.js"></script>
     <script src="../assets/manifest/js/app.js"></script>
    <!-- Bootstrap-->
    <script src="../assets/js/lib/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
   
    <!-- Owl Carousel -->
    <script src="../assets/js/owl.carousel.min.js"></script>
    <!-- Base Js File -->
    <script src="../assets/js/base.js"></script>
     <script src="../assets/js/commands.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Google map -->
   
 

  
  
  <script type="text/javascript">
      

    
    const app = Vue.createApp({
    data() {
        return {
            selectedVariant: 0,
            productAction: "createproduct",
            productName: "",
            productDescription: "",
            productStock:"",
            productPrice:"",
            productId:"",
            otherFee:"",
            remise:"",
            
            productPhoto:"",
            productTitle:"Ajouter un produit",
            total:0,
            
            grtTotal: 0,
            cartProducts: [],
            cart:0,
            products: {!! $products !!},
            stocks: {!! $stocks !!},


            fee:"",
            custumer:"",
            nature:"",
            source:"",
            delivery_date:"",
            montant:"",
            livraison:"",
            adresse:"",
            oth_fee:"",
            phone:"",
            livreur:"",
            observation:"",
            newR:null,
            cmdError:null,
            cmdNature:"",
            cmdProducts:[],
            confirm:null
            
            
        }
    },
    methods:{ 
     

     newCmd(){
            vm = this
            fee= this.fee
            custumer= this.custumer
            nature= this.nature
            source= this.source
            delivery_date= this.delivery_date
            montant= this.total
            livraison = this.livraison
            adresse= this.adresse
            oth_fee= this.oth_fee
            phone= this.phone
            livreur= this.livreur
            observation = this.observation
            

            for(i = 0; i < this.products.length; i++){
                if(this.products[i].qty > 0){
                    this.cmdProducts.push(this.products[i].id+'_'+this.products[i].qty)
                }
            }
             
             products = this.cmdProducts
             var element = document.getElementById("cmdcostumer")
             document.getElementById("addCmd").disabled = true

         axios.post('/command-fast-register', {
            products:products,
            fee: fee,
            confirm:vm.confirm,
            custumer: custumer,
            type: nature,
            source: source,
            delivery_date: delivery_date,
            montant: montant,
            livraison: livraison,
            adresse: adresse,
            oth_fee: oth_fee,
            phone: phone,
            livreur: livreur,
            observation: observation,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    if(response.data.confirm != null){
        vm.confirm = response.data.confirm
    }else{
        
        vm.newR = response.data.newCmd
        
                
                 vm.fee= ""
                vm.custumer= ""
                vm.nature= ""
                vm.source= ""
                vm.delivery_date= ""
                vm.montant= ""
                vm.livraison = ""
                vm.adresse= ""
                vm.oth_fee= ""
                vm.phone= ""
                vm.livreur= ""
                vm.observation = ""
                vm.cmdProducts = []
                element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});

                for(i = 0; i < this.products.length; i++){
                
                    vm.products[i].qty = 0
                           }
            vm.total = 0
            vm.cart = 0
            }
   
 
   
  
  })
  .catch(function (error) {
    addBtn.setAttribute("disabled", "disabled")
    vm.cmdError = "Une erreur s'est produite"
    console.log(error);
  });
    },



    confirmCmd(){
            vm = this

           
            fee= this.fee
            custumer= this.custumer
            nature= this.nature
            source= this.source
            delivery_date= this.delivery_date
            montant= this.total
            livraison = this.livraison
            adresse= this.adresse
            oth_fee= this.oth_fee
            phone= this.phone
            livreur= this.livreur
            observation = this.observation
            var addBtn = document.getElementById("addCmd")
             
             var element = document.getElementById("cmdcostumer")
             var cmdForm = document.getElementById("cmdForm")

            

         axios.post('/command-fast-register', {
             products:vm.cmdProducts,
            fee: fee,
            confirm:vm.confirm,
            custumer: custumer,
            type: nature,
            source: source,
            delivery_date: delivery_date,
            montant: montant,
            livraison: livraison,
            adresse: adresse,
            oth_fee: oth_fee,
            phone: phone,
            livreur: livreur,
            observation: observation,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
        
        vm.newR = response.data.newCmd
        vm.commands = response.data.commands 
                vm.confirm = null
                 vm.fee= ""
                vm.custumer= ""
                vm.nature= ""
                vm.source= ""
                vm.delivery_date= ""
                vm.montant= ""
                vm.livraison = ""
                vm.adresse= ""
                vm.oth_fee= ""
                vm.phone= ""
                vm.livreur= ""
                vm.observation = ""
                vm.cmdProducts = []

                for(i = 0; i < this.products.length; i++){
                
                    vm.products[i].qty = 0
               
            }
            vm.total = 0
            vm.cart = 0
        
      element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
 
   
  
  })
  .catch(function (error) {
    addBtn.setAttribute("disabled", "disabled")
    vm.cmdError = "Une erreur s'est produite"
    console.log(error);
  });
    },


cancelCmd(){

               var element = document.getElementById("cmdcostumer")
                vm.fee= ""
                vm.custumer= ""
                vm.nature= ""
                vm.source= ""
                vm.delivery_date= ""
                vm.montant= ""
                vm.livraison = ""
                vm.adresse= ""
                vm.oth_fee= ""
                vm.phone= ""
                vm.livreur= ""
                vm.observation = ""
                vm.confirm = null
                vm.cmdProducts = []
                 element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
    },

    editCmd(){

               var element = document.getElementById("cmdcostumer")
                
                this.confirm = null
                this.cmdProducts = []
                
                 element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
    },






        updateVariant(index) {
        this.selectedVariant = index
        
    },




        addToCart() {
          this.cart += 1 
          this.products[this.selectedVariant].qty += 1
          this.products[this.selectedVariant].stock -= 1
           this.total += this.products[this.selectedVariant].price 
 
         console.log(this.products)
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

    editProduct(){
            this.productAction= "editproduct",
            this.productName= this.products[this.selectedVariant].name
            this.productDescription = this.products[this.selectedVariant].description
            this.productStock = this.products[this.selectedVariant].stock
            this.productPrice = this.products[this.selectedVariant].price
            this.productId = this.products[this.selectedVariant].id
            this.productPhoto = this.products[this.selectedVariant].photo
            this.productTitle = "Modifier produit "+ this.products[this.selectedVariant].name
    },

    
    addProduct(){
            this.productAction = "createproduct"
            this.productTitle = "Ajouter un produit"
            this.productName = ""
            this.productDescription = ""
            this.productStock = ""
            this.productPrice = ""
    },

     shareBill(text){
       
  if (navigator.share) {
    navigator.share({
      title: 'Facture',
      text: text,
      
    }).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }

    },


   },
   computed:{
     greatTotal(){
        if(this.livraison != 'autre')
        {selectedFee = Number(this.livraison)}
        else{
            selectedFee = Number(this.oth_fee) 
        }
        this.grtTotal = Number(this.total) + selectedFee - Number(this.remise)
        return this.grtTotal
     },

     danger(){
        
        if(this.grtTotal<=0){
            return "text-danger"
        }
     }
    }
});

    const mountedApp = app.mount('#app')


    function search2() {
    
    var input = document.getElementById("Search2");
    var filter = input.value.toLowerCase();
    var nodes = document.getElementsByClassName('target2');
    for (i = 0; i < nodes.length; i++) {
      if (nodes[i].innerText.toLowerCase().includes(filter)) {
        nodes[i].style.display = "block";
      } else {
        nodes[i].style.display = "none";
      }
    }

    
  }


   shareButton = document.getElementById("shareCatalog");


shareButton.addEventListener('click', event => {
  if (navigator.share) {
    navigator.share({
      title: 'Catalogue '+'{{$client->nom}}',
      text: "{{ url('/')}}/catalog?client={{$client->id}}",
      
    }).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }
});

 shareButton = document.getElementById("shareBill");


shareButton.addEventListener('click', event => {
  if (navigator.share) {
    navigator.share({
      title: 'Facture',
      text: $("#shareBill").val(),
      
    }).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }
});
 </script>

</body>

</html>  
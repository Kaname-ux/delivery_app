<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Mes articles</title>
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
<script src="https://unpkg.com/vue@3.0.11/dist/vue.global.js" ></script>
 <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

</head>

<body>
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
            Mes aricles
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
            <button v-on:click="addProduct" class="btn btn-primary" data-toggle="modal" data-target="#addProduct">+ Nouveau produit</button><br>
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
                            <form id="cmdform" action="command-fast-register" method="post">
                               @csrf

                               <input id="cmdid" value="" hidden name="command_id">
           <h3>Client</h3>
            <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Client</span>
  </div>
      <input id="cmdcostumer" maxlength="150" required value="{{ old('costumer') }}"  name="costumer" class="form-control" type="text" placeholder="Nom du client" >
      </div>

       <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Contact*</span>
  </div>
      <input id="cmdphone" value="{{ old('phone') }}" required  name="phone" class="form-control contact" type="number" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">
      @error('phone')
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

       <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Adresse</span>
  </div>
      <input  maxlength="150" value="{{ old('lieu') }}" id="cmdlieu" name="adresse" class="form-control" type="text" placeholder="Ex: grand carrefour... pharmacie... rivera jardin..." autocomplete="off">
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
      <select      class="form-control livreur" name="source">
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
         " required type="date" value="{{ old('delivery_date') }}" name="delivery_date" class="form-control "  id="cmddate" >
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
      <input v-model="remise" id="cmdremise"  value="{{ old('montant') }}"  name="remise" class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Remise" autocomplete="off">
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
      <select v-model="fee"  :required="fee != 'autre'"   class="form-control livraison" name="livraison">
        <option value="">Choisir tarif</option>
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

      <div class="input-group mb-2 autre" v-if="fee == 'autre'" :required="fee == 'autre'">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Autre Tarif*</span>
  </div>
      <input v-model="otherFee" name="other_liv"  value="{{ old('other_liv') }}" id="cmdothfee"  class="form-control tarif" type="number" placeholder="" >
      </div>

    


     
     



@if($client->livreurs->count() > 0)
 <div class="input-group mb-3 livreurInput">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Livreur</span>
</div>
      <select      class="form-control livreur" name="livreur">
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

      <div hidden v-for="product in products">
          <input  v-if="product.qty > 0" type="" :value="product.id+'_'+product.qty" name="products[]">
      </div>

      <div class="form-group">
      <label  class="form-label"> Information supplementaire.</label>
      <input id="comobservation" maxlength="150" value="{{ old('observation') }}"  name="observation" class="form-control border border-primary" type="text" placeholder="Information supplementaire">
      </div>


                                <div class="form-group basic">
                                    <button :disabled="grtTotal <= 0 || products.length == 0" type="submit" class="btn btn-primary btn-block btn-lg border border-primary"
                                        >Enregister</button>
                                </div>
                            </form>
                             
                            <div v-if="cart>0" v-for="(product, index) in products" :key="product.id" @mouseover="updateVariant(index)"  class="transactions mb-2">
                <!-- item -->
                <div class="item" v-if="product.qty > 0">
                
                    <div class="detail">
                        <img :src="findImage(product.photo)" alt="img" class="image-block imaged w48">
                        <div >
                           
                            <strong>@{{ product.name }}</strong>
                            
                            
                        </div>
                    </div>
                     
                     <button :disabled="product.stock > 0 ? false : true" v-on:click="addToCart()" class="btn btn-success mr-1 btn-sm">+ Panier</button>
                    <button v-if="product.qty > 0" v-on:click="removeFromCart()" class="btn btn-danger btn-sm ">-  Panier</button>
                       
                   
                    <div class="right">

                      
                       @{{ product.qty }} * @{{ product.price }} = @{{ product.price* product.qty}}<br>
                     
                      <span :class="product.stock > 0 ? 'text-success' : 'text-danger'">Stock @{{ product.stock }}</span>
                       
                        
                    </div>
                
                </div>
                <!-- * item -->
                
                
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
            <div v-for="(product, index) in products" :key="product.id" @mouseover="updateVariant(index)" class="row target2">
                <!-- item -->
                <div class="item col-sm-6 col-lg-4 mb-2">
                <a href="#" >
                    <div v-on:click="editProduct" data-toggle="modal" data-target="#productDetail" class="detail">
                        <img
                        :src="findImage(product.photo)"

                        alt="img" 
                         
                        

                         class="image-block imaged w48">
                        <div >
                           <p v-if="product.qty > 0"> @{{ product.qty }} dans le panier </p>
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
     
    <!-- Google map -->
   
 

  
  
  <script type="text/javascript">
      

    $(".contact").on('change', function() {
    
    var phone = $(this).val();
    
        $.ajax({
              url: 'phonecheck',
              type: 'post',
              data: {_token: CSRF_TOKEN,phone: phone},
              success: function(response){

                $('.contact_div').html(response.result);
             },
      
             error: function(response){
                 
               alert("Une erreur s'est produite.");
             }
            });
     
    });

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
            fee:null,
            grtTotal: 0,
            cartProducts: [],
            cart:0,
            products: {!! $products !!},
            stocks: {!! $stocks !!},
            
            
        }
    },
    methods:{ 



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
    }


   },
   computed:{
     greatTotal(){
        if(this.fee != 'autre')
        {selectedFee = Number(this.fee)}
        else{
            selectedFee = Number(this.otherFee) 
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
      text: "https://client.livreurjibiat.site/catalog?client={{$client->id}}",
      
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
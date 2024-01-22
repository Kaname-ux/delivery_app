<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Mes commandes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content=" Système de gestion pour vendeur en ligne">
    <meta name="keywords" content="venl.n ligne, livraison, livreur" />
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
 <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="https://unpkg.com/vue@3.0.11/dist/vue.global.js"></script>
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
    <!-- loader -->
    <div id="loader">
        <img src="assets/img/loading-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Mes produits
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
         
         <div class="section">
         <button class="btn btn-primary" data-toggle="modal" data-target="#addProduct">+ Nouveau produit</button>
         </div> 


        <div   class="modal fade modalbox" id="addProduct"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title editModalTitle">Ajouter un produit</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <form method="post" enctype="multipart/form-data" action="createproduct" >
                            @csrf
                            <div class="form-group">
                                <label>Nom du produit</label>
                                <input autocomplete="off" placeholder="Saisir le nom du produit" class="form-control" type="" name="name">
                                
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4" cols="4"></textarea>
                                
                            </div>

                            <div class="form-group">
                                <label>Prix</label>
                                
                                <input autocomplete="off" placeholder="Saisir le prix du produit" class="form-control" type="" name="price">
                                
                            </div>


                             <div class="form-group">
                                <label>Quantite</label>
                                
                                <input autocomplete="off" placeholder="Saisir le stock initial" class="form-control" type="" name="qty">
                                
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





        <div   class="modal fade modalbox" id="cmd"  tabindex="-1" role="dialog">
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

                          
     
      <div class="form-group">
      <label class="form-label">Date de livraison</label>
      <input 
         min="
         <?php
            echo date('Y-m-d');
            ?>
         " required type="date" value="{{ old('delivery_date') }}" name="delivery_date" class="form-control"  id="cmddate" >
      @error('delivery_date')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
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
      

      <div   class="col">
      <label class="form-label"> Saisir tarif livraison</label>
      <input v-model="fee" name="livraison"  class="form-control tarif" type="number" placeholder="" >
      </div>
     </div> 

     
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
      <input id="cmdphone" value="{{ old('phone') }}" required  name="phone" class="form-control contact" type="number" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">
      @error('phone')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror

      <span class="contact_div text-warning"></span>
      </div>         
      </div>



@if($client->livreurs->count() > 0)
<div class="form-group">
      <label class="form-label">Livreur(Vous pouvez le faire plustard)</label>
      <select      class="form-control livreur" name="livreur">
        <option value="">Choisir un livreur</option>
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
      @endif

      <div hidden v-for="product in products">
          <input  v-if="product.qty > 0" type="" :value="product.id+'_'+product.qty" name="products[]">
      </div>

      <div class="form-group">
      <label  class="form-label"> Information supplementaire.</label>
      <input id="comobservation" maxlength="150" value="{{ old('observation') }}"  name="observation" class="form-control" type="text" placeholder="Information supplementaire">
      </div>


                                <div class="form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"
                                        >Enregister</button>
                                </div>
                            </form>
                             <h3>Total: @{{ greatTotal }} </h3> 
                            <div v-if="cart>0" v-for="(product, index) in products" :key="product.id" @mouseover="updateVariant(index)"  class="transactions mb-2">
                <!-- item -->
                <div class="item" v-if="product.qty > 0">
                <a href="#" >
                    <div class="detail">
                        <img src="assets/img/sample/brand/1.jpg" alt="img" class="image-block imaged w48">
                        <div >
                           
                            <strong>@{{ product.name }}</strong>
                            
                            
                        </div>
                    </div>
                     <button :disabled="product.stock > 0 ? false : true" v-on:click="addToCart()" class="btn btn-success mr-1 btn-sm">Ajouter au panier</button>
                    <button v-if="product.qty > 0" v-on:click="removeFromCart()" class="btn btn-danger btn-sm ">Reduire du panier</button>
                       
                    </a>
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
            <div class="section-title"></div>
            <div v-for="(product, index) in products" :key="product.id" @mouseover="updateVariant(index)" class="transactions mb-2 row">
                <!-- item -->
                <div class="item col">
                <a href="#" >
                    <div class="detail">
                        <img
                        :src="findImage(product.photo)"

                        alt="img" 
                         
                        

                         class="image-block imaged w48">
                        <div >
                           <p v-if="product.qty > 0"> @{{ product.qty }} dans le panier </p>
                            <strong>@{{ product.name }}</strong>
                            <p>@{{ product.description }}</p>
                        </div>
                    </div>
                      <button  :disabled="product.stock > 0 ? false : true"  v-on:click="addToCart()" class="btn btn-success btn-sm mr-1 mt-1">Ajouter au panier</button>
                     <button v-if="product.qty > 0" v-on:click="removeFromCart()" class="btn btn-danger btn-sm  mt-1">Reduire du panier</button>
                       
                    </a>
                    <div class="right">

                    Prix:  @{{ product.price }} F<br>
                     
                      <span :class="product.stock > 0 ? 'text-success' : 'text-danger'">Stock @{{ product.stock }}</span>
                      
                      
                        
                        
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
     

     $(".contact").on('change keyup', function() {
    
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
            
            total:0,
            fee:0,
            
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
 

           console.log(this.stocks)
           console.log(this.products)

    },
 
   removeFromCart() {
        this.cart -= 1
        this.products[this.selectedVariant].qty -= 1
         this.products[this.selectedVariant].stock += 1
        this.total -= this.products[this.selectedVariant].price 
      
    },

   
    

    updateCart() {
        if(this.products[this.selectedVariant].qty > 0){
          cartProducts.push(products[this.selectedVariant].id)
        }
        
    },


    findImage(productImg){
        if(productImg == null){
            src = "assets/img/sample/brand/1.jpg"
        }
        else{
            src = "https://livreurjibiat.s3.eu-west-3.amazonaws.com/"+productImg
        }

        return src
    }

   },
   computed:{
     greatTotal(){
        return Number(this.total) + Number(this.fee)
     }
    }
});

    const mountedApp = app.mount('#app')
 </script>

</body>

</html>  
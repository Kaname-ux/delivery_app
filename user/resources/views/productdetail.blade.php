<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{$product->name}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <meta name="description" content="{{$product->description}}">
  <!-- Meta Pixel Code -->

<!-- End Meta Pixel Code -->
</head>
<body class="hold-transition sidebar-mini">
  <script src="https://unpkg.com/vue@3.0.11/dist/vue.global.js" ></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 
<!-- Site wrapper -->
<div class="wrapper" id="app">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    
  </nav>
  <!-- <div   class="modal fade " id="variantModal"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5  class="modal-title editModalTitle">Choisir variant </h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                       
                    </div>
                    <div   class="modal-body">
                       <div class="row">

                         <div class="col">
                         <img class="image-block imaged w48" :src="findImage(products[variant].photo)"  alt="img">
                         </div>  
                         <div class="col">
                         Nom du produit: <span style="font-weight: bold;">@{{ products[variant].name }}</span> 
                         </div>
                       
                       </div>

                       <div  v-for="eachvariant in products[variant].variants" class="row mt-2">
                        <div class="col">
                          @{{eachvariant.attribute}} @{{eachvariant.value}}
                        </div>
                        <div class="col">
                         <button v-if="eachvariant.qty > 0" :disabled="removeProcessing == 1 || addProcessing == 1" v-on:click="removeFromCart()" class="btn btn-light  btn-squared mr-2" href="#" >
                                 

                                 <span v-if="removeProcessing == 0">
                                 <i class="text-danger fa fa-minus"></i>
                                 </span>
                                   <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                   <span class="sr-only">Loading...</span>


                                    </button>

                                
                                <button :disabled="eachvariant.stock == 0 || removeProcessing == 1 || addProcessing == 1"   v-on:click="addToCart()" class="btn btn-warning btn-squared mr-2 bolder" >
                                 <span v-if="addProcessing == 0">
                                  <i class=" fa fa-plus"></i>
                                 </span>
                                  <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                   <span class="sr-only">Loading...</span>
                                
                               </button>
                           
                        </div>
                        
                        
                       </div>

            </div>
          </div>
        </div>

      </div> -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>@{{products[variant].name}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/catalog?client={{$client->id}}">Catalogue</a></li>
              <li class="breadcrumb-item active">@{{products[variant].name}}</li>
            </ol>
          </div>
        </div>
        <div  class="row">
          <div class="col-12 col-sm-6">

            <div class="card card-warning collapsed-card" style="transition: all 0.15s ease 0s; height: inherit; width: inherit;">
              <div class="card-header">
                <h3 class="card-title"> <ion-icon class="icon" name="cart-outline"></ion-icon>
                         Panier  @{{cart}}</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form  id="cmdform" action="command-from-catalog" method="post">
                               @csrf
                     <div class="input-group mb-3">
                   <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">Nom</span>
                   </div>
              <input id="cmdcostumer" maxlength="150" required value="{{ old('costumer') }}"  name="costumer" class="form-control" type="text" placeholder="Votre nom" >
              </div>
            <input hidden value="{{$client->id}}"  class="form-control " name="client">
          
     
              <div class="input-group mb-3">
            <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">Date de livraison</span>
         </div>
           <input 
         min="
         <?php
            echo date('Y-m-d');
            ?>
         " required type="date" value="{{ old('delivery_date') }}" name="delivery_date" class="form-control border border-primary"  id="cmddate" >
      @error('delivery_date')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      

       <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Ville/Commune</span>
  </div>
     
      <select id="cmddestination"  required  class="form-control border border-primary" name="fee">
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

      
    


      <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Precision</span>
  </div>
      <input maxlength="150" value="{{ old('lieu') }}" id="cmdlieu" name="adresse" class="form-control border border-primary" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." >
      </div>
      <div class="form-row mb-3">
        <div class="col">
          <label class="form-label">Indicatif</label>
          <select class="form-control">
            <option>+225</option>
          </select>
        </div>
        <div class="col-8">
      <label class="form-label">Contact</label>
      <input id="cmdphone" value="{{ old('phone') }}" required  name="phone" class="form-control contact border border-primary" type="number" placeholder="Votre numero"  autocomplete="off">
      @error('phone')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror

      <span class="contact_div text-warning"></span>
      </div>         
      </div>





      <div hidden v-for="product in products">
          <input  v-if="product.qty > 0" type="" :value="product.id+'_'+product.qty" name="products[]">
      </div>

      <div class="form-group">
      <label  class="form-label"> Information supplementaire.</label>
      <input id="comobservation" maxlength="150" value="{{ old('observation') }}"  name="observation" class="form-control border border-primary" type="text" placeholder="Ex: livrer avant midi...">
      </div>


                                <div class="form-group basic">
                                    <button :disabled="!cart" type="submit" class="btn btn-primary btn-block btn-lg border border-primary"
                                        >Commander</button>
                                </div>
                            </form>

                             <h3>Total: @{{ greatTotal }} (NB: les frais de livraion seront ajoutés a ce total)</h3> 
                            <div v-if="cart>0" v-for="(product, index) in products" :key="product.id" @mouseover="updateVariant(index)" class="card card-widget widget-user-2 shadow-sm">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div v-if="product.qty > 0" class="widget-user-header bg-warning">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" :src="findImage(product.photo)" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">@{{ product.name }}</h3>
                <h5 class="widget-user-desc">@{{ product.qty }} * @{{ product.price }} = @{{ product.price* product.qty}}</h5>

                <ul class="nav flex-column">
                  
                  <li class="nav-item">
                    <!-- <span v-if="products[variant].variants.length > 0">
                         <button data-toggle="modal" data-target="#variantModal" class="btn btn-warning squared mr-2 btn-block btn-lg bold" >
                                    
                                        <i class="fa fa-x2 fa-cart-plus mr-4"></i>ACHETER
                                   
                                    

                                
                               </button>         
                    </span> -->
                    <span >
                    <button v-if="products[variant].qty > 0" :disabled="removeProcessing == 1 || addProcessing == 1" v-on:click="removeFromCart()" class="btn btn-light  btn-squared mr-2" href="#" >
                                 

                                 <span v-if="removeProcessing == 0">
                                 <i class="text-danger fa fa-minus"></i>
                                 </span>
                                   <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                   <span class="sr-only">Loading...</span>


                                    </button>

                                  <button :disabled="products[variant].stock == 0  || removeProcessing == 1 || addProcessing == 1" v-if="products[variant].qty"  v-on:click="addToCart()" class="btn btn-warning squared mr-2 btn-block btn-lg bold" >
                                    <span v-if="addProcessing == 0">
                                        <i class="fa fa-x2 fa-cart-plus mr-4"></i>ACHETER
                                    </span>

                                    <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                   <span class="sr-only">Loading...</span>
                                    

                                
                               </button>  
                                <button :disabled="products[variant].stock == 0 || removeProcessing == 1 || addProcessing == 1"  v-if="cart > 0" v-on:click="addToCart()" class="btn btn-warning btn-squared mr-2 bolder" >
                                 <span v-if="addProcessing == 0">
                                  <i class=" fa fa-plus"></i>
                                 </span>
                                  <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                   <span class="sr-only">Loading...</span>
                                
                               </button>
                               </span>
                               
                  </li>
                  
                </ul>
              </div>
              
            </div>
                            <div v-else>
                                Aucum produit dans le panier
                            </div>
              </div>
              <!-- /.card-body -->
            </div>

          </div>
          </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
     @if (session('status'))
      <div class="alert alert-success mb-1" role="alert">
      {!! session('status') !!}
      </div>
      @endif
      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div @mouseover="updateVariant(variant)" class="row">
            <div class="col-12 col-sm-6">
              <h3 class="d-inline-block d-sm-none">@{{products[variant].name}}</h3>
              <div class="col-12">
                <img :src="findImage(products[variant].photo)" class="product-image" alt="Product Image">
              </div>
              <div class="col-12 product-image-thumbs">
                <div class="product-image-thumb active"><img :src="findImage(products[variant].photo)" alt="Product Image"></div>
                <div v-if="products[variant].images.length > 0" v-for="image in products[variant].images" class="product-image-thumb" ><img :src="'https://livreurjibiat.s3.eu-west-3.amazonaws.com/'+image.path" alt="Product Image"></div>
                
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <h3 class="my-3">@{{products[variant].description}}</h3>
              <p>@{{products[variant].description}}</p>

               <hr>
              
              
              <!-- <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center active">
                  <input type="radio" name="color_option" id="color_option_a1" autocomplete="off" checked>
                  Green
                  <br>
                  <i class="fas fa-circle fa-2x text-green"></i>
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_a2" autocomplete="off">
                  Blue
                  <br>
                  <i class="fas fa-circle fa-2x text-blue"></i>
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_a3" autocomplete="off">
                  Purple
                  <br>
                  <i class="fas fa-circle fa-2x text-purple"></i>
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_a4" autocomplete="off">
                  Red
                  <br>
                  <i class="fas fa-circle fa-2x text-red"></i>
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_a5" autocomplete="off">
                  Orange
                  <br>
                  <i class="fas fa-circle fa-2x text-orange"></i>
                </label>
              </div> -->

              <!-- <h4 class="mt-3">Size <small>Please select one</small></h4>
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_b1" autocomplete="off">
                  <span class="text-xl">S</span>
                  <br>
                  Small
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_b2" autocomplete="off">
                  <span class="text-xl">M</span>
                  <br>
                  Medium
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_b3" autocomplete="off">
                  <span class="text-xl">L</span>
                  <br>
                  Large
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_b4" autocomplete="off">
                  <span class="text-xl">XL</span>
                  <br>
                  Xtra-Large
                </label>
              </div> -->

              <div class="bg-gray py-2 px-3 mt-4">
                <h2 class="mb-0">
                  @{{products[variant].price}} FCFA
                </h2>
                
              </div>

              <div class="mt-4">
              <!--   <span v-if="products[variant].variants.length > 0">
                         <button data-toggle="modal" data-target="#variantModal" class="btn btn-warning squared mr-2 btn-block btn-lg bold" >
                                    
                                        <i class="fa fa-x2 fa-cart-plus mr-4"></i>ACHETER
                                   
                                    

                                
                               </button>         
                    </span> -->
                    <span >
                    <button v-if="products[variant].qty > 0" :disabled="removeProcessing == 1 || addProcessing == 1" v-on:click="removeFromCart()" class="btn btn-light  btn-squared mr-2" href="#" >
                                 

                                 <span v-if="removeProcessing == 0">
                                 <i class="text-danger fa fa-minus"></i>
                                 </span>
                                   <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                   <span class="sr-only">Loading...</span>


                                    </button>

                                  <button :disabled="products[variant].stock == 0  || removeProcessing == 1 || addProcessing == 1" v-if="cart == 0"  v-on:click="addToCart()" class="btn btn-warning squared mr-2 btn-block btn-lg bold" >
                                    <span v-if="addProcessing == 0">
                                        <i class="fa fa-x2 fa-cart-plus mr-4"></i>ACHETER
                                    </span>

                                    <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                   <span class="sr-only">Loading...</span>
                                    

                                
                               </button>  
                                <button :disabled="products[variant].stock == 0 || removeProcessing == 1 || addProcessing == 1"  v-if="cart > 0" v-on:click="addToCart()" class="btn btn-warning btn-squared mr-2 bolder" >
                                 <span v-if="addProcessing == 0">
                                  <i class=" fa fa-plus"></i>
                                 </span>
                                  <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                   <span class="sr-only">Loading...</span>
                                
                               </button>
                               </span><br>
                               @{{ products[variant].qty }} dans le panier
              </div>

             <!--  <div class="mt-4 product-share">
                <a href="#" class="text-gray">
                  <i class="fab fa-facebook-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fab fa-twitter-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fas fa-envelope-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fas fa-rss-square fa-2x"></i>
                </a>
              </div> -->

            </div>
          </div>
          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Video</a>
                <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">Comments</a>
                <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="false">Note</a>
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
              <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab"> </div>
              <div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab"></div>
              <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab"> </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
  <script type="text/javascript">
   const app = Vue.createApp({
    data() {
        return {
            selectedVariant: 0,
            productAction: "createproduct",
            productName: "",
            productDescription: "",
            productStock:"",
            productQty:"",
            productPrice:"",
            productId:"",
            productPhoto:"",
            addProcessing:0,
            removeProcessing:0,
            productTitle:"Ajouter un produit",
            total:{{$total}},
            fee:0,
            qty:0,
            variant:{{ $variant }},
            cartProducts: [],
            cart:{{$cart}},
            products: {!! $products !!},
            stocks: {!! $stocks !!},
            
            
        }
    },
    methods:{ 



        updateVariant(index) {
        this.selectedVariant = index
        
    },




        addToCart() {
           
         this.products[this.selectedVariant].stock -=  1
         this.cart += 1
          this.products[this.selectedVariant].qty  += 1
         vm = this
        this.addProcessing = 1
         axios.post('/updatesession', {
        products: JSON.stringify(vm.products),
        cart: vm.cart,
        type:"add",
        stocks:vm.stocks,
        total:vm.total,
        id: vm.products[vm.selectedVariant].id,
    _token: CSRF_TOKEN,
  })

         
  .then(function (response) {
    if(Number(response.data.stock) < 1)
   {vm.products[vm.selectedVariant].stock =  0
       vm.cart -= 1
        vm.products[vm.selectedVariant].qty = 0
        vm.productQty = 0
        }
     vm.addProcessing = 0
   
  })
  .catch(function (error) {
    vm.addProcessing = 0
    console.log(error);
  }); 
 
         
    },
 
   removeFromCart() {
        this.removeProcessing = 1
         this.products[this.selectedVariant].stock +=  1
         this.cart -= 1
          this.products[this.selectedVariant].qty  -= 1

          this.productQty -= 1
        
        
        vm = this
       
         axios.post('/updatesession', {
         products: JSON.stringify(vm.products),
        cart: vm.cart,
        stocks:vm.stocks,
        type:"remove",
       id: vm.products[vm.selectedVariant].id,
        total:vm.total,
        _token: CSRF_TOKEN,
  })

         
  .then(function (response) {

      
       vm.removeProcessing = 0

        
        
         
  })
  .catch(function (error) {
    console.log(error);
    vm.removeProcessing = 0
  }); 
      
    },




     addVariantToCart(index) {
           
         this.products[this.selectedVariant].variants[index].stock -=  1
         this.cart += 1
          this.products[this.selectedVariant].variants[index].qty  += 1
         vm = this
        this.addProcessing = 1
         axios.post('/updatesession', {
        products: JSON.stringify(vm.products),
        cart: vm.cart,
        type:"addvariant",
        stocks:vm.stocks,
        total:vm.total,
        id: vm.products[vm.selectedVariant].variants[index].id,
        _token: CSRF_TOKEN,
  })

         
  .then(function (response) {
    if(Number(response.data.stock) < 1)
   {vm.products[vm.selectedVariant].variants[index].stock =  0
       vm.cart -= 1
        vm.products[vm.selectedVariant].variants[index].qty = 0
        
        }
     vm.addProcessing = 0
   
  })
  .catch(function (error) {
    vm.addProcessing = 0
    console.log(error);
  }); 
 
         
    },
 
   removeVariantFromCart() {
        this.removeProcessing = 1
         this.products[this.selectedVariant].variants[index].stock +=  1
         this.cart -= 1
          this.products[this.selectedVariant].variants[index].qty  -= 1

        
        
        vm = this
       
         axios.post('/updatesession', {
         products: JSON.stringify(vm.products),
        cart: vm.cart,
        stocks:vm.stocks,
        type:"removevariant",
       id: vm.products[vm.selectedVariant].variants[index].id,
        total:vm.total,
        _token: CSRF_TOKEN,
  })

         
  .then(function (response) {

      
       vm.removeProcessing = 0

        
        
         
  })
  .catch(function (error) {
    console.log(error);
    vm.removeProcessing = 0
  }); 
      
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
            this.productQty = this.products[this.selectedVariant].qty
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
        total = 0;
        for(x=0; x< this.products.length; x++){
          if(this.products[x].qty > 0){
            total += this.products[x].price*this.products[x].qty 
          }
        }
        return  total
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
 </script>
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
     <script src="../assets/js/commands.js"></script>
<script>
  $(document).ready(function() {
    $('.product-image-thumb').on('click', function () {
      var $image_element = $(this).find('img')
      $('.product-image').prop('src', $image_element.attr('src'))
      $('.product-image-thumb.active').removeClass('active')
      $(this).addClass('active')
    })
  })
</script>
</body>
</html>

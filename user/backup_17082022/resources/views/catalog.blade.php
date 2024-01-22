<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Catalogue {{$client->nom}}</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Catalogue de {{$client->nom}}">
    <meta name="keywords" content="{{$client->nom}}, jibiat catalogue, vente en ligne" />
    <link rel="apple-touch-icon" size="180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href=".../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../img/favicon.png">
   
    

     <link rel = " manifest " href="../assets/manifest/client.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo-icon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }

 /* Candidate List */
.candidate-list {
  background: #ffffff;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  border-bottom: 1px solid #eeeeee;
  
      
  padding: 20px;
  -webkit-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out; }
  .candidate-list:hover {
    -webkit-box-shadow: 0px 0px 34px 4px rgba(33, 37, 41, 0.06);
            box-shadow: 0px 0px 34px 4px rgba(33, 37, 41, 0.06);
    position: relative;
    z-index: 99; }
    .candidate-list:hover a.candidate-list-favourite {
      color: #e74c3c;
      -webkit-box-shadow: -1px 4px 10px 1px rgba(24, 111, 201, 0.1);
              box-shadow: -1px 4px 10px 1px rgba(24, 111, 201, 0.1); }

.candidate-list .candidate-list-image {
  margin-right: 25px;
  -webkit-box-flex: 0;
      -ms-flex: 0 0 80px;
          flex: 0 0 80px;
  border: none; }
  .candidate-list .candidate-list-image img {
    width: 80px;
    height: 70px;
    -o-object-fit: cover;
       object-fit: cover; }

.candidate-list-title {
  margin-bottom: 5px; }
img {
    margin-top: 10px;
}
.candidate-list-details ul {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
      flex-wrap: wrap;
  margin-bottom: 0px; }
  .candidate-list-details ul li {
    margin: 5px 10px 5px 0px;
    font-size: 13px; }

.candidate-list .candidate-list-favourite-time {
  margin-left: auto;
  text-align: center;
  font-size: 13px;
  -webkit-box-flex: 0;
      -ms-flex: 0 0 90px;
          flex: 0 0 90px; }
  .candidate-list .candidate-list-favourite-time span {
    display: block;
    margin: 0 auto; }
  .candidate-list .candidate-list-favourite-time .candidate-list-favourite {
    display: inline-block;
    position: relative;
    height: 40px;
    width: 40px;
    line-height: 40px;
    border: 1px solid #eeeeee;
    border-radius: 100%;
    text-align: center;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    margin-bottom: 20px;
    font-size: 16px;
    color: #646f79;
    }
    .candidate-list .candidate-list-favourite-time .candidate-list-favourite:hover {
      background: #ffffff;
      color: #e74c3c; }

.candidate-banner .candidate-list:hover {
  position: inherit;
  -webkit-box-shadow: inherit;
          box-shadow: inherit;
  z-index: inherit; }


/* Candidate Grid */
.candidate-list.candidate-grid {
    padding: 0px;
    display: block;
    border-bottom: none;
}

.candidate-grid .candidate-list-image {
    text-align: center;
    margin-right: 0px;
}
.candidate-grid .candidate-list-image img {
    height: 210px;
    width: 80%;
}

.candidate-grid .candidate-list-details {
    text-align: center;
    padding: 20px 20px 0px 20px;
    border: 1px solid #eeeeee;
    border-top: none;
}
.candidate-grid .candidate-list-details ul {
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
.candidate-grid .candidate-list-details ul li {
    margin: 2px 5px;
}

.candidate-grid .candidate-list-favourite-time {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    border-top: 1px solid #eeeeee;
    margin-top: 10px;
    padding: 10px 0;
}
.candidate-grid .candidate-list-favourite-time a {
    margin-bottom: 0;
    margin-left: auto;
}
.candidate-grid .candidate-list-favourite-time span {
    display: inline-block;
    margin: 0;
    -ms-flex-item-align: center;
    align-self: center;
}

.candidate-list.candidate-grid .candidate-list-favourite-time .candidate-list-favourite {
    margin-bottom: 0px;
}

.owl-carousel .candidate-list.candidate-grid {
    margin-bottom: 20px;
}


/* Widget */
.widget .widget-title {
    margin-bottom: 20px;
}
.widget .widget-title h6 {
    margin-bottom: 0;
}
.widget .widget-title a {
    color: #212529;
}

.widget .widget-collapse {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    margin-bottom: 0;
}

/* similar-jobs-item */
.similar-jobs-item .job-list {
    border-bottom: 0;
    padding: 0;
    margin-bottom: 15px;
}
.similar-jobs-item .job-list:last-child {
    margin-bottom: 0;
}
.similar-jobs-item .job-list:hover {
    -webkit-box-shadow: none;
    box-shadow: none;
}

/* checkbox */
.widget .widget-content {
    margin-top: 10px;
}
.widget .widget-content .custom-checkbox {
    margin-bottom: 8px;
}
.widget .widget-content .custom-checkbox:last-child {
    margin-bottom: 0px;
}

.widget .custom-checkbox.fulltime-job .custom-control-label:before {
    background-color: #186fc9;
    border: 2px solid #186fc9;
}

.widget .custom-checkbox.fulltime-job .custom-control-input:checked ~ .custom-control-label:before {
    background: #186fc9;
    border-color: #186fc9;
}

.widget .custom-checkbox.parttime-job .custom-control-label:before {
    background-color: #ffc107;
    border: 2px solid #ffc107;
}

.widget .custom-checkbox.parttime-job .custom-control-input:checked ~ .custom-control-label:before {
    background: #ffc107;
    border-color: #ffc107;
}

.widget .custom-checkbox.freelance-job .custom-control-label:before {
    background-color: #53b427;
    border: 2px solid #53b427;
}

.widget .custom-checkbox.freelance-job .custom-control-input:checked ~ .custom-control-label:before {
    background: #53b427;
    border-color: #53b427;
}

.widget .custom-checkbox.temporary-job .custom-control-label:before {
    background-color: #e74c3c;
    border: 2px solid #e74c3c;
}

.widget .custom-checkbox.temporary-job .custom-control-input:checked ~ .custom-control-label:before {
    background: #e74c3c;
    border-color: #e74c3c;
}

.widget ul {
    margin: 0;
}
.widget ul li a:hover {
    color: #21c87a;
}

.widget .company-detail-meta ul {
    display: block;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}
.widget .company-detail-meta ul li {
    margin-right: 15px;
    display: inline-block;
}
.widget .company-detail-meta ul li a {
    color: #646f79;
    font-weight: 600;
    font-size: 12px;
}

.widget .company-detail-meta .share-box li {
    margin-right: 0;
    display: inline-block;
    float: left;
}

.widget .company-detail-meta ul li.linkedin a {
    padding: 15px 20px;
    border: 2px solid #eeeeee;
    display: inline-block;
}
.widget .company-detail-meta ul li.linkedin a i {
    color: #06cdff;
}

.widget .company-address ul li {
    margin-bottom: 10px;
}
.widget .company-address ul li:last-child {
    margin-bottom: 0;
}
.widget .company-address ul li a {
    color: #646f79;
}

.widget .widget-box {
    padding: 20px 15px;
}

.widget .similar-jobs-item .job-list.jobster-list {
    padding: 15px 10px;
    border: 0;
    margin-bottom: 10px;
}

.widget .similar-jobs-item .job-list {
    padding-bottom: 15px;
}

.widget .similar-jobs-item .job-list-logo {
    margin-left: auto;
    -webkit-box-flex: 0;
    -ms-flex: 0 0 60px;
    flex: 0 0 60px;
    height: 60px;
    width: 60px;
}

.widget .similar-jobs-item .job-list-details {
    margin-right: 15px;
    -ms-flex-item-align: center;
    align-self: center;
}
.widget .similar-jobs-item .job-list-details .job-list-title h6 {
    margin-bottom: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.widget .similar-jobs-item .job-list.jobster-list .job-list-company-name {
    color: #21c87a;
}

.widget .docs-content {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    background: #eeeeee;
    padding: 30px;
    border-radius: 3px;
}
.widget .docs-content .docs-text {
    -ms-flex-item-align: center;
    align-self: center;
    color: #646f79;
}
.widget .docs-content span {
    font-weight: 600;
}
.widget .docs-content .docs-icon {
    margin-left: auto;
    -webkit-box-flex: 0;
    -ms-flex: 0 0 38px;
    flex: 0 0 38px;
}

/* Job Detail */
.widget .jobster-company-view ul li {
    border: 1px solid #eeeeee;
    margin-bottom: 20px;
}
.widget .jobster-company-view ul li:last-child {
    margin-bottom: 0;
}
.widget .jobster-company-view ul li span {
    color: #212529;
    -ms-flex-item-align: center;
    align-self: center;
    font-weight: 600;
}

.sidebar .widget {
    border: 1px solid #eeeeee;
    margin-bottom: 30px;
}
.sidebar .widget .widget-title {
    border-bottom: 1px solid #eeeeee;
    padding: 14px 20px;
}

.sidebar .widget .widget-content {
    padding: 14px 20px;
}
.widget .widget-content {
    margin-top: 10px;
}
    
 
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
            <!-- <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a> -->
        </div>
        <div class="pageTitle">
            Catalogue 
        </div>
        <div class="right">
            <a v-if="cart > 0" href="#" data-toggle="modal" data-target="#cmd" class="headerButton ">
                <ion-icon class="icon" name="cart-outline"></ion-icon>
                <span   class="badge badge-danger">@{{ cart }}</span>

            </a>
            
        </div>
    </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule">
        @if (session('status'))
      <div class="alert alert-success mb-1" role="alert">
      {!! session('status') !!}
      </div>
      @endif
         
         <div class="section">
        <form action="?">
           <input hidden name="client" value="{{$client->id}}">
            <div class="form-group searchbox mt-2">
               
                <input name="search" type="text" class="form-control">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
                <button class="btn btn-primary">Rechercher</button>
            </div>       
    </form>

         
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
                        Description: @{{ productDescription }} <br>

                           
                       </div>


                        
                        
                </div>
            </div>
        </div>

      </div>




        <div   class="modal fade" id="cmd"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title editModalTitle">Panier</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <div  class="action-sheet-content selectedProducts">
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
                                        >Enregister</button>
                                </div>
                            </form>
                             <h3>Total: @{{ greatTotal }} (sans la livraison)</h3> 
                            <div v-if="cart>0" v-for="(product, index) in products" :key="product.id" @mouseover="updateVariant(index)"  class="transactions mb-2">
                <!-- item -->
                <div class="item" v-if="product.qty > 0">
                <a href="#" >
                    <div class="detail">
                        <img :src="findImage(product.photo)" alt="img" class="image-block imaged w48">
                        <div >
                           
                            <strong>@{{ product.name }}</strong>
                            
                            
                        </div>
                    </div>

                     <button :disabled="product.stock > 0 ? false : true" v-on:click="addToCart()" class="btn btn-success mr-1 btn-sm">+ Panier</button>
                    <button v-if="product.qty > 0" v-on:click="removeFromCart()" class="btn btn-danger btn-sm ">-  Panier</button>
                       
                    </a>
                    <div class="right">

                      
                       @{{ product.qty }} * @{{ product.price }} = @{{ product.price* product.qty}}<br>
                        <br>
                      
                       
                        
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
        <div class="section ">
            <div class="section-title">{!! $title !!}</div>


            <div   class="transactions mb-2">
                <!-- item -->
                <div class="item" >
                <a href="#" >
                    <div class="detail">
                        <img @if($client->photo != NULL)
                          src="{{Storage::disk('s3')->url($client->photo)}}" 
                         @else src="assets/img/sample/brand/1.jpg" @endif alt="img" class="image-block imaged w48">
                        <div >
                           
                            <h2>{{ $client->nom }}</h2>
                            
                            
                        </div>
                    </div>

                       
                    </a>
                   
                
                </div>
                <!-- * item -->
                
                
                            </div>
       <div class="transactions">
              
                
                <!-- item -->
             <div class="container ">

                <div class="row">
               <div v-for="(product, index) in products" :key="product.id" @mouseover="updateVariant(index)" class="col-sm-6 col-lg-4  mb-4  target2">
                    <div class="candidate-list candidate-grid ">
                        <div @click="editProduct" data-toggle="modal" data-target="#productDetail" class="candidate-list-image ">
                            <img class="img-fluid" 
                            :src="findImage(product.photo)" alt="">
                        </div>
                        <div class="candidate-list-details">
                            <div class="candidate-list-info">
                                <div class="candidate-list-title">
                                    <h2><a data-toggle="modal" data-target="#productDetail" href="#" @click="editProduct" >@{{ product.name }}</a><br>@{{ product.price }} F</h2>
                                </div>

                                <div class="candidate-list-option">
                                    <ul class="list-unstyled">
                                     
                                        <li>@{{ product.description }}</li>

                                        <li  class="pr-1">
                                         
                                        </li>

                                        
                                    </ul>
                                </div>
                               
                            </div>
                            <div class="candidate-list-favourite-time">
                            
                             
                                


                               
                                

                                 <button v-if="product.qty > 0" v-on:click="removeFromCart()" class="candidate-list-favourite order-2 mr-2" href="#" >
                                 <i class="text-danger fa fa-minus"></i>

                                    </button>
                                <button :disabled="product.stock > 0 ? false : true"  v-on:click="addToCart()" class="candidate-list-favourite order-1 " ><i class="fa fa-plus text-success"></i></button>
                                
                               
                                   <span class="order-2" v-if="product.qty > 0"> @{{ product.qty }} dans le panier </span>

                              
                            </div>
                        </div>
                    </div>
                </div>
               
                <!-- * item -->
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
    @auth
     @include("includes.bottom")
    @include("includes.sidebar")
    @endauth
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
      

     document.querySelector(".contact").addEventListener('change keyup', function() {
    
    var phone = document.querySelector(this).value;
    
        $.ajax({
              url: 'phonecheck',
              type: 'post',
              data: {_token: CSRF_TOKEN,phone: phone},
              success: function(response){

                document.querySelector('.contact_div').html(response.result);
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
            productPhoto:"",
            productTitle:"Ajouter un produit",
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
        return Number(this.total) + Number(this.fee)
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

</body>

</html>  
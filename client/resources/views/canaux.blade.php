<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Mes Canaux</title>
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
<script src="https://unpkg.com/vue@3.0.11/dist/vue.global.js" ></script>
 <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

</head>

<body>
  <div id="app">
     

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Mes Canaux
        </div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule">
         <div class="section">
         <button v-on:click="addCanal" class="btn btn-primary" data-toggle="modal" data-target="#addCanal">+ Nouveau canal</button>

         <div class="form-group searchbox mt-2">
                <input onkeyup="search2()" id="Search2" type="text" class="form-control">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
            </div>
         </div> 


        <div class="modal fade modalbox" id="addCanal"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addCanal" class="modal-title editModalTitle">@{{ canalTitle }}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <form method="post"  :action="action" >
                            @csrf

                            <input hidden :value="canalId" name="id">
                            <div class="form-group border-primary">
                                <label>Type</label>
                                <select :selected="type" v-model="type" name="type" class="form-control border border-primary">
                                    <option value="">Choisir type</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Whatsapp">Whatsapp</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Appel">Appel</option>
                                    <option value="sms">sms</option>
                                    <option value="Autre">Autre</option>
                                </select>
                                
                                
                            </div>

                            <div v-if="type == 'Facebook' || type == 'Instagram'" class="form-group">
                                <label>Saisir la nom de la page</label>
                                <input :value="antity"  placeholder="Nom de la page" class="form-control border border-primary" type="" name="antity">
                                
                            </div>
                           
                            
                            <div v-if="type == 'Appel' || type == 'sms' || type == 'Whatsapp'" class="form-group">
                                <label>Saisir le numero</label>
                                <input :value="antity"  placeholder="Numero de telephone" class="form-control border border-primary" type="number" name="antity">
                                
                            </div>
                            <div v-if="type == 'Autre' " class="form-group">
                                <label>Preciser la nature</label>
                                <input :value="antity" placeholder="Nature du canal" class="form-control border border-primary" type="" name="antity">
                                
                            </div>

                            <div class="form-group">
                                <label>Description (Facultatif)</label>
                                
                                <textarea class="form-control border border-primary" :value="description" rows="4" cols="4"></textarea>
                                
                            </div>



                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                        
                </div>
            </div>
        </div>
      </div>
     

      <div class="modal fade dialogbox" id="deleteCanal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"></h5>
                       

                    </div>
                    
                    <div class="modal-body" >
                      <form method="post" action="deletecanal">
                        @csrf
                        <input hidden :value="canalId" name="id">
                          <button type="submit" class="btn btn-danger" >Confirmer</button>
                          <button type="button" class="btn btn-secondary" class="close" data-dismiss="modal">Annuler</button>
                      </form>
                        
                   
                    </div>
                   
                </div>
            </div>
        </div>


        <!-- Transactions -->
        <div class="section mt-2">
            <div class="section-title"></div>


            <div v-for="(canal, index) in canaux" :key="canal.id" @mouseover="updateVariant(index)" class="transactions mb-2 row target2">
                <!-- item -->
                <div class="item col">
                <a href="#" >
                    <div class="detail">
                        <img
                        :src="findImage()"

                        alt="img" 
                         
                        

                         class="image-rounded imaged w48">
                        <div >
                          
                            <strong>@{{ canal.antity }}</strong>
                            <p>@{{ canal.type }}</p>
                        </div>
                    </div>
                    
                      
                       
                    </a>
                    <div class="right">

                    <button data-toggle="modal" data-target="#addCanal" v-on:click="editCanal" class="btn btn-primary btn-sm mr-1"><ion-icon name="pencil-outline"></ion-icon></button>
                     
                      
                      <button v-on:click="editCanal"  data-toggle="modal" data-target="#deleteCanal" class="btn btn-danger btn-sm mr-1"><ion-icon name="trash-outline"></ion-icon></button>
                      
                      
                        
                        
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
            action: "createcanal",
            type: "",
            description:"",
            antity:"",
            canalId:"",
            canalTitle:"Ajouter un canal",
           canaux: {!! $canaux !!},
           
            
            
        }
    },
    methods:{ 


        updateVariant(index) {
        this.selectedVariant = index
        
    },



    findImage(productImg = null){
        if(productImg == null){
            src = "assets/img/sample/brand/1.jpg"
        }
        else{
            src = "https://livreurjibiat.s3.eu-west-3.amazonaws.com/"+productImg
        }

        return src
    },

    deleteCanal(){
        this.canalId = this.canaux[this.selectedVariant].id
    },

    editCanal(){
            this.action= "editcanal",
            this.antity = this.canaux[this.selectedVariant].antity
            this.description = this.canaux[this.selectedVariant].description
            this.type = this.canaux[this.selectedVariant].type
            this.canalId = this.canaux[this.selectedVariant].id
            this.canalTitle = "Modifier canal "+ this.canaux[this.selectedVariant].type + ": "+ this.canaux[this.selectedVariant].antity
    },

    
    addCanal(){
            this.action= "createcanal"
            this.antity = ""
            this.description = ""
            this.type = ""
            this.canalId = ""
            this.canalTitle = "Ajouter canal"
    }


   },
   computed:{
     
    }
});

    const mountedApp = app.mount('#app')
    </script>

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
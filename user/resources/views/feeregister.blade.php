<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nouveau tarif</title>
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


</head>

<body>
    <script src="https://unpkg.com/vue@3.0.11/dist/vue.global.js" ></script>
 <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
  <div id="app">
     

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="fees" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Nouveau tarif
        </div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule" class="mt-2">
         <div class="section">
             @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
             <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Ajouter tarifs</h3>

                <div class="card-tools">
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body " >
                <div class="row">
                    <div class="col-md-6">
                         @if($fee_roles->contains('action', 'TARIF_C'))
                <form action="/fee-register" method="POST">
                        @csrf
                       
                        <div class="form-group">
              <label>Destination</label>
                            <input value="" name="destination" class="form-control" type="text" placeholder="Destination" required>
                        </div>

                        <div class="form-group">
              <label>Tarif intra</label>
                            <input  value="" name="price" class="form-control" type="number" placeholder="Price">
                            <span></span>
                        </div>

            <div class="form-group">
              <label>Tarif extra</label>
                            <input  value="" name="extraprice" class="form-control" type="number" placeholder="Price">
                            <span></span>
            </div>

                        <div class="form-group">
              <label>Zone</label>
                            <select required name="zone" class="form-control">
                                <option value="">Choisir une zone</option>
                                <option value="ABJ_NORD">Abidjan Nord</option>
                                <option value="ABJ_SUD">Abidjan Sud</option>
                                <option value="ABOBO">Abobo</option>
                                <option value="COCODY2">Cocody</option>
                                <option value="COCODY1">Rivera-Bingerville</option>
                                <option value="YOPOUGON">Yopougon</option>
                                <option value="INTERIEUR">Interieur</option>
                                
                                
                            </select>
                        </div>

                        

                        <button type="submit" class="btn btn-success">Valider</button>
                        <a href="/fees" class="btn btn-danger">Annuler</a>
                        
                        
                    </form>
                    @else
                    Action interdite! Contactez l'ADMIN.
                    @endif
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
         </div>
    </div>
        


    </div>

    <script>
         const app = Vue.createApp({
    data() {
        return {
            
           
            
            
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
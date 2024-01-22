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
   
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" >

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
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Tarifs de livrison
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
         <div class="modal fade " id="priceModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="selected != null">AJouter tarif @{{fees[selected].destination}}</h5>
                        <a id="bulkActionClose" href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                               <div class="alert alert-success" v-if="success != ''">@{{success}}</div>
                                 <div class="form-group">
                                  <label>Type de tarif</label>
                                  <input v-model="name" type="" name="typetarif" class="form-control">
                                </div>

                                <div class="form-group row">
                                  <div class="col">
                                     <label>Tarif intra zone</label>
                                  <input v-model="intraprice" type="number" name="intraprice" class="form-control">
                                  </div>

                                  <div class="col">
                                     <label>Tarif extra zone</label>
                                  <input v-model="extraprice" type="number" name="extraprice" class="form-control">
                                  </div>
                                 
                                </div>

                                <div class="form-group">
                                  <label>Delai(en jour)</label>
                                  <input v-model="description" type="number" name="description" class="form-control">
                                </div>

                                <button @click="updatePrice" :disabled="id == '' || description == '' || intraprice == '' || extraprice == '' || name == '' || processing == 1" class="btn btn-primary btn-block">Enregistrer</button>
                             
                            <hr>
                            <div v-if='selected != null'>
                              <div v-if="fees[selected].tarifs.length > 0">
                              <div class="alert alert-success" v-if="editSuccess != ''">@{{editSuccess}}</div>
                              <h5>Modifier tarifs</h5>
                              <div class="card border" v-for="tarif in fees[selected].tarifs">
                                <div class="card-body">
                              <form class="form-inline "  >
                              <div class="form-group row">

                                <div class="col">
                                  <label>Type</label>
                                   <input :id="'name'+tarif.id" class="form-control" type="" :value="tarif.name" name="">
                                </div>


                                <div class="col">
                                  <label>Intra</label>
                                <input :id="'prc'+tarif.id" class="form-control" type="number" :value="tarif.price" name="">
                                </div>

                                

                               
                              </div>
                              <div class="form-group row">

                                   <div class="col">
                                  <label>Extra</label>
                                <input :id="'prcextra'+tarif.id" class="form-control" type="number" :value="tarif.extraprice" name="">
                                </div>

                               

                                <div class="col">
                                  <label>Delai(jour)</label>
                                  <input :id="'desc'+tarif.id" class="form-control" type="number" :value="tarif.description" name="">
                                </div>


                                <div class="col">
                                   <button :disabled="processing == 1"  @click="updateTarif(tarif.id)" type="button" class="btn  btn-primary mr-1">modifer</button>

                                 <button @click="deleteTarif(tarif.id)" :disabled="processing == 1" type="button" class="btn  btn-danger"><i   name="btn" value="Supprimer"  class="fas fa-trash"  ></i></button>
                                </div>
                                
                              </div>
                              
                              </form>
                            </div>
                          </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade " id="confirmModal" tabindex="-1" role="dialog">
            <div class="modal-dialog bg bg-danger" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="selected != null">Supprimer @{{fees[selected].destination}}</h5>
                        <a id="bulkActionClose" href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                               Voulez vous vraiment supprimer?

                                 <form v-if="selected != null"     method="POST" :action="'/fee-delete/'+fees[selected].id">
                            {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <button class="btn btn-danger">Confirmer</button>
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


         @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
        <!-- /.row -->

        <div class="section ">

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des tarifs</h3>
                 
                @if($fee_roles->contains('action', 'TARIF_C'))
                  <a href="fee-form"  class="btn btn-success">Nouveau tarif</a>
              @endif
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                @if($fee_roles->contains('action', 'TARIF_R'))
                <table class="table table-head-fixed text-nowrap">
                  <thead class=" text-primary">
                      <th></th>

                      <th>
                        Destination
                      </th>
                      <th>
                        Tarif
                      </th>
                     <th>
                       nbre de commande
                     </th>
                     <th>
                         Enregistré par
                     </th>
                      
                    </thead>
                    <tbody>
                     
                      <tr v-for="(fee, index) in fees">
                        
                        <td>
                          

                        

                        @if($fee_roles->contains('action', 'TARIF_D'))
                        <button  @click="getSelected(index)" type="button" data-toggle="modal" data-target="#confirmModal" class="btn btn-danger btn-sm mr-1" type="submit"><i   name="btn"   class="fas fa-trash"  ></i></button>
                        @endif

                         @if($fee_roles->contains('action', 'TARIF_U'))
                          <a :href="'/feeedit/'+fee.id" class="btn btn-sm btn-primary mr-1" ><i class="fas fa-edit"></i>Modifier</a>

                         <button @click="getSelected(index)" type="button" data-toggle="modal" data-target="#priceModal" class="btn btn-sm btn-primary">Modifier tarif</button>
                         @endif
                       


                          
                        </td>
                        <td>
                          @{{fee.destination}}
                        </td>
                        <td>
                         par de defaut: <br>
                         Intra @{{fee.price}}, Extra @{{fee.extraprice}}

                         <span v-if="fee.tarifs.length > 0" v-for="tarif in fee.tarifs">
                           @{{tarif.name}} : @{{tarif.description}} : Intra @{{tarif.price}}, Extra @{{tarif.extraprice}}<br>
                         </span>
                        </td>

                        <td>
                          @{{fee.command.length}}
                        </td>
                        
                       <td>
                          @{{fee.saved_by}}
                        </td>
                        
                      </tr>
                     
                    </tbody>
                </table>
                @else
                Espace interdit! Contactez l'ADMIN.
                @endif
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
          fees: {!! $fees !!},
          extraprice: "",
          intraprice: "",
          name:"",
          description: "",
          destination: "",
          id: null,
          processing: null,
          success: "",
          editSuccess: "",
          tarifs: null,
          selected: null

              }
    },
    methods:{  
    getSelected(index){
      this.selected = index
    },

    updatePrice(){
     var vm = this

     this.processing = 1
    axios.post('/updateprice', {
            
            id:vm.fees[vm.selected].id,
            description: vm.description,
            extraprice: vm.extraprice,
            intraprice: vm.intraprice,
            name:vm.name,
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.success = "Prix enregistré"
     vm.processing = null
     vm.fees = response.data.fees
  })
  .catch(function (error) {
     vm.processing = null
    console.log(error);
    alert("Une erreur s'est produite")
  });
    },




     updateTarif(id){
     var vm = this
     description = document.getElementById("desc"+id).value
     price = document.getElementById("prc"+id).value
     extraprice = document.getElementById("prcextra"+id).value
     name = document.getElementById("name"+id).value
     this.processing = 1
    axios.post('/updatetarif', {
            
            id:id,
            description: description,
            extraprice: extraprice,
            price: price,
            name:name,
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.editSuccess = response.data.editSuccess
     vm.processing = null
     vm.fees = response.data.fees
    
  })
  .catch(function (error) {
     vm.processing = null
    console.log(error);
    alert("Une erreur s'est produite")
  });
    },





     deleteTarif(id){
     var vm = this
     
     this.processing = 1
    axios.post('/deletetarif', {
            
            id:id,
            
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.editSuccess = response.data.editSuccess
     vm.processing = null
     vm.fees = response.data.fees
     
  })
  .catch(function (error) {
     vm.processing = null
    console.log(error);
    alert("Une erreur s'est produite "+ id)
  });
    },

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
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Reglage</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Application pour vendeur en ligne">
    <meta name="keywords" content="bootstrap, mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
</style>

</head>

<body>
   <script src="https://unpkg.com/vue@3"></script> 

  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
   <div id="app">
  
    <div class="modal fade modalbox" id="confirmModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title confirmModalTitle"></h5>
                       <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    
                    <div class="modal-body " >
                        <div class="confirmModalBody">
                          
                        </div>

                        <form method="POST" action="certify">
                    @csrf
                    
                     <div class="form-group">
                      <label  class="form-label">Numero pièce d'identité
                      </label>
                    <input autocomplete="off" id="pieces" placeholder="Saisir le numero de la piece" required class="form-control"  type="" name="pieces" >
                     </div>
                    <div class="form-group">
                      <label class="form-label">Id utilisateur
                      </label>
                    <input required class="form-control" id="user_id" type="" name="user_id" readonly >
                     </div>


                     <div class="form-group">
                      <label class="form-label">Id livreur
                      </label>
                    <input required class="form-control" id="liv_id" type="" name="liv_id" readonly >
                     </div>


                     <div class="form-group">
                      <label class="form-label">Id Demande
                      </label>
                    <input required class="form-control" id="cert_id" type="" name="cert_id" readonly >
                     </div>

                     <div class="form-group">
                      <label class="form-label">Nom
                      </label>
                    <input required class="form-control" id="liv_name" type="" name="liv_name" >
                     </div>


                     <div class="form-group">
                      <label class="form-label">Contact
                      </label>
                    <input required class="form-control" id="liv_phone" type="" name="liv_phone" >
                     </div>
                    

                    <div class="form-group">
                      <label class="form-label">Whatsapp
                      </label>
                    <input required class="form-control" id="liv_wphone" type="" name="wphone" >
                     </div>

                    
                    
                   <button type="submit" class="btn btn-success confirm">Confirmer</button>

                    <button  class="btn btn-danger refused">Refuser</button>
                   <button  class="btn btn-default" data-dismiss="modal">Fermer</button>
                   </form>
                    </div>
                  
                </div>
            </div>
        </div>


     <div class="modal fade modalbox" id="subscribeModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title refusedModalTitle"></h5>
                       <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    
                    <div class="modal-body " >
                        <div class="refusedModalBody">
                          
                        </div>

                        <form target="_blank" method="POST" action="/subscribe">
                    @csrf
                    
            

                     <div class="form-group">
                      <label class="form-label">Formule
                      </label>
                    <select required class="form-control" name="amount">
                        <option value="">Choisir une formule</option>
                        <option value="100">100FCFA - 10 SMS</option>
                        <option value="200">200FCFA - 20 SMS</option>
                        <option value="1000">1000FCFA - 100 SMS</option>
                        <option value="2000">2000FCFA - 200 SMS</option>
                        <option value="3000">3000FCFA - 300 SMS</option>
                        <option value="4000">4000FCFA - 400 SMS</option>
                        <option value="5000">5000FCFA - 500 SMS</option>
                         <option value="10000">10000FCFA - 1000 SMS</option>
                          
                    </select>
                     </div>

                     
                    
                   <button type="submit" class="btn btn-success  phone">Souscrire</button>
                   <button  class="btn btn-default phone" data-dismiss="modal">Fermer</button>
                   </form>
                    </div>
                  
                </div>
            </div>
        </div>

      


       <div class="modal fade modalbox" id="textModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title refusedModalTitle">Modifier message</h5>
                       <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    
                    <div class="modal-body " >
                       @{{warning}}
                      <div v-if="warning == ''">
                       <div  class="form-group">
                <label><h3>@{{textTitle}}</h3></label>
              <textarea id="text" v-model="text" rows="4" cols="4" class="form-control">@{{text}}</textarea><br>
              
              </div>

                    <h5>Inserer dans le message</h5>
                    <div class="row mb-2">
              <button @click="setTextToCurrentPos('LIVREUR_CMD')" class="btn btn-secondary btn-sm mr-1 mb-1">Info Livreur</button>
              <button @click="setTextToCurrentPos('NUMERO_CMD')" class="btn btn-secondary btn-sm mr-1 mb-1">Numero Commande</button>
              <button @click="setTextToCurrentPos('TOTAL_CMD')" class="btn btn-secondary btn-sm mr-1 mb-1">Total Commande</button>
              <button @click="setTextToCurrentPos('TRACKING_CMD')" class="btn btn-secondary mr-1 mb-1 btn-sm  ">Lien de tracking</button>
               <button @click="setTextToCurrentPos('{{$client->nom}}'+ ' '+ '{{$client->phone}}')" class="btn btn-secondary btn-sm  ">Infos vendeur</button>
                        
                    </div>
                
              <button :disabled="text == '' || text == null" @click="setText" class="mr-3 btn btn-primary">Modifier message</button>
              <button data-dismiss="modal" @click="resetText" class="btn btn-default">Fermer</button>
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

<a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
            
        </div>
        <div class="pageTitle">
            <ion-icon name="settings-outline"></ion-icon>Reglage

        </div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>

        <div class="extraHeader">
        <form class="search-form">
            <div class="form-group searchbox">
                <input onkeyup="search()" id="Search" type="text" class="form-control">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
            </div>
        </form>
    </div>
    </div>
    <!-- * App Header -->


    <!-- Add Card Action Sheet -->
    
    <!-- * Add Card Action Sheet -->

    <div id="appCapsule" style="margin-top: 40px">
        @include('includes.cmdvalidation')
      <div class="section full mt-4">

         <div class="card bg-success mb-2">
                    <div class="card-header">
                    <h3>Mes SMS </h3>
                    
                </div>
                    <div class="card-body">
                        Vous avez {{$smscount}} SMS disponibles
                    </div>

                    <div class="card-footer">
                        <button data-toggle="modal" data-target="#subscribeModal" class="btn btn-light btn-block">Souscrire</button>
                    </div>
                </div>

      
            <div class="difusions">
                <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Automatisation</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                   <ul class="listview image-listview text inset">
            
            
             @foreach($settings as $index=>$setting)
            <li>
                <div class="item">
                    <div class="in">
                        <div>
                            {{$setting->description}}
                            
                            <br>
                            <button data-toggle="modal" data-target="#textModal" @click="getText('{{$setting->id}}', '{{htmlspecialchars($setting->description, ENT_QUOTES)}}')" class="btn btn-sm btn-primary">Modifier message</button>
                            
                        </div>
                        <div class="form-check custom-switch ms-2">
                            <input @change="switchSetting('{{$setting->id}}', '{{htmlspecialchars($setting->text, ENT_QUOTES)}}')" @if($client->settings->contains($setting->id)) checked @endif data-onstyle="primary" data-offstyle="secondary"     data-toggle="switchbutton"  type="checkbox" >
                            
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
                
                  
                 
                
              </div>
              <!-- /.card-body -->
            </div>
                </div> 
                 
            <!-- * card block -->
          
        </div>
        <div class="mb-3"></div>
       @include("includes.footer")

    </div>
    <!-- * App Capsule -->


    <div></div>
    <!-- App Bottom Menu -->
    @include("includes.bottom")
    @include("includes.sidebar")
    
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
   
   
   </div>

   <script>

   const app = Vue.createApp({
    data() {
        return {
            
            settings:{!! $settings !!},
            text:null,
            textTitle: null,
            selectedId:null,
            selectedIndex:null,
            warning:"",
            
        }
    },
    methods:{ 
    getText(id, description){
        vm = this
        axios.post('/gettext', {
           
             id: id ,
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
    vm.text = response.data.text
     vm.textTitle =  description 
     vm.selectedId = id
     vm.warning = response.data.warning

  })
  .catch(function (error) {
   alert(error)
    console.log(error);
  });
     
  
    },


    setTextToCurrentPos(element) {
                var curPos = 
                    document.getElementById("text").selectionStart
                console.log(curPos)
                
              
              this.text = this.text.slice(0, curPos) + element + this.text.slice(curPos)

            },

   
    resetText(){
     this.text = null
     this.textTitle = null
     this.selectedId = null
     this.selectedIndex = null
     this.warning = ""
    },
    switchSetting(id, text){
      
      var vm = this
     
     

    axios.post('/switchsetting', {
           
             id: id ,
             text:text,
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
    


  })
  .catch(function (error) {
   alert(error)
    console.log(error);
  });
    },



     setText(){
      
      var vm = this
     
     

    axios.post('/setmessage', {
           
             id: vm.selectedId ,
             text:vm.text,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
   
    alert("Action effectuee")


  })
  .catch(function (error) {
   alert(error)
    console.log(error);
  });
    }


   },
   computed:{
     
}
});

  const mountedApp = app.mount('#app') 
  </script>

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
     <script src="../assets/js/lib/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="../assets/js/lib/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="../assets/js/owl.carousel.min.js"></script>
    <!-- Base Js File -->
    <script src="../assets/js/base.js"></script>
     <script src="../assets/js/commands.js"></script>
     
    <!-- Google map -->
    <script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"
   defer
   ></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>

  <script src="../assets/js/star-rating.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/bigdatacloudapi/js-reverse-geocode-client@latest/bigdatacloud_reverse_geocode.min.js" type="text/javascript"></script>
  <script  src="../assets/js/bootstrap-select.min.js"></script>
  <script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       shareButton = document.getElementById("share");

  $(".share").click( function() {
    if (navigator.share) {
    navigator.share({
      title: 'Diffusion',
      text: $(this).val(),
      
    }).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }
  });


  $('#city-select').selectpicker();


  $(".accept").click( function() {
   
   
   var user_id = $(this).val();
   var liv_id = $(this).data("liv");
   var name = $(this).data("name");
   var photo = $(this).data("photo");
   var p_photo = $(this).data("p_photo");
   var cert_id = $(this).data("cert_id");
    var phone = $(this).data("phone");
    var wphone = $(this).data("wphone")

    $(".confirmModalTitle").html("Certifier "+name);
    $(".confirmModalBody").html("Points a verifier <br><ul><li>Pièce d'identité lisible(texte et photo)</li><li>Photo de bonne qualité avec visage bien visible</li><li>Nom complet conforme à celui inscrit sur la pièce d'identité</li><li>Numero de telephone correcte et appartenant au concerné</li><li>Numero whatsapp correcte et appartenant au concerné</li></ul><br>Nom: "+name+ " Contact:"+phone+" Whatsapp:"+wphone+" <br><br> <img width='100%' src='"+photo+"' ><img width='100%' src='"+p_photo+"' >");
     $("#user_id").val(user_id);
     $("#liv_id").val(liv_id);
     $("#liv_phone").val(phone);
     $("#liv_wphone").val(wphone);
     $("#liv_name").val(name);
     $("#cert_id").val(cert_id);
     $(".refused").val(cert_id);
    $("#confirmModal").modal("show");
    
   }); 


   $(".refused").click( function() {
   
   
   
   var cert_id = $(this).val();
   $("#refused_id").val(cert_id); 

    $(".refusedModalTitle").html("Refuser certification");
    $(".refusedModalBody").html("soyez sûr de votre déision et expliquez bien les raisons. Une fois refusé, le livreur devra introduire une nouvelle demande.");
     $("#refused_id").val(cert_id);
     $("#confirmModal").modal("hide");
    $("#refusedModal").modal("show");
    
   }); 

  </script>

</body>

</html>
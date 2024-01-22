<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Marketing</title>
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






      <div style="height: 100rem" class="modal fade modalbox" id="candidates" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title cmdModalTitle">Postulants</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content candidates-content">
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
            Marketing

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
      
            <div class="difusions">

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





               <form method="POST" action="sendsms">
                @csrf
                <div class="card mb-2">
                    <div class="card-header">
                    <h3>Message </h3>
                    
                </div>
                
                    <div class="card-body">
                        <div class="form-outline">
  <textarea v-model="message" :maxlength="messageMax" name="message" class="form-control" id="textAreaExample1" rows="4"></textarea>
  <label class="form-label" for="textAreaExample">@{{messageMax}} carateres maximum (@{{messageMax-message.length}})</label>
</div>
                    </div>
                </div>
             
                <div class="card">
                    <div class="card-header">
                    <h3>Criteres </h3>
                    <h5 class="float-right">@{{prospects}}</h5>
                </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Status</label>
                            <select @change="countProspects" name="status" v-model="status" class="form-control">
                                <option>Tout</option>
                                <option value="termine">Livré uniquement</option>
                            </select>
                        </div>

                       

                        <div class="form-group">
                            <label>Commune</label>
                            <select @change="countProspects" v-model="cities" data-style="btn-dark"  title="Choisir communes..." id="city-select" class=" selectpicker form-control" multiple  name="cities[]">
                                 
                                
                                 @foreach($fees as $fee)
                                  <option value="{{$fee->id}}">{{$fee->destination}}</option>
                                 @endforeach
                                
                                 </select>
                        </div>


                         <div class="form-group">
                            <label>Achat superieur ou egal a</label>
                            <select @change="countProspects" v-model="amount"  class="form-control"   name="amount">
                                <option>Tout les montants</option>
                                 @for($x=5000; $x<=100000;$x+=5000)
                                <option>{{$x}}</option>
                                @endfor
                                
                                 </select>
                        </div>

                         <div class="form-group">
                            <label>Date d'achat</label>
                            <label class="label" for="text11d">Choisir un interval</label>
                            <div class="form-row">
                               <div class="form-check">
              <input @change="countProspects" v-model="allDates"  class="form-check-input" type="checkbox" value="1" >
            <label class="form-check-label" for="flexCheckDefault">
                 Toutes les dates
               </label>
</div>
                            </div>
                                       
                                         <div   class="form-row">
                                         
                                         <div class="col">
                                         <input @change="countProspects" v-model="intStart" :disabled="allDates == 1" value=""  class="form-control" 
                                        
                                         type="date" name="start">
                                          </div>
                                          <div class="col">
                                         <input @change="countProspects" v-model="intEnd" :disabled="!intStart || allDates == 1" :min="intStart"  class="form-control" 
                                          
                                         type="date" name="end">
                                        </div>
                                       
                                        </div>
                        </div>


                        <div class="form-group">
                            <label>A combien de contacts souhaitez vous envoyer (Laisser vide pour envoyer a un maximum)</label>
                            <input   class="  form-control"  name="limit" type="number">
                                 
                        </div>

                    </div>
                    
                </div>


                <div class="card mt-2">
                    <div class="card-header">
                        <h5>Tester sur mon numero</h5>
                    </div>
                    <div class="card-body">
                        
                      
                        <div  class="row">
                            <div class="col">
                                <input type="" name="" v-model="phone" class="form-control">
                            </div>

                            <div class="col">
                                <button :disabled='message.length < 1 || Number(smscount) < 1' @click="testsms" type="button" class="btn btn-primary">Tester</button>
                            </div>
                            
                        </div>
                        <div class="row">
                            @{{status}}
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    
                    <div class="card-body">
                        <button v-if="confirm == null" @click="confirm = 1" type="button" :disabled='message.length < 1 || Number(smscount) < 1' class="btn btn-primary btn-block">Envoyer message </button>

                        <div v-if="confirm == 1" class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success">Confirmer</button>
                            </div>

                            <div class="col">
                                <button @click="confirm = null" type="button" class="btn btn-light">Annuler</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
                 
             </form>
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
            
            
            intEnd:null,
            intStart:null,
            allDates:null,
            status:"",
            cities:[],
            amount:"",
            prospects: '{{$prospects}}' ,
            message:"",
            messageMax:500,
            smscount:"{{$smscount}}",
            confirm:null,
            phone:"{{$client->phone}}"

            
            
        }
    },
    methods:{ 
    countProspects(){
         var vm = this
         this.prospects = 'Chargement...'

    axios.post('/countprospects', {
             end:vm.intEnd,
            start:vm.intStart,
            alldates:vm.allDates,
            status:vm.status,
            cities:vm.cities,
            amount:vm.amount,
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
   
    vm.prospects = response.data.prospects+ " Contacts."
   


  })
  .catch(function (error) {
    alert("une erreur s'est produite")
    console.log(error);
  });
    },

    testsms(){
         var vm = this
         this.status = 'Envoi encous...'

    axios.post('/testsms', {
             phone: vm.phone,
             message:vm.message,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
   
    vm.status = response.data.status
   


  })
  .catch(function (error) {
    alert("une erreur s'est produite")
    console.log(error);
  });
    }
   
   },
   computed:{
   
    
}
});

  const mountedApp = app.mount('#app')     

   
  Vue.component('v-select', VueSelect.VueSelect); 
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
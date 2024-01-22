<!doctype html>
<html lang="fr">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

  <link rel = " manifest " href="../assets/manifest/client.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo-icon.png" />
  <title>Soucrire</title>

  <style>
    .card {
      border:none;
      padding: 10px 50px;
    }

    .card::after {
      position: absolute;
      z-index: -1;
      opacity: 0;
      -webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
      transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .card:hover {


      transform: scale(1.02, 1.02);
      -webkit-transform: scale(1.02, 1.02);
      backface-visibility: hidden; 
      will-change: transform;
      box-shadow: 0 1rem 3rem rgba(0,0,0,.75) !important;
    }

    .card:hover::after {
      opacity: 1;
    }

    .card:hover .btn-outline-primary{
      color:white;
      background:#007bff;
    }

  </style>

</head>
<body>

  <div class="modal fade dialogbox add-modal" id="InstalAppModal"  data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="pt-3 text-center">
                        <img src="../assets/img/logo-icon.png" alt="image" class="imaged w48  mb-1">
                    </div>
                    <div class="modal-header pt-2">
                        <h5 class="modal-title">Installer l'application Jibiat</h5>
                    </div>
                    <div class="modal-body">
                        Accedez a jibiaT en un clique!
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary " data-dismiss="modal">Annuler</a>
                            <a href="#" class="btn btn-text-primary add-button" data-dismiss="modal">Installer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade dialogbox" id="stateModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"></h5>
                       

                    </div>
                    
                    <div class="modal-body" id="stateModalBody">
                        
                    </div>
                   
                </div>
            </div>
        </div>

<div class="modal fade dialogbox" id="subscribeModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"></h5>
                      
                    </div>
                    
                    <div class="modal-body subscribeBody" >
                        <div class="message bold"></div>
                        @auth
                         <form method="post" action="subscribe">
                          @csrf
                         En confirmant votre souscription, vous acceptez les <a target="blank" href="conditions">conditions d'utilisation</a>.   
                        
                        <button type="submit" class="btn-block btn btn-success" >Confirmer</button>
                   <button type="button"  class="close btn btn-secondary btn-block" data-dismiss="modal">Annuler</button>
                   </form>
                   @endauth
                    </div>
                   
                </div>
            </div>
        </div>


    <div class="modal fade dialogbox" id="monthlyModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">Confirmer la souscription mensuelle</h5>
                       

                    </div>
                    
                    <div class="modal-body" >
                     <form action="subscribe" method="POST"> @csrf
                        <input hidden="hidden" type="text" name="monthly" value="yearly">
                        <div class="form-group mb-2">
                         En confirmant votre souscription, vous acceptez les <a target="blank" href="conditions">conditions d'utilisation</a>.   
                        </div>
                        <button type="submit" class="btn btn-success" id="del_btn">Confirmer</button>
                   <button type="button" class="btn btn-secondary" class="close" data-dismiss="modal">Annuler</button>
                   </form>
                    </div>
                   
                </div>
            </div>
        </div>


  <div class="container-fluid" style="background: linear-gradient(90deg, #00C9FF 0%, #92FE9D 100%);">
    <div class="container p-5">
     @auth
       <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="item">
                                
                                   {{ __('Deconnexion') }}
                                
                            </a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>   
      @endauth
        @if (session('warning'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('warning') }}
                        </div>
                    @endif
      <div class="row">
        <!-- <div class="col-lg-4 col-md-12 mb-4">
          <div class="card h-100 shadow-lg">
            <div class="card-body">
              <div class="text-center p-3">
                <h5 class="card-title">Mensuel</h5>
                
                <br><br>
                <span class="h2">2300 FCFA</span>/mois
                <br><br>
              </div>
              <p class="card-text">Accedez à toutes vos fonctionalités pendant 1 mois.</p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
              </svg> Suivre les activités de vos livreurs</li>
              <li class="list-group-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
              </svg> Point automatique</li>
              <li class="list-group-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
              </svg> Et plus encore</li>
              <li class="list-group-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
              </svg> Assistance 7/7</li>
            </ul>
            <div class="card-body text-center">
              <button value="monthly" class="btn btn-outline-primary btn-lg subscribe" style="border-radius:30px">Souscrire</button>
            </div>
          </div>
        </div> -->
        <div class="col-lg-4 col-md-12 mb-4">
          <div class="card h-100 shadow-lg">
            <div class="card-body">
              <div class="text-center p-3">
                <h5 class="card-title">Mensuel</h5>
                
                <br><br>
                <span class="h2">5000 Fcfa</span>/mois
                <br><br>
              </div>
              <p class="card-text">Accedez à toutes vos fonctionalités pendant 1 mois .</p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
              </svg> Accedez à des centaines d'offres de livraisons</li>
              <li class="list-group-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
              </svg>Trouvez des contrats de longue durée avec les vendeurs</li>
              <li class="list-group-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
              </svg> Et plus encore</li>
              <li class="list-group-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
              </svg> Assistance 7/7</li>
            </ul>
            <div class="card-body text-center">
              <button value="yearly" class="btn btn-outline-primary btn-lg subscribe" style="border-radius:30px">Souscrire</button>
            </div>
          </div>
        </div>
      </div> 

     
    </div>
  </body>


  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="../assets/js/lib/jquery-3.4.1.min.js"></script>
  <script src="../assets/manifest/js/app.js"></script>
 <script src="../assets/js/lib/bootstrap.min.js"></script>

 
<script type="text/javascript">
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(".subscribe").click( function() {
   
   var formula = $(this).val();
   
   if(formula == "monthly"){var title = "Formule mensuelle";}
    if(formula == "yearly"){var title = "Formule mensuelle";}

     @if(Auth::check())
     $.ajax({
       url: 'checksubscription',
       type: 'post',
       data: {_token: CSRF_TOKEN, formula: formula},
   
       success: function(response){
              if(response.message == "no_auth"){
                $(".message").html("Pour souscrire vous devez vous connecter. <a href='login' class='btn btn-primary btn-block'>Se connecter</a><br> Vous n'avez pas de compte? <br><a href='register' class='btn btn-primary btn-block'>Créer un compte</a>");
              }
              else
               {

                $(".message").html(response.message);
                
               }

               $(".modal-title").html(title);
                $('#formula_btn').val(formula);
                $("#subscribeModal").modal("show");
              },
   error: function(response){
               $("#stateModalBody").html("Une erruer s'est produite!!");
                $("#stateModal").modal('show');
               
              }
             
     });
    @else
    $(".message").html("Pour souscrire vous devez vous connecter. <a href='login' class='btn btn-primary btn-block'>Se connecter</a><br><br> Vous n'avez pas de compte? <br><a href='register' class='btn btn-primary btn-block'>Créer un compte</a>");

    $(".modal-title").html(title);
                $('#formula_btn').val(formula);
                $("#subscribeModal").modal("show");
    @endif
   }); 



   $("#formula_btn").click( function() {
   
   var formula = $(this).val();



     $.ajax({
       url: 'subscribe',
       type: 'post',
       data: {_token: CSRF_TOKEN, formula: formula},
   
       success: function(response){
               $(".subscribeBody").html("Votre demande de souscription a été envoyée, votre abonnement sera activée après votre paiement dans un delais de 24h");
                
              },
   error: function(response){
               $("#stateModalBody").html("Une erruer s'est produite");
               $("#subscribeModal").modal('hide');
                $("#stateModal").modal('show');
               
              }
             
     });
   });  
</script>
</body>
</html>

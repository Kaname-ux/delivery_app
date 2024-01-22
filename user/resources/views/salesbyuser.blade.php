<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Mes Ventes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Mes ventes">
    <meta name="keywords" content="Ventes" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    

    <link rel = " manifest " href="../assets/manifest/client.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo-icon.png" />
     <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />
    

    <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>

    <div class="modal fade dialogbox add-modal" id="InstalAppModal"  data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="pt-3 text-center">
                        <img src="../assets/img/logo-icon.png" alt="image" class="imaged w48  mb-1">
                    </div>
                    <div class="modal-header pt-2">
                        <h5 class="modal-title">Vous vendez en ligne?</h5>
                    </div>
                    <div class="modal-body">
                        Installez l'application Jibiat.
                          <ul>
                              <li>Enregistrez vos commandes</li>
                              <li>Trouvez des livreurs fiables</li>
                              <li>Suivez vos commandes en temps réel</li>
                              <li>Vos points sont automatiques</li>

                          </ul>
                          <a class="btn btn-success" href="https://wa.me/2250554269035">Contactez nous sur whatsapp</a>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary " data-dismiss="modal">Annuler</a>
                            <a href="#" class="btn btn-text-success add-button" data-dismiss="modal">Installer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
      

    

    <!-- loader -->
   <!--  <div id="loader">
        <img src="../assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div> -->
    <!-- * loader -->

    <!-- App Header -->
     <div class="appHeader">
    <div class="left">


            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
            
        </div>
        <div class="pageTitle">
            Ventes de {{$salesman->nom}}
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
       
      
        <!-- Wallet Card -->
        <div class="section  pt-1">
            <div class="wallet-card">
                <!-- Balance -->
                <div class="balance">
                    <div class="left">
                        <span class="title">{{$title}}   @if($all != "")
        <a class='btn btn-primary' href='point'>Voir toutes les ventes</a>
       @endif
                        </span>
                        <h2 class="total"> 
            {{number_format($sales->sum('montant'),0,',',' ')}}
            
                        </h2>
                    </div>
                    <div class="right">
                       
                    </div>
                </div>
                <!-- * Balance -->
                <!-- Wallet Footer -->
                <div class="wallet-footer">
                    
                       <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
   <ion-icon name="calendar-outline"></ion-icon>&nbsp;
    <span></span> 
</div> 
                    


 <form hidden action="?" class="range-form ">
          <input class="start" type="text" name="start">
          <input class="end" type="text" name="end">
           <input  value="{{$salesman->id}}" type="" name="id">
        </form>
      
                </div>
                <!-- * Wallet Footer -->
            </div>
        </div>
        <!-- Wallet Card -->
        
        
        <!-- * Exchange Action Sheet -->

        <!-- Stats -->

        



        

        <!-- Transactions -->
        <!-- <div class="section mt-4">
            <div class="section-heading">
                <h2 class="title">Transactions</h2>
                <a href="app-transactions.html" class="link">View All</a>
            </div>
            <div class="transactions"> -->
                <!-- item -->
                <!-- <a href="app-transaction-detail.html" class="item">
                    <div class="detail">
                        <img src="assets/img/sample/brand/1.jpg" alt="img" class="image-block imaged w48">
                        <div>
                            <strong>Amazon</strong>
                            <p>Shopping</p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="price text-danger"> - $ 150</div>
                    </div>
                </a> -->
                <!-- * item -->
                <!-- item -->
               <!--  <a href="app-transaction-detail.html" class="item">
                    <div class="detail">
                        <img src="assets/img/sample/brand/2.jpg" alt="img" class="image-block imaged w48">
                        <div>
                            <strong>Apple</strong>
                            <p>Appstore Purchase</p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="price text-danger">- $ 29</div>
                    </div>
                </a> -->
                <!-- * item -->
                <!-- item -->
               <!--  <a href="app-transaction-detail.html" class="item">
                    <div class="detail">
                        <img src="assets/img/sample/avatar/avatar3.jpg" alt="img" class="image-block imaged w48">
                        <div>
                            <strong>Alex Ljung</strong>
                            <p>Transfer</p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="price">+ $ 1,000</div>
                    </div>
                </a> -->
                <!-- * item -->
                <!-- item -->
               <!--  <a href="app-transaction-detail.html" class="item">
                    <div class="detail">
                        <img src="assets/img/sample/avatar/avatar4.jpg" alt="img" class="image-block imaged w48">
                        <div>
                            <strong>Beatriz Brito</strong>
                            <p>Transfer</p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="price text-danger">- $ 186</div>
                    </div>
                </a> -->
                <!-- * item -->
            <!-- </div>
        </div> -->
        <!-- * Transactions -->

        <!-- my cards -->


  


  





  
         
        <!-- * my cards -->


        <!-- by state -->
        

        
        <!-- * Monthly Bills -->


        <!-- Saving Goals -->
       
        <!-- * Saving Goals -->



        <!-- Transactions -->
        
        <!-- * Transactions -->
       <div class="section  pt-1">
          <div class="listview-title mt-2">Par produit </div>
        <ul class="listview image-listview">
             @if($by_products)
          @foreach($by_products as $product)
            <li>
                <div class="item">
                    <div class="icon-box bg-primary">
                        <ion-icon name=""></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                          
                          {{$product["product_name"]}}
                         
                        </div>
                        <span class="text-muted">
                            {{$product["product_qty"]}}
                            @if($salesman->user_type == "PARTENAIRE")
                         (Commission: {{$product["product_qty"]*400}} FCFA) 
                        @endif
                    </span>
                    </div>
                </div>
            </li>
           @endforeach 
           @endif
        </ul>
        </div>  

        
       <div class="section  pt-1">
          <div class="listview-title mt-2">Par zone {{$sales_by_zone->count()}}</div>
        <ul class="listview image-listview">
          @foreach($sales_by_zone as $sale)
            <li>
                <div class="item">
                    <div class="icon-box bg-primary">
                        <ion-icon name=""></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                          @foreach($all_fees as $fee)
                          @if($fee->id == $sale->fee_id)
                          {{$fee->destination}}
                          @endif
                          @endforeach
                        </div>
                        <span class="text-muted">{{$sale->montant}}</span>
                    </div>
                </div>
            </li>
           @endforeach 
        </ul>
        </div>   
        
       <div class="section  pt-1">
       </div>
        <!-- * News -->


        @include("includes.footer")
         <!-- App Bottom Menu -->
    @include("includes.bottom")
    @include("includes.sidebar")
    </div>
    <!-- * App Capsule -->


   
    
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
   
    <!-- * App Sidebar -->

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
   <script src="../assets/js/lib/jquery-3.5.1.min.js"></script>
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
    <script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"
   defer
   ></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  
<script type="text/javascript">
    
    $(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
       
      
    }
    


    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Aujourd\'hui': [moment(), moment()],
           'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           ' 7 dernier Jours': [moment().subtract(6, 'days'), moment()],
           'Les 30 derniers jours': [moment().subtract(29, 'days'), moment()],
           'Ce mois': [moment().startOf('month'), moment().endOf('month')],
           'Le mois passé': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },

      autoUpdateInput: false,
    "locale": {
        "applyLabel": "Valider",
        "cancelLabel": "Annuler",
    "fromLabel": "Du",
        "toLabel": "Au",
        "customRangeLabel": "Personnalisé",
        "weekLabel": "W",
        "daysOfWeek": [
            "Di",
            "Lu",
            "Ma",
            "Me",
            "Je",
            "Ve",
            "Sa"
        ],
        "monthNames": [
            "Janvier",
            "Fevrier",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juillet",
            "Aout",
            "Septembre",
            "Octobre",
            "Novembre",
            "Decembre"
        ]
    }
   
    }, cb);

    cb(start, end);


$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
  console.log(picker.startDate.format('YYYY-MM-DD'));
  console.log(picker.endDate.format('YYYY-MM-DD'));

  $(".start").val(picker.startDate.format('YYYY-MM-DD'));
    $(".end").val(picker.endDate.format('YYYY-MM-DD'));
    $(".range-form").submit();
});
});

</script>
    

</body>

</html>
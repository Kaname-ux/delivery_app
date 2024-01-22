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
    <meta name="description" content="Finapp HTML Mobile Template">
    <meta name="keywords" content="bootstrap, mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">

    <link rel = " manifest " href="../assets/manifest/client.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo-icon.png" />
    
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />

    <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>
   
      <div class="modal fade action-sheet" id="withdrawActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Date</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            
                               <a class="btn btn-primary btn-block" href= "?period=curmonth" >Ce mois</a> 
                 
                 
                 
                    
                        <a class="btn btn-warning btn-block" href= "?period=lastmonth" >Le mois dernier</a>
                    
                    
                      <a class="btn btn-success btn-block" href="?period=curyear"> Cette année</a>
                        
                    
                    
                        <a class="btn btn-secondary btn-block" href= "?period=lastyear" >L'année dernière</a>
                                

                                
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    

    <!-- loader -->
    <div id="loader">
        <img src="../assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
     <div class="appHeader">
    <div class="left">


            <form class="form-inline" autocomplete="off"  action='dashboard?bydate' >
             @csrf
             <div  class="form-group ">
                                         
                <input style="display: none;" value=''    class="form-control "  name="route_day">
                <button class="btn btn-text-primary headerButton goBack" type="submit"  ><ion-icon name="chevron-back-outline"></ion-icon></button>

            </div>
                </form>
            
        </div>
        <div class="pageTitle">
            Mes ventes
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
                        <span class="title">Ventes  @foreach($months as $x=>$one)
                    @if($x == $month)
                   {{$one}} 
                    @endif
                    @endforeach
                    {{$year}}
                        </span>
                        <h2 class="total"> 
            {{number_format($sales->sum('montant'),0,',',' ')}}
            
                        </h2>
                    </div>
                    <div class="right">
                        <a href="#" class="button" data-toggle="modal" data-target="#withdrawActionSheet">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </a>
                    </div>
                </div>
                <!-- * Balance -->
                <!-- Wallet Footer -->
                <div class="wallet-footer">
                    
                        
                    

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


        <!-- News -->
        <div class="section full mt-4 mb-3">
            
        </div>
        <!-- * News -->


        @include("includes.footer")

    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    @include("includes.bottom")
    
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
  
    

</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    Accueil
  </title>


  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap4.min.css" rel="stylesheet" />
  
<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
<style>

</style>
 
<link rel = " manifest " href="../assets/manifest/client.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo.png" />
    
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />

  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>

</head>

<body  style="
  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover; /* Resize the background image to cover the entire container #2E673F #173B0B  #0B614B #0A2A1B*/
  background-color: #0B3B2E;">
  <div class="container">
 <div style="margin-top: 15px; font-family: 'Sofia';   margin-left: 30px; text-align: center;">
 	<h1 style="color: #A95B0D">Jibiat</h1>
 	<p style="color: white">Système de gestion pour vendeur en ligne</p>
  
  </div>
<div style="position: relative; top: 100px">
  <div style="margin-bottom: 50px">
    <a style="color: white" href="dashboard">
  	<img class="float-left" src="../assets/img/bag2.png" width="100px" height="100">
  	<h4>Commandes</h4>
  	<p style="width: 380px">Enregistre tes commandes et assigne à des livreurs de ta liste  ou à proximité</p>
  	</a>
  </div>

  <div >
   <a style="color: white" href="livreurs">
  	<img class="float-left" src="../assets/img/moto4.png" width="100px" height="100px">
  	<h4>Livreurs</h4>
  	<p style="width: 380px">Trouve des livreurs  Ajoute les à ta liste et  assigne leur des commandes</p>
  	</a>
  </div>
</div>


</div>
<div style="color: white; margin-top: 200px">
<h2 >Client oiseau <i class="fa fa-dove"></i> n'aura plus de pretexte.</h2>
</div>
</body>
</html>
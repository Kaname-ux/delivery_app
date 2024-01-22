@if (Auth::check() && Auth::user()->usertype == 'client')
    <script>window.location = "/dashboard";</script>
@endif


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JibiaT') }}</title>

    <!-- Scripts -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel = " manifest " href="../assets/manifest/client.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo.png" />
    
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />
</head>
<body>
    <div id="app">
      <button style="display: none; font-weight: bolder;" class="btn btn-danger btn-block add-button ">
  Installer l'application Jibiat</button>
        
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <img width="30%" height="60%" src="../assets/img/Jibiatlogo.jpg">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>


                   
               
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">connexion</a>
                            </li>

                             <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Créer un compte</a>
                            </li>
                           
                        @endguest

                        @auth
                          <li class="nav-item">
                         <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Deconnexion') }}
                                    </a>

                         </li>
                        @endauth

                   
                    </ul>

                   
                </div>
            </div>
        </nav>


        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    
</body>

    <script src="../assets/manifest/js/app.js"></script>
        
<script type="text/javascript">
        $( document ).ready(function() {
      
   
     let deferredPrompt;
const addBtn = document.querySelector('.add-button');





window.addEventListener('beforeinstallprompt', (e) => {
  // Prevent Chrome 67 and earlier from automatically showing the prompt
  e.preventDefault();
  // Stash the event so it can be triggered later.
  deferredPrompt = e;
  // Update UI to notify the user they can add to home screen
  addBtn.style.display = 'block';

  addBtn.addEventListener('click', (e) => {
    // hide our user interface that shows our A2HS button
    addBtn.style.display = 'none';
    // Show the prompt
    deferredPrompt.prompt();
    // Wait for the user to respond to the prompt
    deferredPrompt.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
          console.log('User accepted the A2HS prompt');
        } else {
          console.log('User dismissed the A2HS prompt');
        }
        deferredPrompt = null;
      });
  });
});
      
});
    
</script>
</html>

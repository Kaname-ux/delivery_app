 <div class="appBottomMenu">
        <a href="dashboard" class="item {{'dashboard' == request()->path() ? 'active': '' }}">
            <div class="col">
                <ion-icon name="home-outline"></ion-icon>
                <strong>Acceuil</strong>
            </div>
        </a>
        <a href="livreurs" class="item {{'livreurs' == request()->path() ? 'active': '' }}">
            <div class="col">
                <ion-icon name="bicycle-outline"></ion-icon>
                <strong>Livreurs</strong>
            </div>
        </a>
        <a href="app-components.html" class="item">
            <div class="col">
                <ion-icon name="apps-outline"></ion-icon>
                <strong>Components</strong>
            </div>
        </a>
        <a href="commands" class="item {{'commands' == request()->path() ? 'active': '' }}">
            <div class="col">
                <ion-icon name="cart-outline"></ion-icon>
                <strong>Mes Commandes</strong>
            </div>
        </a>
        <a href="app-settings.html" class="item">
            <div class="col">
                <ion-icon name="settings-outline"></ion-icon>
                <strong>Settings</strong>
            </div>
        </a>
    </div>

   @yield('bottom') 
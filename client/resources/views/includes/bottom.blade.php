<!-- App Bottom Menu -->

<style type="text/css">
    .btmMenu:hover, .btmMenu:focus {
   font: #5987b3;     
  font-size: 12px;

}
</style>
    <div class="appBottomMenu">
        <a href="commands" class="item {{'commands' == request()->path() ? 'active': '' }} btmMenu" >
            <div class="col">
                <ion-icon name="cart-outline"></ion-icon>
                <strong>Mes commandes</strong>
            </div>
        </a>
        
        <!-- <a href="livreurs" class="item {{'livreurs' == request()->path() ? 'active': '' }} btmMenu">
            <div class="col">
                <ion-icon name="bicycle-outline"></ion-icon>
                <strong>Livreurs</strong>
            </div>
        </a> -->
        
        <a href="point" class="item {{'point' == request()->path() ? 'active': '' }} btmMenu">
            <div class="col">
                <ion-icon name="stats-chart-outline"></ion-icon>
                <strong>Mes ventes</strong>
            </div>
        </a>
        <a href="products" class="item {{'products' == request()->path() ? 'active': '' }} btmMenu">
            <div class="col">
                <ion-icon name="bag-outline"></ion-icon>
                <strong>Mes articles</strong>
            </div>
        </a>
    </div>

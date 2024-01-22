<div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <!-- profile box -->
                    <div class="profileBox pt-2 pb-2">
                        <div class="image-wrapper">
                            <img @if($client->photo != NULL)
                          src="{{Storage::disk('s3')->url($client->photo)}}" 
                         @else src="assets/img/sample/brand/1.jpg"  @endif alt="image" class="imaged  w36">
                        </div>
                        <a href="account" class="in">
                            <strong>{{$client->nom}}</strong>
                            <div class="text-muted"></div>
                        </a>
                        <a href="#" class="btn btn-link btn-icon sidebar-close" data-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon>
                        </a>
                    </div>
                    <!-- * profile box -->
                    <!-- balance -->
                    @if(isset($total))
                    <div class="sidebar-balance">
                        <div class="listview-title">Total</div>
                        <div class="in">
                            <h1 class="amount">{{$total}}({{$all_commands->count()}})</h1>
                        </div>
                    </div>
                    @endif
                    <!-- * balance -->

                    <!-- action group -->
                    <div class="action-group">
                        <a href="commands" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="cart-outline"></ion-icon>
                                </div>
                                Commandes
                            </div>
                        </a>
                        <a href="livreurs" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="bicycle-outline"></ion-icon>
                                </div>
                                Livreurs
                            </div>
                        </a>
                        <!-- <a href="payments" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="cash-outline"></ion-icon>
                                </div>
                                Payements
                            </div>
                        </a> -->
                        <a href="point" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="stats-chart-outline"></ion-icon>
                                </div>
                                Mes ventes
                            </div>
                        </a>

                        
                    </div>


                    <!-- * action group -->

                    <!-- menu -->
                    <div class="listview-title mt-1">Menu</div>
                    <ul class="listview flush transparent no-line image-listview">
                        <li>
                            <a href="dashboard" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="home-outline"></ion-icon>
                                </div>
                                <div class="in">
                                   Acceuil
                                    <span class="badge badge-primary"></span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="commands" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="cart-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Mes commandes
                                </div>
                            </a>
                        </li>

                         <li>
                            <a href="products" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="bag-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Ma boutique
                                </div>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="payments" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="cash-outline"></ion-icon>
                                </div>
                                <div class="in">
                                   Mes Payements
                                </div>
                            </a>
                        </li> -->
                        <li>
                            <a href="point" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="stats-chart-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Mes ventes
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="meslivreurs" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="bicycle-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Mes livreurs
                                </div>
                            </a>
                        </li>


                        <li>
                            <a href="difusions" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="radio-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Mes diffusions
                                </div>
                            </a>
                        </li>


                      @if($client->is_certifier)
                        <li>
                            <a href="certifications" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="thumbs-up-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Demandes de certification
                                </div>
                            </a>
                        </li>
                    @endif

                    </ul>
                    <!-- * menu -->

                    <!-- others -->
                    <div class="listview-title mt-1">Autre</div>
                    <ul class="listview flush transparent no-line image-listview">


                        <li>
                            <a href="canaux" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="chatbubble-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Canaux
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="account" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="person-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Mon compte
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="information-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Aide
                                </div>
                            </a>
                        </li>
                        <li>

                            <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </div>
                                <div class="in">
                                   {{ __('Deconnexion') }}
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- * others -->

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                    <!-- send money -->
                    <!-- <div class="listview-title mt-1">Send Money</div>
                    <ul class="listview image-listview flush transparent no-line">
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar2.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Artem Sazonov</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar4.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Sophie Asveld</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar3.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Kobus van de Vegte</div>
                                </div>
                            </a>
                        </li>
                    </ul> -->
                    <!-- * send money -->

                </div>
            </div>
        </div>
        <div id="cmdRtrnScript">
         
       </div>

       <div id="singlePayScript">
         
       </div>
    </div>
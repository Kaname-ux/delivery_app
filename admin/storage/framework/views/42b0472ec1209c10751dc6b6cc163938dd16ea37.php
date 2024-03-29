<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->

      
    </ul>
  </nav>


 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Jibiat</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo e(Auth::user()->name); ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
         
          <li class="nav-item">
            <a href="/dashboard" class="nav-link <?php echo e('dashboard' == request()->path() ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/commands" class="nav-link <?php echo e('commands' == request()->path() ? 'active' : ''); ?>">
              <i class="nav-icon fa fa-shopping-bag"></i>
              <p>
                Course
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/livreurs" class="nav-link <?php echo e('livreurs' == request()->path() ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-motorcycle"></i>
              <p>
                Livreurs
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/clients" class="nav-link <?php echo e('clients' == request()->path() ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Clients
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/payements" class="nav-link <?php echo e('payements' == request()->path() ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Payements
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/fees" class="nav-link <?php echo e('fees' == request()->path() ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-tag"></i>
              <p>
                Tarifs livraison
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/charge" class="nav-link <?php echo e('charge' == request()->path() ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-wallet"></i>
              <p>
                Charges
                
              </p>
            </a>
          </li>
         


          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shop"></i>
              <p>
                Produits
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/shops" class="nav-link <?php echo e('shops' == request()->path() ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-store"></i>
             
              <p>
                Mes boutiques
                
              </p>
            </a>
              </li>
              <li class="nav-item">
                <a href="/products" class="nav-link <?php echo e('products' == request()->path() ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-shopping-bag"></i>
             
              <p>
                Mes articles
                
              </p>
            </a>
              </li>
              <li class="nav-item">
                <a href="/suppliers" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fournisseurs</p>
                </a>
              </li>
             
            </ul>
          </li>

          <li class="nav-item">
            <a href="/canaux" class="nav-link <?php echo e('canaux' == request()->path() ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-filter"></i>
             
              <p>
               Canaux
                
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link ">
               <i class="nav-icon fas fa-user"></i>
              <p>
                Utilisateurs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/users" class="nav-link <?php echo e('users' == request()->path() ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Liste</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/roles" class="nav-link <?php echo e('roles' == request()->path() ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Groupe</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/userstat" class="nav-link <?php echo e('userstat' == request()->path() ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Objectifs et chiffres</p>
                </a>
              </li>
            
            </ul>
          </li>

          <li class="nav-item">
            <a href="/certifications" class="nav-link <?php echo e('certifications' == request()->path() ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Certification
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/marketing" class="nav-link <?php echo e('marketing' == request()->path() ? 'active' : ''); ?>">
             
              
              <i class="nav-icon fas fa-comments-dollar"></i>
              <p>
              Marketing & SMS
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

           <li class="nav-item">
            <a href="/settings" class="nav-link <?php echo e('settings' == request()->path() ? 'active' : ''); ?>">
             
             <i class="nav-icon fa fa-cog"></i>
              <p>
              Reglage
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/rapports" class="nav-link <?php echo e('rapports' == request()->path() ? 'active' : ''); ?>">
              <i class="nav-icon far fa-chart-bar"></i>
              <p>
                Rapports
                
              </p>
            </a>
          </li>
        
         <li class="nav-item">
            <a href="<?php echo e(route('logout')); ?>"
                onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();" >
              <i class="nav-icon fas fa-sign-out"></i>
              <p>
                Deconnection
                
              </p>
            </a>
          </li>

          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

   <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form><?php /**PATH /htdocs/clients/logistica/admin/resources/views////includes/navbar.blade.php ENDPATH**/ ?>
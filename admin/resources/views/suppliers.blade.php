<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fournisseurs</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

   <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <style type="text/css">
    .dot {
  height: 10px;
  width: 10px;
  background-color: green;
  border-radius: 50%;
  display: inline-block;
}
  </style>
</head>
<body class="hold-transition sidebar-mini">
  <script src="https://unpkg.com/vue@3.0.11/dist/vue.global.js" ></script>
<div class="wrapper" id="app">
  <!-- Navbar -->
 @include("includes.navbar")

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Liste des fournisseurs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Fournisseurs</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

       <div class="modal fade" id="filterModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Filter</h5>
                        
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content ">
                            <form action="?">
                                
                                <div class="form-group">
                            <label class="form-label">Filter par pays</label>
                              <select  id="fee-select" class="select2 form-control" multiple="multiple" data-placeholder="selectionner communes(s)"  name="countries[]">
                               
                                 @foreach($countries as $country)
                                  <option value="{{$country[3]}}">{{$country[3]}}</option>
                                 @endforeach
                                 </select>
                                 @error('countries')
                                   <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                          </div>
                                    
                                
                          
                          <div class="form-group">
                            <label class="form-label ">Filter par produits</label>
                              <select title="Choisir produits..." id="sexe-select" class="select2 form-control" multiple="multiple" data-placeholder="selectionner produits(s)"   name="products[]">
                               
                                  @foreach($products as $product)
                                  
                                  <option  value="{{$product->id}}">{{$product->name}}</option>
                                  
                                  @endforeach
                                 
                                 </select>
                                 @error('products')
                                   <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                          </div>
                          

                           

                        <div class="form-group">
                            <label class="form-label">Montant achat superieur ou egal a</label>
                            <input name="montant" type="number" class="form-control"  >
                                

                          </div>

                          <button  class="btn btn-primary btn-block">Filtrer</button>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



       <div   class="modal fade" id="addSupplier"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addProduct" class="modal-title editModalTitle">@{{supplierTitle}}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <form method="post" enctype="multipart/form-data" :action="supplierAction" >
                            @csrf

                            <input hidden :value="supplierId" name="id">
                            <input hidden type="" name="errorTrigger" v-model="errorTrigger">
                            <div class="form-group">
                                <label>Nom du fournisseur*</label>
                                <input required value="{{old('name')}}" v-model="supplierName" name="name"  autocomplete="off" placeholder="Saisir le nom du fournisseur" class="form-control border border-primary" type="" >

                                @error('name')
                            <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                                
                            </div>

                            <div class="form-group">
                                <label>Pays*</label>
                          <select id="" v-model="supplierCountry" title="Choisir Pays" data-placeholder="Choisir pays" required class="form-control " name="country">
                           
                            @foreach($countries as $country)
                                  <option value="{{$country[3]}}">{{$country[3]}}</option>
                                 @endforeach
                                
                        </select>
                            @error('country')
                            <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                                
                            </div>

                            <div class="form-group">
                                <label>Adresse</label>
                                <input value="{{old('adress')}}" v-model="supplierAdress" name="adress" autocomplete="off" placeholder="Saisir adresse du fournisseur" class="form-control border border-primary" type="" >
                                @error('adress')
                            <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                             <div class="form-group">
                                <label>Contact*</label>
                                <input v-model="supplierContact" required name="contact" value="{{old('contact')}}" autocomplete="off" placeholder="Saisir contact du fournisseur" class="form-control border border-primary" type="number" >

                                @error('contact')
                            <span class="text-danger"role="alert">
                            <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                                
                            </div>
                             <div class="form-group">
                                <label>Whatsapp</label>
                                <input v-model="supplierWhatsapp" name="whatsapp" minlength="10" maxlength="10" value="{{old('whatsapp')}}"  autocomplete="off" placeholder="Saisir numero whatsapp du fournisseur" class="form-control border border-primary" type="number" >

                                @error('whatsapp')
                            <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                                
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="supplierEmail" name="email" autocomplete="off" placeholder="Saisir adresse email du fournisseur" value="{{old('email')}}" class="form-control border border-primary" type="email" >

                                @error('email')
                            <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                                
                            </div>

                            

                            


                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    
                </div>
            </div>
        </div>

      </div>
      <div class="container-fluid">
        
            @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

        @if($filter != "" || $search_result)    
        <div class="row">
           
           <p> <a href="/clients" class=" d-print-none">Voir tous les fournisseurs</a></p>
            </div>
        @endif        
       <div class="row mb-2">
            <form>
              <div class="input-group input-group-sm" style="width: 300px;">

                    <select name="search_type" class="form-control">
                      <option value="contact">Par contact</option>
                      <option value="email">Par mail</option>
                      <option value="name">Par nom</option>
                      <option value="whatsapp">Par Numero whatspp</option>
                    </select>
                    <input  type="text" name="search_term" class="form-control float-right" placeholder="Recherche">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form> 

                
       </div>

          @if($search_result != "")
                 <div class="row">
           <p> {{ $search_result }} </p>

            </div>

             
            @endif

        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des fournisseurs</h3>
                 @if($filter != "")
                 <br>
            {!! $filter !!} 

            <a href="/clients" class=" d-print-none">Voir tous les fournisseurs</a>
            
            @endif

                <div class="card-tools">
                  <!-- <div class="input-group input-group-sm" style="width: 150px;">
                    <input id="Search" onkeyup="search()" type="text" name="table_search" class="form-control float-right" placeholder="Recherche">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div> -->

                  <button @click="addSupplier" data-toggle="modal" data-target="#addSupplier" class="btn btn-primary mr-2">Ajouter un fournisseur</button>

                   <button data-toggle="modal" data-target="#filterModal" class="btn btn-sm btn-light phone"><ion-icon name="filter-outline"></ion-icon>Filtrer</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 600px;">
                <table id="example" class="table table-head-fixed text-nowrap">
                  <thead class=" text-primary">
                      
                      <th></th>
                      
                      <th>
                        Nom
                      </th>
                      <th>
                        Pays
                      </th>
                      <th>
                        Adresse
                      </th>
                      <th>
                        contact
                      </th>
                      <th>
                        whatsapp
                      </th>

                      <th>
                        Email
                      </th>

                      
                      
                      
                      
                    </thead>
                    <tbody>
                     
                      <tr @mouseover="updateVariant(index)" class="target" v-for="(supplier, index) in suppliers.data">
                        <td>
                      <button :id="edit+index" data-toggle="modal" data-target="#addSupplier" class="btn btn-primary" @click="editSupplier">Modifier</button>
                        </td>
                        <td>
                         @{{supplier.name}}
                         
                        </td>
                        
                        <td>
                          @{{supplier.country}}

                        </td>
                        <td>
                          @{{supplier.adress}}
                        </td>
                        <td>
                          @{{supplier.contact}}
                        </td>
                        <td>
                          @{{supplier.whatsapp}}
                        </td>

                        <td>
                          @{{supplier.email}}
                        </td>

                        
                       
                      </tr>



                     
                    </tbody>
                </table>
                {{ $suppliers->links() }}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      <button hidden id="addsupplierBtn" data-toggle="modal" data-target="#addSupplier"></button>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<script type="text/javascript">
  const app = Vue.createApp({
    data() {
        return {
            selectedVariant: 0,
            supplierAction: "createsupplier",
            supplierName: "{{old('name')}}",
            supplierCountry: "{{old('country')}}",
            supplierAdress: "{{old('adress')}}",
            supplierContact: "{{old('contact')}}",
            supplierWhatsapp: "{{old('whatsapp')}}",
            
            supplierTitle:"Ajouter un fournisseur",
            suppliers: {!! $sups !!},
            supplierEmail:"",
            supplierId: "{{old('id')}}",
            errorTrigger:"",



        }
    },
    methods:{ 
     

     revomeCategory(id){
         vm = this
    axios.post('/removecategory', {
    id: id,
    
    _token: CSRF_TOKEN,
  })

         
  .then(function (response) {
    vm.categories = response.data.updatedCategory
    console.log(response.data.updatedCategory);
  })
  .catch(function (error) {
    console.log(error);
  });
    },

   


        updateVariant(index) {
        this.selectedVariant = index
        
    },



    editSupplier(){
            this.supplierAction= "editsupplier",
            this.supplierName= this.suppliers.data[this.selectedVariant].name
            this.supplierCountry= this.suppliers.data[this.selectedVariant].country
            this.supplierAdress= this.suppliers.data[this.selectedVariant].adress
            this.supplierContact= this.suppliers.data[this.selectedVariant].contact 
            this.supplierWhatsapp= this.suppliers.data[this.selectedVariant].whatsapp
            this.supplierEmail= this.suppliers.data[this.selectedVariant].email
           
            this.supplierId= this.suppliers.data[this.selectedVariant].id

            this.supplierTitle = "Modifier client "+ this.suppliers.data[this.selectedVariant].name

            this.errorTrigger = "edit"+this.selectedVariant
    },

    
    addSupplier(){
            this.supplierAction= "createsupplier",
            this.supplierName= ""
            this.supplierCountry= ""
            this.supplierAdress= ""
            this.supplierContact= "" 
            this.supplierWhatsapp= ""
            this.supplierEmail= ""
            
            this.supplierId= 0

            this.supplierTitle = "Ajouter fournisseur "
            this.errorTrigger = "addsupplierBtn"
    },


    deleteSupplier(){
           
            
            this.supplierId = this.suppliers[this.selectedVariant].id
            
             this.supplierName= this.suppliers[this.selectedVariant].name
    },

     confirmDelete(id){
    vm = this
    axios.post('/deletesupplier', {
    id: id,

    _token: CSRF_TOKEN,
  })

         
  .then(function (response) {
    vm.products = response.data.updatedProducts
    
  })
  .catch(function (error) {
    console.log(error);
  });
    },

  
   },
   computed:{
     
    }
});

    const mountedApp = app.mount('#app')


</script>

<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
@if(old('errorTrigger'))
<script type="text/javascript">
  $("#"+"{{old('errorTrigger')}}").click();

</script>
@endif
<script type="text/javascript">
 $('#sexe-select').select2();
$('#fee-select').select2();
$('#country-select').select2();
  function search() {
    
    var input = document.getElementById("Search");
    var filter = input.value.toLowerCase();
    var nodes = document.getElementsByClassName('target');
    for (i = 0; i < nodes.length; i++) {
      if (nodes[i].innerText.toLowerCase().includes(filter)) {
        nodes[i].style.display = "block";
      } else {
        nodes[i].style.display = "none";
      }
    }
  }
</script>
</body>
</html>

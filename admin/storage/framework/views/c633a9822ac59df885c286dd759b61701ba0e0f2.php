<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mes Canaux</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
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
 <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<div class="wrapper" id="app">
  <!-- Navbar -->
 <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

 <div class="modal fade modalbox" id="addCanal"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addCanal" class="modal-title editModalTitle">{{ canalTitle }}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <form method="post"  :action="action" >
                            <?php echo csrf_field(); ?>

                            <input hidden :value="canalId" name="id">
                            <div class="form-group border-primary">
                                <label>Type</label>
                                <select :selected="type" v-model="type" name="type" class="form-control border border-primary">
                                    <option value="">Choisir type</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Whatsapp">Whatsapp</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Appel">Appel</option>
                                    <option value="sms">sms</option>
                                    <option value="Autre">Autre</option>
                                </select>
                                
                                
                            </div>

                            <div v-if="type == 'Facebook' || type == 'Instagram'" class="form-group">
                                <label>Saisir la nom de la page</label>
                                <input :value="antity"  placeholder="Nom de la page" class="form-control border border-primary" type="" name="antity">
                                
                            </div>
                           
                            
                            <div v-if="type == 'Appel' || type == 'sms' || type == 'Whatsapp'" class="form-group">
                                <label>Saisir le numero</label>
                                <input :value="antity"  placeholder="Numero de telephone" class="form-control border border-primary" type="number" name="antity">
                                
                            </div>
                            <div v-if="type == 'Autre' " class="form-group">
                                <label>Preciser la nature</label>
                                <input :value="antity" placeholder="Nature du canal" class="form-control border border-primary" type="" name="antity">
                                
                            </div>

                            <div class="form-group">
                                <label>Description (Facultatif)</label>
                                
                                <textarea name="description" class="form-control border border-primary" :value="description" rows="4" cols="4"></textarea>
                                
                            </div>



                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                        
                </div>
            </div>
        </div>
      </div>

      <div class="modal fade dialogbox" id="deleteCanal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"></h5>
                       

                    </div>
                    
                    <div class="modal-body" >
                      <form method="post" action="deletecanal">
                        <?php echo csrf_field(); ?>
                        <input hidden :value="canalId" name="id">
                          <button type="submit" class="btn btn-danger" >Confirmer</button>
                          <button type="button" class="btn btn-secondary" class="close" data-dismiss="modal">Annuler</button>
                      </form>
                        
                   
                    </div>
                   
                </div>
            </div>
        </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Liste des Canaux</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Canaux</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
            <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Canaux</h3>

                <div class="card-tools">
                 <button v-on:click="addCanal" class="btn btn-primary" data-toggle="modal" data-target="#addCanal">+ Nouveau canal</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-nowrap">
                  <thead class=" text-primary">
                      <th></th>
                      <th>
                        Nom
                      </th>
                      <th>
                        Type
                      </th>
                      <th>
                        Description
                      </th>
                     
                     
                      
                    </thead>
                    <tbody>
                      
                      <tr v-for="(canal, index) in canaux" :key="canal.id" @mouseover="updateVariant(index)">
                        
                        <td>
                         <button data-toggle="modal" data-target="#addCanal" v-on:click="editCanal" class="btn btn-primary btn-sm mr-1">Modifier</button>
                     
                      
                      <button v-on:click="editCanal"  data-toggle="modal" data-target="#deleteCanal" class="btn btn-danger btn-sm mr-1">Supprimer</button>
                        </td>
                        <td>
                         {{ canal.antity }}
                        </td>

                        <td>
                          {{ canal.type }}
                        </td>

                        <td>
                          {{ canal.description }}
                        </td>
                        
                        
                      </tr>
                      
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      
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
<!-- ./wrapper -->
<script>
         const app = Vue.createApp({
    data() {
        return {
            selectedVariant: 0,
            action: "createcanal",
            type: "",
            description:"",
            antity:"",
            canalId:"",
            canalTitle:"Ajouter un canal",
           canaux: <?php echo $canaux; ?>,
           
            
            
        }
    },
    methods:{ 


        updateVariant(index) {
        this.selectedVariant = index
        
    },



    findImage(productImg = null){
        if(productImg == null){
            src = "assets/img/sample/brand/1.jpg"
        }
        else{
            src = "https://livreurjibiat.s3.eu-west-3.amazonaws.com/"+productImg
        }

        return src
    },

    deleteCanal(){
        this.canalId = this.canaux[this.selectedVariant].id
    },

    editCanal(){
            this.action= "editcanal",
            this.antity = this.canaux[this.selectedVariant].antity
            this.description = this.canaux[this.selectedVariant].description
            this.type = this.canaux[this.selectedVariant].type
            this.canalId = this.canaux[this.selectedVariant].id
            this.canalTitle = "Modifier canal "+ this.canaux[this.selectedVariant].type + ": "+ this.canaux[this.selectedVariant].antity
    },

    
    addCanal(){
            this.action= "createcanal"
            this.antity = ""
            this.description = ""
            this.type = ""
            this.canalId = ""
            this.canalTitle = "Ajouter canal"
    }


   },
   computed:{
     
    }
});

    const mountedApp = app.mount('#app')
    </script>

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
<?php /**PATH /var/www/html/admin/resources/views/canaux.blade.php ENDPATH**/ ?>
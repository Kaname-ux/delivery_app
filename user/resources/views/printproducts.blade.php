<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Imprimer</title>
    <link rel="stylesheet" href="../assets/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <meta name="viewport"
        content="width=device-width,  viewport-fit=cover" />
    <meta name="description" content=" Système de gestion pour vendeur en ligne">
    <meta name="keywords" content="" />
    <link rel="apple-touch-icon" size="180" href="assets/img/apple-touch-icon.png">
    
    <link rel="shortcut icon" href="../img/favicon.png">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-print-css/css/bootstrap-print.min.css" media="print">

    
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }


 
@media print {
 
  .noprint{
    display: none;
  }
}
 
</style>


</head>

<body>
 <script src="https://unpkg.com/vue@3"></script> 
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule mt-0">
       <div class="section-full" id="app">
             
            
                  
                   <div class="container" >
                    <div class="row d-print-none mb-2">
                    <div class="col "> <a class="btn btn-primary" href="javascript:window.print();">Imprimer</a></div>
                </div>
                    
                   @include("includes.printable_products")
                    
                      </div>
                 
            
        </div>
        </div>
        
        <script type="text/javascript">
       const app = Vue.createApp({
    data() {
        return {
            
            
            products: {!! $products !!},
            
            
        }
    },
    methods:{
      
    findImage(productImg){
        if(productImg == null){
            src = "assets/img/sample/brand/1.jpg"
        }
        else{
            src = "https://livreurjibiat.s3.eu-west-3.amazonaws.com/"+productImg
        }

        return src
    },

    }
    });
  const mountedApp = app.mount('#app')  
   
</script>
  
     <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 
 
 <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>







     
    <!-- Google map -->
   
 

  
  
  <script type="text/javascript">
     
$('#printable').DataTable(  {

        select: true,
        paginate:false,
        dom: 'Bfrtip',
         buttons: [
       
        {
            extend: 'excel',
            text: 'Excel',
            
        },
        
    ]
        
    });


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
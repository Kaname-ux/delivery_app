

<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
     @yield("title")
  </title>


  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/now-ui-dashboard.css?v=1.3.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
  
</head>

<body class="">
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 <script src="https://unpkg.com/vue@3"></script>
  <div class="wrapper ">
    <div class="sidebar" data-color="blue">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="/dashboard" class="simple-text logo-mini">
        Shana group
        </a>
        
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class="{{'dashboard' == request()->path() ? 'active' : ''}}">
            <a href="/dashboard">
              <i class="fa fa-shopping-cart"></i>
              <p>Commandes</p>
            </a>
          </li>
          
          <!-- <li class="{{'salesmen' == request()->path() ? 'active' : ''}}">
            <a href="/salesmen">
              <i class="now-ui-icons users_single-02"></i>
              <p>Commerciaux</p>
            </a>
          </li> -->
          <li  class="{{'livreur' == request()->path() ? 'active' : ''}}">
            <a href="/livreur">
              <i class="fa fa-truck"></i>
              <p>Livreurs</p>
            </a>
          </li>


          <li  class="{{'client' == request()->path() ? 'active' : ''}}">
            <a href="/client">
              <i class="fas fa-star"></i>
              <p>Clients</p>
            </a>
          </li>

           <li  class="{{'payments' == request()->path() ? 'active' : ''}}">
            <a href="/payments">
              <i class="fas fa-dollar-sign"></i>
              <p>Payments</p>
            </a>
          </li>

           


         <li  class="{{'fee' == request()->path() ? 'active' : ''}}">
            <a href="/fee">
              <i class="fa fa-money-bill-alt"></i>
              <p>Tarifs</p>
            </a>
          </li>
          
          <li  class="{{'charge' == request()->path() ? 'active' : ''}}">
            <a href="/charge">
              <i class="now-ui-icons ui-1_bell-53"></i>
              <p>Charges</p>
            </a>
          </li>
         

         <li  class="{{'products' == request()->path() ? 'active' : ''}}">
            <a href="/products">
              <i class="now-ui-icons shopping_cart-simple"></i>
              <p>Mes articles</p>
            </a>
          </li>
          
         
          <!-- <li class="{{'role-register' == request()->path() ? 'active' : ''}}">
            <a href="/role-register">
              <i class="now-ui-icons users_single-02"></i>
              <p>Utilisateurs</p>
            </a>
          </li> -->

          


           <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    Utlisateurs
                    <span class="d-lg-none d-md-block"></span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="{{'managers' == request()->path() ? 'active' : ''}}" class="dropdown-item" href="managers">Liste d'utilisateurs</a>
                  <a class="dropdown-item" href="usergroup">Groupe d'utilisateurs</a>
                  
                </div>
              </li>


           <li class="{{'certifications' == request()->path() ? 'active' : ''}}">
            <a href="/certifications">
              <i class="now-ui-icons users_single-02"></i>
              <p>Certification</p>
            </a>
          </li>


          

           <li class="{{'rapport' == request()->path() ? 'active' : ''}}">
            <a href="/rapport">
              <i class="fa fa-stat"></i>
              <p>Rapport</p>
            </a>
          </li>
          
        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo"></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <!-- <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                  </div>
                </div>
              </div>
            </form> -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons media-2_sound-wave"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>

              <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Deconnexion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
             
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->


      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
         @yield("content")
        
     
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav>
            <!-- <ul>
              <li>
                <a href="https://www.creative-tim.com">
                  Creative Tim
                </a>
              </li>
              <li>
                <a href="http://presentation.creative-tim.com">
                  About Us
                </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
                </a>
              </li>
            </ul> -->
          </nav>
          <div class="copyright" id="copyright">
            &copy;
            <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Designed by Adamu Mahamadou
            <!-- <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by
            <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>. -->
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/now-ui-dashboard.min.js?v=1.3.0" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
 <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="../assets/js/html2canvas.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js" type="text/javascript"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

 

  <script type="text/javascript">

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var spinner = '<span  class="spinner-border  siteSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>';

     $(".showLivreur").click( function() {
        
     var cmd_id = $(this).val();
     var cur_liv = $(this).data('livid');
     var cur_liv_name =  $(this).data('livname');
     var assign_modal = $('#LivChoice');
     var assign_body = $('.LivChoiceBody');
     var top = $('.top');
     
     $(".spinner"+cmd_id).removeAttr('hidden');


       $.ajax({
         url: 'assign',
         type: 'post',
         data: {_token: CSRF_TOKEN,cmd_id: cmd_id},
     
         success: function(response){
                  $(".spinner"+cmd_id).attr('hidden', 'hidden');
                   if(cur_liv != "11"){$('.curLiv').html("livreur actuel: "+ cur_liv_name + response.unassign_btn);}
                  (assign_body).html(response.title1+ "<br>" +response.zone_output +"<br>"+response.title2+"<br>"+ response.other_output + response.assign_script);
                 
                  (top).text('Assigner Commande '+cmd_id);
                  (assign_modal).modal('show');
                   $('#loader').attr('hidden', 'hidden');
                },
     error: function(response){
                 $(".spinner"+cmd_id).attr('hidden', 'hidden');
                  alert("Une erruer s'est produite");
                }
               
       });
     });  

   $(".edit").click( function() {

    var description = $(this).data('desc');
     var date = $(this).data('date');
     var date2 = $(this).data('date2');
     var montant = $(this).data('montant');
     var fee = $(this).data('fee');
     var com = $(this).data('com');
     var adresse = $(this).data('adrs');
     var phone = $(this).data('phone');
     var id = $(this).data('id');
     var etat = $(this).data('etat');
     var observation = $(this).data('observation');
     var livphone = $(this).data('livphone');
     var livraison = $(this).data('liv');
     var livreur = $(this).data('livreur');
     var total = $(this).data('total');
     var costumer = $(this).data("costumer");
     var canal = $(this).data("canal");
     

     $("#cmdnature").val(description);
     $("#cmdlieu").val(com);
     $("#cmdid").val(id);
     $("#cmddate").val(date);
     $("#cmdprice").val(montant);
     $("#cmddate").val(date);
     $("#cmdcostumer").val(costumer);

     if(canal != "none"){
        $("#cmdsource").val(canal);
     }
     
     
     $("#cmdphone").val(phone);
     $("#cmdobservation").val(observation);

      $("#cmddestination").val(fee);
     
     if(livraison !== 'no'){
      
      if(livraison != "1000" && livraison != "1500" && livraison != "2000" && livraison != "2500" && livraison != "3000")
       {
        $('.livraison').val('autre');
        $('.autre').removeAttr("hidden");
        $('.tarif').val(livraison);
       }else{$('.livraison').val(livraison);}
     }

    $('.livreur').val(livreur);  
    $('.cmdModalTitle').html('Modifier commande n° '+id);
    $('#cmdform').attr('action', 'command-update');    
    $('#cmdMenumodal').modal('hide');
   
     $("#depositActionSheet").modal('show');
       
   
   
   
   });

    $("#assignButton").click(function(){
 if($("#bulkDiv").children().length > 0)
      {$('#bulkAssign').modal('show');}
    else{alert("Veuillez selectionner commande");}
});

   $("#reportButton").click(function(){
 if($("#bulkReport").children().length > 0)
      {$('#bulkRep').modal('show');}
    else{alert("Veuillez selectionner commande");}
}); 


 $("#statusButton").click(function(){
 if($("#bulkStatus").children().length > 0)
      {$('#bulkSts').modal('show');}
    else{alert("Veuillez selectionner commande");}
});  
 

  $("#etat").on('change',function(){
                              if($("#etat").val()== "annule"  || $("#etat").val()== "annule retour")
                                {$('.wrapper1').append("<label class='form-label'>Coupable de l'annulation</label><select class='form-control' name = 'coupable'><option>Livreur</option><option>JibiaT</option><option>Client</option><option>Fournisseur</option></select> ");

                              $('.wrapper1').append("<label class='form-label'>Détail</label><input class='form-control' name = 'coupable'> ");

                             }else{$(".wrapper1").empty();
                                   $(".wrapper2").empty();}
                             });
  

    $('#myTable').DataTable(  {

     
       

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            // total = api
            //     .column(4)
            //     .data()
            //     .reduce( function (a, b) {
            //         return intVal(a) + intVal(b);
            //     }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );


                
 

             // Update footer
           

            // Update footer
            $( api.column(9).footer() ).html(
                pageTotal + 'CFA' 
            );

            
        }, 
          

        
        "bSort" : false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                text: 'Imprimer tout',
                exportOptions: {
                    modifier: {
                        selected: null,
                        
                }
            },

            exportOptions: {
                    stripHtml: false
                    }

          },


            {
                extend: 'print',
                text: 'Imprimer selection',

                 exportOptions: {
                    stripHtml: false
                    }
            },

            { extend: 'pdf', footer: true }
        ],
        select: true,


        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,

        "bPaginate": false,

           
            




            
        
        
    }  );

     //           $('#submit').click(function(){
     // /* when the submit button in the modal is clicked, submit the form */
    
     //                $('#myForm').submit();
     //                 });



     //                    $('#submitBtn'+id).click(function() {
     // /* when the button in the form, display the entered values in the modal */
     // });

 


$('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);  
         } else {  
            $(".sub_chk").prop('checked',false);  
         }  
        });

        
        $('.delete_allannule').on('click', function(e) {


            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  


            if(allVals.length <=0)  
            {  
                alert("Veuillez seletionner commande.");  
            }  else {  


                var check = confirm("Confirmer?");  
                if(check == true){  


                    var join_selected_values = allVals.join(","); 


                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['status']) {
                                
                                alert(data['status']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                  
                }  
            }  
        });






         $('.delete_allenattente').on('click', function(e) {


            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  


            if(allVals.length <=0)  
            {  
                alert("Veuillez seletionner commande.");  
            }  else {  


                var check = confirm("Confirmer?");  
                if(check == true){  


                    var join_selected_values = allVals.join(","); 


                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['status']) {
                                $(".sub_chk:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                                alert(data['status']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                  
                }  
            }  
        });
    

        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });


        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });


            return false;
        });





  $(".showLivreurs").click( function() {
var assign_modal = $('#LivChoice');
     var assign_body = $('.LivChoiceBody');
     var top = $('.top');


              var cmd_ids = [];  
              $(".cmd_chk:checked").each(function() {  
                  cmd_ids.push($(this).attr('data-id'));
              });  


              
       $(".spinnerbulk").removeAttr('hidden');
      $.ajax({
           url: 'showlivreurs',
           type: 'post',
           data: {_token: CSRF_TOKEN,cmd_ids: cmd_ids},
       
           success: function(response){
                    $(".spinnerbulk").attr('hidden', 'hidden');
                    (assign_body).html(response.title+ "<br>" +response.output +"<br>"+ response.assign_script);
                    
                    (top).text('Assigner la selection');
                     $('#bulkModal').modal("hide");
                    (assign_modal).modal('show');

                     
                  },
       error: function(response){
                   $(".spinnerbulk").attr('hidden', 'hidden');
                    alert("Une erruer s'est produite");
                  }
                 
         });
     });



$("#day").change(function(){
  $("#day_btn").click();
});
 



                

</script>
  
  @yield("script")
</body>

</html>
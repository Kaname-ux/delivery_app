@extends("layouts.master")

@section("title")
{{$livreur->nom}}
@endsection




@section("content")
<style type="text/css">
  
  th { white-space: nowrap; }
</style>



<div class="content">



        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <!-- <a target="top" href="https://maps.app.goo.gl/NtXUbskFr6R9F1t37">Sur sur google map</a> -->
                
                @if($wme ==! NULL)
                
                <a class="fa fa-whatsapp" href="https://wa.me/{{$wme}}?text=Jibia'T Admin: Votre application est votre outil de travail. N'oubliez pas de la mettre à jour!">Envoyer une alert whatsapp</a>
                @endif
                <h6 class="card-title">
                

                  La route du livreur: {{$livreur->nom}}</h6> 
                  <h6 >
                

                  {{$livreur->phone}}</h6>
               
              </div>


              <button class="btn btn-default" data-toggle="modal" data-target="#myModal" type="button">Nouvelle commande</button>





                   

                
              

              <div class="card-body">
                <div class="table-responsive">
                

               

                
               
                 

                          <div class="container box">
   
                   <div>
                     <meta name="csrf-token" content="{{ csrf_token() }}" />

                       <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Bilan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Par client</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Par adresse</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="livreur-tab" data-toggle="tab" href="#livreur" role="tab" aria-controls="livreur" aria-selected="false">Par livreur</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">

  <!--Livrison -->
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">@if($commands->count()>0)     
             
          <!--  <button  class="btn btn-danger btn-sm delete_all" data-url="{{ url('bulk-recup') }}">J'ai recupéré les selectionnés</button> -->
          

         
               
                  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
     <div class="row">
  <div class="col-sm-6 ">
    <div class="card  ">
          <div class="card-body">
         <div class="card-title"><h1>Bilan</h1></div>
          <h4>Livraison <strong class="float-right"></strong></h4>
          <h4>Charges <strong class="float-right"></strong></h4><br>
          <h4>Resultat <strong class="float-right"></strong></h4>
         </div>
         <div class="card-footer">
           <h4>Moyenne <strong class="float-right"></strong></h4>
         </div>
              </div>
         </div>
              <div class="col-sm-6 ">
    <div class="card  text-center">
      <div class="card-body">
      <div class="card-title"><h1>Tableau des charges</h1></div>
          <div class="card-title"><h1>Bilan</h1></div>
          <h4>Livraison <strong class="float-right"></strong></h4>
          <h4>Charges <strong class="float-right"></strong></h4><br>
          <h4>Resultat <strong class="float-right"></strong></h4>
         </div>
          </h1>
          </strong>
         </div>
         </div>
             </div>
             </div>
  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    


    <div class="row">
  <div class="col-sm-6 ">
    <div class="card  ">
          <div class="card-body">
         <div class="card-title"><h1>Bilan</h1></div>
          <h4>Livraison <strong class="float-right"></strong></h4>
          <h4>Charges <strong class="float-right"></strong></h4><br>
          <h4>Resultat <strong class="float-right"></strong></h4>
         </div>
         <div class="card-footer">
           <h4>Moyenne <strong class="float-right"></strong></h4>
         </div>
              </div>
         </div>
              <div class="col-sm-6 ">
    <div class="card  text-center">
      <div class="card-body">
      <div class="card-title"><h1>Tableau des charges</h1></div>
          <div class="card-title"><h1>Bilan</h1></div>
          <h4>Livraison <strong class="float-right"></strong></h4>
          <h4>Charges <strong class="float-right"></strong></h4><br>
          <h4>Resultat <strong class="float-right"></strong></h4>
         </div>
          </h1>
          </strong>
         </div>
         </div>
             </div>
             </div>
  </div>

  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    

    <div class="row">
  <div class="col-sm-6 ">
    <div class="card  ">
          <div class="card-body">
         <div class="card-title"><h1>Bilan</h1></div>
          <h4>Livraison <strong class="float-right"></strong></h4>
          <h4>Charges <strong class="float-right"></strong></h4><br>
          <h4>Resultat <strong class="float-right"></strong></h4>
         </div>
         <div class="card-footer">
           <h4>Moyenne <strong class="float-right"></strong></h4>
         </div>
              </div>
         </div>
              <div class="col-sm-6 ">
    <div class="card  text-center">
      <div class="card-body">
      <div class="card-title"><h1>Tableau des charges</h1></div>
          <div class="card-title"><h1>Bilan</h1></div>
          <h4>Livraison <strong class="float-right"></strong></h4>
          <h4>Charges <strong class="float-right"></strong></h4><br>
          <h4>Resultat <strong class="float-right"></strong></h4>
         </div>
          </h1>
          </strong>
         </div>
         </div>
             </div>
             </div>
  </div>

  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    <div class="row">
  <div class="col-sm-6 ">
    <div class="card  ">
          <div class="card-body">
         <div class="card-title"><h1>Bilan</h1></div>
          <h4>Livraison <strong class="float-right"></strong></h4>
          <h4>Charges <strong class="float-right"></strong></h4><br>
          <h4>Resultat <strong class="float-right"></strong></h4>
         </div>
         <div class="card-footer">
           <h4>Moyenne <strong class="float-right"></strong></h4>
         </div>
              </div>
         </div>
              <div class="col-sm-6 ">
    <div class="card  text-center">
      <div class="card-body">
      <div class="card-title"><h1>Tableau des charges</h1></div>
          <div class="card-title"><h1>Bilan</h1></div>
          <h4>Livraison <strong class="float-right"></strong></h4>
          <h4>Charges <strong class="float-right"></strong></h4><br>
          <h4>Resultat <strong class="float-right"></strong></h4>
         </div>
          </h1>
          </strong>
         </div>
         </div>
             </div>
             </div>

             <div class="row">
  <div class="col-sm-6 ">
    <div class="card  ">
          <div class="card-body">
         <div class="card-title"><h1>Bilan</h1></div>
          <h4>Livraison <strong class="float-right"></strong></h4>
          <h4>Charges <strong class="float-right"></strong></h4><br>
          <h4>Resultat <strong class="float-right"></strong></h4>
         </div>
         <div class="card-footer">
           <h4>Moyenne <strong class="float-right"></strong></h4>
         </div>
              </div>
         </div>
              <div class="col-sm-6 ">
    <div class="card  text-center">
      <div class="card-body">
      <div class="card-title"><h1>Tableau des charges</h1></div>
          <div class="card-title"><h1>Bilan</h1></div>
          <h4>Livraison <strong class="float-right"></strong></h4>
          <h4>Charges <strong class="float-right"></strong></h4><br>
          <h4>Resultat <strong class="float-right"></strong></h4>
         </div>
          </h1>
          </strong>
         </div>
         </div>
             </div>
             </div>
  </div>
</div>
                  
             
                </div>
              </div>
            </div>
          </div>
         <!-- Modal -->

          

        </div>


@endsection

@section("script")
<script type="text/javascript">
  $(document).ready(function() {



    // $('#myTable').DataTable(  {

     


        
    // }  );



 $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);  
         } else {  
            $(".sub_chk").prop('checked',false);  
         }  
        });


        $('.delete_all').on('click', function(e) {


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
} );


setTimeout(function(){
       location.reload();
   },2000000);

</script>

@endsection










@extends("layouts.master")

@section("title")
dvl system
@endsection

@section("content")
<style type="text/css">
  
  th { white-space: nowrap; }
</style>
<div class="content">

  <div class="modal fade action-sheet  " id="payModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div hidden class="left payReturn">
                        <a href="#" class="headerButton returnPay">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                        Retour
                    </a>
                    </div>
                        <h5 class="modal-title">Payements</h5>
                         
                       <span class="payLivreur"></span> <span class="payTotal float-right"></span>
                       
                    
                     
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content payBody">
                            <span  hidden="hidden" class="spinner-border  paySpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
                            
                        </div>
                        <hr>
                        <div hidden class="text-center payeur">
                           
                        <img  src='' alt='img'  class='payeurimg image-block imaged w48'>
                        <br>
                          Noter  <strong class="payeurnom"></strong>
                           
                        
                    

                    
                         <input  id='input-1' name='rate' class='rating rating-loading' data-min='1' data-max='5' data-step='1'  data-size='xs'><button type='submit' class='btn btn-success rateLivreur'>Envoyer Note</button>
                          <input class="payeurid" type='hidden' name='id' required value=''>
                            
                   
                    
                
                    </div>
                    <div class="paySuccess">
                      
                    </div>
                </div>
            </div>
        </div>
      </div>


<div class="modal fade action-sheet  " id="doneModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4>Detail payment</h4> 
                       <span class="donee"></span> 
                       
                    
                     
                        

                    </div>
                    <div   class="modal-body doneModalBody">
                        
                   
                    
                
                    </div>
                    
                </div>
            </div>
        </div>
      </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <h6 class="card-title">Payments </h6>
               
              </div>

                
              
              <div class="card-body">
                <div class="table-responsive">
                 
                          



                          <div class="container box">
   
                   <div>
                   
                   <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirmer
            </div>
            <div class="modal-body">
                <h4>Voulez-vous vraiment supprimer Ce payment?</h4>

                

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <a href="#" id="submit" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
    </div>
</div>
                  
               <div class="container box">
   
                   <div>
                     <meta name="csrf-token" content="{{ csrf_token() }}" />

                       <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">En attente</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Payes</a>
  </li>
  
</ul>
<div class="tab-content" id="myTabContent">

  <!--Livrison -->
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <table id="myTable" >
                    <thead class=" text-primary">
                      <th>Livreur</th>
                      <th>
                     Montant
                      </th>
                      <th>
                        Action
                      </th>
                     
                     
                     
                      
                    </thead>
                    <tbody>
                      @if($unpayed->count()>0)
                      @foreach($unpayed as $payment)
                      <tr>
                        
                        <td>
                          @foreach($livreurs as $livreur)
                                @if($livreur->id == $payment->livreur->id)
                                {{$livreur->nom}}
                                @endif
                                @endforeach
                        </td>
                        <td>
                          {{$payment->montant}}
                        </td>
                        <td> <button  value="{{$payment->livreur->id}}"  class="btn btn-primary detail">Voir detail</button>

                            <button id='allPay{{$payment->livreur_id}}' class='btn btn-success mt-1 payall' value='{{$payment->livreur_id}}'>Tout encaisser</button>

                            <br>
      <span hidden id='allPayButtons{{$payment->livreur_id}}'>
     <div class="form-group"> 
      <select class='form-control payMethod{{$payment->livreur_id}}' >
       <option value='no'>
        Choisir mode de paiement
       </option>

       <option value='Main à main'>
       Main à main
       </option>
       <option value='Mobile money'>
       Mobile money
       </option>
       <option value='Virement bancaire'>
        Virement bancaire
       </option>
      </select>
      </div>  
      
       <button id='allPayConfirm{{$payment->livreur_id}}' value='{{$payment->livreur_id}}'  class='btn btn-info allPayConfirm'  data-allPayButtons='allPayButtons{{$payment->livreur_id}}'>
        
        <span  hidden class="spinner-border spinner-border-sm allPaySpinner{{$payment->livreur_id}}" role=status aria-hidden="true"></span><span class=sr-only></span>
       
       Confirmé</button>
       <button value='{{$payment->livreur_id}}'  class='btn btn-danger allPayCancel{{$payment->livreur_id}} allPayCancel'>Annuler</button>
      </span>
                        </td>
                        

                        
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                   
                  </table>
                  

          </div>
                

       <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

        <div class="row mt-4 mb-2">
            @foreach($payed_by_livreur as $liv_pay)
              {{$liv_pay->livreur->nom}}:  {{$liv_pay->montant}} |
            @endforeach
        </div>
       <form action="" class="date_form">
        <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Date </span>
  </div>
<input  onchange="$('.date_form').submit()" required type="date" value="{{ $day }}" name="route_day" class="form-control" type="text" id="cmddate" >
      @error('route_day')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
    </form>
<strong></strong>
<table class="table table-striped">
	<thead class=" text-primary">
    <th>Livreur</th>
    <th>Montant</th>
		<th>Commande</th>
		<th>Verser par</th>
  
	</thead>

	<tbody>
		  @foreach($payed as $done)
		<tr>
      <td>
          {{ $done->livreur->nom}} <br>
           {{$done->created_at->format("H:i:s")}}
         
      </td>
      <td>{{$done->montant}}</td>   
			
			<td>
                <span style="font-weight: italic;">By {{ $done->client->nom }}</span><br>
                {{ $done->command->id }} - {{ $done->command->description }} - {{ $done->command->adresse }} - Livre le:{{ $done->command->delivery_date->format('d-m-Y') }}</td>
            <td>
                @if($done->user_id != null)
                {{$done->user()->nom}}
                @else
                Manager
                @endif
            </td>
     
		</tr>
@endforeach

	</tbody>
</table>
  </div>


 </div>
              </div>


                </div>
              </div>
            </div>
          </div>
         <!--  <div class="col-md-12">
            <div class="card card-plain">
              <div class="card-header">
                <h4 class="card-title"> Table on Plain Background</h4>
                <p class="category"> Here is a subtitle for this table</p>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Name
                      </th>
                      <th>
                        Country
                      </th>
                      <th>
                        City
                      </th>
                      <th class="text-right">
                        Salary
                      </th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          Dakota Rice
                        </td>
                        <td>
                          Niger
                        </td>
                        <td>
                          Oud-Turnhout
                        </td>
                        <td class="text-right">
                          $36,738
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Minerva Hooper
                        </td>
                        <td>
                          Curaçao
                        </td>
                        <td>
                          Sinaai-Waas
                        </td>
                        <td class="text-right">
                          $23,789
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Sage Rodriguez
                        </td>
                        <td>
                          Netherlands
                        </td>
                        <td>
                          Baileux
                        </td>
                        <td class="text-right">
                          $56,142
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Philip Chaney
                        </td>
                        <td>
                          Korea, South
                        </td>
                        <td>
                          Overland Park
                        </td>
                        <td class="text-right">
                          $38,735
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Doris Greene
                        </td>
                        <td>
                          Malawi
                        </td>
                        <td>
                          Feldkirchen in Kärnten
                        </td>
                        <td class="text-right">
                          $63,542
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Mason Porter
                        </td>
                        <td>
                          Chile
                        </td>
                        <td>
                          Gloucester
                        </td>
                        <td class="text-right">
                          $78,615
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Jon Porter
                        </td>
                        <td>
                          Portugal
                        </td>
                        <td>
                          Gloucester
                        </td>
                        <td class="text-right">
                          $98,615
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> -->
        </div>
@endsection


@section("script")

@if(request()->has('route_day'))
<script type="text/javascript">
    $("#contact-tab").click();
</script>
@endif
<script type="text/javascript">
  $(document).ready(function() {

 $('.detail').click( function() {
   var livreur_id = $(this).val();
   
   $('#payModal').modal('show');
    
   $('.payBody').html('<span   class="spinner-border spinner-border paySpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>');


     $.ajax({
       url: 'paydetail',
       type: 'post',
       data: {_token: CSRF_TOKEN,livreur_id: livreur_id},
   
       success: function(response){
                 $('.payReturn').removeAttr('hidden');
                $('.payBody').html(response.display);
                $('.payTotal').html('<strong>Total:' +response.total + '</strong>');
                 $('.payLivreur').html(response.livreur);
                 $('#singlePayScript').html(response.single_pay_script);
              },
   error: function(response){
               
                alert('Une erruer s\'est produite');
              }
             
     });
   });



    $('.allPayConfirm').click( function() {
       var livreur_id = $(this).val();
       var method = $('.payMethod'+livreur_id).val();
       var curallPaybtns = $(this).data('allPayButtons');
    
   
   $('.allPaySpinner'+livreur_id).removeAttr('hidden');

     if(method == 'no')
     {alert('veuillez choisr une methode de paiement');

      $('.allPaySpinner'+livreur_id).attr('hidden', 'hidden');}
     else {
      $.ajax({
            url: 'payall',
            type: 'post',
            data: {_token: CSRF_TOKEN,livreur_id: livreur_id, method:method},
        
            success: function(response){
                     $('#allPayButtons'+livreur_id).attr('class', 'alert alert-success');
                     $('#allPayButtons'+livreur_id).html('Payé');
                     $('#payDetail'+livreur_id).attr('hidden', 'hidden');

                     $('.payeur').removeAttr('hidden');
                     $('.payeurid').val(livreur_id);
                     $('.payeurimg').attr('src', response.src);
                     $('.payeurnom').html(response.nom);
                      
                   },
        error: function(response){
                    
                     alert('Une erruer s\'est produite');
                     $('.allPaySpinner'+livreur_id).attr('hidden', 'hidden');
                   }
                  
          });}
   });


$('.payall').click(function(){
       $(this).attr('hidden', 'hidden');
    var id = $(this).val();
  $('#allPayButtons'+id).removeAttr('hidden');
  $('.allPayCancel'+id).removeAttr('hidden');
 
});


 $(".allPayCancel").click(function(){
   id = $(this).val();
     $(this).attr('hidden', 'hidden');
   $('#allPayButtons'+id).attr('hidden', 'hidden');
   $('#allPay'+id).removeAttr('hidden');
   $('#payDetail'+id).removeAttr('hidden');
});


 $('.doneDetail').click(function(){
  
    var doneDate = $(this).data("date"); 
    var id = $(this).data("id");
    var ids = $(this).val();
    var montant = $(this).data("montant");
    var done = $(this).data("done");
    $(".doneSpinner"+done).removeAttr("hidden");

    $.ajax({
            url: 'donedetail',
            type: 'post',
            data: {_token: CSRF_TOKEN,ids: ids, id: id},
        
            success: function(response){
                     $('.doneModalBody').html(response.dones);
                     $('.donee').html(response.livreur_nom + " - "+ montant + " - "+ doneDate);
                     $('#doneModal').modal('show');
                      $('.doneSpinner'+done).attr('hidden', 'hidden');
                   },
        error: function(response){
                    
                     alert('Une erruer s est produite');
                     $('.doneSpinner'+done).attr('hidden', 'hidden');
                   }
                  
          });
  

});



$('#submitBtn').click(function() {
     /* when the button in the form, display the entered values in the modal */
     
});

$('#submit').click(function(){
     /* when the submit button in the modal is clicked, submit the form */
    
    $('#myForm').submit();
});
     
} );


</script>

@endsection
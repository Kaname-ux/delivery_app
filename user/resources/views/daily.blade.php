@extends("layouts.master")

@section("title")
Point livreur
@endsection




@section("content")





@foreach($errors->all() as $error)
      {{$error}}
     @endforeach
   
        <div class="row">
        <script src="../assets/js/core/jquery.min.js"></script>
          <div class="col-md-14">


            <div class="card">
              <div class="content">
   


              <div class="card-header">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                  @endif
                   
                    
               

             
                  
               
               



                  </div>
      
              <div class="card-body">
                <div class="table-responsive">
               
                

                    {{$livreur->nom}}     
                    
                  
                
        
           <meta name="csrf-token" content="{{ csrf_token() }}" />

                    
                     
                       @if($payments_by_livreurs->count()>0)
                    <p  style="color: red; font-weight: bold;">
                     Vous avez 
                    Des payment(s) non réglé
                  <form   action="daily" id="due_form">
                    @csrf
                    <select style="color: white; font-weight: bold;" name="livreur_id" id='due_list' class="alert alert-danger form-control">
                      <option disabled selected>Choisir un livreur pour faire son point</option>
                      @foreach($payments_by_livreurs as $pay_by_liv)
                      @if($pay_by_liv->montant>0)
                      @foreach($livreurs as $livreur3)
                      @if($livreur3->id == $pay_by_liv->livreur_id)
                      <option value="{{$pay_by_liv->livreur_id}}">{{$livreur3->nom}} - {{$pay_by_liv->montant}} CFA impayé</option>
                      @endif
                      @endforeach
                      @endif
                      @endforeach
                      @foreach($livreurs as $livreur5)
                      @if($pay_by_liv->livreur_id != $livreur5->id)
                       <option value="{{$livreur5->id}}">{{$livreur5->nom}} </option>
                      @endif
                      @endforeach
                    </select>
                   </p>

                   </form> 
                   @else
                     <p  style=" font-weight: bold;">
                     Liste de vos livreurs
                  <form   action="daily" id="due_form">
                    @csrf
                    <select style="color: white; font-weight: bold;" name="livreur_id" id='due_list' class=" form-control">
                       <option disabled selected>Choisir un livreur pour voir son point</option>
                      
                      @foreach($livreurs as $livreur5)
                       <option value="{{$livreur5->id}}">{{$livreur5->nom}} </option>
                      
                      @endforeach
                    </select>
                   </p>

                   </form> 
                    @endif
                      
                    

                   @if($commands_by_date->count()>0)
                      
                      @foreach($commands_by_date as $y=>$by_date) 
                      
                  <div   class="card border border-warning" style="width: 22rem; ">
            <ul class="list-group list-group-flush">
              <li class="pt-6 list-group-item">
              
                Date:  <strong class=" float-right">{{date_format(date_create($by_date->cmd_date), 'd-m-Y')}}</strong>
               </li>
               <li class="pt-6 list-group-item">
                Total:  <strong class=" float-right">({{$commands_nbre_by_date[$y]->nbre}} colis){{$by_date->montant}}</strong>
               </li>
               <li class="pt-6 list-group-item">
                @foreach($done_by_date as $x=>  $did)
                @if($by_date->cmd_date == $did->cmd_date)
                 Total Livré:<strong class=" float-right">
                  @if($did->nbre>0)
                  ({{$did->nbre}} Colis){{$done_mt_by_date[$x]->montant}}</strong>
                 @else
                 Total Livré:<strong class=" float-right">0</strong>
                 @endif
                 @endif 

                 @endforeach
               </li>
                @foreach($unpayed_by_date as $unpayed)
               @if(date_format(date_create($unpayed->pay_date), 'Y-m-d') == $by_date->cmd_date)

               <li style="color: red" class="pt-6 border border-danger list-group-item">
              
               <p>
                Impayé: 
                <strong  class=" float-right"> {{$unpayed->montant}} </strong> 
                </p>
               
               </li>
               @endif
               @endforeach
               <li class="pt-6 list-group-item">
                @if($undone_by_date->count()>0) @foreach ($undone_by_date as $undone) @if($undone->cmd_date == $by_date->cmd_date)
                  <p>
                Non livré: 
                <strong style="color: red" class=" float-right"> {{$undone->nbre}} colis</strong> 
                </p>
                @endif  @endforeach @else
                Non livré: 
                <strong style="color: red" class=" float-right">0</strong> 

                 @endif
               </li>
               <li  class="pt-6 list-group-item">
                 <button value="{{$livreur->id}}" data-id="{{$by_date->cmd_date}}"class="btn btn-sm detail">Voir detail</button>

                 
               </li>
             </ul>
           </div>

                        

   


                
                

                      @endforeach

                    
                  
                  @else
                      Vous n'avez aucun point
                      @endif
                </div>
              </div>
            </div>
          </div>
         <!-- Modal -->



         <div class="modal fade" id="detailModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="title modal-title">commandes </h6>
                <form  class="form-inline" method="post" action="pay">
                  @csrf
                  <div id="pay_form">
                    
                  </div>
                </form>
            </div>
            <div class="detailBody modal-body">
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

          

        </div>





@endsection





@if (count($errors) > 0)
    <script>
        $( document ).ready(function() {
            $('#myModal').modal('show');
        });
    </script>
@endif


@section("script")

<script type="text/javascript">
  $(document).ready(function() {

   
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

   $(".detail").click( function() {
    
  var cmd_date = $(this).data('id');
  var livreur_id = $(this).val();
  var detailModal = $("#detailModal");
  var detailBody = $(".detailBody");
  var title = $(".title");
  var pay_form = $("#pay_form");

    $.ajax({
      url: 'bydatedetail',
      type: 'post',
      data: {_token: CSRF_TOKEN,cmd_date: cmd_date,livreur_id: livreur_id},
      success: function(response){

        (detailBody).html('Total:'+response.total+ '&nbsp;&nbsp; Livré: ' +response.done+ '&nbsp;&nbsp; <strong style="color: green"> &nbsp;&nbsp;Payé: '+ response.payed+'</strong> ' + '<br> <strong style="color: red">Impayé: '+ response.remain+'</strong> <br>'+'<br>'+response.display);
        (title).text(response.livreur_nom + " - " + cmd_date );
        (pay_form).html(response.pay_form);
        (detailModal).modal('show');



         
    }
});
});   




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
       
//        $('#day ').datepicker({
// language: 'fr',
// autoclose: true,
// todayHighlight: true
// })

        $("#day").change(function(){
  $("#date-form").submit();
});


     





 $("#due_list").change(function(){
  $("#due_form").submit();
});       

} );





function CopyBill() {
  /* Get the text field */

  document.getElementById("myInput").hidden = false;
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Lien de facture copié");

  document.getElementById("myInput").hidden = true;
}


 function showCommand(event) {
    var id  = $(event).data();
    let _url = `/posts`;
    $('#titleError').text('');
    $('#descriptionError').text('');
    
    $.ajax({
      url: _url,
      type: "GET",
      success: function(response) {
          if(response) {
            $("#post_id").val(response.id);
            $("#title").val(response.title);
            $("#description").val(response.description);
            $('#post-modal').modal('show');
          }
      }
    });
  }

</script>

@if(session('facture'))
<a hidden id="facture" href="{{session('facture')}}"></a>

<script type="text/javascript">
  document.getElementById("facture").click();
</script>
@endif

@endsection










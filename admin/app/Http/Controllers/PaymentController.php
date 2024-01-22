<?php

namespace App\Http\Controllers;
use App\User;
use App\Command;
use App\Client;
use App\Fee;
use App\Livreur;
use App\Friendship;
use App\Verify;
use App\Fast_command;
use App\Lesroute;
use App\Payment;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Auth;
use DateTime;
use willvincent\Rateable\Rating;

class PaymentController extends Controller
{

  

  function bydatedetail(Request $request){
    $client_id = Auth::user()->client_id;
    $cmd_date = $request->cmd_date;
    $livreur_id = $request->livreur_id;

    $livreur =Livreur::findOrFail($livreur_id);

    $commands = Command::where('client_id', $client_id)
                         ->where('livreur_id', $livreur_id)
                         ->where('delivery_date', $cmd_date)
                         ->orderBy('etat', 'asc')
                         ->get();
$payed = array(); $done = array(); $total = array(); $unpayed_ids = array();

  foreach($commands as $command){
    $pay_state = "";
    
    $total[] =  $command->montant;

     if($command->payment && $command->payment->etat == 'termine')
      {$payed[] = $command->payment->montant;
       $pay_state =" <span 'class='badge badge-success float-right'>Payé</span>";
        }

        if($command->payment && $command->payment->etat != 'termine')
      {$unpayed_ids[] = $command->payment->id;
       
        }
       
       
       
       if($command->etat == 'termine')
       {$done[] = $command->montant;} 
       

    if($command->etat == 'encours') 
                          {$class = 'class="badge badge-danger"';}
                          

                          if($command->etat == 'recupere')
                          {$class = 'class="badge badge-warning"';}
                          

                          if($command->etat == 'en chemin')
                          {$class = 'class="badge badge-warning"';}
                          


                          if($command->etat == 'termine')
                          {$class = 'class="badge badge-success"';}
                         

                          if($command->etat == 'annule')
                          {$class = 'class="badge badge-secondary"';}

          if($command->etat != 'termine')
                          {$txt = $command->etat;

                      
                          }
                           else
                           {$txt = "Livré"; }              
     $note = "";
     $note_date ="";
     if($command->note->count() > 0)
      {$note = $command->note->last()->description;
       
     }
     $cancel_btn ="";
     $active_btn ="";
     $report_btn = "";
     if($command->etat != 'termine' && $command->etat != 'annule')
     {
      $cancel_btn = "<button id='cancel_btn".$command->id."' data-id='annule' class='cancel_btn".$command->id." btn btn-danger btn-sm' value='".$command->id."' >Annuler</button>";

      $active_btn = "<button hidden='hidden' data-id='encours' class='cancel_btn".$command->id." btn btn-success btn-sm' id='active_btn".$command->id."' value='".$command->id."' >Activer</button>";
      $report_btn = "<button class='report_btn".$command->id." btn btn-success btn-sm' value='".$command->id."'>Report</button><label  hidden='hidden' class='form-label rprt_date_label".$command->id."'>Choisir date de report<input  type='date' class='form-control rprt_date".$command->id."'></label>
        <button hidden='hidden' class='cancel_report".$command->id." btn btn-danger btn-sm'  >Annuler report</button>

      <script>
      var CSRF_TOKEN = $('meta[name=\"csrf-token\"]').attr('content');
      $('.report_btn".$command->id."').click(function(){
   $('.cancel_btn".$command->id."').attr('hidden', 'hidden');
   $('.report_btn".$command->id."').attr('hidden', 'hidden');
  $('.rprt_date_label".$command->id."').removeAttr('hidden');
  $('.rprt_date".$command->id."').attr('data-id', $(this).val());
  $('.rprt_date".$command->id."').attr('data-cur', cmd_id".$command->id.");
  $('.cancel_report".$command->id."').removeAttr('hidden');
  $(this).attr('hidden', 'hidden');
}); 


$('.cancel_report".$command->id."').click(function(){
   $('#cancel_btn".$command->id."').removeAttr('hidden');
   $('.report_btn".$command->id."').removeAttr('hidden');
  $('.rprt_date_label".$command->id."').attr('hidden', 'hidden');
 
  $(this).attr('hidden', 'hidden');
}); 



 $('.rprt_date".$command->id."').change(function(){

  var cmd_id = $(this).data('id');
  var rprt_date = $(this).val();
  

  var cur_cmd = $('#cmd_id".$command->id."');
    $.ajax({
      url: 'report',
      type: 'post',
      data: {_token: CSRF_TOKEN,cmd_id: cmd_id,cmd_date: rprt_date},
      success: function(response){
       alert('Commande reportée');
       (cur_cmd).attr('hidden', 'hidden');
               
    }
});
   
}); 



$('.cancel_btn".$command->id."').click(function(){

  var state = $(this).data('id');
  var cmd_id = $(this).val();
  var active_btn = $('#active_btn".$command->id."');
  var cancel_btn = $('#cancel_btn".$command->id."');
  var cur_cmd = $('#cmd_state".$command->id."');

    $.ajax({
      url: 'cancel_cmd',
      type: 'post',
      data: {_token: CSRF_TOKEN,cmd_id: cmd_id,state: state},
      success: function(response){
        if(response.state == 'annule')
       {alert('Commande annulée');
              (cur_cmd).attr('class', 'badge badge-secondary');
              (cur_cmd).text('annule');
              (active_btn).removeAttr('hidden');
              (cancel_btn).attr('hidden', 'hidden');

            }else
            {
              alert('Commande activée');
              (cur_cmd).attr('class', 'badge badge-danger');
              (cur_cmd).text('encours');
              (active_btn).attr('hidden', 'hidden');
              (cancel_btn).removeAttr('hidden');
            }
       
    }
});
   
}); 
 </script>

      ";

     }

    $display[] = "<ul id='cmd_id".$command->id."'><li><strong>#" .$command->id. " ". $command->montant. " " .$command->adresse ." ". "</strong><span id='cmd_state".$command->id."' ". $class .">".$txt ." ".$command->updated_at->format('H:i:s'). "</span>$command->description<br>$pay_state<br>$note<br>$report_btn  $cancel_btn $active_btn</li></ul>";
                
    
  }


   $pay_form = "";
   $total = array_sum($total); $payed = array_sum($payed); $done = array_sum($done); 
   $remain = $done-$payed;
   
   if($remain>0)
    {$pay_form = '';

  foreach($unpayed_ids as $unpayed_id)
    {$pay_form .= '<input hidden type="text" name="unpayed[]" value="'.$unpayed_id.'">
                   <input hidden name="livreur_phone" value="'.$livreur->phone.'">';}
  $pay_form .= '<label class="form-label">
                Valider Payement
            <select name="pay_methode" required  class="form-control">
            <option disabled selected >Choisir mode de payement</option>
         
          
          <option value="Main a Main">Main à main</option>
          <option value="Mobile money">Mobile money</option>
          
          </select>
           </label>
          <button type="submit" class"btn btn-sm btn-success">Valider</button>';}
   return response()->json(['display'=>$display, 'livreur_nom'=>$livreur->nom, 'payed'=>$payed, 'total'=>$total, 'done'=>$done, 'remain'=>$remain, 'pay_form'=>$pay_form]);                      
  }

  public function pay(Request $request){
    $unpayed_ids = $request->unpayed;
    $cmd_ids = array();
    $pay_methode = $request->pay_methode;
    $livreur_phone = $request->livreur_phone;

    foreach($unpayed_ids as $unpayed_id)
    {
      $payment = Payment::findOrFail($unpayed_id);
      $payment->etat = 'termine';
      $payment->payment_method;
      $payment->update();


      $cmd_ids[] = $payment->command_id;
      $pay_mt[] = $payment->montant;
    }
    $pay_montant = array_sum($pay_mt);
    $each_id = implode( ", ", $cmd_ids );

  if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad')) {
    $recu = "sms:$livreur_phone&body=Payement recu: " .$pay_montant . "FCFA Pour commandes numero $each_id. ".Auth::user()->nom.".";}

  else{$recu = "sms:$livreur_phone?body=Payement recu: " .$pay_montant . "FCFA Pour commandes numero $each_id. ".Auth::user()->name.".";}
    
    return redirect()->back()->with("status", "Payement effectué")->with("facture", $recu);
  }

  
public function currentpay(Request $request){
  $livreurs = Livreur::where("status", "active")->get();
  $client_id = Auth::user()->client_id;
  foreach($livreurs as $livreur){
    $active_liv_ids[] = $livreur->id;
  }

   $payments_by_livreurs = Payment::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
     ->where('client_id', $client_id)
     ->where('etat', 'en attente')
     ->where('montant', '>', 0)
     ->whereIn('livreur_id', $active_liv_ids)
    ->groupBy('livreur_id')
    ->get();

   $payed_field = "";
    
    if($payments_by_livreurs->count() > 0)
    {foreach($payments_by_livreurs as $payed){
          $payed_field .= '<div  class="card target" style="width: 100%;border-style: solid; border-width: 1px;">
                <ul  class="list-group list-group-flush">
                <li  class="pt-6 list-group-item">';
    
                foreach($livreurs as $livreur2){
        if($payed->livreur_id == $livreur2->id){
          $payed_field .= $livreur2->nom;
         }
       }
    
      
       $payed_field .= "<span style='font-weight: bold; color:red' class='float-right'>$payed->montant</span><br>

       <button id='payDetail$payed->livreur_id' class='btn btn-info btn-sm detail' value='$payed->livreur_id'>Voir details</button> 

       <button id='allPay$payed->livreur_id' class='btn btn-info btn-sm payall' value='$payed->livreur_id'>Tout Encaiser</button>
                       </li></ul>


      <div class='row' hidden id='allPayButtons$payed->livreur_id'>

      <div class='form-group'>
      <select class='form-control payMethod$payed->livreur_id' >
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
      
       <button id='allPayConfirm$payed->livreur_id' value='$payed->livreur_id'  class='btn btn-info allPayConfirm'  data-allPayButtons='allPayButtons$payed->livreur_id'>
        
        <span  hidden=\"hidden\" class=\"spinner-border spinner-border-sm allPaySpinner$payed->livreur_id\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>
       
       Confirmé</button>
       <button value='$payed->livreur_id'  class='btn btn-danger allPayCancel$payed->livreur_id allPayCancel'>Annuler</button>
      </div>
 </div>";



      }



  $payed_field .= "


  <script>

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
                     $('#allPayButtons'+livreur_id).html('Payement effectué');
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


 $(\".allPayCancel\").click(function(){
   id = $(this).val();
     $(this).attr('hidden', 'hidden');
   $('#allPayButtons'+id).attr('hidden', 'hidden');
   $('#allPay'+id).removeAttr('hidden');
   $('#payDetail'+id).removeAttr('hidden');
});



           $('.detail').click( function() {
   var livreur_id = $(this).val();
   
    
   $('.payBody').html('<span   class=\"spinner-border spinner-border paySpinner\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>');


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
   </script>";    
    }else{
      $payed_field = "Vous n'avez pas de commande impayées.";
    }

  return response()->json(['payed_field'=>$payed_field]);
}




public function paydetail(Request $request){
    
    $livreur_id = $request->livreur_id;

    $livreur =Livreur::findOrFail($livreur_id);

    $commands = Command::whereHas('payment', function (Builder $query) {
                       $query->where('etat', '=', 'en attente');})
                       ->selectRaw('SUM(montant) montant, (client_id) client_id')
                        ->where('livreur_id', $livreur_id)
                         ->where('etat', 'termine')
                         ->groupBy('client_id')
                         
                         ->get();
$payed = array(); $done = array(); $total = array(); $unpayed_ids = array();

$single_pay_script = " <script>


 $('.allPayConfirm').click( function() {
       var livreur_id = $(this).val();
       var client_id = $(this).data('client');
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
            data: {_token: CSRF_TOKEN,livreur_id: livreur_id, client_id: client_id, method:method},
        
            success: function(response){
                     $('#allPayButtons'+client_id).attr('class', 'alert alert-success');
                     $('#allPayButtons'+livreur_id).html('Payement effectué');
                     $('#payDetail'+client_id).attr('hidden', 'hidden');

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
    var id = $(this).data('client');
  $('#allPayButtons'+id).removeAttr('hidden');
  $('.allPayCancel'+id).removeAttr('hidden');
 
});


 $(\".allPayCancel\").click(function(){
   id = $(this).data('client');
     $(this).attr('hidden', 'hidden');
   $('#allPayButtons'+id).attr('hidden', 'hidden');
   $('#allPay'+id).removeAttr('hidden');
   $('#payDetail'+id).removeAttr('hidden');
});

 $('.rtrndetail').click( function() {
   var livreur_id = $(this).val();
   
    $('.cmdRtrnBack').removeAttr('hidden');
   $('.cmdRtrnBody').html('<span   class=\"spinner-border spinner-border cmdRtrnSpinner\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>');


     $.ajax({
       url: 'cmdrtrndetail',
       type: 'post',
       data: {_token: CSRF_TOKEN,livreur_id: livreur_id},
   
       success: function(response){
                 $('.cmdRtrnReturn').removeAttr('hidden');
                $('.cmdRtrnBody').html(response.display);
                $('.cmdRtrnTotal').html('<strong>Total:' +response.total + '</strong>');
                 $('.cmdRtrnLivreur').html(response.livreur);
                 $('#cmdRtrnScript').html(response.cmd_rtrn_script);
              },
   error: function(response){
               
                alert('Une erruer s\'est produite');
              }
             
     });
   });

           $('.detailc').click( function() {
   var livreur_id = $(this).val();
   var client_id = $(this).data('client');
    
   $('.payBody').html('<span   class=\"spinner-border spinner-border paySpinner\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>');


     $.ajax({
       url: 'paydetailc',
       type: 'post',
       data: {_token: CSRF_TOKEN,livreur_id: livreur_id, client_id: client_id},
   
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
   </script>";

  foreach($commands as $command){
    $total[] = $command->montant;
  
     
 
       $display[] = "<div  class='card target ' style='width: 100%;border-style: solid; border-width: 1px; margin-bottom:5px'>
        <div class='ml-2 mr-2' >".$command->client->nom."<span class='bolder text-danger float-right'>$command->montant fcfa - Non Livré: ".$livreur->commands->whereIn("etat", ["recupere", "en chemin"])->where("id", $command->id)->count()."<div class='row mb-2' hidden id='allPayButtons$command->client_id'>
           
      <div class='form-group'>
      <select class='form-control  >
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
      </form>
       <button id='allPayConfirm$command->client_id' value='$livreur->id'  class='btn btn-info allPayConfirm' data-client='$command->client_id'  data-allPayButtons='allPayButtons$command->client_id'>
        
        <span  hidden=\"hidden\" class=\"spinner-border spinner-border-sm allPaySpinner$command->client_id\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>
       
       Confirmé</button>
       <button value='$livreur->id' data-client='$command->client_id'  class='btn btn-danger allPayCancel$command->client_id allPayCancel'>Annuler</button>
      </div>
      <button id='payDetail$command->client_id' class='btn  btn-primary btn-sm detailc' value='$livreur->id' data-client = '$command->client_id'>Détails</button> 
      <button id='allPay$command->client_id' data-client='$command->client_id' class='btn btn-info btn-sm payall'  value='$livreur->id'>Verser</button>
 </div>
 
        
    </div>";
  }

   
   return response()->json(['single_pay_script'=>$single_pay_script, 'livreur'=>$livreur->nom,  'total'=>array_sum($total), 'display'=>$display]);                      
  }


public function paydetailc(Request $request){
    $client_id = $request->client_id;
    $client = Client::findOrFail($client_id);
    $livreur_id = $request->livreur_id;

    $livreur =Livreur::findOrFail($livreur_id);

    $commands = $livreur->commands
    
    ->where("client_id", $client_id)
    ->whereIn("etat", ["recupere", "en chemin"]);

    $payments = $livreur->payments
              ->where("client_id", $client_id)
              ->where("etat", "en attente");

$payed = array(); $done = array(); $total = array(); $unpayed_ids = array();
$display = array();
$single_pay_script = "

<script>


     $('.cmdRprt').click(function(){
      var id = $(this).val();
       $('#cmdArea'+id).attr('hidden', 'hidden');
    
  $('#cmdRprtButtons'+id).removeAttr('hidden');
 
 
});


$('.cmdCncl').click(function(){
  var cur_btn = $(this);
  var state = $(this).data('id');
  var cmd_id = $(this).val();
  var active_btn = $('#active_btn'+cmd_id);
  var cancel_btn = $('#cancel_btn'+cmd_id);
  var cur_cmd = $('#cmd_state'+cmd_id);
  $(this).find('span').removeAttr('hidden');

    $.ajax({
      url: 'cancel_cmd',
      type: 'post',
      data: {_token: CSRF_TOKEN,cmd_id: cmd_id,state: state},
      success: function(response){
        cur_btn.find('span').attr('hidden', 'hidden')
        if(response.state == 'annule')
       {
              (cur_cmd).attr('class', 'badge badge-secondary');
              (cur_cmd).text('annule');
              (active_btn).removeAttr('hidden');
              (cancel_btn).attr('hidden', 'hidden');


            }else
            {
              
              (cur_cmd).attr('class', 'badge badge-danger');
              (cur_cmd).text('encours');
              (active_btn).attr('hidden', 'hidden');
              (cancel_btn).removeAttr('hidden');
            }
       
    }
});
   
}); 

 $(\".cmdCancel\").click(function(){
   id = $(this).val();
     $('#cmdCancelButtons'+id).removeAttr('hidden');
      $('#cmdArea'+id).attr('hidden', 'hidden');
});



  $('.cmdRprtConfirm').click( function() {
       var cmd_id = $(this).val();
       var rprt_date = $('.rprtDate'+cmd_id).val();
       
       var assign = 0;
       if($('#assign'+cmd_id).is(':checked')){var assign = 1;}
    
   
   $('.cmdRprtSpinner'+cmd_id).removeAttr('hidden');

     if(rprt_date == '0000-00-00')
     {alert('veuillez choisr la date de report');

      $('.cmdRprtSpinner'+cmd_id).attr('hidden', 'hidden');}
     else {
      $.ajax({
            url: 'report',
            type: 'post',
            data: {_token: CSRF_TOKEN,cmd_id: cmd_id, rprt_date:rprt_date, assign: assign},
        
            success: function(response){
                 
       $('#cur'+cmd_id).html('<span class=\'alert alert-success\'>Commande ' +cmd_id+ ' Reportée au '+rprt_date +'</span>');
                      $('.cmdRprtSpinner'+cmd_id).attr('hidden', 'hidden');
                   },
        error: function(response){
                    
                     alert('Une erreur s\'est produite');
                     $('.cmdRprtSpinner'+cmd_id).attr('hidden', 'hidden');
                   }
                  
          });}
   });


    $('.singlePay').click(function(){
       $(this).attr('hidden', 'hidden');
    var id = $(this).val();
  $('#singlePayButtons'+id).removeAttr('hidden');
  $('.singlePayCancel'+id).removeAttr('hidden');
 
});


 $(\".singlePayCancel\").click(function(){
   id = $(this).val();
     $(this).attr('hidden', 'hidden');
   $('#singlePayButtons'+id).attr('hidden', 'hidden');
   $('#singlePay'+id).removeAttr('hidden');
   
});



  $('.singlePayConfirm').click( function() {
       var cmd_id = $(this).val();
       var method = $('.payMethod'+cmd_id).val();
       var curSinglePaybtns = $(this).data('singlePayButtons');
    
   
   $('.singlePaySpinner'+cmd_id).removeAttr('hidden');

     if(method == 'no')
     {alert('veuillez choisr une methode de paiement');

      $('.singlePaySpinner'+cmd_id).attr('hidden', 'hidden');}
     else {
      $.ajax({
            url: 'singlepay',
            type: 'post',
            data: {_token: CSRF_TOKEN,cmd_id: cmd_id, method:method},
        
            success: function(response){
                 
                     $('#singlePayButtons'+cmd_id).html('<span class=\'alert alert-success\'>Payement effectué</span>');
                      
                   },
        error: function(response){
                    
                     alert('Une erruer s\'est produite');
                     $('.singlePaySpinner'+cmd_id).attr('hidden', 'hidden');
                   }
                  
          });}
   });


   $('.detail2').click( function() {
   var livreur_id = $(this).val();
   
 
    
   $('.payBody').html('<span   class=\"spinner-border spinner-border paySpinner\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>');


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

</script>";

  foreach($payments as $payment){
    $pay_state = "";
   $payarea = "";
  
      
          $total[] = $payment->montant;

          $payarea = "<span class='payArea".$payment->command->id."'>
  <button class='btn btn-info singlePay' id='singlePay".$payment->command->id."' value='".$payment->command->id."' >Encaisser</button> 
      </span>
      
     <span hidden id='singlePayButtons".$payment->command->id."'>
      <select class='form-control payMethod".$payment->command->id."' >
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
      
      
       <button id='singlePayConfirm".$payment->command->id."' value='".$payment->command->id."'  class='btn btn-info singlePayConfirm'  data-singlePayButtons='singlePayButtons".$payment->command->id."'>
        
        <span  hidden='hidden' class='spinner-border spinner-border-sm singlePaySpinner".$payment->command->id."' role='status' aria-hidden='true'></span><span class='sr-only'></span>
       
       Confirmé</button>
       <button value='".$payment->command->id."'  class='btn btn-danger singlePayCancel".$payment->command->id." singlePayCancel'>Annuler</button>
      </span>";
        


     
      
        
    
        $class = 'class="badge badge-success"';
       
     
      $txt = "Livré";

   


      $note = "";
      $note_date ="";
     if($payment->command->note->count() > 0)
      {
        $note = $payment->command->note->last()->description;
       
       }


       $display[] = "<div  class='card target' style='width: 100%;border-style: solid; border-width: 1px;'>
    <ul class='list-group list-group-flush' id='cmd_id".$payment->command->id."'><li  class='pt-6 list-group-item'><strong>#" .$payment->command->id. "</strong><span id='cmd_state".$payment->command->id."' ". $class .">".$txt . "</span><br> Date de livraison:".$payment->command->delivery_date->format('d-m-Y')."<br>". $payment->command->montant. "<br> ".$payment->command->description. "<br>".$payment->command->adresse ." ". "<span id='paystate$payment->command->id' >$pay_state</span><br>$note<br>
      $payarea
    
      </li></ul></div>
     
      

    
      ";
   
       
}


if($commands->count()>0)
  {foreach($commands as $command){
      
   
    
        
       
        
       
       if($command->etat == 'encours')   
      {$class = 'class="badge badge-danger"';
       }
  
  
        else 
      {$class = 'class="badge badge-warning"';
        }
     
      $txt = $command->etat;
  
        $note = "";
        $note_date ="";
       if($command->note->count() > 0)
        {
          $note = $command->note->last()->description;
         
         }
  
  
         $display[] = "<div id='cur".$command->id."'  class='card target' style='width: 100%;border-style: solid; border-width: 1px;'>
      <ul class='list-group list-group-flush' id='cmd_id".$command->id."'><li  class='pt-6 list-group-item'><strong>#" .$command->id. " ". "<span id='cmd_state".$command->id."' ". $class .">".$txt .  "</span><br> Date de livraison:".$command->delivery_date->format('d-m-Y') ."<br>".$command->adresse ." ". "</strong><br>$command->description<br>$command->montant FCFA<br>$note<br>
      <span id='cmdArea$command->id'>
        <button class='btn btn-info btn-sm cmdRprt' id='cmdRprt$command->id' value='$command->id' >Reporter</button> 
        
        <button class='btn btn-danger btn-sm cmdCncl' id='cancel_btn$command->id' data-id='annule' value='$command->id' >
        
        <span  hidden=\"hidden\" class=\"spinner-border spinner-border-sm \" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>


        Annuler</button> 
        <button hidden class='btn btn-success btn-sm cmdCncl' id='active_btn$command->id' data-id='encours' value='$command->id' >
          
          <span  hidden=\"hidden\" class=\"spinner-border spinner-border-sm \" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>

        Activer</button>
        </span>
        
       <span hidden id='cmdRprtButtons$command->id'>
       <label class'form-label'><strong>Reporter la commande</strong></label>
        <input type='date' class='form-control rprtDate$command->id'>
        <input id='assign$command->id' type='checkbox' name='unassigne'> Reinitialiser.
        
         <button id='cmdRprtConfirm$command->id' value='$command->id' data-curCmd='cur".$command->id."'  class='btn btn-info cmdRprtConfirm'  data-singlePayButtons='cmdRprtButtons$command->id'>
          
          <span  hidden=\"hidden\" class=\"spinner-border spinner-border-sm cmdRprtSpinner$command->id\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>
         
         Confirmé</button>
         <button value='$command->id'  class='btn btn-danger cmdRprtCancel$command->id cmdRprtCancel'>Annuler</button>
        </span>
       
        </li></ul></div>
       
        
  
      
        ";
     
         
  }}






   
   return response()->json(['single_pay_script'=>$single_pay_script, 'livreur'=>"<div> <button class='btn btn-info detail2' value='".$livreur->id."'> < </button> Point livreur <h2>".$livreur->nom. "</h2> pour client: <h2></div>".$client->nom."</h2>",'totalundone'=>$commands->count(), 'total'=>array_sum($total), 'display'=>$display]);                      
  }



public function singlepay(Request $request){
  $cmd_id = $request->cmd_id;
  $client_id = Auth::user()->client_id;
  $method = $request->method;
  $command = Command::findOrFail($cmd_id);
  $command->payment->etat = 'termine';
  $command->payment->payment_method = $method;
  $command->payment->update();

  $route = new Lesroute;
    $route->action = "PAY";
    $route->observation = $cmd_id. ",";
    $route->montant = $command->montant;
    $route->client_id = $client_id;
    $route->livreur_id = $command->livreur_id;
    $route->save();

  return response()->json(['status'=>'Payé']);

  }

public function payall(Request $request){
    $client_id = $request->client_id;
    $method = $request->method;
    $unpayeds = Payment::where('client_id', $client_id)
                         ->where("etat", "en attente")->get();

   $client = Client::findOrFail($client_id);

   


       $nom = $client->nom;
    $route_ids = "";
    $route_montant = array();

    foreach($unpayeds as $payment)
    {
      $route_montant[] = $payment->montant;
      $route_ids .= $payment->command_id. ",";
      $payment->etat = 'termine';
      $payment->payment_method = $method;
      $payment->update();
    }

  //   foreach($unpayed_ids as $unpayed_id)
  //   {
  //     $payment = Payment::findOrFail($unpayed_id);
  //     $payment->etat = 'termine';
  //     $payment->payment_method;
  //     $payment->update();


  //     $cmd_ids[] = $payment->command_id;
  //     $pay_mt[] = $payment->montant;
  //   }
  //   $pay_montant = array_sum($pay_mt);
  //   $each_id = implode( ", ", $cmd_ids );

  // if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad')) {
  //   $recu = "sms:$livreur_phone&body=Payement recu: " .$pay_montant . "FCFA Pour commandes numero $each_id. ".Auth::user()->nom.".";}

  // else{$recu = "sms:$livreur_phone?body=Payement recu: " .$pay_montant . "FCFA Pour commandes numero $each_id. ".Auth::user()->name.".";}

    $route = new Lesroute;
    $route->action = "PAY";
    $route->observation = $route_ids;
    $route->montant = array_sum($route_montant);
    $route->client_id = $request->client_id;
    $route->client_nom = $request->client_name;
    $route->payed_by = Auth::user()->name. "_". Auth::user()->phone;
  
    $route->save();


    
     return redirect()->back()->with("status", "Commandes encaissees");
  }

  public function allpay(Request $request){

    $payments = $request->pay;
    
    $client_ids = array();
    
    $livreur_id = $request->livreur_id;
    $client_id = Auth::user()->client_id;
    $livreur = Livreur::findOrFail($livreur_id);

    if(!empty($payments)){
      foreach($payments as $pay){
        $payable = Payment::findOrFail($pay);
        $payable->etat = "termine";
        $payable->payment_method = $request->method;
        $payable->user_id = Auth::user()->id;
        $payable->update();

        
     
      $client_ids[] = $payable->user_id;
      }
     
    $all_payed = Payment::whereIn("id", $payments)->get();
    $payed_by_client = Payment::selectRaw('SUM(montant) montant, (client_id) client_id')
    ->whereIn('client_id', $client_ids)
    ->groupBy('client_id')
    ->get();

    foreach($payed_by_client as $payed)
    {
        $route_ids = "";
        $route = new Lesroute;
        $route->action = "PAY";
        foreach($all_payed as $one_pay){
          if($one_pay->client_id == $payed->client_id){
             $route_ids .= $payable->command_id. ",";
          }
        }
        $route->observation = $route_ids;
        $route->montant = $payed->montant;
        $route->client_id = $payed->client_id;
        $route->livreur_id = $livreur_id;
        $route->save();
    }

    $rateable = "";

     
  
    
    return redirect()->back()->with("status", "Commandes encaissees")->with("rateable", $rateable);
    }
    
   return redirect()->back()->with("Warning", "Aucun encaissement effectué");
  }





  public function dailypay(Request $request){
     $delivery_date = date_format(date_create($request->day), "Y-m-d");
     $route_ids = "";
    $route_montant = array();
    $livreur_id = $request->livreur_id;
    $client_id = Auth::user()->client_id;

    $payments = Payment::
        join('commands', 'commands.id', '=', 'payments.command_id')
        ->where('commands.delivery_date', $delivery_date)
    
     ->where('payments.client_id', $client_id)
     ->where('payments.etat', 'en attente')
      ->where('payments.montant', '>', 0)
     ->where('commands.livreur_id', $livreur_id)
     ->get();   
    

    if($payments->count()>0){
      foreach($payments as $payable){
       
        $payable->etat = "termine";
        $payable->payment_method = $request->method;
        $payable->update();

        $route_montant[] = $payable->montant;
      $route_ids .= $payable->command_id. ",";
      }


      $route = new Lesroute;
    $route->action = "PAY";
    $route->observation = $route_ids;
    $route->montant = array_sum($route_montant);
    $route->client_id = $client_id;
    $route->livreur_id = $livreur_id;
    $route->save();


    
    return redirect()->back()->with("status", "Commandes encaissees ". array_sum($route_montant));
    }
    
   return redirect()->back()->with("warning", "Aucun encaissement effectué");
  }




  function payments(request $request){
  $livreurs = Livreur::where("status", "active")->get();
  $active_liv_ids = array();
  foreach($livreurs as $livreur){
    $active_liv_ids[] = $livreur->id;
  }



  
  $unpayed = Payment::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
     
     ->where('etat', 'en attente')
     ->where('montant', '>', 0)
     ->whereIn('livreur_id', $active_liv_ids)
    ->groupBy('livreur_id')
    ->get();

   

    function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;}

    $day = date('Y-m-d');

    if($request->route_day && validateDate($request->route_day))
    {
      $day = date_format(date_create($request->input('route_day')), 'Y-m-d');
    }

  $payed = Lesroute::orderBy("created_at", "desc")->whereDate("created_at", $day)->get();

$payed_by_livreur = Payment::selectRaw('SUM(montant) montant,  (livreur_id) livreur_id')
     ->whereDate("created_at", $day)
     ->where('etat', 'termine')
     ->where('montant', '>', 0)
     ->groupBy('livreur_id')
    
   
    ->groupBy('user_id')
    
    ->get();


    $payed = Payment::whereDate("created_at", $day)
     ->where('etat', 'termine')
     ->where('montant', '>', 0)
    
    ->get();


  return view("payments")->with("payed",$payed)->with("unpayed", $unpayed)->with('livreurs', $livreurs)->with("payed_by_livreur", $payed_by_livreur)->with("day",$day);
  }


 
public function payements(request $request){
  $livreurs = Livreur::where("status", "active")->get();
  $active_liv_ids = array();
  foreach($livreurs as $livreur){
    $active_liv_ids[] = $livreur->id;
  }

  $clients = Client::get();
  $client = Client::findOrFail(Auth::user()->client_id);

$day = date('Y-m-d');
   


     
     function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;}

    
   if($request->route_day && validateDate($request->route_day))
    {
      $day = date_format(date_create($request->input('route_day')), 'Y-m-d');

      
    }



 $recette = Command::selectRaw('SUM(livraison) livraison, SUM(montant-remise) montant, (livreur_id) livreur_id')
     
     ->where('payed_at', NULL)
     ->whereDate("delivery_date", $day)
  
    ->where("etat", "termine")
     ->whereIn('livreur_id', $active_liv_ids)
    
     ->groupBy('livreur_id')
     
            ->get();

  
  $unpayed = Command::selectRaw('SUM(montant-remise) montant, (client_id) client_id, (delivery_date) delivery_date')
                       ->where("etat", "termine")
                       ->where('cashedback_at', NULL)
                      ->whereDate("delivery_date", $day)
                      ->groupBy('client_id')
                      ->groupBy('delivery_date')
                      ->get();
    

   $payed_by_livreur = Command::selectRaw('SUM(livraison) livraison, SUM(montant-remise) montant, (cashkey) cashkey, (delivery_date) delivery_date')
      ->where("etat", "termine")
     ->where('payed_at', "!=", null)
   ->whereDate("delivery_date", $day)
     ->whereIn('livreur_id', $active_liv_ids)
     ->groupBy('delivery_date')
     ->groupBy('cashkey')
     ->get();


    $payed_by_client = Command::selectRaw('SUM(montant-remise) montant, (cashedback_key) cashedback_key')
      ->where("etat", "termine")
     ->where('payed_at', "!=", null)
   ->whereDate("delivery_date", $day)

     ->groupBy("cashedback_key")
     ->get();


    



  return view("payements")->with("payed_by_client",$payed_by_client)->with("unpayed", $unpayed)->with('livreurs', $livreurs)->with("payed_by_livreur", $payed_by_livreur)->with("day",$day)->with("recette", $recette)->with("clients",$clients);
  }

  public function payedbylivreur(Request $request){
    $client = Client::findOrFail($request->id);
    $unpayed = Command::selectRaw('SUM(montant-remise) montant, (livreur_id) livreur_id')
     ->where("client_id", $client->id)
     ->where("etat", "termine")
     ->where('cashedback_at', null)
    ->where("delivery_date", $request->delivdate)
    ->groupBy('livreur_id')
    ->get();

    $unpayed_commands =  Command::where("client_id", $client->id)
     ->where("etat", "termine")
     ->where('cashedback_at', null)
     ->where("delivery_date", $request->delivdate)
    
    ->get();

    $undelivered = Command::where("client_id", $client->id)
     ->whereIn("etat", ["encours", "en chemin", "recupere"])
     ->where("delivery_date", $request->delivdate)
    
    ->get();


    return redirect()->back()->with("by_livreur", $unpayed)->with("client", $client)->with('unpayed_commands', $unpayed_commands)->with("undelivered", $undelivered);
  }


   public function payedbyclient(Request $request){
    $livreur = Livreur::findOrFail($request->id);
    $unpayed = Command::selectRaw('SUM(montant-remise) montant, SUM(livraison) livraison, (client_id) client_id')
     ->where("livreur_id", $livreur->id)
     ->where("etat", "termine")
     ->where('payed_at', null)
     ->where('montant', '>', 0)
    ->where("delivery_date", $request->delivdate)
    ->groupBy('client_id')
    ->get();

    $unpayed_commands =  Command::where("livreur_id", $livreur->id)
     ->where("etat", "termine")
     ->where('payed_at', null)
     ->where('montant', '>', 0)
     ->where("delivery_date", $request->delivdate)
    
    ->get();


    return redirect()->back()->with("by_client", $unpayed)->with("livreur", $livreur)->with('unpayed_commands', $unpayed_commands);
  }

  public function receipt(Request $request){
    $cashedkey = $request->cashedback_key;
    

    $payed_commands =  Command::where("cashedback_key", $cashedkey)
     ->where("etat", "termine")
      ->where('cashedback_at', "!=", null)
     ->where('montant', '>', 0)
     
    
    ->get();

    $singleinfo =  Command::where("cashedback_key", $cashedkey)
     ->where("etat", "termine")
      ->where('cashedback_at', "!=", null)
     ->where('montant', '>', 0)
     
    
    ->first();

     return redirect()->back()->with("singleinfo", $singleinfo)->with('payed_commands', $payed_commands);
  }


   public function moneyreceipt(Request $request){
    $cashedkey = $request->payed_key;
    

    $payed_commands =  Command::where("cashkey", $cashedkey)
     ->where("etat", "termine")
     ->where('montant', '>', 0)
     ->where("delivery_date", $request->delivdate)
    
    ->get();

    $singleinfo =  Command::where("cashkey", $cashedkey)
     ->where("etat", "termine")
     ->where("delivery_date", $request->delivdate)
     ->where('montant', '>', 0)
     
    
    ->first();

     return redirect()->back()->with("singleinfo", $singleinfo)->with('payed_recettes', $payed_commands);
  }

  public function moneypay(Request $request){
    $ids = $request->ids;
   $cashkey = uniqid();


   $livreur_id = $request->livreur_id;
    $method = $request->method;
    
  
    $date = $request->deliv_date;
   $livreur = livreur::findOrFail($livreur_id);

   


       $nom = $livreur->nom;
    $route_ids = "";
    $route_montant = array();

   


    

    $commands = Command::where("livreur_id", $livreur_id)
                       ->where("payed_at", null)
                       ->where("etat", "termine")
                       ->whereDate("delivery_date", $request->delivdate)
                       ->get();
    foreach($commands as $command){
     
      $command->payed_to = Auth::user()->name;
      $command->update();
      $command->payed_at = $command->updated_at;
      $command->cashkey = $command->livreur->nom. "_".$cashkey;
      $command->update();
    }

    return redirect()->back()->with("status", "recette encaissées");
  }

}







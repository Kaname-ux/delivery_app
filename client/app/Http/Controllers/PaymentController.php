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
  $livreurs = Livreur::where("certified_at", "!=",null)->get();
  $client_id = Auth::user()->client_id;
  $client = Client::findOrFail($client_id);
  
   $payed_field = "";
  foreach($livreurs as $livreur)
            {
              if($livreur->commands()->orderBy("delivery_date", "desc")->where("client_id", $client->id)->whereIn("etat", ["recupere", "en chemin"])
                ->where('delivery_date', '>=', "2020-11-10")
                ->count()>0 || $livreur->payments()->orderBy("created_at", "desc")->where("client_id", $client->id)->where("etat", "en attente")->where("montant",">",0)->count()>0)
              {
                   $payed_field .= '<div  class="card target mb-2" style="width: 100%;border-style: solid; border-width: 1px;">
                <ul  class="list-group list-group-flush">
                <li  class="pt-6 list-group-item">';
                $payed_field .= $livreur->nom;

                  
                $payed_field .= "<br>Payement:<span style='font-weight: bold; color:red' >". $livreur->payments->where("client_id", $client_id)->where("etat", "en attente")->sum("montant");

                if($livreur->payments->where("client_id", $client_id)->where("etat", "en attente")->sum("montant") > 0)
                {
                  

                  $payed_field .=" <button id='allPay$livreur->id' class='btn btn-info btn-sm payall'  value='$livreur->id'>Encaiser</button>";
                }


      $payed_field .=
              "</span><br>Non Livré:<span style='font-weight: bold; color:red' >". $livreur->commands->where("client_id", $client->id)->whereIn("etat", ["recupere", "en chemin"])->where('delivery_date', '>=', "2020-11-10")->count()." 
</li></ul>
      

      <div class='row mb-2' hidden id='allPayButtons$livreur->id'>

      <div class='form-group'>
      <select class='form-control payMethod$livreur->id' >
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
      
       <button id='allPayConfirm$livreur->id' value='$livreur->id'  class='btn btn-info allPayConfirm'  data-allPayButtons='allPayButtons$livreur->id'>
        
        <span  hidden=\"hidden\" class=\"spinner-border spinner-border-sm allPaySpinner$livreur->id\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>
       
       Confirmé</button>
       <button value='$livreur->id'  class='btn btn-danger allPayCancel$livreur->id allPayCancel'>Annuler</button>
      </div>
      <button id='payDetail$livreur->id' class='btn btn-block btn-info btn-sm detail' value='$livreur->id'>details</button> 
 </div>
 

 ";

              }
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
    

  return response()->json(['payed_field'=>$payed_field]);
}




public function paydetail(Request $request){
    $client_id = Auth::user()->client_id;

    $livreur_id = $request->livreur_id;

    $livreur =Livreur::findOrFail($livreur_id);

    $commands = $livreur->commands
    ->where('delivery_date', '>=', "2020-11-10")
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






   
   return response()->json(['single_pay_script'=>$single_pay_script, 'livreur'=>$livreur->nom,'totalundone'=>$commands->count(), 'total'=>array_sum($total), 'display'=>$display]);                      
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


   

    $livreur_id = $request->livreur_id;
    $client_id = Auth::user()->client_id;
    $method = $request->method;
    $unpayeds = Payment::where('livreur_id', $livreur_id)->where('client_id', $client_id)
                         ->where("etat", "en attente")->get();
    
    $livreur = Livreur::findOrFail($livreur_id);

    if(Storage::disk('s3')->exists($livreur->photo))
      {$src=Storage::disk('s3')->url($livreur->photo);}
              else {$src="assets/img/sample/brand/1.jpg";}


       $nom = $livreur->nom;
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
    $route->client_id = $client_id;
    $route->livreur_id = $livreur_id;
    $route->save();


    
    return response()->json(['status'=>'Payé', 'src'=>$src, 'nom'=>$nom]);
  }

  public function allpay(Request $request){

    $payments = $request->pay;
    $route_ids = "";
    $route_montant = array();
    $livreur_id = $request->livreur_id;
    $client_id = Auth::user()->client_id;
    $livreur = Livreur::findOrFail($livreur_id);

    if(!empty($payments)){
      foreach($payments as $pay){
        $payable = Payment::findOrFail($pay);
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

    $rateable = "<div  hidden class='text-center payeur'>
                           
                        <img";

      if(Storage::disk('s3')->exists($livreur->photo))
      {$src=Storage::disk('s3')->url($livreur->photo);}
              else {$src="assets/img/sample/brand/1.jpg";}

     $rateable .= "src='$src' alt='img'  class='payeurimg image-block imaged w48'>
                        <br>
                          Noter  <strong class='payeurnom'>$livreur->nom</strong>
                           
                         <input  id='input-1' name='rate' class='rating rating-loading' data-min='1' data-max='5' data-step='1'  data-size='xs'><button type='submit' class='btn btn-success rateLivreur'>Envoyer Note</button>
                          <input class='payeurid' type='hidden' name='id' required value='$livreur->id'>
                          
                    </div>";
  
    
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
  $client_id = Auth::user()->client_id;
  foreach($livreurs as $livreur){
    $active_liv_ids[] = $livreur->id;
  }



  
  $unpayed = Payment::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
     ->where('client_id', $client_id)
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

  $payed = Lesroute::where("client_id", Auth::user()->client_id)->orderBy("created_at", "desc")->whereDate("created_at", $day)->get();



  return view("payments")->with("payed",$payed)->with("unpayed", $unpayed)->with('livreurs', $livreurs)->with("day",$day);
  }


 



}







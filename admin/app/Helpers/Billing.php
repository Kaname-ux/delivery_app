<?php
namespace App\Helpers;
use Exception;
use App\Command;
use App\Client;
use App\Subscription;
use App\Billing_period;

  class Billing
  {

     public function getexpiration($issue_date){

      return date('Y-m-d', strtotime($end." +30 days"));
     }

     public function taxes(){
      return 18/100; 
     }



function convertCurrencyToFrenchWords($amount, $currency = 'Francs CFA') {

  function convertNumberToFrenchWords($number) {

    $units = ['', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf'];
    $teens = ['', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf'];
    $tens = ['', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingt', 'quatre-vingt-dix'];


    if ($number < 0 || $number > 999999999) {
        return "Unsupported number. This example only supports numbers between 0 and 999,999,999.";
    }

    if ($number == 0) {
        return 'zéro';
    }

    $result = '';

    // Handle millions
    $millions = floor($number / 1000000);
    $remainder = $number % 1000000;

    if ($millions > 0) {
        $result .= convertNumberToFrenchWords($millions) . ' million';
        $result .= ($millions > 1) ? 's' : '';
        $result .= ($remainder > 0) ? ' ' : '';
    }

    // Handle thousands
    $thousands = floor($remainder / 1000);
    $remainder %= 1000;

    if ($thousands > 0) {
        if(convertNumberToFrenchWords($thousands) == "un"){
          $result .= 'mille';
        }else
        {$result .= convertNumberToFrenchWords($thousands) . ' mille';}
        $result .= ($thousands > 1) ? 's' : '';
        $result .= ($remainder > 0) ? ' ' : '';
    }

    // Handle hundreds
    $hundreds = floor($remainder / 100);
    $remainder %= 100;

    if ($hundreds > 0) {
      if($units[$hundreds] == "un"){
        $result .= 'cent';
      }else
        {$result .= $units[$hundreds] . ' cent';}
        $result .= ($remainder > 0) ? ' ' : '';
    }




    // Handle tens and units

    if ($remainder > 0) {
        if ($remainder < 10) {
            $result .= $units[$remainder];
        } else {
            $tensDigit = floor($remainder / 10);
            $unitsDigit = $remainder % 10;

            $result .= $tens[$tensDigit];
            $result .= ($unitsDigit > 0) ? '-' . $units[$unitsDigit] : '';
        }
    }

    return $result;
}
    $integerPart = floor($amount);
    $decimalPart = intval(($amount - $integerPart) * 100);

    $integerWords = convertNumberToFrenchWords($integerPart);

    // $currencyName = ($integerPart > 1) ? $currency . 's' : $currency;

    $currencyName = $currency;

    $result = $integerWords . ' ' . $currencyName;

    if ($decimalPart > 0) {
        $decimalWords = convertNumberToFrenchWords($decimalPart);
        $result .= ' et ' . $decimalWords . ' centime' . ($decimalPart > 1 ? 's' : '');
    }

    return $result;
}








     public function getCost($id, $start, $end){
      $subscription = Subscription::findOrFail($id);
      $cost = 0;
      $daily = 0;
      $interval_days = 0;
      if($subscription->subscription_type == "MAD"){
        $cost = $subscription->cost*$subscription->livreurs()->count();
      }

      if($subscription->subscription_type == "DISTRIBUTION"){
        $cost = $subscription->cost;


      }

      if($cost > 0){
        $daily = ceil($cost/30);
      }
      function isLastDayOfMonth($dateString) {
    $timestamp = strtotime($dateString);
    
    // Get the day of the month
    $day = date('j', $timestamp);
    
    // Get the total number of days in the month
    $lastDayOfMonth = date('t', $timestamp);
    
    // Check if the given date is the last day of the month
    return ($day == $lastDayOfMonth);
   }
      if(!isLastDayOfMonth($end)){
        $start = date_create($subscription->start);
         $end = date_create($subscription->end);

         $interval = $start->diff($end);

         $cost = $daily*$interval->days;
         $interval_days = $interval->days;

      }

      return ["cost"=>$cost, "daily"=>$daily, "interval_days"=>$interval_days];
     }



     public function getExtraWeight($id,  $start, $end){
       $subscription = Subscription::findOrFail($id);
       

       $command_with_extra_weight = $subscription->commands()->where("weight_unit", ">", 0)->where("weight_price" ,">", 0)->whereBetween("delivery_date", [$start, $end])->get();

       
      
      return $command_with_extra_weight;
     }

     public function getExtraZones($id, $start, $end){
      $subscription = Subscription::findOrFail($id);
      $zones = $subscription->zones;
      $commands = 0;
      if($zones != null){
        $zones_array = explode(",", $zones);

        $commands = $subscription->commands()->whereNotIn("client_destination", $zones_array)->whereBetween("delivery_date", [$start, $end])->get();

        if($commands->count() > 0){
          return $commands;

        }

      }
       
    }


    public function getUrgentCost($id, $start, $end){
      $subscription = Subscription::findOrFail($id);
      
      $commands = 0;
     
        $commands = $subscription->commands()->where("is_urgent", true)->whereBetween("delivery_date", [$start, $end])->get();

        if($commands->count() > 0){
          return $commands;

        }
 
    }

    public function getExtraQty($id, $start, $end){
      $subscription = Subscription::findOrFail($id);
      
      $commands = 0;
     
        $commands = $subscription->commands()->whereBetween("delivery_date", [$start, $end])->skip($subscription->qty)->take($subscription->commands()->count())->get();

        if($commands->count() > 0){
          return $commands;

        }
 
    }
  }

  
  
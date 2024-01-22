<br><button class="btn btn-sm btn-secondary" id="assignButton" >
   Assigner selection
</button>
<button class="btn btn-sm btn-secondary" id="reportButton" >
Reporter selection
</button>
 <button class="btn btn-sm btn-secondary" id="statusButton" >
Changer status selection
</button>
<button data-toggle="modal" data-target="#filterModal" class="btn btn-sm btn-light phone"><ion-icon name="filter-outline"></ion-icon>Filtrer
</button>

<form target="_blank" method="post" action="printing?etiquettes">
 @csrf
 <input hidden name="state" value="{{$state}}">
<input hidden name="start" value="{{$start}}">
 <input hidden name="end" value="{{$end}}">
<button class="btn btn-sm btn-light phone" type="submit">
   <ion-icon name="print-outline"></ion-icon>Imprimer Etiquettes
</button>
</form>
<br>


<meta name="csrf-token" content="{{ csrf_token() }}" />

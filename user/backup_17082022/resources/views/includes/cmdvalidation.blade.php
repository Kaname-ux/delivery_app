<div class="section full mt-4">
      @if (session('status') && session('status'))
      <div class="alert alert-success mb-1" role="alert">
      {{ session('status') }}
      </div>
      @endif
      @if(session('new_id'))
      <div class="alert alert-outline-danger mb-1" role="alert">  
      <div class="mb-1">       
      N° commande <strong style="font-size: 35px">{{ session('new_id') }}</strong>

      <input  type="checkbox" value="{{session('new_command')['data-id']}}" data-onstyle="primary" data-offstyle="secondary" class="ready"  data-onlabel="Prêt" data-offlabel="Pas prêt"  data-toggle="switchbutton" data-size="sm" >
      </div>
       <div>
       <span class="dropdown">
      
      <button style=" font-weight: bold; text-transform: uppercase;" class="btn btn-primary  dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <ion-icon name="bicycle-outline"></ion-icon>Assigner
      </button>
      <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <button class="dropdown-item showLivreur"  value="{{ session('new_id') }}" data-liv_id="11">
         <span  hidden="hidden" class="spinner-border spinner-border-sm spinner{{ session('new_id') }}" role="status" aria-hidden="true"></span><span class="sr-only"></span>
        @if($client->livreurs->count()>0)
      <ion-icon name="list-outline"></ion-icon>Choisir un livreur dans ma liste
      
      </button>@else
      <a class="dropdown-item" href="livreurs">Ajouter des livreurs à votre liste</a>
      @endif
      <button class="dropdown-item nearByLivreur"  value="{{ session('new_id') }}" ><ion-icon name="navigate-outline"></ion-icon>Trouver un livreur à proximité</button>
      </span>
      </span>
       
       
      <button style=" font-weight: bold; text-transform: uppercase;" class="btn btn-sm btn-light  cmd_menu float-right" type="button"

      @foreach(session('new_command') as $data=>$value)
      {{$data}} = "{{$value}}"
      @endforeach
      

       >
        <ion-icon name="ellipsis-vertical-outline"></ion-icon>
      
      </button>
        
       <button id="shareBill" value="{{session('bill')}}" data-desc="{{session('new_command')['data-desc']}}" data-adresse="{{session('new_command')['data-adrs'] }}" data-phone="{{ session('new_command')['data-phone'] }}" data-total="{{session('new_command')['data-total']}}" data-date="{{ session('new_command')['data-date'] }}"
       data-date2="{{ session('new_command')['data-date2'] }}" class=" btn btn-primary" ><ion-icon name="share-social-outline"></ion-icon>Facture</button>


       </div>

      

      <strong> Inscrivez ce numero au marker sur votre colis(pas besoin d'autres information). </strong>

      @if(session('add_fast') && session('add_fast') == 'ok')
        
        <button value="{{session('new_id')}}" class="btn btn-dark add_fast">
         

            Ajouter a la liste d'enregistrement rapide
        <span  hidden="hidden" class="spinner-border spinner-border-sm addFastSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
        </button>
        
        @endif
      </div>


      
        
      @endif

   </div>


   @if(session('phone_check'))
     

     
      <!-- Modal content-->
      <div class="alert alert-outline-danger mb-1" role="alert">
      ATTENTION
      Vous avez déja enregistré une  commande avec ce numéro aujourd'hui<br>
      <p><strong>{{session('phone')}}</strong></p>
      <button data-desc2="{{ session('goods_type') }}" data-id2="" data-date2="{{ session('delivery_date') }}" data-montant2="{{ session('montant') }}" data-fee2="{{ session('fee_id') }}" data-adrs2="{{ session('adresse') }}" data-phone2="{{ session('phone') }}" data-observation2="{{ session('observation') }}"  data-price="{{ session('montant') }}" data-description="{{session('goods_type')}}"

      class="btn btn-primary btn-block duplicate">Modifier</button>
           
      <form   action="/command-fast-register" method="POST">
      @csrf
      <div hidden="hidden">
      <input type="text" name="confirm" value="yes">
      <input required value="{{ session('goods_type') }}"  name="type"  type="text" >
      <input type="text"   required  value="{{ session('delivery_date') }}" name="delivery_date"  >
      <input  value="{{ session('montant') }}"  name="montant"  type="text" >
      <input value="{{ session('fee_id') }}"  required   name="fee">
      <input value="{{ session('adresse') }}" name="adresse"  type="text"  >
      <input value="{{ session('phone') }}" required  name="phone"  type="text" >
      <input maxlength="150" value="{{ session('observation') }}"  name="observation"  type="text" >
      </div>
      <button type="submit" class="btn btn-success" >Confirmer?</button>
      <a href="/dashboard" class="btn btn-success" >Annuler</a>
      </form>
    </div>
      @endif
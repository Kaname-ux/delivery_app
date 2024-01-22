@extends("layouts.master")

@section("title")
{{$client->nom}}
@endsection




@section("content")
<style type="text/css">
  
  th { white-space: nowrap; }
</style>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 <script src="https://unpkg.com/vue@3"></script> 
<div id="app">
<div class="content">
      
         <div class="modal fade " id="dateModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Date</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <form  autocomplete="off"  action='?bydate' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("yesterday"))}}'   class="form-control " type="date" name="start">
                                         <input  hidden value='{{date("Y-m-d",strtotime("yesterday"))}}'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-outline-primary btn-block "   >Hier</button>

                                        </div>
                                         </form>

                                         <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("today"))}}'   class="form-control " type="date" name="start">
                                         <input  hidden value='{{date("Y-m-d",strtotime("today"))}}'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-outline-warning btn-block "   >Aujourd'hui</button>

                                        </div>
                                         </form>
                                        
                                        <form  autocomplete="off"  action='?' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input hidden value='{{date("Y-m-d",strtotime("tomorrow"))}}'    class="form-control "  name="start">
                                         <input hidden value='{{date("Y-m-d",strtotime("tomorrow"))}}'    class="form-control "  name="end">
                                         <button class="btn btn-outline-success btn-block " type="submit"  >Demain</button>

                                        </div>
                                         </form>
                                       
                                    </div>
                                </div>
                                <div>
                              <form autocomplete="off" id="date-form" action="?">
                                @csrf
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11d">Choisir une date</label>
                                       
                                         <div  class="form-row">
                                         <div class="col">
                                         <input v-model="costumStart" value=""  class="form-control"type="date" name="start">
                                         
                                         </div>
                                         <div class="col">
                                            <button class="btn btn-primary btn-sm">Valider</button> 
                                         </div>
                                         
                                         <input hidden id="costumEnd" :value="costumStart"  class="form-control" 
                                          
                                         type="date" name="end">

                                        </div>
                                        
                                    </div>
                                </div>
                             </form>
                             </div>

                             <form autocomplete="off" id="date-form" action="?">
                                @csrf
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11d">Choisir un interval</label>
                                       
                                         <div  class="form-row">
                                         
                                         <div class="col">
                                         <input v-model="intStart" value=""  class="form-control" 
                                        
                                         type="date" name="start">
                                          </div>
                                          <div class="col">
                                         <input :disabled="!intStart" :min="intStart"  class="form-control" 
                                          
                                         type="date" name="end">
                                        </div>
                                       
                                        </div>
                                        <button class="btn btn-primary btn-sm">Valider</button> 
                                    </div>
                                </div>
                             </form>
                                

                                
                            
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
                
                <h6 class="card-title">
                

                 {{$client->nom}}</h6> 
                  <h6 >
                

                  {{$client->phone}}</h6>
               
              </div>


              <button class="btn btn-default" data-toggle="modal" data-target="#myModal" type="button">Nouvelle commande</button>


                  <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Livraison</a>
  </li>
  
</ul>
<div class="tab-content" id="myTabContent">

  <!--Livrison -->
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                
              
             
                <div class="table-responsive">
                

                <p > {{$commands->count()}} Commande à livrer 
                

                 


                 @if($commands->count() >0)
               </p> <strong> </strong> Livré. 
                @endif

                
                <div class="float-right">
                <p >Montant terminé : <strong class="float-right"></strong> </p>
                <p >Montant livraison : <strong class="float-right"></strong> </p>

                <p >Total : <strong class="float-right"></strong> </p>
                </div>
                 <h4 class="float-center"><button data-toggle="modal" data-target="#dateModal" class="btn btn-outline-primary btn-sm">{{$day}}</button> </h4>
                 <span class="border border-danger">
                  
                 
                </span>
               
                  
             @if($commands->count()>0)     
             
          <!--  <button  class="btn btn-danger btn-sm delete_all" data-url="{{ url('bulk-recup') }}">J'ai recupéré les selectionnés</button> -->
           <meta name="csrf-token" content="{{ csrf_token() }}" />
              
                   @include("includes.tabletop")
                    @include('includes.cmdtable')
              
                  @else
                      Aucune livraison 
                      @endif


                
              
               
              </div>
             
               </div>
          </div>
      </div>    
   </div>      
</div> 
</div>
</div>
<script>
   const app = Vue.createApp({
    data() {
        return {
            
            selectedVariant: 0,
            selectedCommand:"",
            total:0,
            cartProducts: [],
            cart:0,
            products: {!! $products !!},
            assignBody: "",
            state:"",
            states:[{"text":"Encours", "value":"encours"},{"text":"Livre", "value":"termine"},{"text":"Annule", "value":"annule"},],
            assign:null,
            livreur:"",
            livreur2:"",
            etat:"",
            selectedLivreur:null,
            fees:[],
            sources:[],
            livreurs:[],
            allVals:[],
            costumStart:"",
            intStart:null

        }
    },
    methods:{ 
    
    
    updateAssign(index){
        this.assign = index
    },  

    updateVariant(index) {
        this.selectedVariant = index
        
    },

   


    addToCart() {
          this.cart += 1 
          this.products[this.selectedVariant].qty += 1
          this.products[this.selectedVariant].stock -= 1
           this.total += this.products[this.selectedVariant].price 
 

    },
 
   removeFromCart() {
        this.cart -= 1
        this.products[this.selectedVariant].qty -= 1
         this.products[this.selectedVariant].stock += 1
        this.total -= this.products[this.selectedVariant].price 
      
    },

    findImage(productImg){
        if(productImg == null){
            src = "assets/img/sample/brand/1.jpg"
        }
        else{
            src = "https://livreurjibiat.s3.eu-west-3.amazonaws.com/"+productImg
        }

        return src
    },
  

    updateProducts(productIds = {}, commandid = 0) {
         this.total = 0
         this.selectedCommand = commandid

        for (a=0; a <  this.products.length; a++) {
            
                
                this.products[a].qty = 0
               
            
        }
        
        for (i=0; i < productIds.length; i++) {
            
            for (y=0; y <  this.products.length; y++) {
            if(this.products[y].id == productIds[i].product_id){
                
                this.products[y].qty = productIds[i].qty
                this.total += this.products[y].price*this.products[y].qty

                console.log(this.products[y].qty)
            }
            
        }
      }
      

    },

    updateSelectedState(state, commandId, livreur){
        this.state = state
        this.livreur = livreur
        this.selectedCommand = commandId
    }

   },
   computed:{
     
}
});

  const mountedApp = app.mount('#app')     
  </script>

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










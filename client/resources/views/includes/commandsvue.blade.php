<script>

   const app = Vue.createApp({
    data() {
        return {
            
            selectedVariant: null,
            selectedCommand:"",
            total:0,
            cartProducts: [],
            cart:0,
            products: {!! $products !!},
            commands: {!! $commands !!},
            assignBody: "",
            state:"",
            states:[{"text":"Encours", "value":"encours"},{"text":"Livre", "value":"termine"},{"text":"Annule", "value":"annule"},],
            assign:null,
            livreur:"",
            livreur2:"",
            srces:{!! $srces !!},
            etat:"",
            selectedLivreur:null,
            fees:[],
            sources:[],
            livreurs:[],
            clientLivreurs: {!! $clientlivreurs !!},
            assignee:"",
            allVals:[],
            zoneLivreur:null,
            otherLivreur:null,
            costumStart:"",
            intStart:null,
            fee:"",
            costumer:"",
            nature:"",
            source:"",
            delivery_date:"",
            montant:"",
            livraison:"",
            adresse:"",
            oth_fee:"",
            phone:"",
            phone2:"",
            livreur:"",
            observation:"",
            remise:"",
            payed: null,
            newR:null,
            cmdError:null,
            cmdNature:"",
            cmdProducts:[],
            assignees:"",
            singleCommand:[],
            deleteConfirm:null,
            zoneLast:null,
            otherLast:null,
            confirm:null,
            allFees: {!! $allfees !!},
            selectedCommands:{},
            bulkRptDate:null,
            selectedProduct:null,
            productPlus:[],
            selectedProducts:"",
            grtTotal: 0,
            cmdTotal:[],
            categories: {!! $categories !!},
             payMethod: "",
            cmdPayment: "", 
            selectedFee: null,
            tarif: null,
            feeTarifs: null,
            delai: ""
            
        }
    },
    methods:{ 

    checkAvailability(id){
  var availability = null
  for(i=0; i < this.commands.length; i++){
    if(this.commands[i].id == id){
         availability = 1
    }
  }

  return availability
 }, 
    fastFee(fee, index){
        this.fee = fee
        this.selectedFee = index
    },

     fastTarif(livraison){
        this.livraison = livraison
        this.delai = delai
    },

     getTarif(){
        this.tarif = null
        this.feeTarifs = null
        for(i = 0; i<this.allFees.length; i++){
            if(this.allFees[i].id == this.fee){
                this.tarif = this.allFees[i].price
                if(this.allFees[i].tarifs.length > 0)
                {this.feeTarifs = this.allFees[i].tarifs}
            }
        }
    }, 

    fastDate(delivery_date){
        this.delivery_date = delivery_date
    },    
    
    addProductPlus(){
        this.productPlus.push(this.products)
    },

    removeField(index){
        this.productPlus.splice(index, 1)
    },
    cmdsByfee(fee_id){
        var qties = []
        var destination = 0
        destinations = []
        for(i=0; i < this.commands.length; i++){
            if(this.commands[i].fee_id == fee_id){
                qties.push(1) 
                destination = this.commands[i].fee_id
                
            }
        }

    
       

        return [qties.length, destination]
    },


   duplicate(productIds = {}, commandid = 0){
        
        this.fee = this.singleCommand.fee_id
        this.costumer  = this.singleCommand.costumer
      this.nature  = this.singleCommand.description
      this.source  = this.singleCommand.source
      this.delivery_date  = this.singleCommand.delivery_date.substring(0, 4)  +"-"+this.singleCommand.delivery_date.substring(5, 7)+"-"+this.singleCommand.delivery_date.substring(8, 10)
       this.montant  = this.singleCommand.montant
          this.livraison  = this.singleCommand.livraison
       this.adresse  = this.singleCommand.adresse.replace(this.singleCommand.fee.destination+":", "")
      
    this.phone  = this.singleCommand.phone
    this.phone2  = this.singleCommand.phone2
    this.livreur  = this.singleCommand.livreur_id
    this.observation  = this.singleCommand.observation
 

     if(productIds.length > 0){
        this.total = 0
         this.selectedCommand = commandid

        for (a=0; a <  this.products.length; a++) {
            
                
                this.products[a].qty = 0
               
            
        }
        
        for (i=0; i < productIds.length; i++) {
            
            for (y=0; y <  this.products.length; y++) {
            if(this.products[y].id == productIds[i].id){
                
                this.products[y].qty = productIds[i].pivot.qty
                this.total += this.products[y].price*this.products[y].qty

                
            }
            
        }
      }
     }



    document.getElementById('cmdsection').scrollIntoView({behavior: 'smooth'}); document.getElementById('cmdtab').click() 
    },



     resetCmdForm(){
        
        this.fee = ""
        this.costumer  = ""
      this.nature  = ""
      this.source  = ""
      this.delivery_date  = ""
       this.montant  = ""
          this.livraison  = ""
       this.adresse  = ""
      
    this.phone  = ""
    this.phone2  = ""
    this.livreur  = ""
    this.observation  = ""
 

   
        this.total = 0
         

        for (a=0; a <  this.products.length; a++) {
            
                
                this.products[a].qty = 0
               
            
        }
      
    },

    checkAll(){

        checkboxes = document.getElementsByClassName("cmds_chk")
        if(document.getElementById("checkAll").checked == true)
        { this.selectedCommands = {}
         for (var i = 0; i < checkboxes.length; i++) { 
              checkboxes[i].checked = true;
              
            }


       for (var i = 0; i < checkboxes.length; i++) { 
              if(checkboxes[i].checked == true){
                this.selectedCommands[i] = checkboxes[i].value


              }
           }
       }
    else{
        this.selectedCommands = {}
        for (var i = 0; i < checkboxes.length; i++) { 
              checkboxes[i].checked = false;
            }
    }

        
    },

    updateSource(){
     var vm = this
     source = document.getElementById("cmdSrc").value
     

    axios.post('/updatesource', {
           
            cmdid: vm.singleCommand.id,
          
            source: source,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.canal = response.data.source
    


  })
  .catch(function (error) {
 
    console.log(error);
  });
    },
    
    updateAssign(index){
        this.assign = index
    },  

    updateVariant(index) {
        this.selectedVariant = index
        this.singleCommand = this.commands[index]

       
    },

    updateSelectedProduct(index) {
        this.selectedProduct = index
        

       
    },



   


    addToCart() {
          this.cart += 1 
          this.products[this.selectedProduct].qty += 1
          this.products[this.selectedProduct].stock -= 1
           this.total += this.products[this.selectedProduct].price 
           this.montant = this.total
 

    },
 
   removeFromCart() {
        this.cart -= 1
        this.products[this.selectedProduct].qty -= 1
         this.products[this.selectedProduct].stock += 1
        this.total -= this.products[this.selectedProduct].price 
        this.montant = this.total
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
  

    resetProducts() {
       this.total = 0
        this.nature = ""

        for (a=0; a <  this.products.length; a++) {
            
                
                this.products[a].qty = 0
               
            
        }
    },
    updateProducts(productIds = {}, commandid = 0) {
         this.total = 0
         this.selectedCommand = commandid

        for (a=0; a <  this.products.length; a++) {
            
                
                this.products[a].qty = 0
               
            
        }
        
        for (i=0; i < productIds.length; i++) {
            
            for (y=0; y <  this.products.length; y++) {
            if(this.products[y].id == productIds[i].id){
                
                this.products[y].qty = productIds[i].pivot.qty
                this.total += this.products[y].price*this.products[y].qty

                console.log(productIds)
            }
            
        }
      }
      

    },

    updateSelectedState(state, commandId, livreur){
        this.state = state
        this.livreur = livreur
        this.selectedCommand = commandId
    },



     bulkAssign(id){
            vm = this
           


         axios.post('/bulkassigncmd', {
            start:'{{$start}}',
            end:'{{$end}}',
            cmd_ids: this.selectedCommands,
            livreur_id:id
  })

         
  .then(function (response) {
    
        vm.commands = response.data.commands 
        

        
        document.getElementById("checkAll").checked = false


        checkboxes = document.getElementsByClassName("cmds_chk")
         vm.selectedCommands = {}
         for (var i = 0; i < checkboxes.length; i++) { 
              checkboxes[i].checked = false
              
            }

        document.getElementById("LivChoiceClose").click()
        document.getElementById("toast-10").classList.add("show")
       
       
  
  })
  .catch(function (error) {
    
    console.log(error);
  });
    },


    bulkReport(){
            vm = this
           
   var rprt_date = document.getElementById("bulk_rpt_date").value
      var assign = 0
       var reset = 0
       if(document.getElementById("ynbassign").checked == true){
          assign = 1
       }

        if(document.getElementById("ynbreset").checked == true){
            reset = 1
        }
         axios.post('/bulkreport', {
            start:'{{$start}}',
            end:'{{$end}}',
            reset:reset,
            assign:assign,
            cmd_ids: this.selectedCommands,
            rprt_date:rprt_date
  })

         
  .then(function (response) {
    
        vm.commands = response.data.commands 
        

        
        document.getElementById("checkAll").checked = false


        checkboxes = document.getElementsByClassName("cmds_chk")
         vm.selectedCommands = {}
         for (var i = 0; i < checkboxes.length; i++) { 
              checkboxes[i].checked = false
              
            }

        document.getElementById("bulkReportClose").click()
        document.getElementById("toast-10").classList.add("show")
       
       
  
  })
  .catch(function (error) {
    
    console.log(error);
  });
    },


    bulkReset(){
            vm = this
  
         axios.post('/bulkreset', {
            start:'{{$start}}',
            end:'{{$end}}',
            
            cmd_ids: this.selectedCommands,
           
  })

         
  .then(function (response) {
    
        vm.commands = response.data.commands 
        

        
        document.getElementById("checkAll").checked = false


        checkboxes = document.getElementsByClassName("cmds_chk")
         vm.selectedCommands = {}
         for (var i = 0; i < checkboxes.length; i++) { 
              checkboxes[i].checked = false
              
            }

        document.getElementById("bulkActionClose").click()
        document.getElementById("toast-10").classList.add("show")
       
       
  
  })
  .catch(function (error) {
    
    console.log(error);
  });
    },

    newCmd(){
            vm = this
            fee= this.fee
            costumer= this.costumer
            nature= this.nature
            source= this.source
            delivery_date= this.delivery_date
            montant= this.montant
            livraison = this.livraison
            adresse= this.adresse
            oth_fee= this.oth_fee
            phone= this.phone
            phone2= this.phone2
            remise = this.remise
            livreur= this.livreur
            observation = this.observation
             delai = this.delai
            if(document.getElementById("payed").checked == true){
                payed  = 1
            }else
            {payed = 0}

             for(i = 0; i < this.products.length; i++){
                if(this.products[i].qty > 0){
                    this.cmdProducts.push(this.products[i].id+'_'+this.products[i].qty)
                }
            }
             
             products = this.cmdProducts

             
             var element = document.getElementById("cmdcostumer")
             var bill =  document.getElementById("bill")
            document.getElementById("addCmd").disabled = true

         axios.post('/command-fast-register', {
            products:products,
            start:'{{$start}}',
            end:'{{$end}}',
            fee: fee,
            confirm:vm.confirm,
            costumer: costumer,
            remise: remise,
            type: nature,
            source: source,
            delivery_date: delivery_date,
            montant: montant,
            livraison: livraison,
            adresse: adresse,
            other_liv: oth_fee,
            phone: phone,
            phone2: phone2,
            livreur: livreur,
            observation: observation,
            payed:vm.payed,
            delai: delai,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    if(response.data.confirm != null){
        vm.confirm = response.data.confirm
    }else{
        
        vm.newR = response.data.newCmd
        vm.commands = response.data.commands 
    
                 vm.fee= ""
                vm.costumer= ""
                vm.nature= ""
                vm.source= ""
                vm.remise=""
                vm.delivery_date= ""
                vm.montant= ""
                vm.livraison = ""
                vm.adresse= ""
                vm.oth_fee= ""
                vm.phone= ""
                vm.livreur= ""
                vm.observation = ""
                vm.delai = ""
                document.getElementById("payed").checked = false
                
                vm.cmdProducts = []
                element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});

                for(i = 0; i < vm.products.length; i++){
                
                    vm.products[i].qty = 0
                           }
            vm.total = 0

           
            }
   
 
   
  
  })
  .catch(function (error) {
    addBtn.setAttribute("disabled", "disabled")
    vm.cmdError = "Une erreur s'est produite"
    console.log(error);
  });
    },



    confirmCmd(){
            vm = this

            
            fee= this.fee
            costumer= this.costumer
            nature= this.nature
            source= this.source
            remise = this.remise
            delivery_date= this.delivery_date
            montant= this.montant
            livraison = this.livraison
            adresse= this.adresse
            oth_fee= this.oth_fee
            phone= this.phone
            phone2= this.phone2
            livreur= this.livreur
            observation = this.observation
            delai = this.delai
           if(document.getElementById("payed").checked == true){
                payed  = 1
            }else
            {payed = 0}

             
             var element = document.getElementById("cmdcostumer")
             var cmdForm = document.getElementById("cmdForm")
            
         axios.post('/command-fast-register', {
            products:vm.cmdProducts,
            start:'{{$start}}',
            end:'{{$end}}',
            fee: fee,
            confirm:vm.confirm,
            costumer: costumer,
            type: nature,
            source: source,
            delivery_date: delivery_date,
            montant: montant,
            remise:remise,
            livraison: livraison,
            adresse: adresse,
            other_liv: oth_fee,
            phone: phone,
            phone2: phone2,
            livreur: livreur,
            payed:vm.payed,
            observation: observation,
            delai: delai,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
        
        vm.newR = response.data.newCmd
        vm.commands = response.data.commands 
                vm.confirm = null
                 vm.fee= ""
                vm.costumer= ""
                vm.nature= ""
                vm.source= ""
                vm.delivery_date= ""
                vm.montant= ""
                vm.livraison = ""
                vm.adresse= ""
                vm.oth_fee= ""
                vm.phone= ""
                vm.phone2= ""
                vm.livreur= ""
                vm.observation = ""
                vm.delai = ""
               document.getElementById("payed").checked = false
               vm.cmdProducts = []
      element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
 
   for(i = 0; i < vm.products.length; i++){
                
                    vm.products[i].qty = 0
               
            }
            vm.total = 0
             
  
  })
  .catch(function (error) {
    addBtn.setAttribute("disabled", "disabled")
    vm.cmdError = "Une erreur s'est produite"
    console.log(error);
  });
    },


    cancelCmd(){
                this.fee= ""
                this.costumer= ""
                document.getElementById("payed").checked == false
                this.nature= ""
                this.source= ""
                this.delivery_date= ""
                this.montant= ""
                this.livraison = ""
                this.adresse= ""
                this.oth_fee= ""
                this.phone= ""
                this.phone2= ""
                this.livreur= ""
                this.cmdProducts = []
                this.observation = ""
                this.remise =""
                this.delai = ""
                this.confirm = null
                document.getElementById("payed").checked = false
                for(i = 0; i < this.products.length; i++){
                
                    this.products[i].qty = 0
               
            }
            this.total = 0
    },


   updatePay(){
     var vm = this

    axios.post('/updatepay', {
           
            cmdid: vm.singleCommand.id ,
            etat: document.getElementById("cmdPayment").value,
            payMethod: this.payMethod,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.payment = response.data.payment

  })
  .catch(function (error) {
  alert("Une erreur s'est produite")
    console.log(error);
  });
    },
    

    updateStatus(){
     var vm = this

    axios.post('/updatestatus', {
           
            cmdid: vm.singleCommand.id ,
            etat: document.getElementById("cmdState").value,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.etat = response.data.etat

  })
  .catch(function (error) {
 
    console.log(error);
  });
    },


     updateDescription(){
     var vm = this

    axios.post('/updatedescription', {
           
            cmdid: vm.singleCommand.id ,
            type: document.getElementById("cmdDesc").value,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.description = response.data.description

  })
  .catch(function (error) {
 
    console.log(error);
  });
    },


getTotal(){
  var total = 0
  for(i=0; i < this.commands.length; i++){
    total += Number(this.commands[i].montant)
  }

  return total
 },

 getLivre(){
  var total = 0
  var nbre = 0
  for(i=0; i < this.commands.length; i++){
    if(this.commands[i].etat == 'termine')
    {total +=  Number(this.commands[i].montant)
        nbre  += 1}
  }

 livre = [total, nbre]
  return livre
},

    updateObs(){
     var vm = this

    axios.post('/updateobservation', {
           
            cmdid: vm.singleCommand.id ,
            obs: document.getElementById("cmdObs").value,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.observation = response.data.observation

  })
  .catch(function (error) {
 
    console.log(error);
  });
    },


    updateClient(){
     var vm = this

    axios.post('/updateclient', {
           
            cmdid: vm.singleCommand.id ,
            client: document.getElementById("cmdClt").value,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.nom_client = response.data.client

  })
  .catch(function (error) {
 
    console.log(error);
  });
    },


     updateAdresse(){
     var vm = this

    axios.post('/updateadresse', {
           
            cmdid: vm.singleCommand.id ,
            fee: document.getElementById("cmdFee").value,
            adresse: document.getElementById("cmdAdrs").value,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.fee = response.data.fee
    vm.singleCommand.adresse = response.data.adresse
    
   


  })
  .catch(function (error) {
 
    console.log(error);
  });
    },



    updateCost(){
     var vm = this
     montant = document.getElementById("cmdMontant").value
     livraison = document.getElementById("cmdLiv").value

    axios.post('/updatecost', {
           
            cmdid: vm.singleCommand.id ,
            livraison: livraison, 
            montant: montant,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.livraison = Number(response.data.livraison)
    vm.singleCommand.montant = Number(response.data.montant)


  })
  .catch(function (error) {
 
    console.log(error);
  });
    },



    updateDate(){
     var vm = this

    axios.post('/updatedate', {
           
            cmdid: vm.singleCommand.id ,
            ddate: document.getElementById("ddate").value,
            start:'{{$start}}',
            end:'{{$end}}',
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand = response.data.singleCommand
    vm.commands = response.data.commands


   console.log(vm.singleCommand)

  })
  .catch(function (error) {
 
    console.log(error);
  });
    },


    updatePhone(){
     var vm = this

    axios.post('/updatephone', {
           
            cmdid: vm.singleCommand.id ,
            phone: document.getElementById("cmdPhone").value,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.phone = response.data.phone

  })
  .catch(function (error) {
 
    console.log(error);
  });
},

deleteCmd(){
     var vm = this

    axios.post('/deletecmd', {
           
            cmdid: vm.singleCommand.id ,
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.commands.splice(vm.selectedVariant, 1)
    vm.selectedVariant = null

  })
  .catch(function (error) {
 
    console.log(error);
  });
},


    getLivreurs(){
     var vm = this
     document.getElementById("assignees").innerHTML = '<span   class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span><span class="sr-only"></span>'
    axios.post('/assign', {
           
            cmd_id: vm.singleCommand.id ,
           
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
  
   vm.zoneLivreur = response.data.zone_livreurs
   vm.otherLivreur = response.data.other_livreurs
   vm.zoneLast = response.data.zonelast
   vm.otherLast = response.data.otherlast

   
    document.getElementById("assignees").innerHTML = ''
    

  })
  .catch(function (error) {
   document.getElementById("assignees").innerHTML = "Une erreur s'est produite"
    console.log(error);
  });
    },


    assignLiv(id){
     var vm = this
    var element = document.getElementById("livDEtail") 
    
    axios.post('/assigncommand', {
           
            cmd_id: vm.singleCommand.id ,
            livreur_id:id ,
           
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
   
    vm.singleCommand.livreur = response.data.livreur
    
  element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
  })
  .catch(function (error) {
    element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
   document.getElementById("assignees").innerHTML = "Une erreur s'est produite"
    console.log(error);
  });
    },



    getLivreurCmds(id, index, type){
     var vm = this
    document.getElementById(type+"Detail"+index).innerHTML = '<span   class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span><span class="sr-only"></span>'
    axios.post('/getlivreurcmds', {
           
            livreur_id:id ,
           
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
   
    
    document.getElementById(type+"Detail"+index).innerHTML = response.data.livreurcmds
  })
  .catch(function (error) {
   document.getElementById(type+"Detail"+index).innerHTML = "Une erreur s'est produite"
    console.log(error);
  });
    },



    prepareCmd(id){
     var vm = this
     
    axios.post('/ready', {
           
            cmdid:id,
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.ready = response.data.newstate
    
  

  })
  .catch(function (error) {
    
    console.log(error);
  });
    },


     getNote(id){
     var vm = this
     
    axios.post('/getnote', {
           
            cmdid:id,
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
    
  document.getElementById('noteViewBody').innerHTML = response.data.result

  })
  .catch(function (error) {
    
    console.log(error);
  });
    },




     getEvent(id){
     var vm = this
     
    axios.post('/getevent', {
           
            cmdid:id,
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
    
  document.getElementById('eventViewBody').innerHTML = response.data.result

  })
  .catch(function (error) {
    
    console.log(error);
  });
    },
    

    shareBill(text){
       
  if (navigator.share) {
    navigator.share({
      title: 'Facture',
      text: text,
      
    }).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }

    },

 checkCmd(id){

      var checkboxes = document.getElementsByClassName("cmds_chk")
       for (var i = 0; i < checkboxes.length; i++) { 
              if(checkboxes[i].checked == true){
                this.selectedCommands[i] = checkboxes[i].value


              }
              if(checkboxes[i].checked == false)
              {
                
                delete this.selectedCommands[i]; 
              }
            }
          
 }

   },
   computed:{
   
     getSelectedProducts(){
        this.selectedProducts = ""
        for(i=0; i<this.products.length; i++){
        if(this.products[i].qty > 0){ 
         this.selectedProducts +=   this.products[i].qty + ' '+ this.products[i].name + "," 
        }
      } 
      if(this.selectedProducts != "")
      {this.nature = this.selectedProducts}
      return this.nature
    },
}
});

  const mountedApp = app.mount('#app')     

   
  Vue.component('v-select', VueSelect.VueSelect); 
  </script>
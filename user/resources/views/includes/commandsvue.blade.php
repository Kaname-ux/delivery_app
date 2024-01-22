 <script>



   const app = Vue.createApp({

    data() {

        return {
            departments: null,
            madLivreurs: null,
            subsId: "",
             allAssigned: '{{$all_commands->where("livreur_id", 11)->count()}}',
            clientTip: "Commencez à taper son nom pour le selectionner. ",

            providerName: "",

              showProvSuggestions: false,

              swu: [{"id":"SWU","created_at":"2023-06-20 06:37:52","updated_at":"2023-06-20 06:37:52","nom":"Nouveau client","phone":"","city":"","adresse":"","":null,"wme":null,"user_id":"","latitude":null,"longitude":null,"photo":null,"manager_id":null,"is_manager":null,"is_certifier":null,"is_collecter":null,"client_type":null,"cc_id":null}],

             filteredProvSuggestions: [],  

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

            delai: "",

            provider:"",

            srces:{!! $srces !!},

            etat:"",

            selectedLivreur:null,

            fees:[],

            sources:[],

            livreurs:[],

            clientLivreurs: {!! $livreurs !!},

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
            plis: "",
            type: "",
            delivType: "",
            poids: "",
            subsType: "",

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

            selectedCommands:[],

            bulkRptDate:null,

            selectedProduct:null,

            productPlus:[],

            selectedProducts:"",

            grtTotal: 0,

            cmdTotal:[],

            ids:[],

            categories: {!! $categories !!},

            successText:"",

            selectedSubscriber: "",



            payText:"",

            unpayedClass:"btn btn-danger btn-sm",

            payedClass:"btn btn-success btn-sm",

            payEtat:"",

            moyens:["Main a main", "Mobile money", "Virement bancaire"],

            confirmText:"",

            confirmTitle:"",

            selectedPay: "", 

            selectedMoyen: "",

            payAll:null,

            livreur2: "",

            selectedDate: null,

            payMethod: "",

            cmdPayment: "", 

            processing: null,





            singleFee:"",

            singlePhone1:"",

            provName: "",

            provPhone:"",

            provAdresse: "",

            provCity: "",
            distribProviderName:"",
            providers: {!! $providers !!},
            madproviders: {!! $madproviders !!},
            distribproviders: {!! $distribproviders !!},

            selectedFee: null,

            tarif: null,

            feeTarifs: null,

            displayed: "table",



             suggestionsList:{!! $bclients !!},

              showSuggestions: false,

             filteredSuggestions: [],

            unasigned:0,

            input: "",

            input2: ""

        }

},



  methods:{ 

getMadLivreurs(){
    vm = this
    this.processing = 1
    if(this.subsId && subsType == "MAD"){
      

      axios.post('/getmadlivreur', {
 id: vm.singleCommand.id ,
 subscriber: subsId,
 _token: CSRF_TOKEN

  })

.then(function (response) {
vm.madLivreurs = response.data.livreurs

vm.processing = 0


  })

  .catch(function (error) {

   vm.processing = 0

    console.log(error);

  });
    }
},  



getClientDeprtment(id){
    vm = this
    this.processing = 1
    
      

      axios.post('/getclientdepartment', {
     id: id ,

 _token: CSRF_TOKEN

  })

.then(function (response) {
 if(response.data.departments.length > 0)   
{vm.departments = response.data.departments}

vm.processing = 0


  })

  .catch(function (error) {

   vm.processing = 0

    console.log(error);

  });
    
},   

handleProvInput(providers) {

      if(providers == "providers"){
        antity = this.providers
        var inputText = this.providerName.toLowerCase().trim();
      }

      if(providers == "distribproviders"){
        antity = this.distribproviders
        var inputText = this. distribProviderName.toLowerCase().trim();
      }

      if(providers == "madproviders"){
        antity = this.madproviders
        var inputText = this.providerName.toLowerCase().trim();
      }

      this.showProvSuggestions = true;

      

      this.filteredProvSuggestions = antity.filter((suggestion) =>

        suggestion.nom.toLowerCase().startsWith(inputText)

      );

    },

    selectProvSuggestion(suggestion) {

        if(suggestion.id == "SWU"){

         this.clientTip = "Entrez les informations du nouveau client"



         this.providerName = ""

             this.provider = suggestion.id

             this.provName = ""

           this.provPhone = ""

           this.provCity = ""

           this.provAdresse = ""

        }else

       { 

        this.providerName = suggestion.nom

             this.provider = suggestion.id;

             this.provName = suggestion.nom

           this.provPhone = suggestion.phone

           this.provCity = suggestion.city

           this.provAdresse = suggestion.adresse
           
        
       

             for(i=0; i<this.allFees.length;i++){

               if(this.allFees[i].destination.toLowerCase() == suggestion.city.toLowerCase()){

                   this.fee = this.allFees[i].id

               }

             }

      if(suggestion.subscriptions[0])
    {this.subsId = suggestion.subscriptions[0].id}
             vm = this
    this.processing = 1
    if(this.subsId && this.subsType == "MAD"){
      

      axios.post('/getmadlivreurs', {
 id: vm.subsId,
 _token: CSRF_TOKEN

  })

.then(function (response) {
vm.madLivreurs = response.data.livreurs

vm.processing = 0


  })

  .catch(function (error) {

   vm.processing = 0

    console.log(error);

  });
    }


 axios.post('/getclientdepartments', {
     id: suggestion.id ,

 _token: CSRF_TOKEN

  })

.then(function (response) {
vm.departments = response.data.departments

vm.processing = 0


  })

  .catch(function (error) {

   vm.processing = 0

    console.log(error);

  });


            
         }

   

      this.showProvSuggestions = false;

    },



    searchInput(){







const dataTable = document.getElementById('cmdTable');

const tableRows = dataTable.getElementsByTagName('tr');





    const searchTerm = this.input2.toLowerCase();



    // Loop through all table rows and hide/show based on the search term

    for (let i = 1; i < tableRows.length; i++) {

        const row = tableRows[i];

        const rowData = row.getElementsByTagName('td');



        let foundMatch = false;

        for (let j = 0; j < rowData.length; j++) {

            const cell = rowData[j];

            if (cell) {

                const cellValue = cell.textContent.toLowerCase();

                if (cellValue.includes(searchTerm)) {

                    foundMatch = true;

                    break;

                }

            }

        }



        if (foundMatch) {

            row.style.display = '';

        } else {

            row.style.display = 'none';

        }

    }





    },





   search() {

    

    

    var filter = this.input.toLowerCase();

    var nodes = document.getElementsByClassName('target');

    for (i = 0; i < nodes.length; i++) {

      if (nodes[i].innerText.toLowerCase().includes(filter)) {

        nodes[i].style.display = "block";

      } else {

        nodes[i].style.display = "none";

      }

    }



    $('html, body').animate({

  scrollTop: $(".commands").offset().top

});

  },





 

resetCheck(){

    this.selectedCommands = []

    checkboxes = document.getElementsByClassName('cmds_chk')

     checkboxes1 = document.getElementsByClassName('cmds_chk1')

        for (var i = 0; i < checkboxes.length; i++) { 

              checkboxes[i].checked = false;

              checkboxes1[i].checked = false;

            }



            document.getElementById('checkAll1').checked = false;

            document.getElementById('checkAll').checked = false;

 },      





 handleInput() {

      this.showSuggestions = true;

      const inputText = this.costumer.toLowerCase().trim();

      this.filteredSuggestions = this.suggestionsList.filter((suggestion) =>

        suggestion.nom.toLowerCase().startsWith(inputText)

      );

    },

    selectSuggestion(suggestion) {

      this.costumer = suggestion.nom;

      this.phone = suggestion.contact



      for(i=0; i<this.allFees.length;i++){

        if(this.allFees[i].destination.toLowerCase() == suggestion.commune.toLowerCase()){

            this.fee = this.allFees[i].id

        }

      }

      this.adresse = suggestion.adresse

      this.showSuggestions = false;

    },

printElement(elementToPrint) {

    // Get the element with the desired ID

    const element = document.getElementById(elementToPrint);



    // Check if the element exists

    if (element) {

        // Print the innerHTML of the element

        old = document.body.innerHTML

        document.body.innerHTML = element.innerHTML

          window.print();

          location.reload()

        console.log(element.innerHTML);

    } else {

        console.log('Element not found.');

    }

},



      getClass(index){

        if(this.commands[index].livreur_id == 11 ){

            return "target table-warning"

        }else{

             return "target"

        }

    },

     fastFee(fee, index){

        this.fee = fee

        this.selectedFee = index

    },



     fastTarif(livraison, delai){

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



       getProvName(){

        if(this.provider != ""){

            for(x= 0; x<this.providers.length; x++){

               if(this.providers[x].id == this.provider){

                this.provName = this.providers[x].nom

                this.provPhone = this.providers[x].phone

                this.provCity = this.providers[x].city

                this.provAdresse = this.providers[x].adresse

               }

            }

        }



    },

    updateProvider(index){

      this.processing = 1  

     var vm = this

     subscriber = this.selectedSubscriber

    

     



    axios.post('/updateprovider', {

           

            cmdid: vm.singleCommand.id ,

          

            subscriber: subscriber,

          



            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

    vm.singleCommand.client = null

    vm.singleCommand.client = response.data.client

     vm.singleCommand.client_id = response.data.client.id

  

    vm.processing = 0



   



    









  })

  .catch(function (error) {

   vm.processing = 0

    console.log(error);

  });

    },



      updateRam(){

      this.processing = 1  

     var vm = this

     

     ramCommune = document.getElementById("ramCommune").value

     ramAdresse = document.getElementById("ramAdresse").value

     ramPhone = document.getElementById("ramPhone").value

     ramName = document.getElementById("ramName").value

     



    axios.post('/updateram', {

           

            cmdid: vm.singleCommand.id ,

          

           

            ram_adresse: ramAdresse,

            ram_phone: ramPhone,

            ram_name: ramName,

            ram_commune: ramCommune,



            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

  

vm.singleCommand.ram_nom =    response.data.name

vm.singleCommand.ram_adresse =    response.data.adresse

vm.singleCommand.ram_phone =    response.data.phone

vm.singleCommand.ram_commune =    response.data.commune

   

    vm.processing = 0





  })

  .catch(function (error) {

   vm.processing = 0

    console.log(error);

  });

    },



     





    checkAvailability(id){

  var availability = null

  for(i=0; i < this.commands.length; i++){

    if(this.commands[i].id == id){

         availability = 1

    }

  }



  return availability

 },   

    updatePayAll(){

        this.selectedDate = null

        this.selectedPay = null

        this.payAll = 1

        this.confirmTitle = "Encaisser tout"

    },



    updateSelectedDate(ddate, formated){

        this.payAll = null

        this.selectedPay = null

        this.selectedDate = ddate

        

        this.confirmTitle = "Encaissement  "+ formated



        console.log(ddate)

    },

    confirmpay(payid){

    this.payAll = null

    this.selectedDate = null    

    this.selectedPay = payid

    this.confirmTitle = "Encaissement commande "+ payid

    this.payText = "Quelle est le moyen de Payement"

    },



    singlePay(){

        id = "pay"+this.selectedPay

         axios.post('/singlepay', {

    cmd_id: this.selectedPay,

    method: this.selectedMoyen,



    _token: CSRF_TOKEN,

  })

  .then(function (response) {

    actualPay = document.getElementById(id)

    actualPay.className = ""

    actualPay.classList.add('btn', 'btn-success','btn-sm')

    actualPay.innerText = 'Commande encaissee'

  })

  .catch(function (error) {

    console.log(error);

  });

    },





    

    addProductPlus(){

        this.productPlus.push(this.products)

    },



    removeField(index){

        this.productPlus.splice(index, 1)

    },



    print(){

        this.ids = []

        for(i=0; i < this.commands.length; i++){

            

                this.ids.push(this.commands[i].id) 

                

         }

         

        

          

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





    checkAll(cmds_chk, checkAll){



        checkboxes = document.getElementsByClassName(cmds_chk)

        if(document.getElementById(checkAll).checked == true)

        { this.selectedCommands = []

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

        this.selectedCommands = []

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

 



    },

 

   removeFromCart() {

        this.cart -= 1

        this.products[this.selectedProduct].qty -= 1

         this.products[this.selectedProduct].stock += 1

        this.total -= this.products[this.selectedProduct].price 

      

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

           

         var currentCommands = []

         for(i = 0; i<this.commands.length; i++){

            currentCommands.push(this.commands[i].id)

         }



         axios.post('/bulkassigncmd', {

            

            cmd_ids: this.selectedCommands,

            current: currentCommands,

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

        document.getElementById("stateModal").classList.add("show")

       

       

  

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

        vm.successText = response.data.message

       

       

  

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

   

    duplicate(productIds = {}, commandid = 0){

        

        this.fee = this.singleCommand.fee_id

        this.remise = this.singleCommand.remise

        this.costumer  = this.singleCommand.nom_client

      this.nature  = this.singleCommand.description

      if(this.singleCommand.source != null)

      {this.source  = this.singleCommand.source}

      this.delivery_date  =this.singleCommand.delivery_date.substring(0, 4)  +"-"+this.singleCommand.delivery_date.substring(5, 7)+"-"+this.singleCommand.delivery_date.substring(8, 10)

        

        



       this.montant  = this.singleCommand.montant

          this.livraison  = this.singleCommand.livraison

       this.adresse  = this.singleCommand.adresse.replace(this.singleCommand.fee.destination+":", "")

      

    this.phone  = this.singleCommand.phone

    this.phone2  = this.singleCommand.phone2

    this.livreur  = this.singleCommand.livreur_id

    this.observation  = this.singleCommand.observation

 



     if(productIds.length > 0){

        this.total = 0

        this.cart = 0

         this.selectedCommand = commandid



        for (a=0; a <  this.products.length; a++) {

            

                

                this.products[a].qty = 0

               

            

        }

        

        for (i=0; i < productIds.length; i++) {

            

            for (y=0; y <  this.products.length; y++) {

            if(this.products[y].id == productIds[i].id && this.products[y].stock >= productIds[i].pivot.qty){

                

                this.products[y].qty = productIds[i].pivot.qty

                this.total += this.products[y].price*this.products[y].qty

                

                

            }

            

        }

      }



      this.cart = productIds.length

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

      this.remise = ""

    this.phone  = ""

    this.phone2  = ""

    this.livreur  = ""

    this.observation  = ""

   

 



   

        this.total = 0

         



        for (a=0; a <  this.products.length; a++) {

            

                

                this.products[a].qty = 0

               

            

        }

      

    },

    newCmd(){



            vm = this

           
            department = this.department
            provName = this.provName

            provPhone = this.provPhone

            provAdresse = this.provAdresse

            provCity = this.provCity

            fee= this.fee

            plis = this.plis

            type = this.type
            delivType = this.delivType
            poids = this.poids
            subsType = this.subsType

            costumer= this.costumer

            nature= this.nature

            remise= this.remise

            source= this.source

            delai = this.delai

            provider = this.provider

            delivery_date= this.delivery_date

            montant= this.montant

            livraison = this.livraison

            adresse= this.adresse

            oth_fee= this.oth_fee

            phone= this.phone

            phone2= this.phone2

            livreur= this.livreur

            observation = this.observation
            payed = 0
            maddecharge = 0
            distribdecharge = 0
            if(document.getElementById("payed"))
            {if(document.getElementById("payed").checked == true){
            
                            payed  = 1
            
                        }
                    }


            if(document.getElementById("maddecharge"))
            {if(document.getElementById("maddecharge").checked == true){

                maddecharge  = 1

            }
           }
            
            if(document.getElementById("distribdecharge"))
            {if(document.getElementById("distribdecharge").checked == true){

                distribdecharge  = 1

            }
        }

             for(i = 0; i < this.products.length; i++){

                if(this.products[i].qty > 0){

                    this.cmdProducts.push(this.products[i].id+'_'+this.products[i].qty)

                }

            }

             

             products = this.cmdProducts



             this.ids = []

        for(i=0; i < this.commands.length; i++){

            

                this.ids.push(this.commands[i].id) 

                

         }



             

             var element = document.getElementById("cmdSuccess")

            document.getElementById("addCmd").disabled = true



         axios.post('/command-fast-register', {
           
            department: department,
            maddecharge: maddecharge,
            distribdecharge: distribdecharge,
            products:products,

            start:'{{$start}}',

            end:'{{$end}}',

            fee: fee,

            ids: vm.ids,

            delai: delai,

            provider: provider,

            confirm:vm.confirm,

            costumer: costumer,

            nature: nature,

            delivType: delivType,
            poids: poids,
            source: source,

            remise: remise,

            delivery_date: delivery_date,

            montant: montant,

            livraison: livraison,

            adresse: adresse,

            other_liv: oth_fee,

            phone: phone,

            phone2: phone2,

            livreur: livreur,

            observation: observation,

            payed:payed,

            provName: provName,

            provPhone: provPhone,

            provAdresse: provAdresse,

             provCity: provCity,
            
            plis: plis,
            type: type,
            delivType: delivType,
            poids: poids,
            subsType: subsType,


            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

    if(response.data.confirm != null){

        vm.confirm = response.data.confirm

    }else if(response.data.error){
        alert(response.data.error)
    }


    else{

        

        vm.newR = response.data.newCmd

        vm.commands = response.data.commands 

       vm.providers = response.data.providers

                 vm.fee= ""

                vm.costumer= ""

                vm.plis = ""
                vm.type = ""
                vm.delivType = ""
                vm.poids = ""
                vm.subsType = ""

                vm.nature= ""

                vm.remise = ""

                vm.source= ""

                vm.delai = ""

               vm.provider = ""

                vm.delivery_date= ""

                vm.montant= ""

                vm.livraison = ""

                vm.adresse= ""

                vm.oth_fee= ""

                vm.phone= ""

                vm.phone2=""

                vm.livreur= ""

                vm.observation = ""

                

                vm.payed = null

                document.getElementById("payed").checked = false
                document.getElementById("maddecharge").checked = false
                document.getElementById("distribdecharge").checked = false

                element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});



                for(i = 0; i < vm.products.length; i++){

                

                    vm.products[i].qty = 0

                           }

            vm.total = 0

            vm.cmdProducts = []

            }

   

 

   

  

  })

  .catch(function (error) {

    addBtn.setAttribute("disabled", "disabled")

    vm.cmdError = "Une erreur s'est produite"

    console.log(error);

  });

    },






newDistrib(){



            vm = this

            provName = this.provName

            provPhone = this.provPhone

            provAdresse = this.provAdresse

            provCity = this.provCity

            fee= this.fee

            plis = this.plis
            type = this.type
            delivType = this.delivType
            poids = this.poids
            subsType = this.subsType

            costumer= this.costumer

            nature= this.nature

            remise= this.remise

            source= this.source

            delai = this.delai

            provider = this.provider

            delivery_date= this.delivery_date

            montant= this.montant

            livraison = this.livraison

            adresse= this.adresse

            oth_fee= this.oth_fee

            phone= this.phone

            phone2= this.phone2

            livreur= this.livreur

            observation = this.observation
            payed = 0
            maddecharge = 0
            distribdecharge = 0
            if(document.getElementById("payed"))
            {if(document.getElementById("payed").checked == true){
            
                            payed  = 1
            
                        }
                    }


            if(document.getElementById("maddecharge"))
            {if(document.getElementById("maddecharge").checked == true){

                maddecharge  = 1

            }
           }
            
            if(document.getElementById("distribdecharge"))
            {if(document.getElementById("distribdecharge").checked == true){

                distribdecharge  = 1

            }
        }

             for(i = 0; i < this.products.length; i++){

                if(this.products[i].qty > 0){

                    this.cmdProducts.push(this.products[i].id+'_'+this.products[i].qty)

                }

            }

             

             products = this.cmdProducts



             this.ids = []

        for(i=0; i < this.commands.length; i++){

            

                this.ids.push(this.commands[i].id) 

                

         }



             

             var element = document.getElementById("cmdSuccess")

            document.getElementById("addCmd").disabled = true



         axios.post('/distribregister', {

            products:products,

            start:'{{$start}}',

            end:'{{$end}}',

            fee: fee,

            ids: vm.ids,

            delai: delai,

            provider: provider,

            confirm:vm.confirm,

            costumer: costumer,

            nature: nature,
            
            source: source,

            remise: remise,

            delivery_date: delivery_date,

            montant: montant,

            livraison: livraison,

            adresse: adresse,

            other_liv: oth_fee,

            phone: phone,

            phone2: phone2,

            livreur: livreur,

            observation: observation,

            payed:payed,

            provName: provName,

            provPhone: provPhone,

            provAdresse: provAdresse,

             provCity: provCity,
            
            plis: plis,
            type: type,
            subsType: subsType,


            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

    if(response.data.confirm != null){

        vm.confirm = response.data.confirm

    }else{

        

        vm.newR = response.data.newCmd

        vm.commands = response.data.commands 

       vm.providers = response.data.providers

                 vm.fee= ""

                vm.costumer= ""

                vm.plis = ""
                
                vm.type = ""
                vm.delivType = ""
                vm.poids = ""
                vm.nature= ""

                vm.remise = ""

                vm.source= ""

                vm.delai = ""

               vm.provider = ""

                vm.delivery_date= ""

                vm.montant= ""

                vm.livraison = ""

                vm.adresse= ""

                vm.oth_fee= ""

                vm.phone= ""

                vm.phone2=""

                vm.livreur= ""

                vm.observation = ""

                

                vm.payed = null

                document.getElementById("payed").checked = false

                element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});



                for(i = 0; i < vm.products.length; i++){

                

                    vm.products[i].qty = 0

                           }

            vm.total = 0

            vm.cmdProducts = []

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



            
            department = this.department
            fee= this.fee

            costumer= this.costumer

            nature= this.nature

            source= this.source

            delai = this.delai

            provider = this.provider

            delivery_date= this.delivery_date

            montant= this.montant

            livraison = this.livraison

            adresse= this.adresse

            oth_fee= this.oth_fee

            phone= this.phone

            phone2= this.phone2

            livreur= this.livreur

            observation = this.observation

            remise = this.remise

            provName = this.provName
            plis = this.plis
            type: this.type
            delivType: this.delivType
            poids: this.poids
            subsType = this.subsType

                provPhone = this.provPhone

                provAdresse = this.provAdresse

                 provCity = this.provCity

            payed = 0
            maddecharge = 0
            distribdecharge = 0
            if(document.getElementById("payed"))
            {if(document.getElementById("payed").checked == true){
            
                            payed  = 1
            
                        }
                    }


            if(document.getElementById("maddecharge"))
            {if(document.getElementById("maddecharge").checked == true){

                maddecharge  = 1

            }
           }
            
            if(document.getElementById("distribdecharge"))
            {if(document.getElementById("distribdecharge").checked == true){

                distribdecharge  = 1

            }
        }

             this.ids = []

        for(i=0; i < this.commands.length; i++){

            

                this.ids.push(this.commands[i].id) 

                

         }

             

             var element = document.getElementById("cmdSuccess")

             var cmdForm = document.getElementById("cmdForm")

             

         axios.post('/command-fast-register', {
            department: department,
            maddecharge: maddecharge,
            distribdecharge: distribdecharge,
            products:vm.cmdProducts,

            start:'{{$start}}',

            end:'{{$end}}',

            fee: fee,

            ids:vm.ids,

            confirm:vm.confirm,

            delai: delai,

            provider: provider,

            costumer: costumer,

            nature: nature,

            remise: remise,

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

            payed:payed,

            provName: provName,

                provPhone: provPhone,

                provAdresse: provAdresse,

                provCity: provCity,
                plis: plis,
                type: type,
                delivType: delivType,
                poids: poids,
                subsType: subsType,

            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

    

        

        vm.newR = response.data.newCmd

        vm.commands = response.data.commands 

        vm.providers = response.data.providers

                vm.confirm = null

                 vm.fee= ""

                vm.costumer= ""

                vm.nature= ""

                vm.source= ""

                vm.delai = ""

                vm.provider = ""

                vm.delivery_date= ""

                vm.montant= ""

                vm.livraison = ""

                vm.adresse= ""

                vm.oth_fee= ""

                vm.remise =""

                vm.phone = ""

                vm.phone2 = ""

                vm.livreur= ""

                vm.observation = ""
                
                plid = ""
                

                vm.payed = null

                document.getElementById("payed").checked = false



        

      element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});

 

   for(i = 0; i < vm.products.length; i++){

                

                    vm.products[i].qty = 0

               

            }

            vm.total = 0

            vm.cmdProducts = []

  

  })

  .catch(function (error) {

    addBtn.setAttribute("disabled", "disabled")

    vm.cmdError = "Une erreur s'est produite"

    console.log(error);

  });

    },





    cancelCmd(){

               this.department = null

                this.fee= ""

                this.costumer= ""

                this.payed = null

                this.nature= ""

                this.source= ""

                 this.delai = ""

                this.provider = ""

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

                this.plis = ""
                
                this.type = ""
                this.delivType = ""
                this.poids = ""
                this.confirm = null

                this.payed = null

               document.getElementById("payed").checked = false

                for(i = 0; i < this.products.length; i++){

                

                    this.products[i].qty = 0

               

            }

            this.total = 0

    },







    updatePay(){

     var vm = this

     this.processing = 1

    axios.post('/updatepay', {

           

            cmdid: vm.singleCommand.id ,

            etat: document.getElementById("cmdPayment").value,

            payMethod: this.payMethod,

            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

    vm.processing = null

    vm.singleCommand.payment = response.data.payment



  })

  .catch(function (error) {

    vm.processing = null

    console.log(error);

  });

    },

    



    updateStatus(){

     var vm = this

     this.processing = 1

    axios.post('/updatestatus', {

           

            cmdid: vm.singleCommand.id ,

            etat: document.getElementById("cmdState").value,

            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

    vm.processing = null

    vm.singleCommand.etat = response.data.etat



  })

  .catch(function (error) {

    vm.processing = null

    console.log(error);

  });

    },





    updateOlis(){

     var vm = this

     this.processing = 1

    axios.post('/updateplis', {

           

            cmdid: vm.singleCommand.id ,

            plis: document.getElementById("cmdPlis").value,

            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

    vm.processing = null

    vm.singleCommand.plis = response.data.plis



  })

  .catch(function (error) {

    vm.processing = null

    console.log(error);

  });

    },





     updateDescription(){

     var vm = this

    this.processing = 1

    axios.post('/updatedescription', {

           

            cmdid: vm.singleCommand.id ,

            type: document.getElementById("cmdDesc").value,

            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

    vm.processing = null

    vm.singleCommand.description = response.data.description



  })

  .catch(function (error) {

    vm.processing = null

    console.log(error);

  });

    },





getTotal(){

  var total = 0

  for(i=0; i < this.commands.length; i++){

    total += this.commands[i].livraison

  }



  return total

 },



 getLivre(){

  var total = 0

  var nbre = 0

  for(i=0; i < this.commands.length; i++){

    if(this.commands[i].etat == 'termine')

    {total +=  Number(this.commands[i].livraison)

        nbre  += 1}

  }



 livre = [total, nbre]

  return livre

},





getUndone(){

  var total = 0

  var nbre = 0

  for(i=0; i < this.commands.length; i++){

    if(this.commands[i].etat == 'en chemin' || this.commands[i].etat == 'recupere')

    {total +=  Number(this.commands[i].livraison)

        nbre  += 1}

  }



 livre = [total, nbre]

  return livre

},





getEncours(){

  var total = 0

  var nbre = 0

  for(i=0; i < this.commands.length; i++){

    if(this.commands[i].etat == 'encours' )

    {total +=  Number(this.commands[i].livraison)

        nbre  += 1}

  }



 livre = [total, nbre]

  return livre

},



getAnnule(){

  var total = 0

  var nbre = 0

  for(i=0; i < this.commands.length; i++){

    if(this.commands[i].etat == 'annule')

    {total +=  Number(this.commands[i].livraison)

        nbre  += 1}

  }



 livre = [total, nbre]

  return livre

},





getEncaisse(){

  var total = 0

  var nbre = 0

  for(i=0; i < this.commands.length; i++){

     if(this.commands[i].payment)

    {

        if(this.commands[i].payment.etat == 'termine')

        {total +=  Number(this.commands[i].montant)-Number(this.commands[i].remise)

            nbre  += 1}

        }

  }



 livre = [total, nbre]

  return livre

},







getDelai(){

  var total = 0

  var nbre = 0

  for(i=0; i < this.commands.length; i++){

     if(this.commands[i].date_delai)

    {

        if(Number(this.commands[i].delivery_date.substring(8, 10))+Number(this.commands[i].delivery_date.substring(5, 7))+Number(this.commands[i].delivery_date.substring(0, 4)) > Number(this.commands[i].date_delai.substring(8, 10))+Number(this.commands[i].date_delai.substring(5, 7))+Number(this.commands[i].date_delai.substring(0, 4)))

        {total +=  Number(this.commands[i].montant)-Number(this.commands[i].remise)

            nbre  += 1}

        }

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

    this.processing = 1

    axios.post('/updateclient', {

           

            cmdid: vm.singleCommand.id ,

            client: document.getElementById("cmdClt").value,

            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

    vm.processing = null

    vm.singleCommand.nom_client = response.data.client



  })

  .catch(function (error) {

   vm.processing = null

    console.log(error);

  });

    },





     updateAdresse(){

     var vm = this

  this.processing = 1

    axios.post('/updateadresse', {

           

            cmdid: vm.singleCommand.id ,

            fee: document.getElementById("cmdFee").value,

            adresse: document.getElementById("cmdAdrs").value,

            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

   vm.processing = null

    vm.singleCommand.fee = response.data.fee

    vm.singleCommand.adresse = response.data.adresse

    

   





  })

  .catch(function (error) {

 vm.processing = null

    console.log(error);

  });

    },







    updateCost(){

     var vm = this

     montant = document.getElementById("cmdMontant").value

     livraison = document.getElementById("cmdLiv").value

     remise = document.getElementById("cmdRem").value



    axios.post('/updatecost', {

           

            cmdid: vm.singleCommand.id ,

            livraison: livraison,

            remise: remise, 

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

     this.processing = 1

     this.ids = []

        for(i=0; i < this.commands.length; i++){

            

                this.ids.push(this.commands[i].id) 

                

         }



    axios.post('/updatedate', {

           

            cmdid: vm.singleCommand.id ,

            ids:vm.ids,

            ddate: document.getElementById("ddate").value,

            start:'{{$start}}',

            end:'{{$end}}',

            

            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

    vm.processing = null

    vm.commands = response.data.commands





   console.log(vm.singleCommand)



  })

  .catch(function (error) {

 

    console.log(error);

  });

    },





    updatePhone(){

     var vm = this

    this.processing = 1

    axios.post('/updatephone', {

           

            cmdid: vm.singleCommand.id ,

            phone: document.getElementById("cmdPhone").value,

            phone2: document.getElementById("cmdPhone2").value,

            _token: CSRF_TOKEN

  })



         

  .then(function (response) {

    vm.processing = null

    vm.singleCommand.phone = response.data.phone

    vm.singleCommand.phone2 = response.data.phone2



  })

  .catch(function (error) {

  vm.processing = null

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

    vm.singleCommand.livreur_id = response.data.livreur.id

    

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

          

 },







   },

   computed:{



     bigTotal(){



        var montant = 0

        var liv = 0

      if (this.cart > 0)

        { montant = this.total}



       if(this.livraison != 'autre'){

        var  liv = this.livraison

       }



       if(this.livraison == 'autre'){

       var liv =  this.other_liv

       }

      

      montant = montant+Number(liv)-Number(this.remise)



       return montant

     },



      getUnassigned(){

    this.unasigned = 0

       if(this.commands.length > 0)

       { for (var i = 0; i < this.commands.length; i++) { 

                   if(this.commands[i].livreur_id == 11){

                       this.unasigned += 1

                   }

                   }

               }

 return this.unasigned

 }, 

    greatTotal(){

      if (this.cart > 0)

        { this.montant = this.total}



       return this.montant

     },



     

     getSelectedProducts(){

        this.selectedProducts = ""

        for(i=0; i<this.products.length; i++){

        if(this.products[i].qty > 0){ 

         this.selectedProducts += "(#"+this.products[i].id+ ")"+  this.products[i].qty + ' '+ this.products[i].name + ", " 

        }

      } 

      if(this.selectedProducts != "")

      {this.nature = this.selectedProducts}

      return this.selectedProducts

    },

}

});



  const mountedApp = app.mount('#app')    

   

  </script>

@include ("qrcode.qrlib")
@extends("layouts.master")

@section("title")
dvl system
@endsection

@section("content")
<style type="text/css">
  
  th { white-space: nowrap; }


.dot {
  height: 10px;
  width: 10px;
  background-color: green;
  border-radius: 50%;
  display: inline-block;
}

</style>
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <button  class="btn" id="btnDislay">Ajouter</button>
               
              </div>

                
              
              <div class="card-body">
                <div class="table-responsive">
                 
                          



                          <div class="container box">
   
                   <div>
                    <div id="html-content-holder">
                       <div class="row ">
                  @for($x = 1; $x<=30; $x++)
                  
                 <div class="col-2 mb-1 border" style="background-color: #F0F0F1; color: #00cc65; width: 100px; height: 200px;
        ">
         
        
        <p >
          <strong style="font-size: 35px">{{$x}}</strong><br>.
            <svg id="barcode{{$x}}"></svg>
            <script type="text/javascript">
  JsBarcode("#barcode{{$x}}", "{{$x}}");</script>
        </p>
        <p style="color: #3e4b51;">
           </p>
        <p style="color: #3e4b51;">
           
        </p>
         
    

  </div>


  

    @endfor
    </div>
  </div>
    <input id="btn-Preview-Image" type="button" value="Preview" />
    <a id="btn-Convert-Html2Image" href="#">Download</a>
    <input type="button" value="Preview & Convert" id="btnConvert" >
    <br />
    <h3>Preview :</h3>
    <div id="previewImg">

    </div>
                </div>
              </div>
            </div>
          </div>
       
        </div>
@endsection

@section("script")
<script src="https://unpkg.com/html5-qrcode" type="text/javascript">
</script>
<script type="text/javascript">

document.getElementById("btnConvert").addEventListener("click", function() {
  html2canvas(document.getElementById("html-content-holder")).then(function (canvas) {      var anchorTag = document.createElement("a");
      document.body.appendChild(anchorTag);
      document.getElementById("previewImg").appendChild(canvas);
      anchorTag.download = "1_100.jpg";
      anchorTag.href = canvas.toDataURL("image/jpeg");
      anchorTag.target = '_blank';
      anchorTag.click();
    });
 });


$("#btn_convert").on('click', function () {
    html2canvas(document.getElementById("html-content-holder"),   {
      allowTaint: true,
      useCORS: true
    }).then(function (canvas) {
      var anchorTag = document.createElement("a");
     
          anchorTag.download = "filename.jpg";
      anchorTag.href = canvas.toDataURL();
      anchorTag.target = '_blank';
      anchorTag.click();
    });
});

var element = $("#html-content-holder"); // global variable
var getCanvas; // global variable

    $("#btn-Preview-Image").on('click', function () {
         html2canvas(element, {
         onrendered: function (canvas) {
                $("#previewImg").append(canvas);                getCanvas = canvas;
             }
         });
    });

$("#btn-Convert-Html2Image").on('click', function () {
    var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Convert-Html2Image").attr("download", "your_pic_name.png").attr("href", newData);
});

  $(document).ready(function() {


     


     $('#myTable').DataTable(  {

     


       "bPaginate": false,
        "bSort" : false,
                
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                text: 'Imprimer tout',
                footer: true,
                exportOptions: {
                    modifier: {
                        selected: null
                    }


                }
            },
            {
                extend: 'print',
                text: 'Imprimer selection'
            }
        ],
        select: true
    }  );




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
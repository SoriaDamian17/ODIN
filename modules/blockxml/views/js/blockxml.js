$(function(){

    $("#configuration_form .form-group:last-child").addClass('tree-hide');
    $('.tree-hide').hide();
    
    $('input[name="category_active"]').click(function(){
        if($(this).val() == 1){
            //alert($(this).val());
            $('.tree-hide').hide();  
        }else{
            //alert($(this).val());
            $('.tree-hide').show();
        }
       
    });


    $( "#Exportcategorias" ).click(function(){
        alert('categoria');        
        actions.exportCategoria();
    });

    $( "#Exportproduct" ).click(function(){
        alert('productos');        
        actions.exportProduct();
    });
    
    $("#owl-demo").owlCarousel({ 
        items : 5, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0
        navigation:false,
    });
 
    $('.solo_numero').keyup(function(e){
        var numero = $(this).val();
        if(isNumeric(numero)){}else{
            $(this).val('');
            alert('Solo numero');
        }       
    });

    $( "#configuration_form" ).prop("onSubmit");


    /*$("#configuration_form_submit_btn").click(function(e){  
        $ads_type_chosen = $("#ads_type_chosen").prop('selectedIndex');
        if($ads_type_chosen < 0){
            alert("Depositos Requerido");
            $("#ads_type_chosen").focus();
            $('#ads_type_chosen').trigger('chosen:activate');          
            return false;
        }

    });*/

});

var actions = {   
    modebug:0, 
    module:'blockxml',    
    baseURL:location.href.substr(0, location.href.lastIndexOf("/") + 1).replace('adminmto/',''),
    exportCategoria:function(){        
        $.ajax({
          type: "GET", 
          url: this.baseURL + "modules/" + this.module + "/"+this.module+"-ajax.php",
          data: "method=ExportCategorias",                              
          success: function(response){
            $('#msg-export-product').html(response).fadeIn();
          }
        });
    },
    exportProduct:function(){        
        $.ajax({
          type: "GET", 
          url: this.baseURL + "modules/" + this.module + "/"+this.module+"-ajax.php",
          data: "method=ExportProductos",                              
          success: function(response){
            $('#msg-export-product').html(response).fadeIn();
          }
        });
    }, 
};

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function justNumbers(e)
{
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == 46))
    return true;
     
    return /\d/.test(String.fromCharCode(keynum));
}
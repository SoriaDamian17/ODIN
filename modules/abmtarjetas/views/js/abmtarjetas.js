$(function(){
   $( ".datepicker" ).datepicker({
    dateFormat: 'yy/mm/dd',
    beforeShow: function() {
        setTimeout(function(){
            $('.ui-datepicker').css('z-index', 10);
        }, 0);
    } 
   });
    
    var url = window.location.href;     // Returns full URL    
    //btnPlanes(url); 
    //addCodigotarjeta(url);
    /*$('.solo_numero').click(function(e){
        justNumbers(e);
    });*/
    $('.solo_numero').keyup(function (e) {
        var numero = $(this).val();
        if(isNumeric(numero)){}else{
            $(this).val('');
            alert('Solo numero');
        }       
    });
    
});

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
$(function(){

   $( ".datepicker" ).datepicker({
    dateFormat: 'yy/mm/dd',
    beforeShow: function() {
        setTimeout(function(){
            $('.ui-datepicker').css('z-index', 10);
        }, 0);
    } 
   });
    
    $("#owl-demo").owlCarousel({ 
        items : 6, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0
        navigation:false,
    });
 
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
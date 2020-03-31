<script>
    $(function(){
       $('.bxslider').bxSlider({
         mode:'fade',
         controls:false,
         auto:true,
         pause:6000,
         adaptiveHeight:true,
         touchEnabled:true,
       });
       $( ".close" ).click(function() {
          $( "#promociones" ).fadeOut( "slow", function() {
            // Animation complete.
          });
        });
    });

    var promo = {
        name:'blockmd',
        modebug:1,
        getPromos:function(){
          
        },//End getPlanes  
    };
    //alert(planes);
</script>
{if $total > 0}
<div id="promociones">
    <div id="ads" class="promociones ">
        <button class="close"><i class="icon icon-remove"></i></button>
        <div class="bxslider">
            {foreach from=$promociones item=promo key=key}
                <div class="ads">
                   {if $promo.link != ''}
                   <a href="{$promo.link}" target="_blank">{$promo.descripcion}</a>
                   {else}
                    {$promo.descripcion}
                   {/if}
                </div>
            {/foreach}
        </div>
    </div>
</div>
{/if}
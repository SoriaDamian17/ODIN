<script>
    $(function(){
        $("#owl-demo").owlCarousel({ 
            items : {$item}, //10 items above 1000px browser width
            itemsDesktop : [1000,{$itemsDesktop}], //5 items between 1000px and 901px
            itemsDesktopSmall : [900,{$itemsDesktopSmall}], // betweem 900px and 601px
            itemsTablet: [600,{$itemsTablet}], //2 items between 600 and 0
        });
        {if $autoplay}
          $("#owl-demo").trigger('owl.play',{$delay});
        {/if}
       // Custom Navigation Events
      $(".next").click(function(){
        $("#owl-demo").trigger('owl.next');
      })
      $(".prev").click(function(){
        $("#owl-demo").trigger('owl.prev');
      })
    });
    //alert(planes);
</script>
<style type="text/css">
  {if $pagination}
  {else}
    .owl-pagination{
      display:none;
    }
  {/if}
</style>
<div id="Marcas">    
    <div id="owl-demo" class="owl-carousel owl-theme"> 
        {foreach from=$marcas item=marca key=key}
            <div class="item">                
                <a href="/{$marca.link_rewrite}" target="_blank" title="{$marca.name}">
                  <img src="img/m/{$marca.id_manufacturer}-{$tipoImagen}.jpg" alt="{$marca.name}"/>  
                </a>  
                <!--<small>{$marca.name}</small>-->            
            </div>
        {/foreach}
    </div>    
    {if $countMarcas > $cantidad}
    <div class="customNavigation">
      <a class="btn prev"><i class="icon icon-chevron-left"></i></a>
      <a class="btn next"><i class="icon icon-chevron-right"></i></a>
    </div>
    {/if}
</div>
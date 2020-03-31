<script>
    
    $(function(){
      initfb(document, 'script', 'facebook-jssdk');
       $( ".close" ).click(function() {
          $( "#promociones" ).fadeOut( "slow");
        });
    });
function initfb(d, s, id)
{
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) 
    return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/{$facebooklang}/all.js#xfbml=1&appId=334341610034299";
  //js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.5&appId=927820097253305";
  js.async = true;
  fjs.parentNode.insertBefore(js, fjs);
}
</script>
{if $facebookurl != ''}
<div id="promociones">
    <div id="ads" class="promociones ">
        <button class="close"><i class="icon icon-remove"></i></button>
        <div id="fb-root"></div>
        <div id="facebookup_block">          
          <div class="facebook-fanbox">
            <div class="fb-page" data-href="{$facebookurl|escape:'html':'UTF-8'}" data-width="{$data_width}" data-height="{$data_height}" data-small-header="false" data-adapt-container-width="true" data-hide-cover="{$data_cover}" data-show-facepile="{$data_facepile}" data-show-posts="{$data_posts}"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/facebook"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div></div>
          </div>
        </div>
    </div>
</div>
{/if}
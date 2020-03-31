<script>
$(document).ready(function() {
    initfb(document, 'script', 'facebook-jssdk');
});

function initfb(d, s, id)
{
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) 
        return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/{$facebooklang}/all.js#xfbml=1&appId=334341610034299";
    fjs.parentNode.insertBefore(js, fjs);
}
</script>
{if $facebookurl != ''}
<div class="bootstrap panel">
  <div class="panel-heading">
    <i class="icon-picture-o"></i> {l s="Preview"}
  </div>
  <div id="fb-root"></div>
  <div id="facebook_block">
    <h4 >{l s='Siguenos en facebook' mod='blockfacebookup'}</h4>
   
    <div class="facebook-fanbox">      
        <div class="fb-page" data-href="{$facebookurl|escape:'html':'UTF-8'}" data-width="{$data_width}" data-height="{$data_height}" data-small-header="false" data-adapt-container-width="true" data-hide-cover="{$data_cover}" data-show-facepile="{$data_facepile}" data-show-posts="{$data_posts}"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/facebook"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div></div>
      </div>
    </div>
  </div>
</div>
{/if}
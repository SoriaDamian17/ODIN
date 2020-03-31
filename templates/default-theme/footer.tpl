          <!-- Footer -->
          <footer class="footer text-center">
              <div class="container">
                  <div class="row">
                      <div class="col-xs-12">
                          2016 © Odin.
                      </div>
                  </div>
              </div>
          </footer>
          <!-- End Footer -->
      </div> <!-- container -->
      {include file='templates/default-theme/side-bar.tpl'}
    </div> <!-- End wrapper -->
      <nav id="c-menu--slide-left" class="c-menu c-menu--slide-left">
        <div class="cover-menu">
            <div class="cover">
               <img src="https://lh3.googleusercontent.com/-MKQMgNV0IRE/VCmTRy8ZNlI/AAAAAAAAAzQ/odC4jTZdyWwWV38GOaXdhXJC0RTcaRB2QCL0B/w859-h483-n-rw-no/portada.jpg" />
                <div class="avatar">
                    <img src="templates/default-theme/images/users/avatar-1.jpg" alt="user" class="img-circle">
                    <div class="avatar-name">
                        Damian Soria
                    </div>
                    <input type="hidden" class="c-menu__close"/>
                </div>
                <div class="gradient-bg"></div>
            </div>
        </div>        
        <ul class="c-menu__items">
            <li class="has-submenu c-menu__item">
				<a href="#" data-link="true" data-controller="AdminProduct" data-token="{$tools->getToken('AdminProduct')}" class="c-menu__link"><i class="zmdi zmdi-view-dashboard"></i> <span> Productos </span> </a>
            </li>
            <li class="has-submenu c-menu__item">
                    <a href="#" data-link="true" data-controller="AdminManufacturer" data-token="{$tools->getToken('AdminManufacturer')}" class="c-menu__link"><i class="zmdi zmdi-format-underlined"></i> <span> Marcas </span> </a>
            </li>

            <li class="has-submenu c-menu__item">
                    <a href="#" data-link="true" data-controller="AdminCategory" data-token="{$tools->getToken('AdminCategory')}" class="c-menu__link"><i class="zmdi zmdi-album"></i> <span> Categorias </span> </a>
            </li>

            <li class="has-submenu c-menu__item">
                    <a href="#" data-link="true" data-controller="AdminThemes" data-token="{$tools->getToken('AdminThemes')}" class="c-menu__link"><i class="zmdi zmdi-collection-text"></i><span> Tienda </span> </a>
                    <ul class="submenu c-menu__item">
                            <li><a href="#" data-link="true" data-controller="AdminThemesConfiguration" data-token="{$tools->getToken('AdminThemesConfiguration')}" class="c-menu__link">Plantillas</a></li>
                            <li><a href="#" data-link="true" data-controller="AdminPagesCms" data-token="{$tools->getToken('AdminPagesCms')}" class="c-menu__link">Páginas</a></li>
                    </ul>
            </li>
        </ul>

        </nav><!-- /c-menu slide-left -->
      <div id="c-mask" class="c-mask"></div><!-- /c-mask -->
      <script>
          var resizefunc = [];
      </script>

      <!-- jQuery  -->
      <script src="templates/{$theme}/js/jquery.min.js"></script>
      <script src="templates/{$theme}/js/tether.min.js"></script><!-- Tether for Bootstrap -->
      <script src="templates/{$theme}/js/bootstrap.min.js"></script>
      <script src="templates/{$theme}/js/waves.js"></script>
      <script src="templates/{$theme}/js/jquery.nicescroll.js"></script>
      <script src="templates/{$theme}/plugins/switchery/switchery.min.js"></script>

      <!--Form Wizard-->
      <script src="templates/{$theme}/plugins/jquery.steps/build/jquery.steps.min.js" type="text/javascript"></script>
      <script src="templates/{$theme}/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript" ></script>

      <!--wizard initialization-->
        <script src="templates/{$theme}/pages/jquery.wizard-init.js" type="text/javascript"></script>

      <!-- Sweet Alert js -->
      <script src="templates/{$theme}/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
      <!--<script src="templates/{$theme}/plugins/bootstrap-sweetalert/jquery.sweet-alert.init.js"></script>-->

      <!-- Menu Mobile js -->
      <script src="templates/{$theme}/js/menu.js"></script>

      <!-- App js -->
      <script src="templates/{$theme}/js/jquery.core.js"></script>
      <script src="templates/{$theme}/js/jquery.app.js"></script>


      <script>
      	$(document).ready(function(){
            /**
            * Plugin TyniSetup
            */  
            /*tinySetup({
                editor_selector :"autoload_rte"
            });
            $(".textarea-autosize").autosize();*/

            /**
            * Envio de formulario
            */
			$('div.actions  ul li').last().click(function(){
                //swal("Buen Trabajo!", "", "success");
				$('.formController').submit();
			});

            function sweetalert(event){
                if(event == 'success')
				    swal("Buen Trabajo!", "", "success");
			}

		});

      </script>

    </body>
</html>

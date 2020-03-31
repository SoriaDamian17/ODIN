<div class="row">
    <div class="col-xs-12 col-lg-12 col-xl-3">
        <div class="card-box product-btn" data-link="true" data-controller="AdminThemesConfiguration" data-token="{$tools->getToken('AdminThemesConfiguration')}">
            <h4 class="text-xs-center header-title m-t-0 m-b-30">
                Diseño de Plantilla
            </h4>
            <div class="text-xs-center m-b-20">
                <img src="templates/{$theme}/images/themes.png" title="Configuration Theme" />
            </div>

            <div class="text-xs-center">
                <p>Seleciona tu plantilla que mas se adecue a tu local.</p>
            </div>
        </div>
    </div><!-- end col-->
		<div class="col-xs-12 col-lg-12 col-xl-3">
        <div class="card-box manufacture-btn" data-link="true" data-controller="AdminPagesCms" data-token="{$tools->getToken('AdminPagesCms')}">
            <h4 class="header-title m-t-0 m-b-30">
            Paginas
            <span type="button" class="btn btn-primary-outline btn-rounded waves-effect waves-light" style="float:right;">{$Manufacturer->getCount()}</span>
            </h4>
            <div class="text-xs-center m-b-20">
                <img src="templates/{$theme}/images/pagesCms.png" title="paginas" />
            </div>

            <div class="text-xs-center">
                <p>Crea tu secciones de interes para el usuario.</p>
            </div>
        </div>
    </div><!-- end col-->

</div>

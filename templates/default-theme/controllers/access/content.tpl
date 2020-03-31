<div class="row">
    <div class="col-xs-3 col-lg-3 col-xl-3 col-md-2">
        <div class="card-box product-btn" data-link="true" data-controller="AdminProduct" data-token="{$tools->getToken('AdminProduct')}">
            <h4 class="text-xs-left header-title m-t-0 m-b-30">
                Productos
            <span type="button" class="btn btn-primary-outline btn-rounded waves-effect waves-light" style="float:right;">{$Product->getCount()}</span>
            </h4>
            <div class="text-xs-center m-b-20">
                <img src="templates/{$theme}/images/zapatillas.png" title="Productos" />
            </div>

            <div class="text-xs-center">
                <p>Crea o modifica tus productos, tambièn puedes personalizarlos.</p>
            </div>
        </div>
    </div><!-- end col-->
		<div class="col-xs-3 col-lg-3 col-xl-3">
        <div class="card-box manufacture-btn" data-link="true" data-controller="AdminManufacturer" data-token="{$tools->getToken('AdminManufacturer')}">
            <h4 class="header-title m-t-0 m-b-30">
            Marcas
            <span type="button" class="btn btn-primary-outline btn-rounded waves-effect waves-light" style="float:right;">{$Manufacturer->getCount()}</span>
            </h4>
            <div class="text-xs-center m-b-20">
                <img src="templates/{$theme}/images/marcas.png" title="Marcas" />
            </div>

            <div class="text-xs-center">
                <p>Puede ver todas las marcas cargadas, cargar una nueva o modificarla.</p>
            </div>
        </div>
    </div><!-- end col-->
		<div class="col-xs-3 col-lg-3 col-xl-3">
        <div class="card-box category-btn" data-link="true" data-controller="AdminCategory" data-token="{$tools->getToken('AdminCategory')}">
            <h4 class="header-title m-t-0 m-b-30">Categorias <span type="button" class="btn btn-primary-outline btn-rounded waves-effect waves-light" style="float:right;">10</span></h4>
            <div class="text-xs-center m-b-20">
                <img src="templates/{$theme}/images/categorias.png" title="Categorias" />
            </div>

            <div class="text-xs-center">
                <p>Crea tu arbol de categorias para poder asignar a tus productos.</p>
            </div>
        </div>
    </div><!-- end col-->
		<div class="col-xs-3 col-lg-3 col-xl-3">
        <div class="card-box shop-btn" data-link="true" data-controller="AdminThemes" data-token="{$tools->getToken('AdminThemes')}">
            <h4 class="text-xs-center header-title m-t-0 m-b-30">Tienda Online</h4>
            <div class="text-xs-center m-b-20">
                <img src="templates/{$theme}/images/tienda.png" title="Tienda Online" />
            </div>
            <div class="text-xs-center">
                <p>Personaliza tu tienda, cambia el template, colores y tipo de letra.</p>
            </div>
        </div>
    </div><!-- end col-->
</div>

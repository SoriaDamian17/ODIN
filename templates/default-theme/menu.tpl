<!-- Navigation Menu-->

<ul class="navigation-menu" style="{if $nameController == 'AdminAccess'}display:none;{/if}">		
		<li class="has-submenu">
				<a href="#" data-link="true" data-controller="AdminProduct" data-token="{$tools->getToken('AdminProduct')}"><i class="zmdi zmdi-view-dashboard"></i> <span> Productos </span> </a>
		</li>
		<li class="has-submenu">
				<a href="#" data-link="true" data-controller="AdminManufacturer" data-token="{$tools->getToken('AdminManufacturer')}"><i class="zmdi zmdi-format-underlined"></i> <span> Marcas </span> </a>
		</li>

		<li class="has-submenu">
				<a href="#" data-link="true" data-controller="AdminCategory" data-token="{$tools->getToken('AdminCategory')}"><i class="zmdi zmdi-album"></i> <span> Categorias </span> </a>
		</li>

		<li class="has-submenu">
				<a href="#" data-link="true" data-controller="AdminThemes" data-token="{$tools->getToken('AdminThemes')}"><i class="zmdi zmdi-collection-text"></i><span> Tienda </span> </a>
				<ul class="submenu">
						<li><a href="#" data-link="true" data-controller="AdminThemesConfiguration" data-token="{$tools->getToken('AdminThemesConfiguration')}">Plantillas</a></li>
						<li><a href="#" data-link="true" data-controller="AdminPagesCms" data-token="{$tools->getToken('AdminPagesCms')}">Páginas</a></li>
				</ul>
		</li>

</ul>
<!-- End navigation menu  -->

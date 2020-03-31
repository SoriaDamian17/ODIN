	<script>
      	//sweetalert('success');
      </script>
<!-- Page-Title -->
<div class="row" >
	<div class="col-sm-12">
		<div class="btn-group pull-right m-t-15">
				<button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
								data-toggle="dropdown" aria-expanded="false">Acciones Masivas <span class="m-l-5"><i
								class="fa fa-cog"></i></span></button>
				<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Seleccionar todos</a>
						<a class="dropdown-item" href="#">Deseleccionar todos</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Eliminar Seleccion</a>
				</div>
		</div>
		<h4 class="page-title">
		Categorias 
		<span type="button" class="btn btn-primary-outline btn-rounded waves-effect waves-light">{$categoria->getCount()}</span></h4>
	</div>
</div>

{include file='templates/default-theme/kpi.tpl' kpi=''}

<div class="row">
  <div class="col-xs-12">
      <div class="card-box" style="{if isset($smarty.get.addCategory)}{else}display:none;{/if}">
          <div class="row m-t-50">
              <div class="col-sm-12 col-xs-12">
						<form id="wizard-vertical" class="formController" action="index.php?controller=AdminCategory&token={Tools::getToken('AdminCategory')}&addCategory" method="post">
						<input type="hidden" value="{$categoria->id}" name="id" />
							<h3>Información</h3>
							<section>
								<div class="form-group clearfix">
										<label class="col-lg-2 control-label " for="categoryName">Nombre *</label>
										<div class="col-lg-10">
												<input class="form-control required" id="categoryName" name="name" type="text">
										</div>
								</div>

								<div class="form-group clearfix">
										<label class="col-lg-2 control-label " for="active">Activo</label>
										<div class="col-lg-10">
												<input type="checkbox" checked data-plugin="switchery" data-color="#3db9dc" name="active"/>
										</div>
								</div>											
								<div class="form-group clearfix">
									<label class="col-lg-2 control-label " for="description">Descripción</label>
									<div class="col-lg-10">
										<textarea id="textarea" class="form-control" maxlength="225" rows="3" placeholder="This textarea has a limit of 225 chars." name="description"></textarea>
									</div>
								</div>
								<div class="form-group clearfix">
										<label class="col-lg-12 control-label ">(*) Requeridos</label>
								</div>
							</section>
							<h3>Optimización (SEO)</h3>
							<section>
								<div class="form-group clearfix">
									<label class="col-lg-2 control-label " for="meta_title">Meta Titulo</label>
									<div class="col-lg-10">
											<input class="form-control required" id="meta_title" name="meta_title" type="text">
									</div>
								</div>
								<div class="form-group clearfix">
									<label class="col-lg-2 control-label " for="meta_description">Meta Descripcio</label>
									<div class="col-lg-10">
											<input class="form-control required" id="meta_description" name="meta_description" type="text">
									</div>
								</div>
								<div class="form-group clearfix">
									<label class="col-lg-2 control-label " for="url_shop">Url Amigable</label>
									<div class="col-lg-10">
											<input class="form-control required" id="url_shop" name="url_shop" type="text">
									</div>
								</div>
							</section>
							<h3>Imagenes</h3>
							<section>
								<div class="form-group clearfix">
									<div class="col-lg-12">
										<span class="sweet-success">Click me</span>
											<div class="checkbox checkbox-primary">
													<input id="checkbox-v" type="checkbox">
													<label for="checkbox-v"> I agree with the Terms and Conditions. </label>
											</div>
									</div>
								</div>
							</section>      
							<input type="hidden" name="addM" />                              
					</form>
					<!-- End #wizard-vertical -->
              </div>
          </div>
          <!-- end row -->
      </div>
  </div><!-- end col-->
</div>

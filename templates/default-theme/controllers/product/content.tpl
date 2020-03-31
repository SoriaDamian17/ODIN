
<!-- Page-Title -->
<div class="row">
		<div class="col-sm-12">
				<div class="btn-group pull-right m-t-15">
						<button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
										data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i
										class="fa fa-cog"></i></span></button>
						<div class="dropdown-menu">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Separated link</a>
						</div>
				</div>
				<h4 class="page-title">Productos 
				<span type="button" class="btn btn-primary-outline btn-rounded waves-effect waves-light">{$product->getCount()}</span>
				</h4>
		</div>
</div>

{include file='templates/default-theme/kpi.tpl' kpi=''}

<div class="row " >
  <div class="col-xs-12">
      <div class="card-box" style="{if isset($smarty.get.addProduct)}{else}display:none;{/if}">
          <div class="row m-t-50">
              <div class="col-sm-12 col-xs-12">
								<form id="wizard-vertical">
									<input type="hidden" value="{$product->id}" name="id" />
									<h3>Información</h3>
									<section>
											<div class="form-group clearfix">
													<label class="col-lg-2 control-label " for="productName">Nombre *</label>
													<div class="col-lg-10">
															<input class="form-control required" id="productName" name="productName" type="text">
													</div>
											</div>
											<div class="form-group clearfix">
													<label class="col-lg-2 control-label " for="reference"> Código </label>
													<div class="col-lg-10">
															<input id="reference" name="reference" type="text" class="required form-control">
													</div>
											</div>
											<div class="form-group clearfix">
													<label class="col-lg-2 control-label " for="codEan">EAN-13 o JAN *</label>
													<div class="col-lg-10">
															<input class="form-control required" id="codEan" name="codEan" type="text">
													</div>
											</div>
											<div class="form-group clearfix">
													<label class="col-lg-2 control-label " for="active">Activo</label>
													<div class="col-lg-10">
															<input type="checkbox" checked data-plugin="switchery" data-color="#3db9dc" name="active"/>
													</div>
											</div>
											<div class="form-group clearfix">
												<label class="col-lg-2 control-label " for="codEan">Descripción</label>
												<div class="col-lg-10">
													<textarea id="textarea" class="form-control" maxlength="225" rows="3" placeholder="This textarea has a limit of 225 chars."></textarea>
												</div>
											</div>
											<div class="form-group clearfix">
													<label class="col-lg-12 control-label ">(*) Requeridos</label>
											</div>
									</section>
									<h3>Categorias</h3>
									<section>


									</section>
									<h3>Optimización (SEO)</h3>
									<section>
										<div class="form-group clearfix">
												<label class="col-lg-2 control-label " for="codEan">Meta Titulo</label>
												<div class="col-lg-10">
														<input class="form-control required" id="meta_title" name="meta_title" type="text">
												</div>
										</div>
										<div class="form-group clearfix">
												<label class="col-lg-2 control-label " for="codEan">Meta Descripcio</label>
												<div class="col-lg-10">
														<input class="form-control required" id="meta_description" name="meta_description" type="text">
												</div>
										</div>
										<div class="form-group clearfix">
												<label class="col-lg-2 control-label " for="codEan">Url Amigable</label>
												<div class="col-lg-10">
														<input class="form-control required" id="url_shop" name="url_shop" type="text">
												</div>
										</div>
									</section>
									<h3>Cantidades</h3>
									<section>
											<div class="form-group clearfix">
													<div class="col-lg-12">
															<div class="checkbox checkbox-primary">
																	<input id="checkbox-v" type="checkbox">
																	<label for="checkbox-v"> I agree with the Terms and Conditions. </label>
															</div>
													</div>
											</div>
									</section>
									<h3>Transporte</h3>
									<section>


									</section>
									<h3>Imagenes</h3>
									<section>
											<div class="form-group clearfix">
													<div class="col-lg-12">
															<div class="checkbox checkbox-primary">
																	<input id="checkbox-v" type="checkbox">
																	<label for="checkbox-v"> I agree with the Terms and Conditions. </label>
															</div>
													</div>
											</div>
									</section>
									<input type="hidden" name="{if isset($smarty.get.addProduct)}addP{else}updP{/if}" />
							</form>
							<!-- End #wizard-vertical -->
              </div>
          </div>
          <!-- end row -->
      </div>
  </div><!-- end col-->
</div>

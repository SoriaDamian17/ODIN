<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable();
    } );

</script>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
												<th>
													<div class="checkbox checkbox-single">
                              <input type="checkbox" id="singleCheckbox1" value="option1" aria-label="Single checkbox One">
                              <label></label>
                          </div>
												</th>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Código</th>
												<th>Categoria</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Activo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
									{foreach from=$Product->getProducts() item=product}
										<tr>
											<td>
												<div class="checkbox checkbox-success">
                            <input id="checkbox3" type="checkbox" name="productos[]" />
														<label></label>
                        </div>
											</td>
											<td>{$product.id_product}</td>
											<td>{$product.name|truncate:30:"..."}</td>
											<td>{$product.reference}</td>
											<td> --- </td>
											<td>${$product.price}</td>
											<td>
												{if $product.quantity > 5}
												<span class="btn btn-success-outline btn-rounded waves-effect waves-light">{$product.quantity}</span>
												{/if}
												{if $product.quantity >= 1 && $product.quantity <= 5}
												<span class="btn btn-warning-outline btn-rounded waves-effect waves-light">{$product.quantity}</span>
												{/if}
												{if $product.quantity <= 0}
												<span class="btn btn-danger-outline btn-rounded waves-effect waves-light">{$product.quantity}</span>
												{/if}
											</td>
                      <td>
                        {if $product.active == 1}
                        <button class="btn waves-effect waves-light btn-success">
                          <i class="fa fa-check"></i>
                        </button>
                        {else}
                        <button class="btn waves-effect waves-light btn-danger">
                          <i class="fa fa-times"></i>
                        </button>
                        {/if}
                      </td>
											<td>
												{include file='templates/default-theme/actions.tpl' actions={$product.id_product} controller='AdminProduct' path=''}
											</td>
										</tr>
									{/foreach}
                </tbody>
							</table>
        </div>
    </div>
</div> <!-- end row -->
<a href="index.php?controller=AdminProduct&token={Tools::getToken('AdminProduct')}&addProduct" class="btn-floating btn-large waves-effect waves-light fixed"><i class="zmdi zmdi-plus"></i></a>

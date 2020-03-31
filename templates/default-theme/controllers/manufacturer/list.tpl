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
                        <th>Productos</th>                        
												<th>Fecha</th>
                        <th>Activo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
									{foreach from=$Marca->getManufacturers() item=marca}
										<tr>
											<td>
												<div class="checkbox checkbox-success">
                            <input id="checkbox3" type="checkbox" name="marcas[]" />
														<label></label>
                        </div>
											</td>
											<td>{$marca.id_manufacturer}</td>
											<td>{$marca.name|truncate:30:"..."}</td>
                      <td>{$Marca->getProduct($marca.id_manufacturer)}</td>
											<td>{$marca.date_upd}</td>
                      <td>
                        {if $marca.active == 1}
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
												{include file='templates/default-theme/actions.tpl' actions={$marca.id_manufacturer} controller='AdminManufacturer' path=''}
											</td>
										</tr>
									{/foreach}
                </tbody>
							</table>
        </div>
    </div>
</div> <!-- end row -->
<a href="index.php?controller=AdminManufacturer&token={Tools::getToken('AdminManufacturer')}&addManufacturer" class="btn-floating btn-large waves-effect waves-light fixed"><i class="zmdi zmdi-plus"></i></a>
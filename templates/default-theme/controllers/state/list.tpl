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
                        <th>Código ISO</th>
												<th>Zona</th>
                        <th>Pais</th>
                        <th>Activo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
									{foreach from=$State item=provincia}
										<tr>
											<td>
												<div class="checkbox checkbox-success">
                            <input id="checkbox3" type="checkbox" name="productos[]" />
														<label></label>
                        </div>
											</td>
											<td>{$provincia.id_state}</td>
											<td>{$provincia.name}</td>
											<td>{$provincia.iso_code}</td>
											<td>{$Zone->getNameById($provincia.id_zone)}</td>
											<td>{$Country->getNameById(1,$provincia.id_country)}</td>
                      <td>
                        {if $provincia.active == 1}
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
												{include file='templates/default-theme/actions.tpl' actions='' path=''}
											</td>
										</tr>
									{/foreach}
                </tbody>
							</table>
        </div>
    </div>
</div> <!-- end row -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable();

        $('tr.list-item').click(function(){
          var id = $(this).data('id');
          
          $(location).attr('href',);
        });
    });

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
                        <th>Posición</th>                        
												<th>Fecha</th>
                        <th>Activo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
									{foreach from=$categoria->getCategories() item=cat}
										<tr class="list-item" data-id="{$cat.id_category}">
											<td>
												<div class="checkbox checkbox-success">
                            <input id="checkbox3" type="checkbox" name="cat[]" />
														<label></label>
                        </div>
											</td>
											<td>{$cat.id_category}</td>
											<td>{$cat.name|truncate:30:"..."}</td>
                      <td>{$cat.position}</td>
											<td>{$cat.date_upd}</td>
                      <td>
                        {if $cat.active == 1}
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
<a href="index.php?controller=AdminCategory&token={Tools::getToken('AdminCategory')}&addCategory" class="btn-floating btn-large waves-effect waves-light fixed"><i class="zmdi zmdi-plus"></i></a>
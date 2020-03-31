<div class="panel" id="fieldset_0_2_2">
    <div class="panel-heading">
        <i class="icon-envelope"></i> Generar xml
    </div>
                    
    <div class="alert alert-info col-lg-offset-3">
        <span>Generar un archivo .XML usando los ajustes definidos en el formulario anterior.</span><br>
    </div>
    {if $url_xml != ''}
    <div id="msg-export-product" class="alert alert-success col-lg-offset-3">
        <span>{$url_xml}</span><br>
    </div>
    {/if}

    <div class="panel-footer">
        <button type="submit" value="1" id="Exportall" name="submitExportmodule" class="btn btn-default pull-left">
            <i class="process-icon-save"></i> Exportar Productos y Categorias
        </button>
        <button type="submit" value="1" id="Exportcategorias" name="submitExportmodule" class="btn btn-default pull-right">
            <i class="process-icon-save"></i> Exportar Categorias
        </button>
        <button type="submit" value="1" id="Exportproduct" name="submitExportmodule" class="btn btn-default pull-right">
            <i class="process-icon-save"></i> Exportar Productos
        </button>                                                                                              
    </div>
                            
</div>
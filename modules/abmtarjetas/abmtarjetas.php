<?php
if (!defined('_PS_VERSION_'))
  exit;
require_once (dirname(__FILE__) . '/class/install.php');
require_once (dirname(__FILE__) . '/class/tarjetas.php');
require_once (dirname(__FILE__) . '/class/planes.php');
class AbmTarjetas extends Module
{
	public function __construct()
  {
    $this->name = 'abmtarjetas';
    $this->tab = 'front_office_features';
    $this->version = '0.9';
    $this->author = 'Flexxus S.A';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_); 
    $this->bootstrap = true;
 	
    parent::__construct();
 
    $this->displayName = $this->l('ABM Tarjetas');
    $this->description = $this->l('Alta, Baja y Modificación de Tarjetas y Planes.');
 
    $this->confirmUninstall = $this->l('Estás seguro que deseas desinstalar?');
 
  }

  public function install()
	{
	  if (Shop::isFeatureActive())
   	 Shop::setContext(Shop::CONTEXT_ALL);
 
	  if (!parent::install() ||
	  	!$this->registerHook('DisplayHeader') ||
	  	!$this->registerHook('displayBackOfficeHeader') ||
	    !$this->registerHook('displayProductButtons') ||
	    //!$this->registerHook('displayProductListFunctionalButtons') ||
	    !installtarjeta::installTablas()
	  )
	    return false;
	  return true;	}

	public function uninstall()
	{
	  if (!parent::uninstall() ||
	    !installtarjeta::uninstallTablas()
	  )
	    return false;
	  return true;
	}

	public function reset()
	{
		if (!$this->uninstall(false))
			return false;
		if (!$this->install(false))
			return false;

		return true;
	}

	/**
	 * recupero y guardo los valores ingresados en el formulario
	 */
	protected function _postProcess()
	{
		$output = null;$update = 0;
		
		if(isset($_GET['statusplanes_tarjetas']) || isset($_GET['statustarjetas'])){
			if(isset($_GET['idPlanestarjetas'])){
				$id = Tools::getValue('idPlanestarjetas');
				$status = 'planes';
			}else if(isset($_GET['codigotarjeta'])){
				$id = Tools::getValue('codigotarjeta');
				$status = 'tarjetas';
			}
			$this->processStatus($id,$status);
		}
		

		if(isset($_GET['deletetarjetas'])){
			$tarjetas = new tarjetasCore(Tools::getValue("codigotarjeta"));            
            //$tarjetas->deletPlanes(Tools::getValue("codigotarjeta"));
            $tarjetas->delete();
            $output .= $this->displayConfirmation($this->l('Se borro correctamente.'));
		}

		if(isset($_GET['deleteplanes_tarjetas'])){
			$planes = new planestarjetasCore(Tools::getValue("idPlanestarjetas"));            
            $planes->delete();
            $output .= $this->displayConfirmation($this->l('Se borro correctamente.'));
		}

		if (Tools::isSubmit('submit'.$this->name))
	    {
	        $my_module_name = strval(Tools::getValue('tarjeta_nombre'));        
	    	
	        if (!$my_module_name
	          || empty($my_module_name)
	          || !Validate::isGenericName($my_module_name))
	            $output .= $this->displayError($this->l('El campo nombre no puede quedar vacio.'));
	        else
	        {
	        	
	        	if((int)Tools::getValue("id_tarjeta") > 0 ){
	        		$tarjetas = new tarjetasCore(Tools::getValue("id_tarjeta"));
		            $tarjetas->descripcion = Tools::getValue("tarjeta_nombre");
		            $tarjetas->activo = (int)Tools::getValue("status");
		            $tarjetas->numerocomercio = (int)0;
		            $tarjetas->date_upd = date('Y-m-d H:m:s');
		            $tarjetas->update();
		            $output .= $this->displayConfirmation($this->l('Actualizado correctamente'));
	        	}else{
		        	$tarjetas = new tarjetasCore();
		            $tarjetas->descripcion = Tools::getValue("tarjeta_nombre");
		            $tarjetas->activo = (int)Tools::getValue("status");
		            $tarjetas->numerocomercio = (int)0;
		            $tarjetas->date_add = date('Y-m-d H:m:s');
		            $tarjetas->add();
		            //Configuration::updateValue('MYMODULE_NAME', $my_module_name);
		            $output .= $this->displayConfirmation($this->l('Cargado exitosamente!'));
	            }
	        }
	    }

	    if (Tools::isSubmit('submitPlanes'))
	    {
	    	$plan_nombre = strval(Tools::getValue('plan_nombre'));
	    	$cuotas = strval(Tools::getValue('cuotas'));
	    	$coeficiente = strval(Tools::getValue('coeficiente'));
	    	$fechadesde = strval(Tools::getValue('fechahoravigenciadesde'));
	    	$fechahasta = strval(Tools::getValue('fechahoravigenciahasta'));
	    	if (!$plan_nombre || !$cuotas || !$coeficiente || !$fechadesde || !$fechahasta
	          || empty($plan_nombre)
	          || !Validate::isGenericName($plan_nombre)){
	            $output .= $this->displayError($this->l('Todos los campos son requeridos.'));

	        }else
	        {
	        	
	        	if((int)Tools::getValue("idPlanestarjetas") > 0 ){
	        		$planes = new planestarjetasCore(Tools::getValue("idPlanestarjetas"));
		            $planes->codigotarjeta = Tools::getValue("codigotarjeta");
		            $planes->tarjeta = Tools::getValue("tarjeta_nombre");
		            $planes->planestarjeta = Tools::getValue("plan_nombre");
		            $planes->cantidadcuotas = (int)Tools::getValue("cuotas");
		            $planes->coeficiente = (int)str_replace('%','',Tools::getValue("coeficiente"));
					$planes->fechahoravigenciadesde = Tools::getValue("fechahoravigenciadesde");
					$planes->fechahoravigenciahasta = Tools::getValue("fechahoravigenciahasta");
		            $planes->activo = Tools::getValue("status");
		            $planes->update();
		            $output .= $this->displayConfirmation($this->l('Actualizado correctamente'));
		            //Tools::redirectAdmin('index.php?controller=AdminModules&token='.Tools::getAdminTokenLite('AdminModules').'&configure='.$this->name.'&addplanes&codigotarjeta='.Tools::getValue('codigotarjeta').'&token='.Tools::getAdminTokenLite('AdminModules'));
	        	}else{
		        	$planes = new planestarjetasCore();
		            $planes->codigotarjeta = Tools::getValue("codigotarjeta");
		            $planes->tarjeta = Tools::getValue("tarjeta_nombre");
		            $planes->planestarjeta = Tools::getValue("plan_nombre");
		            $planes->cantidadcuotas = (int)Tools::getValue("cuotas");
		            $planes->coeficiente = (int)str_replace('%','',Tools::getValue("coeficiente"));
					$planes->fechahoravigenciadesde = Tools::getValue("fechahoravigenciadesde");
					$planes->fechahoravigenciahasta = Tools::getValue("fechahoravigenciahasta");
		            $planes->activo = (int)Tools::getValue("status");
		            $planes->add();
		            //Configuration::updateValue('MYMODULE_NAME', $my_module_name);
		            $output .= $this->displayConfirmation($this->l('Cargado exitosamente!'));
		            //Tools::redirectAdmin('index.php?controller=AdminModules&token='.Tools::getAdminTokenLite('AdminModules').'&configure='.$this->name.'&addplanes&codigotarjeta='.Tools::getValue('codigotarjeta').'&token='.Tools::getAdminTokenLite('AdminModules'));
	            }
	        }
	    }
	    
	    return $output;
	}

	/**
	 * Muestro el formulario
	 */
	public function getContent()
	{   
		//$this->_postProcess();
		if (Tools::isSubmit('submitFilter') or Tools::isSubmit('submitResettarjetas')){	
			
			if(Tools::isSubmit('submitResettarjetas'))
			$filtro = '';
				else
			$filtro = $_POST['tarjetasFilter_descripcion'];

			return $this->_postProcess().$this->processFilter($filtro);
	
		}else{
			if(isset($_GET['addplanes']) && !isset($_GET['updatetarjetas']) && !isset($_GET['deletetarjetas']) && !isset($_GET['statustarjetas']) or isset($_GET['addplanes']) && isset($_GET['updateplanes_tarjetas']) && isset($_GET['statusplanes_tarjetas']))
			 	return $this->_postProcess().$this->displayFormPlanes();
			 else
			    return $this->_postProcess().$this->displayForm();
		}//end submitFilter
	}


	public function displayForm()
	{
		if(isset($_GET['updatetarjetas']))
			$tarjeta = new tarjetasCore(Tools::getValue('codigotarjeta'));

		$this->html = '';
		
		//** HelperForm **//

		// Get default language
	    $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
	     
	    // Init Fields form array
	    $fields_form[0]['form'] = array(
	        'legend' => array(
	            'title' => $this->l('Crear Tarjeta'),
	        ),
	        'input' => array(
	            array(
	                'type' => 'text',
	                'label' => $this->l('Nombre'),
	                'name' => 'tarjeta_nombre',
	                'desc' => 'Nombre con el que aparecera el metodo de pago',
	                'size' => 20,
	                'required' => true
	            ),
	            array(
	                'type' => 'hidden',	                
	                'name' => 'id_tarjeta',
	                'size' => 20,
	                'required' => true
	            ),
	            array(
						'type' => 'switch',
						'label' =>'Activo',
						'name' =>  'status',
						'desc' => 'Activa y desactiva el metodo de pago',
						'is_bool' => false,
						'values' => array(
								array(
										'id' => 'active_on',
										'value' => 1,
										'label' =>'SI'
								),
								array(
										'id' => 'active_off',
										'value' => 0,
										'label' =>'NO'
								)
						),
						'required' => false
				),

	        ),
	        'buttons' => array(
		        array(
		            'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
		            'title' => $this->l('Back to list'),
		            'icon' => 'process-icon-back'
		        )
		    ),	        
	        'submit' => array(
	            'title' => $this->l('Save'),
	            'class' => 'button pull-right'
	        ),
	        
	    );
		
		
	    
	    $helper = new HelperForm();
	     
	    // Module, token and currentIndex
	    $helper->module = $this;
	    $helper->name_controller = $this->name;
	    $helper->token = Tools::getAdminTokenLite('AdminModules');
	    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
	     
	    // Language
	    $helper->default_form_language = $default_lang;
	    $helper->allow_employee_form_lang = $default_lang;
	     
	    // Title and toolbar
	    $helper->title = $this->displayName;
	    $helper->show_toolbar = true;        // false -> remove toolbar
	    $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
	    $helper->submit_action = 'submit'.$this->name;
	    $helper->toolbar_btn = array(
	        'save' => array(
	            'desc' => $this->l('Save'),
	            'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
	            '&token='.Tools::getAdminTokenLite('AdminModules'),
	        ),
	        'back' => array(
	            'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
	            'desc' => $this->l('Back to list')
	        )
	    );
	    
	    $helper->fields_value['status'] = 1;
	    
	    // Load current value
	    if(isset($_GET['updatetarjetas'])){
	    	$helper->fields_value['tarjeta_nombre'] = $tarjeta->descripcion;
			$helper->fields_value['id_tarjeta'] = $tarjeta->codigotarjeta;
			$helper->fields_value['status'] = $tarjeta->activo;
		}
	     
	    if(isset($_GET['add'.$this->name]) || isset($_GET['updatetarjetas']))
	    $this->html .= $helper->generateForm($fields_form);

	    //HelperList

		$this->fields_list = array(
		    'codigotarjeta' => array(
		        'title' => $this->l('Id'),
		        'width' => auto,
		        'type' => 'text',
		        'class' => 'fixed-width-xs',
		        'search' => false,
		    ),
		    'descripcion' => array(
		        'title' => $this->l('Nombre'),
		        'width' => 140,
		        'type' => 'text',
		        'search' => true,
		        
		    ),
		    'count_values' => array(
		        'title' => $this->l('Cantidad de Planes'),
		        'width' => 140,
		        'type' => 'price',
		        'callback' => 'getCountPlanes',	
		        'search' => false,	      	        
		    ),
		    'activo' => array(
		        'title' => $this->l('Estado'),
		        'width' => auto,
		        'align' => 'center',
		        'active' => 'status',
				'type' => 'bool',
				'search' => false,
				'class' => 'fixed-width-sm'
		    ),
		    /*'date_add' => array(
		        'title' => $this->l('Fecha de Creacion'),
		        'width' => auto,
		        'align' => 'center',
		        'search' => false,
		        'type' => 'text',
		        
		    ),*/
		    'date_upd' => array(
		        'title' => $this->l('Fecha Actualizacion'),
		        'width' => auto,
		        'align' => 'center',
		        'search' => false,
		        'type' => 'text',
		        
		    ),
		);

		$helperList = new HelperList();
		 
		$helperList->shopLinkType = '';
		$helperList->no_link=false;
		 
		$helperList->simple_header = false;
		$helperList->listTotal = tarjetasCore::getCountTarjetas('TotalTarjetas'); 
		// Actions to be displayed in the "Actions" column
		$helperList->actions = array('view','edit', 'delete');
		
		$helperList->identifier = 'codigotarjeta';
		$helperList->show_toolbar = true;
		$helperList->title = 'Listado de Tarjetas';
		$helperList->table = 'tarjetas';
		//echo $this->name.'_categories';
		$helperList->toolbar_btn = array(
	      'new' => array(
	          'desc' => $this->l('Agregar Tarjeta'),
	          'href' => AdminController::$currentIndex.'&configure='.$this->name.'&add'.$this->name.
	          '&token='.Tools::getAdminTokenLite('AdminModules'),
	      ),	      
	      /*'back' => array(
	          'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
	          'desc' => $this->l('Back to list')
	      )*/
	    );
		//token
		$helperList->token = Tools::getAdminTokenLite('AdminModules');
		$helperList->currentIndex = AdminController::$currentIndex.'&configure='.$this->name.'&addplanes';

		$tarjetas = tarjetasCore::getTarjetas('codigotarjeta','ASC');		

		if(!isset($_GET['add'.$this->name]) && !isset($_GET['updatetarjetas']))
		$this->html .= $helperList->generateList($tarjetas, $this->fields_list);


		return $this->html;
	}

	public function displayFormPlanes()
	{
		$tarjeta = new tarjetasCore(Tools::getValue('codigotarjeta'));
		if(isset($_GET['updateplanes_tarjetas']))
			$planes = new planestarjetasCore(Tools::getValue('idPlanestarjetas'));


		$this->html = '';
		
		//** HelperForm **//

		// Get default language
	    $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

	    // Init Fields form array
	    $fields_form[0]['form'] = array(
	        'legend' => array(
	            'title' => $this->l('Crear Planes > '.tarjetasCore::getNombreTarjeta(Tools::getValue('codigotarjeta'))),
	        ),
	        'input' => array(
	        	array(
	                'type' => 'hidden',	                
	                'name' => 'codigotarjeta',
	                'size' => 20,
	                'required' => true
	            ),
	            array(
	                'type' => 'hidden',	                
	                'name' => 'tarjeta_nombre',
	                'size' => 20,
	                'required' => true
	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('Nombre'),
	                'name' => 'plan_nombre',
	                'desc' => 'Nombre con el que aparecera los planes de pago.',
	                'size' => 20,
	                'col' => '4',
	                'required' => true
	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('Cuotas'),
	                'name' => 'cuotas',
	                'desc' => 'Cantidad de cuotas.',	              
	                'required' => true,
	                'class' => 'solo_numero',
	                'col' => '3',
	                
	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('Porcentaje de Interes'),
	                'name' => 'coeficiente',
	                'desc' => 'Los valores negativos funcionan como descuento.',
	                'size' => 20,
	                'col' => '3',
	                'required' => true
	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('Fecha Desde'),
	                'name' => 'fechahoravigenciadesde',
	                'desc' => 'Fecha de plan de pago.',
	                'size' => 20,
	                'class' => 'datepicker',
	                'col' => '3',
	                'required' => true
	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('Fecha Hasta'),
	                'name' => 'fechahoravigenciahasta',
	                'desc' => 'Fecha de plan de pago.',
	                'size' => 20,
	                'class' => 'datepicker',
	                'col' => '3',
	                'required' => true
	            ),
	            array(
	                'type' => 'hidden',	                
	                'name' => 'idPlanestarjetas',
	                'size' => 20,
	                'required' => true
	            ),
	            array(
						'type' => 'switch',
						'label' =>'Activo',
						'name' =>  'status',
						'desc' => 'Activa y desactiva el metodo de pago',
						'is_bool' => true,
						'values' => array(
								array(
										'id' => 'active_on',
										'value' => true,
										'label' =>'SI'
								),
								array(
										'id' => 'active_off',
										'value' => false,
										'label' =>'NO'
								)
						),
						'required' => false
				),
	        ),
	        'buttons' => array(
		        array(
		            'href' => AdminController::$currentIndex.'&configure='.$this->name.'&addplanes&codigotarjeta='.Tools::getValue('codigotarjeta').'&token='.Tools::getAdminTokenLite('AdminModules'),
		            'title' => $this->l('Volver a los planes'),
		            'icon' => 'process-icon-back'
		        )
		    ),	        
	        'submit' => array(
	            'title' => $this->l('Save'),
	            'class' => 'button pull-right'
	        )
	    );
	     
	    $helper = new HelperForm();
	     
	    // Module, token and currentIndex
	    $helper->module = $this;
	    $helper->name_controller = 'Planes';
	    $helper->token = Tools::getAdminTokenLite('AdminModules');
	    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name.'&addplanes&codigotarjeta='.Tools::getValue('codigotarjeta');
	     
	    // Language
	    $helper->default_form_language = $default_lang;
	    $helper->allow_employee_form_lang = $default_lang;
	     
	    // Title and toolbar
	    $helper->title = $this->displayName;
	    $helper->show_toolbar = true;        // false -> remove toolbar
	    $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
	    $helper->submit_action = 'submitPlanes';
	    $helper->toolbar_btn = array(
	        'save' =>  array(
	            'desc' => $this->l('Save'),
	            'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
	            '&token='.Tools::getAdminTokenLite('AdminModules'),
	        ),
	        'back' => array(
	            'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
	            'desc' => $this->l('Back to list')
	        )
	    );
	     
	     $helper->fields_value['codigotarjeta'] = $tarjeta->codigotarjeta;
	     $helper->fields_value['tarjeta_nombre'] = $tarjeta->descripcion;
	     $helper->fields_value['status'] = 1;
	    // Load current value
	    if(isset($_GET['updateplanes_tarjetas'])){	    	
	    	
	    	$helper->fields_value['plan_nombre'] = $planes->planestarjeta;
	    	$helper->fields_value['cuotas'] = $planes->cantidadcuotas;	
	    	$helper->fields_value['coeficiente'] = $planes->coeficiente.'%';
	    	$helper->fields_value['fechahoravigenciadesde'] = $planes->fechahoravigenciadesde;
	    	$helper->fields_value['fechahoravigenciahasta'] = $planes->fechahoravigenciahasta;		    	
			$helper->fields_value['idPlanestarjetas'] = $planes->idPlanestarjetas;
			$helper->fields_value['status'] = $planes->activo;
		}
	    
	    if(isset($_GET['addPlanes'.$this->name]) || isset($_GET['updateplanes_tarjetas']))
	    $this->html .= $helper->generateForm($fields_form);

	    //HelperList

		$this->fields_list = array(

		    'idPlanestarjetas' => array(
		        'title' => $this->l('Id'),
		        'width' => auto,
		        'type' => 'text',
		        'class' => 'codigotarjeta fixed-width-xs',
		        'search' => false,
		    ),
		    'planestarjeta' => array(
		        'title' => $this->l('Nombre'),
		        'width' => 140,
		        'type' => 'text',
		        'search' => false,
		        
		    ),
		    'cantidadcuotas' => array(
		        'title' => $this->l('Cuotas'),
		        'width' => auto,
		        'type' => 'text',
		        'search' => false,
		        'align' => 'center',
		        
		    ),
		    'coeficiente' => array(
		        'title' => $this->l('Porcentaje'),
		        'width' => auto,
		        'type' => 'text',
		        'search' => false,
		        'align' => 'center',
		        
		    ),
		    'activo' => array(
		        'title' => $this->l('Estado'),
		        'align' => 'center',
		        'width' => auto,
		        'active' => 'status',
				'type' => 'bool',
				'class' => 'fixed-width-sm',
				'search' => false,
				'align' => 'center',
		    ),
		    
		);
		$helperList = new HelperList();
		 
		$helperList->shopLinkType = '';
		$helperList->no_link=true;
		$helperList->listTotal = planestarjetasCore::getCountPlanes(Tools::getValue('codigotarjeta'));
		$helperList->simple_header = false;
		 
		// Actions to be displayed in the "Actions" column
		$helperList->actions = array('edit', 'delete');

		
		$helperList->identifier = 'idPlanestarjetas';
		$helperList->show_toolbar = true;
		$helperList->title = 'Listado Planes > '.tarjetasCore::getNombreTarjeta(Tools::getValue('codigotarjeta'));
		$helperList->table = 'planes_tarjetas';
		//echo $this->name.'_categories';
		$helperList->toolbar_btn = array(
	      'new' => array(
	          'desc' => $this->l('Agregar Planes'),
	          'href' => AdminController::$currentIndex.'&configure='.$this->name.'&addplanes&codigotarjeta='.Tools::getValue('codigotarjeta').'&addPlanes'.$this->name.
	          '&token='.Tools::getAdminTokenLite('AdminModules'),
	      ),	      
	      'back' => array(
	          'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
	          'desc' => $this->l('Volver al listado de tarjetas')
	      )
	    );

		//token
		$helperList->token = Tools::getAdminTokenLite('AdminModules');
		$helperList->currentIndex = AdminController::$currentIndex.'&configure='.$this->name.'&addplanes&codigotarjeta='.Tools::getValue('codigotarjeta');

		$planes = planestarjetasCore::getPlanes(Tools::getValue('codigotarjeta'),'idPlanestarjetas','ASC');

		if(!isset($_GET['addPlanesabmtarjetas']) && !isset($_GET['updateplanes_tarjetas']))
		$this->html .= $helperList->generateList($planes, $this->fields_list);


		return $this->html;
	}

	public function getCountPlanes($codigotarjeta){
		$countPlanes = planestarjetasCore::getCountPlanes($codigotarjeta);
		return (int)$countPlanes;
	}

	public function processStatus($id,$status)
	{
		switch($status){
			case 'tarjetas':
				$tarjeta = new tarjetasCore($id);
				if((int)$tarjeta->activo)
					$tarjeta->activo = 0;
				else
					$tarjeta->activo = 1;
				$tarjeta->update();
			break;
			case 'planes':
				$planes = new planestarjetasCore($id);
				if((int)$planes->activo)
					$planes->activo = 0;
				else
					$planes->activo = 1;
				$planes->update();
			break;
		}
	}

	public function processFilter($filter){
		$this->html = '';
		
		$this->fields_list = array(
		    'codigotarjeta' => array(
		        'title' => $this->l('Id'),
		        'width' => auto,
		        'type' => 'text',
		        'class' => 'fixed-width-xs',
		        'search' => false,
		    ),
		    'descripcion' => array(
		        'title' => $this->l('Nombre'),
		        'width' => 140,
		        'type' => 'text',
		        'search' => true,
		        
		    ),
		    /*'count_values' => array(
		        'title' => $this->l('Cantidad de Planes'),
		        'width' => 140,
		        'type' => 'text',
		        'value' => 10,		        
		    ),*/
		    'activo' => array(
		        'title' => $this->l('Estado'),
		        'width' => auto,
		        'align' => 'center',
		        'active' => 'status',
				'type' => 'bool',
				'search' => false,
				'class' => 'fixed-width-sm'
		    ),
		    /*'date_add' => array(
		        'title' => $this->l('Fecha de Creacion'),
		        'width' => auto,
		        'align' => 'center',
		        'search' => false,
		        'type' => 'text',
		        
		    ),*/
		    'date_upd' => array(
		        'title' => $this->l('Fecha Actualizacion'),
		        'width' => auto,
		        'align' => 'center',
		        'search' => false,
		        'type' => 'text',
		        
		    ),
		);

		$helperList = new HelperList();
		 
		$helperList->shopLinkType = '';
		$helperList->no_link=false;
		 
		$helperList->simple_header = false;
		$helperList->listTotal = tarjetasCore::getCountTarjetas('TotalTarjetas'); 
		// Actions to be displayed in the "Actions" column
		$helperList->actions = array('view','edit', 'delete');
		
		$helperList->identifier = 'codigotarjeta';
		$helperList->show_toolbar = true;
		$helperList->title = 'Listado de Tarjetas';
		$helperList->table = 'tarjetas';
		//echo $this->name.'_categories';
		$helperList->toolbar_btn = array(
	      'new' => array(
	          'desc' => $this->l('Agregar Tarjeta'),
	          'href' => AdminController::$currentIndex.'&configure='.$this->name.'&add'.$this->name.
	          '&token='.Tools::getAdminTokenLite('AdminModules'),
	      ),	      
	      /*'back' => array(
	          'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
	          'desc' => $this->l('Back to list')
	      )*/
	    );
		//token
		$helperList->token = Tools::getAdminTokenLite('AdminModules');
		$helperList->currentIndex = AdminController::$currentIndex.'&configure='.$this->name.'&addplanes';

		if(empty($filter))
		$tarjetas = tarjetasCore::getTarjetas('codigotarjeta','ASC');	
			else
		$tarjetas = tarjetasCore::searchTarjetas($filter);

		
		$this->html .= $helperList->generateList($tarjetas, $this->fields_list);
		return $this->html;
	}

	/**
	* Opcional: para archivos CSS y JavaScript que se usaran en el BackOffice de este modulo.
	*/
	public function hookDisplayBackOfficeHeader()
	{
		$this->context->controller->addJS(($this->_path).'views/js/abmtarjetas.js');
		$this->context->controller->addCSS(($this->_path).'css/back.css');
	}

	public function hookHeader($params)
    {
        $this->context->controller->addCSS(($this->_path).'views/css/abmtarjetas_hook.css', 'all');
        $this->context->controller->addJS(($this->_path).'views/js/abmtarjetas_hook.js');
        
    }

	public function hookDisplayProductListFunctionalButtons($params)
	{
		
		//$this->smarty->assign('product', $params['product']);
		//return $this->display(($this->_path), 'views/templates/hook/abmtarjetas.tpl');
	}

	public function hookDisplayProductButtons($params)
	{
		$this->smarty->assign(array(
			'product' => $params['product'],
			'tarjetas' => tarjetasCore::getTarjetasActivo('t.descripcion','ASC'),
			'planes' => new planestarjetasCore,			
			));

		return $this->display(($this->_path), 'views/templates/hook/abmtarjetas.tpl');
	}
}
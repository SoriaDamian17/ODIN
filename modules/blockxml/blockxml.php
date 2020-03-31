<?php
if (!defined('_PS_VERSION_'))
  exit;
include (dirname(__FILE__) . '/class/install.php');
require_once (dirname(__FILE__) . '/class/generarXml.php');
require_once (dirname(__FILE__) . '/class/xml.php');
require_once (dirname(__FILE__) . '/class/apilvz.php');

class blockxml extends Module
{
	public function __construct()
  {
    $this->name = 'blockxml';
    $this->tab = 'front_office_features';
    $this->version = '0.9';
    $this->author = 'Flexxus S.A';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_); 
    $this->bootstrap = true;
 	
    parent::__construct();
 
    $this->displayName = $this->l('Bloque Export Xml');
    $this->description = $this->l('Exporta productos y categorias en xml.');
 
    $this->confirmUninstall = $this->l('Estás seguro que deseas desinstalar?');
 
  }

  public function install()
	{
	  if (Shop::isFeatureActive())
   	 Shop::setContext(Shop::CONTEXT_ALL);
 
	  if ( !parent::install() 
	  	|| !$this->registerHook('displayBackOfficeHeader') 
	  	|| !inst::installTablas()
	  	|| !Configuration::updateValue('ads_type',0)
	    || !Configuration::updateValue('operation',0)
	    || !Configuration::updateValue('payment',0)
	    || !Configuration::updateValue('district',0)
	  	|| !Configuration::updateValue('email',Configuration::get('PS_SHOP_EMAIL'))
	  	|| !Configuration::updateValue('stores',1)
	  	|| !Configuration::updateValue('product_active',1)
	  	|| !Configuration::updateValue('category_active',1)	
	  	|| !Configuration::updateValue('city',Configuration::get('PS_SHOP_CITY')) 
	  	|| !Configuration::updateValue('state',Configuration::get('PS_SHOP_STATE_ID'))    
	  	|| !Configuration::updateValue('phone',Configuration::get('PS_SHOP_PHONE'))  
	  	|| !Configuration::updateValue('latitude',Configuration::get('PS_STORES_CENTER_LAT')) 
	  	|| !Configuration::updateValue('longitude',Configuration::get('PS_STORES_CENTER_LONG'))  
	  )
	    return false;
	  return true;	}

	public function uninstall()
	{
	  if ( !parent::uninstall() 
	  	|| !inst::uninstallTablas()
	    || !Configuration::deleteByName('ads_type')
	    || !Configuration::deleteByName('operation')
	    || !Configuration::deleteByName('payment')
	    || !Configuration::deleteByName('district')
	  	|| !Configuration::deleteByName('email')
	  	|| !Configuration::deleteByName('stores')
	  	|| !Configuration::deleteByName('product_active')
	  	|| !Configuration::deleteByName('category_active')
	  	|| !Configuration::deleteByName('city')
	  	|| !Configuration::deleteByName('state')
	  	|| !Configuration::deleteByName('phone')
	  	|| !Configuration::deleteByName('latitude')
	  	|| !Configuration::deleteByName('longitude')
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
		$id_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		if (Tools::isSubmit('submit'.$this->name)){	
			Configuration::updateValue('ads_type',Tools::getValue('ads_type'));
			Configuration::updateValue('operation',Tools::getValue('operation'));
			Configuration::updateValue('payment',Tools::getValue('payment'));
			Configuration::updateValue('district',Tools::getValue('district'));
			Configuration::updateValue('email',Tools::getValue('email'));	
			Configuration::updateValue('stores',Tools::getValue('stores'));
			Configuration::updateValue('product_active',Tools::getValue('product_active'));
			Configuration::updateValue('category_active',Tools::getValue('category_active'));
			Configuration::updateValue('city',Tools::getValue('city'));
			Configuration::updateValue('state',Tools::getValue('state'));
			Configuration::updateValue('phone',Tools::getValue('phone'));
			Configuration::updateValue('latitude',Tools::getValue('latitude'));
			Configuration::updateValue('longitude',Tools::getValue('longitude'));
			//var_dump($_POST);
		}//end isSubmit

		return $output;
	}

	/**
	 * Muestro el formulario
	 */
	public function getContent()
	{   
		return $this->_postProcess().$this->renderForm().$this->renderView().$this->getModules();		
	}

	public function renderForm()
	{		
		
		$id_shop = Context::getContext()->shop->id;
		$selected_categories = array( (int)Tools::getValue('id_parent', Category::getRootCategory()->id)); 
		// Init Fields form array
	    $fields_form[0]['form'] = array(
	        'legend' => array(
	            'title' => $this->l('Ajustes de Exportacion Xml'),
	            'icon' => 'icon-cog',
	        ),
	        'tinymce' => true,
	        'input' => array(
	        	array(
				  'type' => 'select',
				  'label' => $this->l('Tipo de Aviso'),
				  'name' => 'ads_type',
				  'required' => true,
				  'options' => array(
					'query' => generarXml::generarOptions('ads_type'),
					'id' => 'value',                      
					'name' => 'name' 
				  ),
				  'class' => 'chosen-select'
				), 
				array(
				  'type' => 'select',
				  'label' => $this->l('Tipo de Operacion'),
				  'name' => 'operation',
				  'required' => true,
				  'options' => array(
					'query' => generarXml::generarOptions('operation'),
					'id' => 'value',                      
					'name' => 'name' 
				  ),
				  'class' => 'chosen-select'
				),   
				array(
				  'type' => 'select',
				  'label' => $this->l('Formas de pago'),
				  'name' => 'payment',
				  'required' => true,
				  'options' => array(
					'query' => generarXml::generarOptions('payment'),
					'id' => 'value',                      
					'name' => 'name' 
				  ),
				  'class' => 'chosen-select'
				),
				array(
				  'type' => 'select',
				  'label' => $this->l('Zona'),
				  'name' => 'district',
				  'required' => true,
				  'options' => array(
					'query' => generarXml::generarOptions('zona'),
					'id' => 'value',                      
					'name' => 'name' 
				  ),
				  'class' => 'chosen-select'
				), 
				array(
				  'type' => 'select',
				  'label' => $this->l('Provincia'),
				  'name' => 'state',
				  'required' => true,
				  'options' => array(
					'query' => generarXml::generarOptions('state'),
					'id' => 'value',                      
					'name' => 'name' 
				  ),
				  'class' => 'chosen-select'
				), 
				array(
	                'type' => 'text',
	                'label' => $this->l('Ciudad'),
	                'name' => 'city',
	                'col' => '3',
	                'required' => false,
	                //'desc' => 'Nombre para ordenar la promocion.',
	            ),   
	            array(
	                'type' => 'text',
	                'label' => $this->l('Teléfono'),
	                'name' => 'phone',
	                'col' => '3',
	                'required' => false,
	                //'desc' => 'Nombre para ordenar la promocion.',
	            ),  
	        	array(
	                'type' => 'text',
	                'label' => $this->l('Email'),
	                'name' => 'email',
	                'col' => '3',
	                'required' => false,
	                //'desc' => 'Nombre para ordenar la promocion.',
	            ),
	            array(
	            	'type' => 'hidden',
					'label' => $this->l('Latitude'),
					'hint' => $this->l('Latitud GMap donde se encuentra su negocio.'),
					'cast' => 'floatval',
					'name' => 'latitude',					
					'size' => '10',
					'col' => '3',
				),
				array(
					'type' => 'hidden',
					'label' => $this->l('Longitude'),
					'hint' => $this->l('Longitud GMap donde se encuentra su negocio.'),
					'cast' => 'floatval',
					'name' => 'longitude',					
					'size' => '10',
					'col' => '3',
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Mostrar Stock'),
					'name' =>  'stores',
					'desc' => 'Muestra el stock disponible de los productos.',
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
	            array(
					'type' => 'switch',
					'label' => $this->l('Productos activos'),
					'name' =>  'product_active',
					'desc' => 'Solo se genera el xml con productos activos',
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
				array(
					'type' => 'switch',
					'label' => $this->l('Todas las Categoria'),
					'name' =>  'category_active',
					'desc' => 'Seleccione que no para habilitar el arbol de categorias para seleccionar.',
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
					'class' => 'categorias-switch',
					'required' => false
				),
				array(
					'type'  => 'categories',
					'label' => $this->l('Categorias'),
					'name'  => 'id_parent',
					'tree'  => array(
						'id'                  => 'categories-tree',
						'selected_categories' => $selected_categories,
						//'disabled_categories' => (!Tools::isSubmit('add'.$this->table) && !Tools::isSubmit('submitAdd'.$this->table)) ? array($this->_category->id) : null
					),
				),
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
	    //Get Lenguajes
	    foreach (Language::getLanguages(false) as $lang)
		$helper->languages[] = array(
			'id_lang' => $lang['id_lang'],
			'iso_code' => $lang['iso_code'],
			'name' => $lang['name'],
			'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
		);
	    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;	     
	    // Language
	    $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
    	$helper->default_form_language = $lang->id;
	    $helper->allow_employee_form_lang = $lang->id;	     
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
	    
	    $options = self::getConfigFieldsValues();
	    //var_dump($options);
	    foreach($options as $key => $value) 
	    {
	    	$helper->fields_value[$key] = Configuration::get($key);
	    }	    	      

	    $this->html .= $helper->generateForm($fields_form);

		return $this->html;
	}

	public function renderView()
	{
		$tpl = $this->context->smarty->createTemplate(dirname(__FILE__).'/views/templates/admin/'.$this->name.'.tpl');
		
		$url_xml = $_SERVER['SERVER_NAME'].$this->_path.'xml/';

		$tpl->assign(array( 
             'url_xml' => '',
        ));
  		
  		return $tpl->fetch();
	}	

	public function renderExportForm()
	{
		
	}

	public function getModules()
	{	
       $modules = xmlapi::getModules();
       return $modules;
	}

	public function getConfigFieldsValues()
	{	

		return array(
					'ads_type' => Configuration::get('ads_type'), 
					'operation' => Configuration::get('operation'), 
					'payment' => Configuration::get('payment'), 
					'district' => Configuration::get('district'), 
					'email' => Configuration::get('email'),
					'latitude' => Configuration::get('latitude'), 
					'longitude' => Configuration::get('longitude'),  
					'phone' => Configuration::get('phone'),
					'city' => Configuration::get('city'), 
					'state' => Configuration::get('state'),
					'stores' => Configuration::get('stores'),
					'product_active' => Configuration::get('product_active'),
					'category_active' => Configuration::get('category_active'),
					'category' => Configuration::get('category'), 
				);
	}

	/**
	* Opcional: para archivos CSS y JavaScript que se usaran en el BackOffice de este modulo.
	*/
	public function hookDisplayBackOfficeHeader()
	{
		$this->context->controller->addJS(($this->_path).'views/js/'.$this->name.'.js');
		$this->context->controller->addJS(($this->_path).'views/lib/owl-carousel/owl.carousel.js');
		$this->context->controller->addCSS(($this->_path).'views/css/'.$this->name.'.css');
		$this->context->controller->addCSS(($this->_path).'views/lib/owl-carousel/owl.carousel.css');
		$this->context->controller->addCSS(($this->_path).'views/lib/owl-carousel/owl.theme.css');
	}

	public function hookHeader($params)
    {
        
    }

	public function hookDisplayProductListFunctionalButtons($params)
	{
	
	}


}
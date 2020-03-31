<?php
if (!defined('_PS_VERSION_'))
  exit;
include (dirname(__FILE__) . '/class/xml.php');

class blockmarcas extends Module
{
	public function __construct()
  {
    $this->name = 'blockmarcas';
    $this->tab = 'front_office_features';
    $this->version = '0.9';
    $this->author = 'Flexxus S.A';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_); 
    $this->bootstrap = true;
 	
    parent::__construct();
 
    $this->displayName = $this->l('Bloque Carousel Marcas');
    $this->description = $this->l('Muestra un carousel de marcas.');
 
    $this->confirmUninstall = $this->l('Estás seguro que deseas desinstalar?');
 
  }

  public function install()
	{
	  if (Shop::isFeatureActive())
   	 Shop::setContext(Shop::CONTEXT_ALL);
 
	  if (!parent::install() ||
	  	!$this->registerHook('DisplayHeader') ||
	  	!$this->registerHook('displayBackOfficeHeader') ||
	    !$this->registerHook('displayHome') ||
	    !Configuration::updateValue('tipoImagen')
	    || !Configuration::updateValue('item',5)
	    || !Configuration::updateValue('itemsDesktop',4)
	    || !Configuration::updateValue('itemsDesktopSmall',3)
	    || !Configuration::updateValue('itemsTablet',2)
	    || !Configuration::updateValue('delay',1500)
		|| !Configuration::updateValue('autoplay',1)
		|| !Configuration::updateValue('pagination',1)	
	  )
	    return false;
	  return true;	
	}

	public function uninstall()
	{
	  if (!parent::uninstall() 
	  	|| !Configuration::deleteByName('tipoImagen')
	    || !Configuration::deleteByName('item')
	    || !Configuration::deleteByName('itemsDesktop')
	    || !Configuration::deleteByName('itemsDesktopSmall')
	    || !Configuration::deleteByName('itemsTablet')
	    || !Configuration::deleteByName('delay')
	    || !Configuration::deleteByName('autoplay')
	    || !Configuration::deleteByName('pagination')
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
				Configuration::updateValue('tipoImagen',Tools::getValue('tipoImagen'));
				Configuration::updateValue('item',Tools::getValue('item'));	
				Configuration::updateValue('itemsDesktop',Tools::getValue('itemsDesktop'));
			    Configuration::updateValue('itemsDesktopSmall',Tools::getValue('itemsDesktopSmall'));
			    Configuration::updateValue('itemsTablet',Tools::getValue('itemsTablet'));
			    Configuration::updateValue('delay',Tools::getValue('delay'));
			    Configuration::updateValue('autoplay',Tools::getValue('autoplay'));
			    Configuration::updateValue('pagination',Tools::getValue('pagination'));		
		}//end isSubmit

		return $output;
	}

	/**
	 * Muestro el formulario
	 */
	public function getContent()
	{   
		return $this->_postProcess().$this->renderForm().$this->getModules();		
	}

	public function renderForm()
	{
		$marcas = ImageType::getImagesTypes('manufacturers');
		
		$tipoImagenes = array();
		foreach ($marcas as $value => $key)
			$tipoImagenes[] = array('value' => $key['name'], 'name' => $key['name']);

		// Init Fields form array
	    $fields_form[0]['form'] = array(
	        'legend' => array(
	            'title' => $this->l('Ajustes'),
	            'icon' =>	'icon-cogs',
	        ),
	        'tinymce' => true,
	        'input' => array(
	        	array(
				  'type' => 'select',
				  'label' => $this->l('Tipo de imagen'),
				  'name' => 'tipoImagen',
				  'required' => true,
				  'options' => array(
					'query' => $tipoImagenes,
					'id' => 'value',                      
					'name' => 'name' 
				  )
				),      	
	            array(
	                'type' => 'text',
	                'label' => $this->l('Numero de marcas mostradas Wide Screen'),
	                'name' => 'item',
	                'desc' => 'Indique el numero de marcas que desea mostrar en el carousel.',
	                'size' => 20,
	                'col' => '3',

	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('Numero de marcas mostradas descktop screens'),
	                'name' => 'itemsDesktop',
	                'desc' => 'Indique el numero de marcas que desea mostrar en el carousel.',
	                'size' => 20,
	                'col' => '3',

	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('Numero de marcas mostradas tablet screen'),
	                'name' => 'itemsDesktopSmall',
	                'desc' => 'Indique el numero de marcas que desea mostrar en el carousel.',
	                'size' => 20,
	                'col' => '3',

	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('Numero de marcas mostradas mobile screen'),
	                'name' => 'itemsTablet',
	                'desc' => 'Indique el numero de marcas que desea mostrar en el carousel.',
	                'size' => 20,
	                'col' => '3',

	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('Delay'),
	                'name' => 'delay',
	                'desc' => 'Indique el numero de tiempo para la transicion.',
	                'size' => 20,
	                'col' => '3',

	            ),
	            array(
						'type' => 'switch',
						'label' =>'Autoplay',
						'name' =>  'autoplay',
						'desc' => 'Activa y desactiva el modo slider',
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
						'label' =>'Mostrar posicion de carrousel',
						'name' =>  'pagination',
						'desc' => 'Activa y desactiva la posicion del carrousel',
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
	    
	    $helper->fields_value['tipoImagen'] = Configuration::get('tipoImagen');
	    $helper->fields_value['item'] = (int)Configuration::get('item');
	    $helper->fields_value['itemsDesktop'] = (int)Configuration::get('itemsDesktop');
	    $helper->fields_value['itemsDesktopSmall'] = (int)Configuration::get('itemsDesktopSmall');  
	    $helper->fields_value['itemsTablet'] = (int)Configuration::get('itemsTablet'); 
	    $helper->fields_value['delay'] = (int)Configuration::get('delay'); 
	    $helper->fields_value['autoplay'] = (int)Configuration::get('autoplay'); 
	    $helper->fields_value['pagination'] = (int)Configuration::get('pagination');    
	   
	    $this->html .= $helper->generateForm($fields_form);

		return $this->html;
	}

	public function renderList($filter)
	{

	}	

	public function processStatus($id,$status)
	{
		
	}

	public function getModules()
	{		
		
      	$modules = api::getModules();
       return $modules;
      	
	}

	public function getCountMarcas(){
		$marcas = Manufacturer::getManufacturers(false,1,true);
		$count = 0;
		foreach($marcas as $marca){
			$count++;
		}
		return $count;
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
        //$this->context->controller->addJS(($this->_path).'views/js/'.$this->name.'.js');
		$this->context->controller->addJS(($this->_path).'views/lib/owl-carousel/owl.carousel.js');
		$this->context->controller->addCSS(($this->_path).'views/css/'.$this->name.'.css');
		$this->context->controller->addCSS(($this->_path).'views/lib/owl-carousel/owl.carousel.css');
		$this->context->controller->addCSS(($this->_path).'views/lib/owl-carousel/owl.theme.css');
    }

	public function hookdisplayHome($params)
	{	
		$this->smarty->assign(array(
			'tipoImagen' => Configuration::get('tipoImagen'),
			'item' => (int)Configuration::get('item'),
			'itemsDesktop' => (int)Configuration::get('itemsDesktop'),
			'itemsDesktopSmall' => (int)Configuration::get('itemsDesktopSmall'),
			'itemsTablet' => (int)Configuration::get('itemsTablet'),
			'delay' => (int)Configuration::get('delay'),
			'autoplay' => (int)Configuration::get('autoplay'),
			'pagination' => (int)Configuration::get('pagination'),
			'countMarcas' => (int)$this->getCountMarcas(),
            'marcas' => Manufacturer::getManufacturers(false,1,true), 
        ));

		return $this->display(($this->_path), 'views/templates/hook/'.$this->name.'.tpl');
	}


}
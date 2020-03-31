<?php
if (!defined('_PS_VERSION_'))
  exit;
require_once (dirname(__FILE__) . '/class/facebook_lang.php');
require_once (dirname(__FILE__) . '/class/xml.php');

class blockfacebookup extends Module
{
	public function __construct()
  {
    $this->name = 'blockfacebookup';
    $this->tab = 'front_office_features';
    $this->version = '0.9';
    $this->author = 'Flexxus S.A';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_); 
    $this->bootstrap = true;
 	
    parent::__construct();
 
    $this->displayName = $this->l('Bloque Facebook Up');
    $this->description = $this->l('Muestra un bloque flotante con la pagina de facebook.');
 
    $this->confirmUninstall = $this->l('Estás seguro que deseas desinstalar?');
 
  }

  public function install()
	{
	  if (Shop::isFeatureActive())
   	 Shop::setContext(Shop::CONTEXT_ALL);
 
	  if (!parent::install() 
	  	|| !$this->registerHook('DisplayHeader') 
	  	|| !$this->registerHook('displayBackOfficeHeader') 
	    || !$this->registerHook('displayProductButtons') 
	    //!$this->registerHook('displayProductListFunctionalButtons') ||
	    || !Configuration::updateValue($this->name.'lang','es_ES')
	    || !Configuration::updateValue($this->name,'https://www.facebook.com/prestashop')
	    || !Configuration::updateValue('data_height','300')
		|| !Configuration::updateValue('data_width','400')
		|| !Configuration::updateValue('data_cover',1)
		|| !Configuration::updateValue('data_facepile',1)	
		|| !Configuration::updateValue('data_posts',0)
	  )
	    return false;
	  return true;	}

	public function uninstall()
	{
	  if (!parent::uninstall()
	  	|| !Configuration::deleteByName($this->name.'lang')
	    || !Configuration::deleteByName($this->name)
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
			Configuration::updateValue($this->name.'lang',Tools::getValue('idioma'));
			Configuration::updateValue($this->name,Tools::getValue('facebookurl'));
			Configuration::updateValue('data_height',Tools::getValue('data_height'));
			Configuration::updateValue('data_width',Tools::getValue('data_width'));
			Configuration::updateValue('data_cover',Tools::getValue('data_cover'));
			Configuration::updateValue('data_facepile',Tools::getValue('data_facepile'));	
			Configuration::updateValue('data_posts',Tools::getValue('data_posts'));
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
		$fblang = fblang::getLang();
		// Init Fields form array
	    $fields_form[0]['form'] = array(
	        'legend' => array(
	            'title' => $this->l('Bloque Facebook Up'),
	            'icon' => 'icon-cogs'
	        ),
	        'input' => array(
	        	array(
				  'type' => 'select',
				  'label' => $this->l('Idioma'),
				  'name' => 'idioma',
				  'required' => true,
				  'options' => array(
					'query' => $fblang,
					'id' => 'value',                      
					'name' => 'name' 
				  ),
				  'class' => 'chosen-select'
				),   	        	
	            array(
	                'type' => 'text',
	                'label' => $this->l('Facebook Url'),
	                'name' => 'facebookurl',
	                'col' => '3',
	                'required' => true,
	                //'desc' => 'Nombre para ordenar la promocion.',
	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('Alto box'),
	                'name' => 'data_height',
	                'col' => '3',
	                'required' => false,
	                //'desc' => 'Nombre para ordenar la promocion.',
	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('Ancho box'),
	                'name' => 'data_width',
	                'col' => '3',
	                'required' => false,
	                //'desc' => 'Nombre para ordenar la promocion.',
	            ),
	            array(
					'type' => 'switch',
					'label' => $this->l('Portada'),
					'name' => 'data_cover',
					'desc' => $this->l('Muestra la imagen de portada.'),
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
					'label' => $this->l('Seguidores'),
					'name' => 'data_facepile',
					'desc' => $this->l('Desactiva el visualizador de seguidores.'),
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
					'label' => $this->l('Mostrar Publicaciones'),
					'name' => 'data_posts',
					'desc' => $this->l('Desactiva la visualizacion de publicaciones.'),
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
	    
	    $helper->fields_value['idioma'] = Configuration::get($this->name.'lang');
	    $helper->fields_value['facebookurl'] = Configuration::get($this->name);
	    $helper->fields_value['data_height'] = Configuration::get('data_height');
	    $helper->fields_value['data_width'] = Configuration::get('data_width');    
	    $helper->fields_value['data_cover'] = Configuration::get('data_cover');
	    $helper->fields_value['data_facepile'] = Configuration::get('data_facepile');
	    $helper->fields_value['data_posts'] = Configuration::get('data_posts');

	    $this->html .= $helper->generateForm($fields_form);

		return $this->html;
	}

	public function renderList($filter)
	{

	}	

	public function renderView()
	{
		$tpl = $this->context->smarty->createTemplate(dirname(__FILE__).'/views/templates/admin/'.$this->name.'.tpl');
		
		$data_cover = (!Configuration::get('data_cover')? 'true' : 'false');
		$data_facepile = (Configuration::get('data_facepile')? 'true' : 'false');
		$data_posts = (Configuration::get('data_posts')? 'true' : 'false');
		
		$tpl->assign(array( 
            'facebooklang' => Configuration::get($this->name.'lang'),   
            'facebookurl' => Configuration::get($this->name),
            'data_height' => Configuration::get('data_height'),
		    'data_width' => Configuration::get('data_width'),   
		    'data_cover' => $data_cover,
		    'data_facepile' => $data_facepile,
		    'data_posts' => $data_posts,     
        ));
  		
  		return $tpl->fetch();
	}

	public function processStatus($id,$status)
	{

	}

	public function getModules()
	{			
       $modules = xmlfb::getModules();
       //return $modules;      	
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
        $this->context->controller->addCSS(($this->_path).'views/css/'.$this->name.'_hook.css', 'all');       
        $this->context->controller->addJS(($this->_path).'views/js/'.$this->name.'_hook.js');        
        
       	$data_cover = (!Configuration::get('data_cover')? 'true' : 'false');
		$data_facepile = (Configuration::get('data_facepile')? 'true' : 'false');
		$data_posts = (Configuration::get('data_posts')? 'true' : 'false');
		
		$this->smarty->assign(array(
            'facebooklang' => Configuration::get($this->name.'lang'),   
            'facebookurl' => Configuration::get($this->name),
            'data_height' => Configuration::get('data_height'),
		    'data_width' => Configuration::get('data_width'),   
		    'data_cover' => $data_cover,
		    'data_facepile' => $data_facepile,
		    'data_posts' => $data_posts,     
        ));

        return $this->display(($this->_path), 'views/templates/hook/'.$this->name.'.tpl');
    }

	public function hookDisplayProductListFunctionalButtons($params)
	{
	
	}


}
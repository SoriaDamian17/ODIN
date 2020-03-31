<?php
class AdminThemesConfigurationControllerCore
{
	public $name = 'AdminThemesConfiguration';
	public $title = 'Order Data Integration | Themes Configuration';
	public $dir;
	public $context;
	public $alert;
	public $token;
	public $theme = 'default-theme';
	public $action = array();

	public function __construct()
	{
		//$this->title = 'Administrador Criadero';
		$this->dir = str_replace('admin','',strtolower($this->name));
		$this->context = Context::getContext();
		$this->token = Tools::getValue('token');
		$this->action[] = array('name' => 'edit');
		$this->action[] = array('name' => 'delete');
		//if(Tools::getToken($this->name) != Tools::getValue('token'))
			//header('location:index.php?controller=AdminLogin&token='.Tools::getToken('AdminLogin'));
	}

	public function postProcess()
	{
		self::checkToken();
    self::processBulkAction();
	}

	public function renderForm()
	{
		self::postProcess();
		$id = (Tools::getIsset('id') && Tools::getValue('id') != '' ? (int)Tools::getValue('id') : '' );
		$this->context->smarty->assign(array(
				'title' => $this->title,
				'alert' => $this->alert,
		));
		$content = $this->context->smarty->fetch('templates/'.$this->theme.'/controllers/'.$this->dir.'/content.tpl');
		$content .= self::renderList();
		return $content;
	}

	public function renderList()
	{
	}

  public function processBulkAction()
	{

	}

	public function checkToken()
	{
		 if(md5($this->name) != $this->token)
		 		return false;
		return true;
	}

}

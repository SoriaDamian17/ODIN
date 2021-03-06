<?php
class AdminCategoryControllerCore
{
	public $name = 'AdminCategory';
	public $title = 'Order Data Integration | Category';
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
		$this->alert = 'success';
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
		$content = '';
		$id = (Tools::getIsset('id') && Tools::getValue('id') != '' ? (int)Tools::getValue('id') : '' );
		$category = new Category($id);
		$this->context->smarty->assign(array(
				'title' => $this->title,
				'alert' => 'success',
				'categoria' => $category,				
		));
		
		$content .= $this->context->smarty->fetch('templates/'.$this->theme.'/controllers/'.$this->dir.'/content.tpl');
		
		$content .= self::renderList();
		return $content;
	}

	public function renderList()
	{
		$this->context->smarty->assign(array(
				'categoria' => new Category(),
		));
		return $this->context->smarty->fetch('templates/'.$this->theme.'/controllers/'.$this->dir.'/list.tpl');
	}

  	public function processBulkAction()
	{
		$id = (Tools::getIsset('updCategory') && Tools::getValue('id') != '' ? Tools::getValue('id') : 0 );
		$Category = new Category($id);
		$Category->name = Tools::getValue('CategoryName');
		$Category->active = Tools::getValue('CategoryName');
		if(Tools::isSubmit('addM'))
		{
			if($Category->add())
				$this->alert = 'success';
			else
				$this->alert = 'warning';
		}
		
		if(Tools::isSubmit('updM'))
		{
			//$Category->update();		
		}
		
	}

	public function checkToken()
	{
		 if(md5($this->name) != $this->token)
		 		return false;
		return true;
	}

}

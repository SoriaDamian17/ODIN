<?php
class AdminProductControllerCore
{
	public $name = 'AdminProduct';
	public $title = 'Order Data Integration | Product';
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
		$product = new Product($id);
		$this->context->smarty->assign(array(
				'title' => $this->title,
				'alert' => $this->alert,
				'product' => $product,
		));
		$content = $this->context->smarty->fetch('templates/'.$this->theme.'/controllers/'.$this->dir.'/content.tpl');
		$content .= self::renderList();
		return $content;
	}

	public function renderList()
	{
		$this->context->smarty->assign(array(
				'Product' => new Product(),
				'Moneda' => new Currency(),
		));
		return $this->context->smarty->fetch('templates/'.$this->theme.'/controllers/'.$this->dir.'/list.tpl');
	}

  public function processBulkAction()
	{
			$id = (Tools::getIsset('addProduct') && Tools::getValue('id') != '' ? Tools::getValue('id') : 0 );
			$product = new Product($id);
			$product->name = array( 1 => Tools::getValue('productName'));
			$product->reference = Tools::getValue('reference');
			$product->active = Tools::getValue('active');
			if(Tools::isSubmit('addM'))
			{
				if($product->add())
					$this->alert = 'success';
				else
					$this->alert = 'warning';
			}

			if(Tools::isSubmit('updM'))
			{
				$product->update();
			}
	}

	public function checkToken()
	{
		 if(md5($this->name) != $this->token)
		 		return false;
		return true;
	}

}

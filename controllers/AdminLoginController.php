<?php
class AdminLoginControllerCore
{
	public $name = 'AdminLogin';
	public $title = 'Order Data Integration | Login';
	public $dir;
	public $context;
	public $alert;
	public $token;
	public $errors = array();
	public $theme = 'default-theme';

	public function __construct()
	{
		//$this->title = 'Administrador Criadero';
		$this->dir = str_replace('admin','',strtolower($this->name));
		$this->context = Context::getContext();
		$this->token = Tools::getValue('token');
		if(Tools::getToken($this->name) != Tools::getValue('token'))
			$this->alert = 'Token Incorrecto';
		if(Tools::getToken($this->name) != Tools::getValue('token'))
			header('location:index.php?controller=AdminLogin&token='.Tools::getToken('AdminLogin'));
	}

	public function postProcess()
	{
		self::checkToken();
		if (Tools::isSubmit('submitLogin'))
		{
			self::processLogin();
		}
				//self::processLogin();
		//if(isset(Tools::getValue('logout')) && Tools::getValue('logout') == true)
			//Usuarios::logout();

	}

	public function renderForm()
	{
		self::postProcess();
		$this->context->smarty->assign(array(
				'title' => $this->title,
				'alert' => $this->errors,
		));

		$content = $this->context->smarty->fetch('templates/'.$this->theme.'/controllers/'.$this->dir.'/content.tpl');

		return $content;
	}

	public function checkToken()
	{
		 if(md5($this->name) != $this->token)
		 		return false;
		return true;
	}

	public function processLogin()
	{
		/* Check fields validity */
		$passwd = trim(Tools::getValue('passwd'));
		$email = trim(Tools::getValue('email'));
		if (empty($email))
			$this->errors[] = Tools::displayError('Email is empty.');
		elseif (!Validate::isEmail($email))
			$this->errors[] = Tools::displayError('Invalid email address.');

		if (empty($passwd))
			$this->errors[] = Tools::displayError('The password field is blank.');
		elseif (!Validate::isPasswd($passwd))
			$this->errors[] = Tools::displayError('Invalid password.');
		
			if (!count($this->errors))
			{
				// Find employee
				$this->context->employee = new Employee();
				$is_employee_loaded = $this->context->employee->getByEmail($email, $passwd);
				
				if (!$is_employee_loaded)
				{
					$this->errors[] = Tools::displayError('The Employee does not exist, or the password provided is incorrect.');
					$this->context->employee->logout();
				}else{
					//var_dump($is_employee_loaded);
					$cookie = new Cookie();
					// Set cookie name
					$cookie->setName('employee');
					// Set cookie expiration time
					$cookie->setTime("+1 hour");
					$cookie->create();
					// Delete the cookie.
					//$cookie->delete();
					if(empty($cookie))					
						@header('Location:index:php?controller=AdminAccess&token='.Tools::getToken('AdminAccess'));

					}//end count errors
			}
	}
}

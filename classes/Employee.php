<?php
class EmployeeCore extends ObjectModel
{
	public $id;

	/** @var string Determine employee profile */
	public $id_profile;

	/** @var string employee language */
	public $id_lang;

	/** @var string Lastname */
	public $lastname;

	/** @var string Firstname */
	public $firstname;

	/** @var string e-mail */
	public $email;

	/** @var string Password */
	public $passwd;

	/** @var datetime Password */
	public $last_passwd_gen;

	public $stats_date_from;
	public $stats_date_to;

	public $stats_compare_from;
	public $stats_compare_to;
	public $stats_compare_option = 1;

	public $preselect_date_range;

	/** @var string Display back office background in the specified color */
	public $bo_color;

	public $default_tab;

	/** @var string employee's chosen theme */
	public $bo_theme;

	/** @var string employee's chosen css file */
	public $bo_css = 'admin-theme.css';

	/** @var integer employee desired screen width */
	public $bo_width;

	/** @var bool, false */
	public $bo_menu = 1;

	/* Deprecated */
	public $bo_show_screencast = false;

	/** @var boolean Status */
	public $active = 1;

	/** @var boolean Optin status */
	public $optin = 1;

	public $remote_addr;

	/* employee notifications */
	public $id_last_order;
	public $id_last_customer_message;
	public $id_last_customer;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'employee',
		'primary' => 'id_employee',
		'fields' => array(
			'lastname' =>					array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
			'firstname' =>					array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
			'email' =>						array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 128),
			'id_lang' => 					array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
			'passwd' => 					array('type' => self::TYPE_STRING, 'validate' => 'isPasswdAdmin', 'required' => true, 'size' => 32),
			'last_passwd_gen' =>			array('type' => self::TYPE_STRING),
			'active' => 					array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'optin' => 			  			array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'id_profile' => 		 		array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
			'bo_color' => 			 		array('type' => self::TYPE_STRING, 'validate' => 'isColor', 'size' => 32),
			'default_tab' => 		 		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
			'bo_theme' => 			 		array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 32),
			'bo_css' => 					array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 64),
			'bo_width' => 					array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'bo_menu' => 					array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'stats_date_from' => 			array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'stats_date_to' => 				array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'stats_compare_from' =>			array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'stats_compare_to' =>			array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'stats_compare_option' =>		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'preselect_date_range' =>		array('type' => self::TYPE_STRING, 'size' => 32),
			'id_last_order' => 				array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'id_last_customer_message' =>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'id_last_customer' =>			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
		),
	);


	public function __construct($id = null)
	{
		parent::__construct($id);

		//$this->image_dir = _PS_EMPLOYEE_IMG_DIR_;
	}

	public function add($autodate = true, $null_values = true)
	{
		$this->last_passwd_gen = date('Y-m-d H:i:s', strtotime('-'.Configuration::get('PS_PASSWD_TIME_BACK').'minutes'));

	 	return parent::add($autodate, $null_values);
	}

	public function update($null_values = false)
	{
		if (empty($this->stats_date_from) || $this->stats_date_from == '0000-00-00')
			$this->stats_date_from = date('Y-m-d');
		if (empty($this->stats_date_to) || $this->stats_date_to == '0000-00-00')
			$this->stats_date_to = date('Y-m-d');

	 	return parent::update($null_values);
	}



	/**
	 * Return list of employees
	 */
	public static function getEmployees()
	{
		return Db::getInstance()->executeS('
			SELECT `id_employee`, `firstname`, `lastname`
			FROM `'._DB_PREFIX_.'employee`
			WHERE `active` = 1
			ORDER BY `lastname` ASC
		');
	}

	/**
	  * Return employee instance from its e-mail (optionnaly check password)
	  *
	  * @param string $email e-mail
	  * @param string $passwd Password is also checked if specified
	  * @return Employee instance
	  */
	public function getByEmail($email, $passwd = null)
	{
	 	if (!Validate::isEmail($email) || ($passwd != null && !Validate::isPasswd($passwd)))
	 		die(Tools::displayError());

		$result = Db::getInstance()->getRow('
		SELECT *
		FROM `'._DB_PREFIX_.'employee`
		WHERE `active` = 1
		AND `email` = \''.pSQL($email).'\'
		'.($passwd !== null ? 'AND `passwd` = \''.Tools::encrypt($passwd).'\'' : ''));
		if (!$result)
			return false;
		$this->id = $result['id_employee'];
		$this->id_profile = $result['id_profile'];
		foreach ($result as $key => $value)
			if (property_exists($this, $key))
				$this->{$key} = $value;
		return $this;
	}

	public static function employeeExists($email)
	{
	 	if (!Validate::isEmail($email))
	 		die (Tools::displayError());

		return (bool)Db::getInstance()->getValue('
		SELECT `id_employee`
		FROM `'._DB_PREFIX_.'employee`
		WHERE `email` = \''.pSQL($email).'\'');
	}

	/**
	  * Check if employee password is the right one
	  *
	  * @param string $passwd Password
	  * @return boolean result
	  */
	public static function checkPassword($id_employee, $passwd)
	{
	 	if (!Validate::isUnsignedId($id_employee) || !Validate::isPasswd($passwd, 8))
	 		die (Tools::displayError());

		return Db::getInstance()->getValue('
		SELECT `id_employee`
		FROM `'._DB_PREFIX_.'employee`
		WHERE `id_employee` = '.(int)$id_employee.'
		AND `passwd` = \''.pSQL($passwd).'\'
		AND active = 1');
	}



	/**
	  * Logout
	  */
	public function logout()
	{
		if (isset(Context::getContext()->cookie))
		{
			Context::getContext()->cookie->logout();
			Context::getContext()->cookie->write();
		}
		$this->id = null;
	}

}

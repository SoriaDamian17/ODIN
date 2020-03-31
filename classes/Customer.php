<?php
class CustomerCore extends ObjectModel
{
	public $id;

	public $id_shop;

	public $id_shop_group;

	/** @var string Secure key */
	public $secure_key;

	/** @var string protected note */
	public $note;

	/** @var integer Gender ID */
	public $id_gender = 0;

	/** @var integer Default group ID */
	public $id_default_group;

	/** @var integer Current language used by the customer */
	public $id_lang;

	/** @var string Lastname */
	public $lastname;

	/** @var string Firstname */
	public $firstname;

	/** @var string Birthday (yyyy-mm-dd) */
	public $birthday = null;

	/** @var string e-mail */
	public $email;

	/** @var boolean Newsletter subscription */
	public $newsletter;

	/** @var string Newsletter ip registration */
	public $ip_registration_newsletter;

	/** @var string Newsletter ip registration */
	public $newsletter_date_add;

	/** @var boolean Opt-in subscription */
	public $optin;

	/** @var string WebSite **/
	public $website;

	/** @var string Company */
	public $company;

	/** @var string SIRET */
	public $siret;

	/** @var string APE */
	public $ape;

	/** @var float Outstanding allow amount (B2B opt)  */
	public $outstanding_allow_amount = 0;

	/** @var integer Show public prices (B2B opt) */
	public $show_public_prices = 0;

	/** @var int Risk ID (B2B opt) */
	public $id_risk;

	/** @var integer Max payment day */
	public $max_payment_days = 0;

	/** @var integer Password */
	public $passwd;

	/** @var string Datetime Password */
	public $last_passwd_gen;

	/** @var boolean Status */
	public $active = true;

	/** @var boolean Status */
	public $is_guest = 0;

	/** @var boolean True if carrier has been deleted (staying in database as deleted) */
	public $deleted = 0;

	/** @var string Object creation date */
	public $date_add;

	/** @var string Object last modification date */
	public $date_upd;

	public $years;
	public $days;
	public $months;

	/** @var int customer id_country as determined by geolocation */
	public $geoloc_id_country;
	/** @var int customer id_state as determined by geolocation */
	public $geoloc_id_state;
	/** @var string customer postcode as determined by geolocation */
	public $geoloc_postcode;

	/** @var boolean is the customer logged in */
	public $logged = 0;

	/** @var int id_guest meaning the guest table, not the guest customer  */
	public $id_guest;

	public $groupBox;


	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'customer',
		'primary' => 'id_customer',
		'fields' => array(
			'secure_key' => 				array('type' => self::TYPE_STRING, 'validate' => 'isMd5', 'copy_post' => false),
			'lastname' => 					array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
			'firstname' => 					array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
			'email' => 						array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 128),
			'passwd' => 					array('type' => self::TYPE_STRING, 'validate' => 'isPasswd', 'required' => true, 'size' => 32),
			'last_passwd_gen' =>			array('type' => self::TYPE_STRING, 'copy_post' => false),
			'id_gender' => 					array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'birthday' => 					array('type' => self::TYPE_DATE, 'validate' => 'isBirthDate'),
			'newsletter' => 				array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'newsletter_date_add' =>		array('type' => self::TYPE_DATE,'copy_post' => false),
			'ip_registration_newsletter' =>	array('type' => self::TYPE_STRING, 'copy_post' => false),
			'optin' => 						array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'website' =>					array('type' => self::TYPE_STRING, 'validate' => 'isUrl'),
			'company' =>					array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
			'siret' =>						array('type' => self::TYPE_STRING, 'validate' => 'isSiret'),
			'ape' =>						array('type' => self::TYPE_STRING, 'validate' => 'isApe'),
			'outstanding_allow_amount' =>	array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat', 'copy_post' => false),
			'show_public_prices' =>			array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
			'id_risk' =>					array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'copy_post' => false),
			'max_payment_days' =>			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'copy_post' => false),
			'active' => 					array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
			'deleted' => 					array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
			'note' => 						array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'size' => 65000, 'copy_post' => false),
			'is_guest' =>					array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
			'id_shop' => 					array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'copy_post' => false),
			'id_shop_group' => 				array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'copy_post' => false),
			'id_default_group' => 			array('type' => self::TYPE_INT, 'copy_post' => false),
			'id_lang' => 					array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'copy_post' => false),
			'date_add' => 					array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
			'date_upd' => 					array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
		),
	);

	protected static $_defaultGroupId = array();
	protected static $_customerHasAddress = array();
	protected static $_customer_groups = array();

	public function __construct($id = null)
	{
		parent::__construct($id);
	}

	public function add($autodate = true, $null_values = true)
	{
		$success = parent::add($autodate, $null_values);
		return $success;
	}

	public function update($nullValues = false)
	{
		return parent::update(true);
	}

	public function delete()
	{
		return parent::delete();
	}

}

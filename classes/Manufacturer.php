<?php
class ManufacturerCore extends ObjectModel
{
	public $id;

	/** @var string Name */
	public $name;

	/** @var string A description */
	public $description;

	/** @var string A short description */
	public $short_description;

	/** @var int Address */
	public $id_address;

	/** @var string Object creation date */
	public $date_add;

	/** @var string Object last modification date */
	public $date_upd;

	/** @var string Friendly URL */
	public $link_rewrite;

	/** @var string Meta title */
	public $meta_title;

	/** @var string Meta keywords */
	public $meta_keywords;

	/** @var string Meta description */
	public $meta_description;

	/** @var boolean active */
	public $active;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'manufacturer',
		'primary' => 'id_manufacturer',
		'multilang' => true,
		'fields' => array(
			'name' => 				array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'required' => true, 'size' => 64),
			'active' => 			array('type' => self::TYPE_BOOL),
			'date_add' => 			array('type' => self::TYPE_DATE),
			'date_upd' => 			array('type' => self::TYPE_DATE),

			// Lang fields
			'description' => 		array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
			'short_description' => 	array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
			'meta_title' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 128),
			'meta_description' => 	array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
			'meta_keywords' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName'),
		),
	);

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

	/**
	  * Return manufacturers
	  *
	  * @param int $id_lang
	  * @param bool $active
	  * @param int $p
	  * @param int $n
	  * @param bool $all_group
	  * @return array Manufacturers
	  */
	public static function getManufacturers($id_lang = 1, $active = false, $p = false, $n = false, $all_group = false, $group_by = false)
	{
			$manufacturers = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT m.*, ml.`description`, ml.`short_description`
			FROM `'._DB_PREFIX_.'manufacturer` m
			INNER JOIN `'._DB_PREFIX_.'manufacturer_lang` ml ON (m.`id_manufacturer` = ml.`id_manufacturer` AND ml.`id_lang` = '.(int)$id_lang.')
			'.($active ? 'WHERE m.`active` = 1' : '')
			.($group_by ? ' GROUP BY m.`id_manufacturer`' : '' ).'
			ORDER BY m.`id_manufacturer` ASC
			'.($p ? ' LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n : ''));

		 return $manufacturers;
	}

	public static function getProduct($id_manufacturer,$id_lang = 1)
	{
			$product = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT count(p.id_product) as nb_products
				FROM `'._DB_PREFIX_.'product` p
			WHERE p.`id_manufacturer` = '.$id_manufacturer.'
			');

		 return $product;
	}
	
	public static function getCount()
	{
		$manufacturer = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT count(m.id_manufacturer) as marcas
				FROM `'._DB_PREFIX_.'manufacturer` m');
		return $manufacturer;
	}
}

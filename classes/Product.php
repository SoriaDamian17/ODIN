<?php
class ProductCore extends ObjectModel
{
	/** @var string Tax name */
	public $tax_name;

	/** @var string Tax rate */
	public $tax_rate;

	/** @var integer Manufacturer id */
	public $id_manufacturer;

	/** @var integer Supplier id */
	public $id_supplier;

	/** @var integer default Category id */
	public $id_category_default;

	/** @var integer default Shop id */
	public $id_shop_default;

	/** @var string Manufacturer name */
	public $manufacturer_name;

	/** @var string Supplier name */
	public $supplier_name;

	/** @var string Name */
	public $name;

	/** @var string Long description */
	public $description;

	/** @var string Short description */
	public $description_short;

	/** @var integer Quantity available */
	public $quantity = 0;

	/** @var integer Minimal quantity for add to cart */
	public $minimal_quantity = 1;

	/** @var string available_now */
	public $available_now;

	/** @var string available_later */
	public $available_later;

	/** @var float Price in euros */
	public $price = 0;

	/** @var float Additional shipping cost */
	public $additional_shipping_cost = 0;

	/** @var float Wholesale Price in euros */
	public $wholesale_price = 0;

	/** @var boolean on_sale */
	public $on_sale = false;

	/** @var boolean online_only */
	public $online_only = false;

	/** @var string unity */
	public $unity = null;

		/** @var float price for product's unity */
	public $unit_price;

		/** @var float price for product's unity ratio */
	public $unit_price_ratio = 0;

	/** @var float Ecotax */
	public $ecotax = 0;

	/** @var string Reference */
	public $reference;

	/** @var string Supplier Reference */
	public $supplier_reference;

	/** @var string Location */
	public $location;

	/** @var string Width in default width unit */
	public $width = 0;

	/** @var string Height in default height unit */
	public $height = 0;

	/** @var string Depth in default depth unit */
	public $depth = 0;

	/** @var string Weight in default weight unit */
	public $weight = 0;

	/** @var string Ean-13 barcode */
	public $ean13;

	/** @var string Upc barcode */
	public $upc;

	/** @var string Friendly URL */
	public $link_rewrite;

	/** @var string Meta tag description */
	public $meta_description;

	/** @var string Meta tag keywords */
	public $meta_keywords;

	/** @var string Meta tag title */
	public $meta_title;

	/** @var boolean Product statuts */
	public $quantity_discount = 0;

	/** @var boolean Product customization */
	public $customizable;

	/** @var boolean Product is new */
	public $new = null;

	/** @var integer Number of uploadable files (concerning customizable products) */
	public $uploadable_files;

	/** @var int Number of text fields */
	public $text_fields;

	/** @var boolean Product statuts */
	public $active = true;

	/** @var boolean Product statuts */
	public $redirect_type = '';

	/** @var boolean Product statuts */
	public $id_product_redirected = 0;

	/** @var boolean Product available for order */
	public $available_for_order = true;

	/** @var string Object available order date */
	public $available_date = '0000-00-00';

	/** @var enum Product condition (new, used, refurbished) */
	public $condition;

	/** @var boolean Show price of Product */
	public $show_price = true;

	/** @var boolean is the product indexed in the search index? */
	public $indexed = 0;

	/** @var string ENUM('both', 'catalog', 'search', 'none') front office visibility */
	public $visibility;

	/** @var string Object creation date */
	public $date_add;

	/** @var string Object last modification date */
	public $date_upd;


	public static $definition = array(
		'table' => 'product',
		'primary' => 'id_product',
		'multilang' => true,
		'fields' => array(
			/* Classic fields */
			'id_shop_default' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_manufacturer' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_supplier' => 				array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'reference' => 					array('type' => self::TYPE_STRING, 'validate' => 'isReference', 'size' => 32),
			'supplier_reference' => 		array('type' => self::TYPE_STRING, 'validate' => 'isReference', 'size' => 32),
			'location' => 					array('type' => self::TYPE_STRING, 'validate' => 'isReference', 'size' => 64),
			'width' => 						array('type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat'),
			'height' => 					array('type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat'),
			'depth' => 						array('type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat'),
			'weight' => 					array('type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat'),
			'quantity_discount' => 			array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'ean13' => 						array('type' => self::TYPE_STRING, 'validate' => 'isEan13', 'size' => 13),
			'upc' => 						array('type' => self::TYPE_STRING, 'validate' => 'isUpc', 'size' => 12),
			'cache_is_pack' => 				array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'cache_has_attachments' => 		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'is_virtual' => 				array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),

			/* Shop fields */
			'id_category_default' => 		array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedId'),
			'id_tax_rules_group' => 		array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedId'),
			'on_sale' => 					array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'online_only' => 				array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'ecotax' => 					array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice'),
			'minimal_quantity' => 			array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedInt'),
			'price' => 						array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice', 'required' => true),
			'wholesale_price' => 			array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice'),
			'unity' => 						array('type' => self::TYPE_STRING, 'shop' => true, 'validate' => 'isString'),
			'unit_price_ratio' => 			array('type' => self::TYPE_FLOAT, 'shop' => true),
			'additional_shipping_cost' => 	array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice'),
			'customizable' => 				array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedInt'),
			'text_fields' => 				array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedInt'),
			'uploadable_files' => 			array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedInt'),
			'active' => 					array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'redirect_type' => 				array('type' => self::TYPE_STRING, 'shop' => true, 'validate' => 'isString'),
			'id_product_redirected' => 		array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedId'),
			'available_for_order' => 		array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'available_date' => 			array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDateFormat'),
			'condition' => 					array('type' => self::TYPE_STRING, 'shop' => true, 'validate' => 'isGenericName', 'values' => array('new', 'used', 'refurbished'), 'default' => 'new'),
			'show_price' => 				array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'indexed' => 					array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'visibility' => 				array('type' => self::TYPE_STRING, 'shop' => true, 'validate' => 'isProductVisibility', 'values' => array('both', 'catalog', 'search', 'none'), 'default' => 'both'),
			'cache_default_attribute' => 	array('type' => self::TYPE_INT, 'shop' => true),
			'advanced_stock_management' => 	array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
			'date_add' => 					array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDateFormat'),
			'date_upd' => 					array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDateFormat'),
			'pack_stock_type' =>			array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isUnsignedInt'),

			/* Lang fields */
			'meta_description' => 			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
			'meta_keywords' => 				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
			'meta_title' => 				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 128),
			'link_rewrite' =>	array(
				'type' => self::TYPE_STRING,
				'lang' => true,
				'validate' => 'isLinkRewrite',
				'required' => true,
				'size' => 128,
			),
			'name' => 						array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128),
			'description' => 				array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
			'description_short' => 			array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
			'available_now' => 				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
			'available_later' => 			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'IsGenericName', 'size' => 255),
		),
		'associations' => array(
			'manufacturer' => 				array('type' => self::HAS_ONE),
			'supplier' => 					array('type' => self::HAS_ONE),
			'default_category' => 			array('type' => self::HAS_ONE, 'field' => 'id_category_default', 'object' => 'Category'),
			'tax_rules_group' => 			array('type' => self::HAS_ONE),
			'categories' =>					array('type' => self::HAS_MANY, 'field' => 'id_category', 'object' => 'Category', 'association' => 'category_product'),
			'stock_availables' =>			array('type' => self::HAS_MANY, 'field' => 'id_stock_available', 'object' => 'StockAvailable', 'association' => 'stock_availables'),
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

	public static function getProducts($id_lang = 1, $only_active = false, Context $context = null)
	{
			if (!$context)
				$context = Context::getContext();

			$sql = 'SELECT p.*, pl.*
					FROM `'._DB_PREFIX_.'product` p
					LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product`)
					WHERE pl.`id_lang` = '.(int)$id_lang.' AND pl.`id_shop` = 1'.
						($only_active ? ' AND p.`active` = 1' : '');
			$rq = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

			return $rq;
	}

	public static function getCount()
	{
		$product = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT count(p.id_product) as productos
				FROM `'._DB_PREFIX_.'product` p');
		return $product;
	}

}

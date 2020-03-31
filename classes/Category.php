<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class CategoryCore extends ObjectModel
{
	public $id;

	/** @var integer category ID */
	public $id_category;

	/** @var string Name */
	public $name;

	/** @var boolean Status for display */
	public $active = 1;

	/** @var  integer category position */
	public $position;

	/** @var string Description */
	public $description;

	/** @var integer Parent category ID */
	public $id_parent;

	/** @var integer default Category id */
	public $id_category_default;

	/** @var integer Parents number */
	public $level_depth;

	/** @var integer Nested tree model "left" value */
	public $nleft;

	/** @var integer Nested tree model "right" value */
	public $nright;

	/** @var string string used in rewrited URL */
	public $link_rewrite;

	/** @var string Meta title */
	public $meta_title;

	/** @var string Meta keywords */
	public $meta_keywords;

	/** @var string Meta description */
	public $meta_description;

	/** @var string Object creation date */
	public $date_add;

	/** @var string Object last modification date */
	public $date_upd;

	/** @var boolean is Category Root */
	public $is_root_category;

	/** @var integer */
	public $id_shop_default;

	public $groupBox;

	protected static $_links = array();

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'category',
		'primary' => 'id_category',
		'multilang' => true,
		'multilang_shop' => true,
		'fields' => array(
			'nleft' => 				array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'nright' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'level_depth' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'active' => 			array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
			'id_parent' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'id_shop_default' => 	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'is_root_category' => 	array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'position' => 			array('type' => self::TYPE_INT),
			'date_add' => 			array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'date_upd' => 			array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			// Lang fields
			'name' => 				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128),
			'link_rewrite' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite', 'required' => true, 'size' => 128),
			'description' => 		array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
			'meta_title' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 128),
			'meta_description' => 	array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
			'meta_keywords' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
		),
	);

	
	public function __construct($id_category = null, $id_lang = null, $id_shop = null)
	{
		parent::__construct($id_category, $id_lang, $id_shop);
		//$this->id_image = ($this->id && file_exists(_PS_CAT_IMG_DIR_.(int)$this->id.'.jpg')) ? (int)$this->id : false;
		//$this->image_dir = _PS_CAT_IMG_DIR_;
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
	 * @see ObjectModel::toggleStatus()
	 */
	public function toggleStatus()
	{
		$result = parent::toggleStatus();
		//Hook::exec('actionCategoryUpdate');
		return $result;
	}

	/**
	  * Return available categories
	  *
	  * @param integer $id_lang Language ID
	  * @param boolean $active return only active categories
	  * @return array Categories
	  */
	public static function getCategories($id_lang = false, $id_parent = 2, $active = true, $order = true, $sql_filter = '', $sql_sort = '', $sql_limit = '')
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT c.*, cl.*
			FROM `'._DB_PREFIX_.'category` c
			LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category` 
			WHERE 1 AND c.id_parent = '.$id_parent.''.$sql_filter.' '.($id_lang ? 'AND cl.`id_lang` = '.(int)$id_lang : '').'
			'.($active ? 'AND c.`active` = 1' : '').'
			'.(!$id_lang ? 'GROUP BY c.id_category' : '').'
			'.($sql_limit != '' ? $sql_limit : '')
		);

		
		return $result;
	}

	public static function getCount()
	{
		$categorias = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT count(c.id_category) as categpria
				FROM `'._DB_PREFIX_.'category` c');
		return $categorias;
	}

}

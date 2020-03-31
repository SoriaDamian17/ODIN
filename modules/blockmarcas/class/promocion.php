<?php
Class promocion extends ObjectModel
{    
    /** @var integer ID Promocion */
    public $id;

     /** @var integer id shop */
    public $id_shop;

    /** @var integer id Lang */
    public $id_lang;

    /** @var integer nombre */
    public $nombre;

    /** @var string descripcion de la promocion */
    public $descripcion;

    /** @var string link de la promocion */
    public $link;

    /** @var boolean Status for display */
    public $delay = 0;

    /** @var boolean Status for display */
    public $activo = 1;

    /** @var string Object creation date */
    public $date_desde;

    /** @var string Object last modification date */
    public $date_hasta;

    /** @var string Object creation date */
    public $date_add;

    /** @var string Object last modification date */
    public $date_upd;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'promocion',
        'primary' => 'id_promocion',
        'multilang' => true,
        //'multilang_shop' => true,
        'fields' => array(            
            'id_shop' =>        array('type' => self::TYPE_NOTHING, 'validate' => 'isUnsignedId'),
            /* Lang fields */
            'nombre' =>         array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName' , 'required' => true),
            'descripcion' =>    array('type' => self::TYPE_HTML,   'lang' => true, 'validate' => 'isCleanHtml'),  
            'link' =>           array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName'),         

            'delay' =>         array('type' => self::TYPE_INT,     'validate' => 'isUnsignedInt'),
            'activo' =>         array('type' => self::TYPE_INT,    'validate' => 'isUnsignedInt'),
            'date_desde' =>     array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'date_hasta' =>     array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),            
            'date_add' =>       array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'date_upd' =>       array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),            
        ),
    );
    
    public function add($autodate = true, $null_values = false)
    {
        if (!parent::add($autodate, $null_values))
            return false;
    }

    public function update($null_values = false)
    {
        $return = parent::update($null_values);       

        return $return;
    }

    public function delete()
    {
        $result = parent::delete();
        if (!$result)
            return false;
        return true;
    }

    public function getCount(){
        $sql = 'SELECT count(id_promocion) as TotalPromocion FROM `'._DB_PREFIX_.'promocion` 
                ORDER BY id_promocion ASC';
        $obj = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        
        return $obj;
    }

    public function getList($filter,$order_by, $order_way){
        $sql = 'SELECT p.id_promocion,pl.nombre,pl.descripcion,p.activo,p.date_desde,p.date_hasta FROM `'._DB_PREFIX_.'promocion` p
                LEFT JOIN `'._DB_PREFIX_.'promocion_lang` pl ON(p.id_promocion = pl.id_promocion)                
                ORDER BY '.$order_by.' '.$order_way;
        //WHERE '.(!empty($filter) ? 'pl.nombre LIKE %'.$filter.'%' : '1=1' ).'
        $obj = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        
        return $obj;
    }

    public function getPromociones(){
        $sql = 'SELECT p.id_promocion,pl.nombre,pl.link,pl.descripcion,p.activo,p.date_desde,p.date_hasta FROM `'._DB_PREFIX_.'promocion` p
                LEFT JOIN `'._DB_PREFIX_.'promocion_lang` pl ON(p.id_promocion = pl.id_promocion)
                WHERE p.activo = 1 and cast("'.date('Y-m-d').'" as date) BETWEEN p.date_desde AND p.date_hasta
                ORDER BY p.id_promocion ASC';
        $obj = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        
        return $obj;
    }

}
?>
<?php
Class tarjetasCore extends ObjectModel
{    
    /** @var integer ID tarjeta */
    public $codigotarjeta;

    /** @var integer descripcion */
    public $descripcion;

    /** @var boolean Status for display */
    public $activo = 1;

    /** @var  integer category position */
    public $numerocomercio;

    /** @var  integer category position */
    public $paymentCod;

    /** @var string Object creation date */
    public $date_add;

    /** @var string Object creation date */
    public $date_upd;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'tarjetas',
        'primary' => 'codigotarjeta',
        'multilang' => false,
        'multilang_shop' => false,
        'fields' => array(
            'codigotarjeta' =>     array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'descripcion' =>       array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'activo' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),  
            'numerocomercio' =>    array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'paymentCod' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'), 
            
            'date_add' =>          array('type' => self::TYPE_DATE, 'validate' => 'isDate'), 
            'date_upd' =>          array('type' => self::TYPE_DATE, 'validate' => 'isDate'),               
            
        ),
    );

    public function add($autodate = true, $null_values = false)
    {
        if (!parent::add($autodate, $null_values))
            return false;
        return true;
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

    public function getTarjetas($order_by, $order_way){
        $sql = 'SELECT codigotarjeta,descripcion,activo,date_upd FROM `'._DB_PREFIX_.'tarjetas` 
                ORDER BY '.$order_by.' '.$order_way;
        $obj = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        
        return $obj;
    }

    public function searchTarjetas($query){
        $sql = 'SELECT codigotarjeta,descripcion,activo,date_upd FROM `'._DB_PREFIX_.'tarjetas` 
                WHERE (
                        `descripcion` LIKE \'%'.pSQL($query).'%\'                        
                    )';
        $obj = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        
        return $obj;
    }

    public function getTarjetasActivo($order_by, $order_way){
        $sql = 'SELECT t.codigotarjeta,t.descripcion,count(pt.idPlanestarjetas) AS planes,t.activo,t.date_add FROM `'._DB_PREFIX_.'tarjetas` t  
                INNER JOIN `'._DB_PREFIX_.'planes_tarjetas` pt ON(t.codigotarjeta = pt.codigotarjeta)
                WHERE t.activo = 1 AND cast("'.date('Y-m-d').'" as date) BETWEEN pt.fechahoravigenciadesde AND pt.fechahoravigenciahasta
                GROUP BY t.codigotarjeta
                ORDER BY '.$order_by.' '.$order_way;
        $obj = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
       
        return $obj;
    }

    public function getCountTarjetas(){
        $sql = 'SELECT count(codigotarjeta) as TotalTarjetas FROM `'._DB_PREFIX_.'tarjetas` 
                ORDER BY codigotarjeta ASC';
        $obj = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        
        return $obj;
    }

    public function getNombreTarjeta($codigotarjeta){
        $sql = 'SELECT descripcion FROM `'._DB_PREFIX_.'tarjetas` WHERE codigotarjeta='.$codigotarjeta;
        $obj = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        
        return $obj;
    }

    public function deletPlanes($codigotarjeta){
        $sql = 'DELETE `'._DB_PREFIX_.'planes_tarjetas` WHERE codigotarjeta='.$codigotarjeta;
        $obj = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        
        return $obj;
    }

}
?>
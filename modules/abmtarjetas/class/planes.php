<?php
Class planestarjetasCore extends ObjectModel
{
    /** @var integer ID Planes tarjeta */
    public $idPlanestarjetas;

    /** @var integer  codigo tarjeta */
    public $codigotarjeta;

    /** @var integer nombre de la tarjeta */
    public $tarjeta;

    /** @var integer plan de cada tarjeta */
    public $planestarjeta;

    /** @var integer cuotas */
    public $cantidadcuotas;

    /** @var float cuotas */
    public $coeficiente;

    /** @var float cuotas */
    public $coeficienteespecial;

    /** @var boolean Status for display */
    public $activo = 1;

    /** @var string Object creation date */
    public $fechahoravigenciadesde;

    /** @var string Object last modification date */
    public $fechahoravigenciahasta;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'planes_tarjetas',
        'primary' => 'idPlanestarjetas',
        'multilang' => false,
        'multilang_shop' => false,
        'fields' => array(
            'idPlanestarjetas' =>     array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'codigotarjeta' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'tarjeta' =>              array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'planestarjeta' =>        array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName'),
            'cantidadcuotas' =>       array('type' => self::TYPE_STRING, 'validate' => 'isUnsignedInt'),
            'coeficiente' =>          array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'coeficienteespecial' =>  array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'coeficientecuota' =>     array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),


            'activo' =>                     array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'fechahoravigenciadesde' =>     array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'fechahoravigenciahasta' =>     array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),

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

    public function getPlanes($codigotarjeta,$order_by, $order_way){
        $sql = 'SELECT idPlanestarjetas,planestarjeta,cantidadcuotas,CONCAT(coeficiente,"%") as coeficiente,activo FROM `'._DB_PREFIX_.'planes_tarjetas` 
                WHERE codigotarjeta = '.$codigotarjeta;
        $obj = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        return $obj;
    }

    public function getCountPlanes($codigotarjeta){
        $sql = 'SELECT count(idPlanestarjetas) as TotalPlanes FROM `'._DB_PREFIX_.'planes_tarjetas`
                WHERE codigotarjeta = '.$codigotarjeta.' ORDER BY idPlanestarjetas ASC';
        $obj = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

        return $obj;
    }

    public function getPlanesTarjetas($codigotarjeta){
        $sql = 'SELECT idPlanestarjetas,planestarjeta,cantidadcuotas,coeficiente,activo FROM `'._DB_PREFIX_.'planes_tarjetas`
                WHERE activo = 1 and cast("'.date('Y-m-d').'" as date) BETWEEN fechahoravigenciadesde AND fechahoravigenciahasta and codigotarjeta = '.$codigotarjeta.'
                ORDER BY cantidadcuotas ASC';
        $obj = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        return $obj;
    }

}
?>

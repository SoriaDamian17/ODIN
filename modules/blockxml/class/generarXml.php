<?php
Class generarXml extends ObjectModel
{    
    private $fxml = '</data>'; 
    private $url_xml = '';

    public function sanear_string($string,$esTag = 0)
    {
        $string = trim($string);
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );
        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );
        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );
        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );
        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );
        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );
        //Esta parte se encarga de eliminar cualquier caracter extraño
        if($esTag == 1) 
            $reemplazo = '-';
        else
            $reemplazo = ' ';
            
        $string = str_replace(
            array("\\", "¨", "º", "-", "~",
                 "#", "@", "|", "!", "\"",
                 "·", "$", "%", "&", "/",
                 "(", ")", "?", "'", "¡",
                 "¿", "[", "^", "`", "]",
                 "+", "}", "{", "¨", "´",
                 ">", "< ", ";", ",", ":",
                 ".", " "),
            $reemplazo,
            $string
        );
        return $string;
    }

    public function getAdsType($type = false)
    {
        $adsType = array(
                '0' => 'Seleccione el tipo de aviso',
                '1' => 'Gratuito',
                '2' => 'Básico',
                '3' => 'Destacado',
                '4' => 'Premium',
             );   

        if($type){
            foreach ($adsType as $key => $value) 
            {
                if(Configuration::get('ads_type') == $key)
                return $value;
            }            
        }else
            return $adsType;    
    }

    public function getOperations($type = false)
    {
        $operacion = array(
                '0' => 'Seleccione el tipo de operacion',
                '1' => 'Compra',
                '2' => 'Venta',
                '3' => 'Alquileres',
                '4' => 'Ofrecidos',
             );   

        if($type){
            foreach ($operacion as $key => $value) 
            {
                if(Configuration::get('operation') == $key)
                return $value;
            }            
        }else
            return $operacion;  
    }

    public function getPayments($type = false)
    {
        $payment = array(
                '0' => 'Seleccione la Forma de pago',
                '1' => 'Contado',
                '2' => 'Facilidades',
                '3' => 'Plan',
             );   

        if($type){
            foreach ($payment as $key => $value) 
            {
                if(Configuration::get('payment') == $key)
                return $value;
            }            
        }else
            return $payment;   
    }

    public function getDistrict($type = false)
    {
        $zona = array(
                '0' => 'Seleccione la zona',
                '1' => 'Norte',
                '2' => 'Sur',
                '3' => 'Este',
                '4' => 'Oeste',
                '5' => 'Centro',
             );   

        if($type){
            foreach ($zona as $key => $value) 
            {
                if(Configuration::get('district') == $key)
                return $value;
            }            
        }else
            return $zona;
    }

    public function getIdCountryByName($country)
    {
        $id_country=(int)Db::getInstance()->getValue('
                        SELECT c.`id_country`
                        FROM `'._DB_PREFIX_.'country` c
                        LEFT JOIN `'._DB_PREFIX_.'country_lang` cl ON (c.`id_country` = cl.`id_country`)
                        WHERE cl.`name` LIKE \''.pSQL($country).'\'
                    ');
       return $id_country;
    }

    /* Obtienes estados */
    public function getStates($id_lang = false, $active = false, $type = false)
    {
        $pais = self::getIdCountryByName('Argentina');
        $provincias = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
                        SELECT `id_state`, `name`
                        FROM `'._DB_PREFIX_.'state` WHERE 
                        '.($active ? 'active = 1' : '').' AND id_country = '.$pais.'
                        ORDER BY `name` ASC');
        $options = array();
        foreach($provincias as $prov => $key){
            $options[] = array('value' => $key['id_state'], 'name' => $key['name']); 
        }

        if($type){
            foreach ($provincias as $key => $value) 
            {
                if(Configuration::get('state') == $value['id_state'])
                return $value['name'];
            }            
        }else
            return $options;        
    }

    /* Genera combos del formulario */
    public function generarOptions($type)
    {

        $options = array();
        switch($type){
            case 'ads_type':
                $option = self::getAdsType();
                foreach ($option as $value => $name)
                    $options[] = array('value' => $value, 'name' => $name);        
                return $options;
            break;
            case 'operation':
                $option = self::getOperations();
                foreach ($option as $value => $name)
                    $options[] = array('value' => $value, 'name' => $name);        
                return $options;
            break;
            case 'payment':
                $option = self::getPayments();
                foreach ($option as $value => $name)
                    $options[] = array('value' => $value, 'name' => $name);        
                return $options;
            break;
            case 'zona':
                $option = self::getDistrict();
                foreach ($option as $value => $name)
                    $options[] = array('value' => $value, 'name' => $name);        
                return $options;
            break;
            case 'state':
                return self::getStates(1,1);
            break;
        }
    }

    private function hxml($chu)
    {
        if (empty($chu)){ $chu = "UTF-8";}
        (Configuration::get('EXPRODUCT_NVN_JSON')) ? $json="ON" : $json="OFF";
        (Configuration::get('EXPRODUCT_NVN_JSETG')) ? $selcat = "ON" : $selcat = "OFF";
        return '<?xml version="1.0" encoding="'.$chu.'"?>'."\r\n".'<data>'."\r\n";
    }   

    /* Exporta Categorias Xml */
    public function renderExportFormCat()
    {
        $fname = "categoria_".Tools::getAdminTokenLite('AdminModules').".xml";     
        $xml_path = dirname(__FILE__)."/xml/".$fname;
        $dom = new DOMDocument("1.0",'UTF-8');
        $dom->formatOutput = true;
        if(file_exists($xml_path))
        $dom->load($xml_path,LIBXML_DTDLOAD|LIBXML_DTDATTR);        
        $node = $dom->createElement("RubrosClasificadosLaVoz");
        $parnode = $dom->appendChild($node); 
        $categorias = new Category(2);            
        foreach ($categorias->getSubCategories(1) as $key => $value) 
        {
          //No Imprimimos GSR
          $SR = new Category($value['id_category']);
          foreach($SR->getSubCategories(1) as $k => $v)
          {
              // ADD TO XML DOCUMENT NODE  
              $string=self::sanear_string($v['name'],1);
              $node = $dom->createElement(strtolower($string));  
              $newnode = $parnode->appendChild($node); 
              $R = new Category($v['id_category']);
              foreach ($R->getSubCategories(1) as $key => $value) 
              {      
                  $node = $dom->createElement('rubro'); 
                  $newnodeRubro = $newnode->appendChild($node);  
                  $id = $dom->createElement("id",$value['id_category']);
                  $newId = $newnodeRubro->appendChild($id);
                  $name = $dom->createElement("name", $value['name']); 
                  $newRubro = $newnodeRubro->appendChild($name);
                  $branch = $dom->createElement("branch",$value['name']);
                  $newBranch = $newnodeRubro->appendChild($branch);
              }//END rubro          
          }//END SUPERRUBRO
        }//END GRUPOSUPERRUBRO        
        $dom->save($xml_path);
        $url_xml = $_SERVER['SERVER_NAME']."/class/xml/".$fname;
        $out = '<span>'.$url_xml.'</span></br>';
        return $out;
    }

    /* Exporta Productos Xml */
    public function renderExportFormPrd()
    {
        $dom = new DOMDocument("1.0",'UTF-8');
        $dom->formatOutput = true;
        if(file_exists($xml_path))
        $dom->load($xml_path,LIBXML_DTDLOAD|LIBXML_DTDATTR);
        $node = $dom->createElement("data");
        $data = $dom->appendChild($node); 
        
        $producto = self::getProducts();
        $campos = self::xmlfields();
        
        foreach($producto as $prod => $p)
        {
            $node = $dom->createElement("ad");  
            $ad = $data->appendChild($node);           
            foreach($campos as $k => $v)
            {
                if($v == 'pictures')
                {
                    $node = $dom->createElement($v,$p[$v]); 
                    $pictures = $ad->appendChild($node); 
                    $obj = self::getImages($p['id_product']);
                    foreach($obj as $img => $v)
                    {
                        $node = $dom->createElement('picture','<![CDATA['.$v['id_image'].']]'); 
                        $picture = $pictures->appendChild($node); 
                    }
                }else{
                    $node = $dom->createElement($v,'<![CDATA['.$p[$v].']]'); 
                    $rubro = $ad->appendChild($node);   
                }            
            }
        }   

        $fname = "product_".Tools::getAdminTokenLite('AdminModules').".xml";     
        $xml_path = dirname(__FILE__)."/xml/".$fname;  
        $dom->save($xml_path); 
        $url_xml = $_SERVER['SERVER_NAME']."/class/xml/".$fname;
        $out = '<span>'.$url_xml.'</span></br>';
        return $out;        
    }

    public function getProducts($id_lang = 1, $start = 0, $limit = 0, $order_by = 'id_product', $order_way = 'ASC', $id_category = false,
        $only_active = true, Context $context = null)
    {
        
        $sql = 'SELECT "'.self::getAdsType(true).'" as ads_type,p.`id_product`, p.`id_category_default`, pl.`name`, pl.`description` , "'.self::getStates(1,1,true).'" as region,"'.Configuration::get('city').'" as city,"'.Configuration::get('phone').'" as phone, "'.Configuration::get('email').'" as email,
                       "'.self::getOperations(true).'" as operacion, p.`condition`, p.`price`, "'.self::getPayments(true).'" as payment,"Norte" as district_zone, "'.Configuration::get('latitude').'" as latitud, "'.Configuration::get('longitude').'" as longitude,"" as pictures,"" as store,
                        m.`name` AS marca,p.`date_upd`
                FROM `'._DB_PREFIX_.'product` p
                '.Shop::addSqlAssociation('product', 'p').'
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')
                LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
                LEFT JOIN `'._DB_PREFIX_.'supplier` s ON (s.`id_supplier` = p.`id_supplier`)'.
                ($id_category ? 'LEFT JOIN `'._DB_PREFIX_.'category_product` c ON (c.`id_product` = p.`id_product`)' : '').'
                WHERE pl.`id_lang` = '.(int)$id_lang.
                    ($id_category ? ' AND c.`id_category` = '.(int)$id_category : '').
                    ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').
                    ($only_active ? ' AND product_shop.`active` = 1' : '').'
                ORDER BY '.(isset($order_by_prefix) ? pSQL($order_by_prefix).'.' : '').'`'.pSQL($order_by).'` '.pSQL($order_way).
                ($limit > 0 ? ' LIMIT '.(int)$start.','.(int)$limit : '');
        $productos = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        $campos[] = self::xmlfields();
        
            foreach($productos as $pr => $key){
                $prod[] = array_combine($campos[0],$productos[$pr]);
            }
          
        return $prod;
    }

    /**
    * Get product images and legends
    *
    * @param integer $id_lang Language id for multilingual legends
    * @return array Product images and legends
    */
    public function getImages($id_product,$id_lang, Context $context = null)
    {
        $obj = Db::getInstance()->executeS('
            SELECT image_shop.`cover`, i.`id_image`, il.`legend`, i.`position`
            FROM `'._DB_PREFIX_.'image` i
            '.Shop::addSqlAssociation('image', 'i').'
            LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
            WHERE i.`id_product` = '.(int)$id_product.'
            ORDER BY `position`'
        );

       /*$pictures = '<pictures>';
            foreach($obj as $img => $v){
                $pictures .= '<picture><![CDATA['.self::jsonEOn($v['id_image']).']]></picture>'.'\r\n';
            }
        $pictures = $pictures.'</pictures>';*/

        return $obj;
    }

    public function jsonEOn($jsn)
    {
      return json_encode($jsn);         
    }

    public function xmlcafields()
    { 
        return array(
                'xml-rubro'=>'rubro',
                'xml-id'=>'id',
                'xml-name'=>'name',
                'xml-branch'=>'branch',
            );
    }    
    
    public function xmlfields()
    { 
        return array(                
                'xml-ads_type' => 'ads_type',
                'xml-id'=>'id',
                'xml-type'=>'type',
                'xml-title'=>'title',
                'xml-content'=>'content',
                'xml-region'=>'region',
                'xml-city'=>'city',
                'xml-phone'=>'phone',
                'xml-email'=>'email',
                'xml-operation'=>'operation',
                'xml-status'=>'status',
                'xml-price'=>'price',
                'xml-payment'=>'payment',
                'xml-district'=>'district_zone',
                'xml_latitude'=>'latitude',
                'xml_longitude'=>'longitude',
                'xml-pictures'=>'pictures',
                'xml-store'=>'store',
                'xml-marca'=>'marca',
                'xml-modify'=>'modify',
            );
    } 

}
?>
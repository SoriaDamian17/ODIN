<?php
Class apilvz extends ObjectModel
{    
    private $url_xml = '';

    public function addonsRequest($request){

        $protocol = 'http';
        $end_point = 'www.clasificadoslavoz.com.ar/webservice/clasificadoslavoz-rubros';

        if($content = Tools::file_get_contents($protocol.'://'.$end_point, false))
            return $content;

        return false;
    }

    public function getXML(){
        $content = self::addonsRequest('modules');
        $xml = simplexml_load_string($content, null, LIBXML_NOCDATA);
        return $xml;
    }

    public function getRubros(){
        $rubros = self::getXML();
        
        $rubrosLvz = array();
        foreach ($rubros as $rubro => $rb)
           $rubrosLvz[] = array('value' => $rb->rubro->id, 'name' => $rb->rubro->name);

        
        return $rubros;
    }

}
?>
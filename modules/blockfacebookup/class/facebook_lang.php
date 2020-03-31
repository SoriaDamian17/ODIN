<?php
Class fblang extends ObjectModel
{    
    private $url_xml = '';

    public function addonsRequest($request){

        $protocol = 'https';
        $end_point = 'www.facebook.com/translations/FacebookLocales.xml';

        if($content = Tools::file_get_contents($protocol.'://'.$end_point, false))
            return $content;

        return false;
    }

    public function getXML(){
        $content = self::addonsRequest('modules');
        $xml = simplexml_load_string($content, null, LIBXML_NOCDATA);
        return $xml;
    }

    public function getLang(){
        $langs = self::getXML();
        
        $lang = array();
        foreach ($langs as $lag => $idioma)
           $lang[] = array('value' => $idioma->codes->code->standard->representation, 'name' => $idioma->englishName);

        
        return $lang;
    }

}
?>
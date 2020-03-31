<?php
Class xmlfb extends ObjectModel
{    
    private $url_xml = '';

    public function addonsRequest($request){

        $protocol = 'http';
        $end_point = 'api.modulosprestashop.com.ar/modules.xml';

        if($content = Tools::file_get_contents($protocol.'://'.$end_point, false))
            return $content;

        return false;
    }

    public function getXML(){
        $content = self::addonsRequest('modules');
        $xml = simplexml_load_string($content, null, LIBXML_NOCDATA);
        return $xml;
    }

    public function getModules(){
        $modules = self::getXML();
        $this->html = '<div id="owl-demo" class="owl-carousel owl-theme">';
        foreach($modules as $module => $key){
            $this->html .= '<div class="item">
                                <small>'.$key->categoryName.'</small>
                                <h4>'.$key->displayName.'</h4>
                                <img src="'.$key->img.'" alt="'.$key->name.'"/>
                                <p>'.substr($key->description, 0,50).'</p>
                                <a href="'.$key->url.'" class="btn btn-primary" target="_blank"><i class="icon icon-shopping-cart"></i></a>
                            </div>';
        }
        $this->html.='</div>';
        /*$this->html.='<div class="customNavigation">
                      <a class="btn prev">Previous</a>
                      <a class="btn next">Next</a>
                      <a class="btn play">Autoplay</a>
                      <a class="btn stop">Stop</a>
                    </div>';*/
        return $this->html;
    }

}
?>
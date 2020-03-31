<?php
Class installpm{
    
    public function __construct(){

    }

    public function installTablas(){        
        $sql = explode(";",file_get_contents(dirname(__FILE__) . '/sql/install.sql'));
        foreach($sql as $query)
        Db::getInstance()->execute(preg_replace('\'._DB_PREFIX_.\'',_DB_PREFIX_,$query));

        return true; 
    }

    public function uninstallTablas(){
        $sql = explode(";",file_get_contents(dirname(__FILE__) . '/sql/unistall.sql'));
        foreach($sql as $query)
        Db::getInstance()->execute(preg_replace('\'._DB_PREFIX_.\'',_DB_PREFIX_,$query));

        return true; 
    }

    public function limpiarTablas(){
        
        Db::getInstance()->execute("TRUNCATE "._DB_PREFIX_."promocion");
        Db::getInstance()->execute("TRUNCATE "._DB_PREFIX_."promocion_lang");

        return true; 
    }

}
?>
<?php
class LAIKA_Event extends LAIKA_Singleton{

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------

    protected static $instance;

//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------

    public static function dispatch($event,$param){
        FirePHP::getInstance(true)->log($event, 'Trace');
        //FirePHP::getInstance(true)->log($param, 'Trace');
        LAIKA_Event_Listener::update();    
    }
}
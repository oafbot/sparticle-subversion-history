<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Event_Listener.php
 *
 *	@version        0.1.0b
 *	@package        laika
 *	@subpackage     core
 *	@category       
 *	@date           2011-05-21 03:15:10 -0400 (Sat, 21 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 */
/**
 * LAIKA_Event_Listener class.
 */
class LAIKA_Event_Listener extends LAIKA_Singleton implements SPLObserver{
    
    protected static $instance;
    protected        $registry = array();
    
    public static function init($event,$class,$method){
        if( empty(self::$instance) )
            if( LAIKA_Registry::peek(__CLASS__) )
                self::$instance = LAIKA_Registry::get_record(__CLASS__);
            else
                parent::init();
        self::$instance->registry[$event] = array("CLASS"=>$class,"METHOD"=>$method);
        
        LAIKA_Registry::register(__CLASS__,self::$instance); 
        
        return self::$instance; 
    }
    
    public function update(SplSubject $subject){
        //var_dump($subject);
     
        $handler = $this->registry[$subject->event];
        $method  = $handler['METHOD'];
        
        call_user_func(array($handler['CLASS'], $method), $subject->event, $subject->param);  
     
    }

}
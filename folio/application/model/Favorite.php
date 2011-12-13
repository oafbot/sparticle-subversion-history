<?php
class FOLIO_Favorite extends LAIKA_Abstract_Singleton_Model{

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------

    protected static $instance;
    protected        $model;
    protected        $table;
	
	protected		 $id;
    protected        $item;
    protected        $user;
    protected        $type;

//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------

    public static function mark($item,$type="media"){
        $favorite = self::init();
        $favorite->user = LAIKA_User::active()->id;
        $favorite->item = $item;
        $favorite->type = $type;
        LAIKA_Database::add($favorite);          
    }
    
    public static function undo($object){
        parent::delete($object);
    }
    
    public function is_favorite($user,$item){
        $result = LAIKA_Database::query("SELECT item FROM favorites WHERE user = $user AND item = $item",'SINGLE');
        if(!$result || empty($result))
            return false;
        return true;
    }
}
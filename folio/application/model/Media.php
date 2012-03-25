<?php
class FOLIO_Media extends LAIKA_Abstract_Model{

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------

    protected        $model;
    protected        $table;
	
	protected		 $id;
	protected        $user;
	protected        $name;
	protected        $path;
	protected        $type;
	protected        $privacy;
	protected        $access_group;
    protected        $description;
 
    protected        $created;
    protected        $updated; 
    
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------


    public function get_filename(){
        $path = $this->path;
        return array_pop(explode("/",$path));
    }
    
}
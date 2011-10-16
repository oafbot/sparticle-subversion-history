<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Mysql.php
 *
 *	@version        0.1.0b
 *	@package        laika
 *	@subpackage     util
 *	@category       database
 *	@date           2011-05-21 03:53:51 -0400 (Sat, 21 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 */
/**
 * LAIKA_Mysql class.
 *
 * Database wrapper object using mysqli
 *
 * Unimplemented.
 */
class LAIKA_Mysql_Driver extends LAIKA_Singleton implements LAIKA_Interface_DB_Driver{

    protected static $instance;
    private   static $connection;

    public static function connect(){
        $mysql = self::init();
        $mysql::$connection = new mysqli($host=DB_HOST, $user=DB_USER, $pass=DB_PASS, $db=DB_NAME, $port=DB_PORT);
        return $mysql::$connection;
    }
    public static function disconnect(){}
    
    public function select_by(){}
    public function select_all($table){}
    
    public function update(){}
    public function insert(){}
    public function create(){}
    public function add(){}
    public function delete(){}
    
    //public function get_num_rows(){}
    //public function get_error(){}
   // public function free_result(){}
}
<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Pdo_Driver.php
 *
 *	@version        0.1.0b
 *	@package        laika
 *	@subpackage     util
 *	@category       database
 *	@date           2011-06-08 00:17:06 -0400 (Wed, 8 Jun 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 */
/**
 * LAIKA_Pdo_Driver class.
 *
 * Wrapping PDO in another layer of abstraction may seem silly,
 * but this allows for a failsafe if PDO may be misconfigured on the Server
 * as is the case with standard MySQL + php install on OSX.
 * 
 * @extends LAIKA_Singleton
 * @implements LAIKA_Interface_DB_Driver
 */
class LAIKA_Pdo_Driver extends LAIKA_Singleton implements LAIKA_Interface_DB_Driver{

    protected static $instance;
    private          $connection = NULL;

    /**
     * connect function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function connect(){
        $pdo = self::init();
        $driver = DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME.';port='.DB_PORT;
        $pdo->connection = new PDO($driver, $user=DB_USER, $password=DB_PASS, array(PDO::ATTR_EMULATE_PREPARES => true));
        return $pdo;
    }

    /**
     * disconnect function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function disconnect(){        
        unset( self::init()->connection );
        return NULL;
    }
    
    /**
     * select function.
     * 
     * @access public
     * @param mixed $subject
     * @param mixed $table
     * @return void
     */
    public function select($subject,$table,$condition){
        $query = "SELECT $subject FROM $table $condition;";
        $result = self::init()->query($query, 'ALL');
        return $result;         
    }

    /**
     * select_by function.
     * 
     * @access public
     * @param mixed $id
     * @return void
     */
    public function select_by($id,$table){
        $query = "SELECT * FROM $table WHERE id = $id;";
        $result = self::init()->query($query, 'SINGLE');
        return $result;     
    }    

    /**
     * select_all function.
     * 
     * @access public
     * @param mixed $table
     * @return void
     */
    public function select_all($table){
        $query = "SELECT * FROM $table;";
        $result = self::init()->query($query, 'ALL');
        return $result;     
    }

    /**
     * select function.
     * 
     * @access public
     * @static
     * @param mixed $column
     * @param mixed $table
     * @param mixed $condition
     * @return void
     */
    public function select_all_where($table, $condition){
        $query = "SELECT * FROM $table WHERE $condition;";
        $result = self::init()->query($query, 'ALL');
        return $result; 
    }
    
    /**
     * select function.
     * 
     * @access public
     * @static
     * @param mixed $column
     * @param mixed $table
     * @param mixed $condition
     * @return void
     */
    public function select_where($subject, $table, $condition){
        $query = "SELECT $subject FROM $table WHERE $condition;";
        $result = self::init()->query($query, 'SINGLE');
        return $result; 
    }

    /**
     * query function.
     * 
     * @access public
     * @param mixed $statement
     * @return void
     */
    public function query($statement,$return){
        $pdo = self::init()->connection;
        $command = $pdo->prepare($statement);
        $command->execute();
        // PDO_FETCH_BOTH, PDO_FETCH_NUM, PDO_FETCH_ASSOC, PDO_FETCH_OBJ, PDO_FETCH_LAZY, PDO_FETCH_BOUND
        if($return == 'ALL')
            $row = $command->fetchall(PDO::FETCH_ASSOC);
        else if($return == 'SINGLE')                   
            $row = $command->fetch(PDO::FETCH_ASSOC);
        else
            $row = NULL;
        $command = NULL;
        return $row;                
    } 

    /**
     * insert function.
     * 
     * @access public
     * @param mixed $statement
     * @return void
     */
    public function insert($table,$cols,$vals){
        $columns = impolde(', ',$cols);
        $values = implode(', ',$vals);
        $statement = "INSERT INTO $table ($columns) VALUES ('$values')";
        self::init()->query($statement, 'INSERT');
    }

    /**
     * update function.
     * 
     * @access public
     * @param mixed $table
     * @param mixed $record
     * @param mixed $data
     * @param mixed $condition
     * @return void
     */
    public function update($table, $record, $data, $condition){
        $statement = "UPDATE $table SET $record='$data' WHERE $condition";
        return self::init()->query($statement, 'UPDATE');    
    }

    /**
     * add function.
     * 
     * @access public
     * @param mixed $object
     * @return void
     */
    public function add($object){
        $map = $object::get_map();
        //$columns = $object::map_to_string(true);   
        foreach($map as $key => $name){
            $v = $object->$name;
            if(isset($v)):
                $val[] = $v;
                $col[] = $name;
            endif;
        }
        $columns = implode(', ',$col);            
        $values = implode("', '",$val);        
        $statement = "INSERT INTO {$object->table} ($columns) VALUES ('$values')";
        self::init()->query($statement, 'INSERT');
    }
    
    /**
     * delete function.
     * 
     * @access public
     * @param mixed $table
     * @param mixed $id
     * @return void
     */
    public function delete($table,$id){
        self::init()->reset_auto_increment($table,$id);
    }
    
    /**
     * show function.
     * 
     * @access public
     * @param mixed $table
     * @return void
     */
    public function show($table){
        $statement = "DESCRIBE $table"; 
        return self::init()->query($statement,'ALL');       
    }
    
    /**
     * reset_auto_increment function.
     * 
     * @access public
     * @param mixed $table
     * @param mixed $id
     * @return void
     */
    public function reset_auto_increment($table,$id){
        //$last = PDO::lastInsertId([string name]);
        $inc = "AUTO_INCREMENT = $id";
        return self::init()->alter($table,$inc);
    }
    
    /**
     * alter function.
     * 
     * @access public
     * @param mixed $table
     * @param mixed $condition
     * @return void
     */
    public function alter($table,$condition){        
        $statement = "ALTER TABLE $table $condition";
        return self::init()->query($statement,'ALTER');
    }
    
    /**
     * last function.
     * 
     * @access public
     * @return void
     */
    public function last($table,$limit){
        $statement = "SELECT FROM $table ORDER BY id DESC LIMIT $limit";
        if( $limit > 1)            
            return self::init()->query($statement,'ALL');
        else
            return self::init()->query($statement,'SINGLE');
    }
    
    /**
     * first function.
     * 
     * @access public
     * @return void
     */
    public function first($table,$limit){
        $statement = "SELECT FROM $table ORDER BY id ASC LIMIT $limit";
        if( $limit > 1)            
            return self::init()->query($statement,'ALL');
        else
            return self::init()->query($statement,'SINGLE');
    }

    /**
     * count function.
     * 
     * @access public
     * @param mixed $table
     * @return void
     */
    public function count($table){
        $statement = "SELECT COUNT(*) FROM $table";
        return self::init()->query($statement,'ALL');    
    }

    /**
     * offset function.
     * 
     * @access public
     * @param mixed $table
     * @param mixed $column
     * @param mixed $limit
     * @param mixed $offset
     * @return void
     */
    public function offset($table,$column,$limit,$offset){
            $statement = "SELECT $column FROM $table LIMIT $limit OFFSET $offset";
        return self::init()->query($statement,'ALL');    
    }
        
    public function create(){}
    public function drop(){}    
}
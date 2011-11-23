<?php

interface LAIKA_Interface_DB_Driver{


    public static function connect();
    public static function disconnect();
    
    public function select_by($id,$table);
    public function select_all($table);
    public function select_where($subject,$table,$condition);
    public function query($statement,$return);
        
    public function update($table, $record, $data, $condition);
    public function insert($table,$columns,$values);
    public function create($table,$params);
    public function add($object);
    public function show($table);
    public function delete($table,$id);
    //public function drop($table);
    //public function get_num_rows();
    //public function get_error();
    //public function free_result();
}
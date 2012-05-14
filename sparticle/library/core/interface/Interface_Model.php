<?php
/**
 * LAIKA_Interface_Model interface.
 *
 * @interface
 */
interface LAIKA_Interface_Model{

    public function dset($property,$value);
    public function dget($property);
    
    public static function load($id);
    public static function find($param,$value);
    
    public static function map_to_string($ignore_id);
    public static function get_map();
    
    public static function add();
    public static function delete($object);
    
    public static function count();
    public static function first();
    public static function last();
    
    public static function offset();
    public static function find_with_offset($params,$offset,$limit);
    public static function paginate();
    
    public static function collection($array);
    public static function accessible();

}
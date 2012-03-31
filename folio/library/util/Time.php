<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Time.php
 *
 *	@version        0.1.0b
 *	@package        laika
 *	@subpackage     util     
 *	@category       utility
 *	@date           2011-05-21 03:51:46 -0400 (Sat, 21 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 */
/**
 * LAIKA_Time class.
 */
class LAIKA_Time extends Laika{

//now(){}
//database_datetime(){}
//database_timestamp(){}
//database_time(){}
//database_year(){}
//unix(){}

/**
 * time_since function.
 * 
 * @access public
 * @static
 * @param mixed $then
 * @param mixed $now (default: NULL)
 * @return void
 */
public static function time_since($then,$now=NULL){
    if(!$now) $now = time();
    return $now - strtotime($then);    
}


public static function database_to_datetime($timestamp){
    // October 5, 2008 9:34 pm
    return date("F j, Y - g:i a", strtotime($timestamp));
}
public static function database_to_date($timestamp){
    // October 5, 2008 9:34 pm
    return date("F j, Y", strtotime($timestamp));
}
public static function database_to_shortdate($timestamp){
    // 10/05/2008
    return date("m/d/Y", strtotime($timestamp));
}

public static function database_to_time($timestamp){
    // 10/05/2008
    return date("g:i a", strtotime($timestamp));
}
// It is the 5th day.                           
//echo date('\i\t \i\s \t\h\e jS \d\a\y.', strtotime($row["date"]));
// Sun Oct 5 21:34:02 PST 2008   
//echo date("D M j G:i:s T Y", strtotime($row["date"]));               



}
<?php
/**
 * FOLIO_Home_Page class.
 */
class FOLIO_Home_Page extends LAIKA_Abstract_Page{

	protected static $instance;

    public function content(){
        if(LAIKA_Access::is_logged_in())
            self::render('home_hidden');
    }

}
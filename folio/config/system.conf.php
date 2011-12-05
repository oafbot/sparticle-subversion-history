<?php
/**
 *
 *	LAIKA FRAMEWORK -- Main Configuration File
 *
 *	Framework   Version 0.1.0 Development
 *	Application Version 0.3.0 Development
 *
 *
 *	@filesource 	conf.php
 *	@version    	0.1.0b
 *	@package    	laika
 *	@subpackage     kernel
 *	@category       config file
 *	@date       	010-01-18 01:59:19 -0500 (Mon, 18 Jan 2010)
 *	@author 	    Leonard M. Witzel <leonard_witzel@harvard.edu>
 *
 *	Copyright (c) 2010 Harvard University <http://lab.dce.harvard.edu>
 *
 */

//-------------------------------------------------------------------
//	HOST & APPLICATION URI
//-------------------------------------------------------------------

( FORCE_SSL || !empty($_SERVER['HTTPS']) ) ? 
    define( 'PROTOCOL', 'https://' ) : define( 'PROTOCOL', 'http://' );
    
( $_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") ? 
    define( 'HOST_NAME', $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"] ) : 
    define( 'HOST_NAME', $_SERVER["SERVER_NAME"] );
    
    define( 'BASE_DIRECTORY', dirname(dirname($_SERVER['PHP_SELF'])) );
    define( 'HTTP_ROOT', rtrim(PROTOCOL.HOST_NAME.BASE_DIRECTORY, '/') );
    define( 'SSL_ON', 'https://'.HOST_NAME.BASE_DIRECTORY );
    define( 'SSL_OFF', 'http://'.HOST_NAME.BASE_DIRECTORY );

//-------------------------------------------------------------------
//	FILE PATHS
//-------------------------------------------------------------------

    define( 'CONFIG_DIRECTORY', dirname(__FILE__) ) ;
    define( 'LAIKA_ROOT',       dirname(CONFIG_DIRECTORY) );
    define( 'APPLICATION_ROOT', LAIKA_ROOT.'/application' );
    define( 'LOG_DIRECTORY',    LAIKA_ROOT.'/tmp/logs'    );
    define( 'IMG_DIRECTORY',    HTTP_ROOT.'/images'       );
    define( 'PUBLIC_DIRECTORY', LAIKA_ROOT.'/public'      );
    define( 'MEDIA_DIRECTORY',  LAIKA_ROOT.'/public/media');
/*     define( 'UPLOAD_PATH',     LAIKA_ROOT.'/tmp/uploads'  ); */
/*     define( 'SESSION_PATH',     LAIKA_ROOT.'/tmp/sessions/session.data'); */
    //define( 'PUBLIC_DIRECTORY', LAIKA_ROOT.'/public' );
    //define( 'MODULE_FOLDER',         APPLICATION_FOLDER.'/module'         );
    
    define( 'LAIKA_NS', 'LAIKA_' );

 
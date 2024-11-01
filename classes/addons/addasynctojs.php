<?php
/*
 Addon Name: ASYNC Javascripts
 Description: Add ASYNC to Javascript URLs
 Author: Rahul Taiwala
 Author URI: http://www.rktaiwala.in
 Addon Id: 110
 Version: 1.0.1
 class: ASJS_addon
 */

class ASJS_addon
{
	/** @var string $version */
	static $version = '1.0.1';
	static $addonID= '110';
	static $addonName= 'ASJS_addon';

	/**
	 * Bootstraps the application by assigning the right functions to
	 * the right action hooks.
	 *
	 * @since 1.0.0
	 */
	static function bootStrap()
	{
        add_filter( 'tlo_settings_default_data', array(__CLASS__,'register_addon'),99,1);
		
	}
   
    static function on_active(){
        
        
        add_filter( 'clean_url', array(__CLASS__,'defer_parsing_of_js'), 11, 1 );
    }
    static function defer_parsing_of_js ( $url ) {
        if ( FALSE === strpos( $url, '.js' ) ) return $url;
        if ( strpos( $url, 'jquery.js' ) ) return $url;
        //return "$url.' async onload='myinit()";
        return $url."' async='true";
    }
    
    static function register_addon($data){

        return array_merge($data,array('addon_id_'.self::$addonID=>false));
    }
    
	
    
	
}

ASJS_addon::bootStrap();

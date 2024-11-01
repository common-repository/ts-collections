<?php
/*
 Addon Name: jQuery in Footer 
 Description: Enqueue Default WordPress jQuery in Footer
 Author: Rahul Taiwala
 Author URI: http://www.rktaiwala.in
 Addon Id: 108
 Version: 1.0.1
 class: JIF_addon
 */

class JIF_addon
{
	/** @var string $version */
	static $version = '1.0.1';
	static $addonID= '108';
	static $addonName= 'JIF_addon';

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
        
        add_action( 'wp_default_scripts', array(__CLASS__,'jquery_in_footer' ));
        
    }
    
    static function jquery_in_footer(&$scripts){
        if ( ! is_admin() ){
           $scripts->add_data( 'jquery-core', 'group', 1 );
           $scripts->add_data( 'jquery-migrate', 'group', 1 );
        }
        
        //print_r($scripts);
    }
    
    static function register_addon($data){

        return array_merge($data,array('addon_id_'.self::$addonID=>false));
    }
    
	
    
	
}

JIF_addon::bootStrap();

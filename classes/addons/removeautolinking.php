<?php
/*
 Addon Name: Remove Comment Auto Linking  
 Description: Remove Auto Linking of URLs in WordPress Comments
 Author: Rahul Taiwala
 Author URI: http://www.rktaiwala.in
 Addon Id: 104
 Version: 1.0.1
 class: RCAL_addon
 */

class RCAL_addon
{
	/** @var string $version */
	static $version = '1.0.1';
	static $addonID= '104';
	static $addonName= 'RCAL_addon';

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
        
        remove_filter('comment_text', 'make_clickable', 9);
        
    }
    
    static function register_addon($data){

        return array_merge($data,array('addon_id_'.self::$addonID=>false));
    }
    
	
    
	
}

RCAL_addon::bootStrap();

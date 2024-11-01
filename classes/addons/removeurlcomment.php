<?php
/*
 Addon Name: Remove Url From Comment Form  
 Description: Remove the URL Field from the WordPress Comment Form.
 Author: Rahul Taiwala
 Author URI: http://www.rktaiwala.in
 Addon Id: 103
 Version: 1.0.1
 class: RUFCF_addon
 */

class RUFCF_addon
{
	/** @var string $version */
	static $version = '1.0.1';
	static $addonID= '103';
	static $addonName= 'RUFCF_addon';

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
        
        add_filter('comment_form_default_fields',array(__CLASS__,'remove_comment_fields'));
        
    }
    
    static function remove_comment_fields($fields) {
        unset($fields['url']);
        return $fields;
    }
    
    static function register_addon($data){

        return array_merge($data,array('addon_id_'.self::$addonID=>false));
    }
    
	
    
	
}

RUFCF_addon::bootStrap();

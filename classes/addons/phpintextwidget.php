<?php
/*
 Addon Name: PHP in Text Widgets
 Description: Allow PHP in Default Text Widgets
 Author: Rahul Taiwala
 Author URI: http://www.rktaiwala.in
 Addon Id: 106
 Version: 1.0.1
 class: PTW_addon
 */

class PTW_addon
{
	/** @var string $version */
	static $version = '1.0.1';
	static $addonID= '106';
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
        
        add_filter('widget_text', array(__CLASS__,'php_in_widget'), 99);
        
    }
    
    static function php_in_widget($text){
        if (strpos($text, '<' . '?') !== false) {
            ob_start();
            eval('?' . '>' . $text);
            $text = ob_get_contents();
            ob_end_clean();
        }
        return $text;
    }
    
    static function register_addon($data){

        return array_merge($data,array('addon_id_'.self::$addonID=>false));
    }
    
	
    
	
}

PTW_addon::bootStrap();

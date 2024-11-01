<?php
/*
 Addon Name: Link Twitter Username  
 Description: Automatically link Twitter usernames in WordPress
 Author: Rahul Taiwala
 Author URI: http://www.rktaiwala.in
 Addon Id: 105
 Version: 1.0.1
 class: LTU_addon
 */

class LTU_addon
{
	/** @var string $version */
	static $version = '1.0.1';
	static $addonID= '105';
	static $addonName= 'LTU_addon';

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
        
        add_filter('the_content', array(__CLASS__,'link_twitter_username'));   
        add_filter('comment_text', array(__CLASS__,'link_twitter_username'));
        
    }
    
    static function link_twitter_username($content){
        $twtreplace = preg_replace('/([^a-zA-Z0-9-_&])@([0-9a-zA-Z_]+)/',"$1<a href=\"http://twitter.com/$2\" target=\"_blank\" rel=\"nofollow\">@$2</a>",$content);
        return $twtreplace;
    }
    
    static function register_addon($data){

        return array_merge($data,array('addon_id_'.self::$addonID=>false));
    }
    
	
    
	
}

LTU_addon::bootStrap();

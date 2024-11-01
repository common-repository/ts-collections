<?php
/*
 Addon Name: Content Clips
 Description: Content Clips helps insert content anywhere using the shortcodes.
 Author: rktaiwala
 Author URI: www.rktaiwala.in
 Version: 1.0.0
 License: GPLv2 or later
 class: contentClips
 Addon Id: 107
 */
define('CC_POSTTYPE',1);
define('CC_SHORTCODE',1);
define('CC_SETTINGS',0);
define('CC_BACKENDSCRIPTS',0);
class contentClips
{
	/** @var string $version */
	static $version = '1.0.0';
	static $addonID= '107';
	static $addonName= 'contentClips';

    static function bootStrap(){
    
        add_filter( 'tlo_settings_default_data', array(__CLASS__,'register_addon'),99,1);
    }
	/**
	 * Bootstraps the application by assigning the right functions to
	 * the right action hooks.
	 *
	 * @since 1.0.0
	 */
	static function on_active()
	{
		self::autoInclude();
        if(CC_POSTTYPE)
            contentClipsPostType::init();
        if(CC_SHORTCODE)
            contentClipsShortcode::init();
        if(CC_SETTINGS)
            contentClipsSettings::init();
        
        contentClipsEditorIcon::init();
        if(CC_BACKENDSCRIPTS)
            add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueueBackendScripts'));
        
	}
    
    
    static function register_addon($data){

        return array_merge($data,array('addon_id_'.self::$addonID=>false));
    }
    /**
	 * Includes backend script.
	 *
	 * Should always be called on the admin_enqueue_scrips hook.
	 *
	 * @since 1.0.0
	 */
	static function enqueueBackendScripts()
	{
		// Function get_current_screen() should be defined
		if (!function_exists('get_current_screen'))
		{
			return;
		}

		$currentScreen = get_current_screen();
        //YOUR CODE

	}
	
    
	/**
	 * Returns url to the base directory of this plugin.
	 *
	 * @since 1.0.0
	 * @return string pluginUrl
	 */
	static function getPluginUrl()
	{
		return plugins_url('', __FILE__);
	}

	/**
	 * Returns path to the base directory of this plugin
	 *
	 * @since 1.0.0
	 * @return string pluginPath
	 */
	static function getPluginPath()
	{
		return dirname(__FILE__);
	}

	/**
	 * This function will load classes automatically on-call.
	 *
	 * @since 1.0.0
	 */
	static function autoInclude()
	{
		if (!function_exists('spl_autoload_register'))
		{
			return;
		}

		function contentClipsAutoLoader($name)
		{
			$name = str_replace('\\', DIRECTORY_SEPARATOR, $name);
			$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $name . '.php';

			if (is_file($file))
			{
				require_once $file;
			}
		}

		spl_autoload_register('contentClipsAutoLoader');
	}
    
    
}

/**
 * Activate plugin
 */
contentClips::bootStrap();
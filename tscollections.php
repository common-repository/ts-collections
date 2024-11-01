<?php
/*
 Plugin Name: TS Collections
 Plugin URI: 
 Description: TS Collections provide some usefull Wordpress Customizations, filters, actions to make your wordpress experience more smoother and user friendly.
 Author: Rahul Taiwala
 Author URI: http://www.rktaiwala.in
 Version: 1.0.1
 License: GPLv2 or later
 */

class TheLastOne
{
	/** @var string $version */
	static $version = '1.0.1';
	

	/**
	 * Bootstraps the application by assigning the right functions to
	 * the right action hooks.
	 *
	 * @since 1.0.0
	 */
	static function bootStrap()
	{
		self::autoInclude();
		self::loadaddons();
        TheLastOneSettings::init();
        TheLastOneBase::init();
        //TsDimmerPostType::init();
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueueBackendScripts'));
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

		// Enqueue 3.5 uploader
		wp_enqueue_style('lo-style',self::getPluginUrl().'/css/lo.css');

		
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

    static function addonpath(){
        return self::getPluginPath().DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR .'addons'. DIRECTORY_SEPARATOR;
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

		function TheLastOneAutoLoader($name)
		{
			$name = str_replace('\\', DIRECTORY_SEPARATOR, $name);
			$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $name . '.php';

			if (is_file($file))
			{
				require_once $file;
			}
		}

		spl_autoload_register('TheLastOneAutoLoader');
	}
    
    static function loadAddons(){
        if(is_dir(self::addonpath()))
            foreach(scandir(self::addonpath()) as $addons_file){
                if(preg_match('/\.php$/', $addons_file) && $addons_file !== 'index.php'){
                    include_once self::addonpath().'/'.$addons_file;
                }else if(is_dir(self::addonpath().'/'.$addons_file)){
                    foreach(scandir(self::addonpath().'/'.$addons_file) as $addons_file_sub)
                        if(preg_match('/\.php$/', $addons_file_sub) && $addons_file_sub !== 'index.php')
                            include_once self::addonpath().'/'.$addons_file.'/'.$addons_file_sub;
                }   
            }
    }
}

/**
 * Activate plugin
 */
TheLastOne::bootStrap();

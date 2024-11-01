<?php
/**
 * The general settings page is the page.
 * @since 1.0.0
 * @author Rahul Taiwala
 */
class TheLastOneSettings
{
	/** @var bool $isCurrentPage Flag that represents whether or not the general settings page is the current page */
	static $isCurrentPage = false;

	/** @var string $settingsGroup Settings group */
	static $settingsGroup = 'the-last-one-settings-group';


	/** @var string $defaultSettings */
	static $defaultSettings = 'the-last-one-settings';
	

	/**
	 * 
	 *
	 * @since 1.1.0
	 */
	static function init()
	{
		// Only initialize in admin
		if (!is_admin())
		{
			return;
		}

		if (isset($_GET['page']) && $_GET['page'] == 'the_last_one_settings')
		{
			self::$isCurrentPage = true;
		}

		// Register settings
		add_action('admin_init', array(__CLASS__, 'registerSettings'));

		// Add sub menu
		add_action('admin_menu', array(__CLASS__, 'addSubMenuPage'),9);

		
	}

	/**
	 * 
	 *
	 * @since 1.1.0
	 */
	static function addSubMenuPage()
	{
		
		// Add  menu
		
        add_menu_page('The Last One', 'The Last One', 'read', 'the_last_one_main', array(__CLASS__,'dashpage'));
        /*add_submenu_page('the_last_one_main',
			__('Settings', 'the_last_one'),
			__('Settings', 'the_last_one'),
			'manage_options',
			'the_last_one_settings',
			array(__CLASS__, 'generalSettings')
		);*/
	}
    
    static function dashpage(){
        $addons=TheLastOneBase::get_addons();
        $settings=self::getDefaultSettings();
        
        include TheLastOne::getPluginPath() . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . __CLASS__ . DIRECTORY_SEPARATOR . 'general-settings.php';
       
    }
    
    
	/**
	 * Shows the general settings page.
	 *
	 * @since 1.1.0
	 */
	static function generalSettings()
	{
		// Include general settings page
		include TheLastOne::getPluginPath() . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . __CLASS__ . DIRECTORY_SEPARATOR . 'general-settings.php';
	}

	/**
	 * Registers required settings into the WordPress settings API.
	 * Only performed when actually on the general settings page.
	 *
	 * @since 1.1.0
	 */
	static function registerSettings()
	{
		// Register settings only when the user is going through the options.php page
		$urlParts = explode('/', $_SERVER['PHP_SELF']);

		if (array_pop($urlParts) != 'options.php')
		{
			return;
		}

		
		// Register default settings
		register_setting(self::$settingsGroup, self::$defaultSettings);
		

	}
    static function getSettingByKey($key){
        $settings=self::getDefaultSettings();
        return isset($settings[$key])?$settings[$key]:'';
        
    }
    static function getDefaultSettings($fullDefinition = false, $fromDatabase = true)
	{

		// Default values
        $data=array();
		$data = apply_filters( 'tlo_settings_default_data', $data );
        
		// Read defaults from database and merge with $data, when $fromDatabase is set to true
		if ($fromDatabase)
		{
            $customData = get_option(self::$defaultSettings, array());
            if(is_array($customData)){
                $data = array_merge($data,$customData);
            }
		}
        ;
		// Full definition
		if ($fullDefinition)
		{
			$descriptions = array();

			$data = array(
				'small_breed_image'                   => 
                array('type' => 'text', 'default' => $data['small_breed_image'] , 'description' => $descriptions['small_breed_image'] , 'group' => __('Default', 'ts_dog_ac')),
				'medium_breed_image'                   => 
                array('type' => 'text', 'default' => $data['medium_breed_image'] , 'description' => $descriptions['medium_breed_image'] , 'group' => __('Default', 'ts_dog_ac')),
				'large_breed_image'                   => 
                array('type' => 'text', 'default' => $data['large_breed_image'] , 'description' => $descriptions['large_breed_image'] , 'group' => __('Default', 'ts_dog_ac')),
                'extra_breed_image'                   => 
                array('type' => 'text', 'default' => $data['extra_breed_image'] , 'description' => $descriptions['extra_breed_image'] , 'group' => __('Default', 'ts_dog_ac')),
				'puppy_message'                   => 
                array('type' => 'text', 'default' => $data['puppy_message'] , 'description' => $descriptions['puppy_message'] , 'group' => __('Default', 'ts_dog_ac')),
				'adult_message'                   => 
                array('type' => 'text', 'default' => $data['adult_message'] , 'description' => $descriptions['adult_message'] , 'group' => __('Default', 'ts_dog_ac')),
				'senior_message'                   => 
                array('type' => 'text', 'default' => $data['senior_message'] , 'description' => $descriptions['senior_message'] , 'group' => __('Default', 'ts_dog_ac')),
				'geriatric_message'                   => 
                array('type' => 'text', 'default' => $data['geriatric_message'] , 'description' => $descriptions['geriatric_message'] , 'group' => __('Default', 'ts_dog_ac')),
				
				
				);
		}

		// Return
		return $data;
	}
    
    
    
    static function getInputField($settingsKey, $settingsName, $settings, $hideDependentValues = true)
	{
		if (!is_array($settings) ||
			empty($settings) ||
			empty($settingsName))
		{
			return null;
		}

		$inputField   = '';
		$name         = $settingsKey . '[' . $settingsName . ']';
		$displayValue = (!isset($settings['value']) || (empty($settings['value']) && !is_numeric($settings['value'])) ? $settings['default'] : $settings['value']);
		$class        = ((isset($settings['dependsOn']) && $hideDependentValues)? 'depends-on-field-value ' . $settings['dependsOn'][0] . ' ' . $settings['dependsOn'][1] . ' ': '') . $settingsKey . '-' . $settingsName;

		switch($settings['type'])
		{
			case 'text':

				$inputField .= '<input
					type="text"
					name="' . $name . '"
					class="' . $class . '"
					value="' . $displayValue . '"
				/>';

				break;

            case 'hidden':

				$inputField .= '<input
					type="hidden"
					name="' . $name . '"
					class="' . $class . '"
					value="' . $displayValue . '"
				/>';

				break;

            
			case 'textarea':

				$inputField .= '<textarea
					name="' . $name . '"
					class="' . $class . '"
					rows="20"
					cols="60"
				>' . $displayValue . '</textarea>';

				break;

			case 'select':

				$inputField .= '<select name="' . $name . '" class="' . $class . '">';

				foreach ($settings['options'] as $optionKey => $optionValue)
				{
					$inputField .= '<option value="' . $optionKey . '" ' . selected($displayValue, $optionKey, false) . '>
						' . $optionValue . '
					</option>';
				}

				$inputField .= '</select>';

				break;

			case 'radio':

				foreach ($settings['options'] as $radioKey => $radioValue)
				{
					$inputField .= '<label style="padding-right: 10px;"><input
						type="radio"
						name="' . $name . '"
						class="' . $class . '"
						value="' . $radioKey . '" ' .
						checked($displayValue, $radioKey, false) .
						' />' . $radioValue . '</label>';
				}

				break;
            case 'checkbox':
                $inputField .= '<input
						type="checkbox"
						name="' . $name . '"
						id="' . $class . '"' .
						checked($displayValue,'on',false) .
						' /><label for="'.$class.'"></label>';
                break;
			default:

				$inputField = null;

				break;
		};

		// Return
		return $inputField;
	}

	
}
<?php
/**
 * @since 1.1.0
 * @author: Rahul Taiwala
 */
class TheLastOneBase
{
	/**
	 * Initializes the shortcode
	 *
	 * @since 1.0.0
	 */
	static function init()
	{
        $addons=self::get_addons();
		$settings=TheLastOneSettings::getDefaultSettings();
        foreach($addons as $addon){
            if($settings['addon_id_'.$addon['Id']]){
                $addon['Class']::on_active();
            }
        }
	}
    
    static function get_addons() {
        if ( ! $cache_addons = wp_cache_get('lo_addons', 'lo_addons') )
		  $cache_addons = array();

        $lo_addons = array ();
        $addons_root = TheLastOne::addonpath();
        
        // Files in addons/ directory
        $addons_dir = @ opendir( $addons_root);
        $addons_files = array();
        if ( $addons_dir ) {
            while (($file = readdir( $addons_dir ) ) !== false ) {
                if ( substr($file, 0, 1) == '.' )
                    continue;
				if ( is_dir( $addons_root.'/'.$file ) ) {
                    $plugins_subdir = @ opendir( $addons_root.'/'.$file );
                    if ( $plugins_subdir ) {
                        while (($subfile = readdir( $plugins_subdir ) ) !== false ) {
                            if ( substr($subfile, 0, 1) == '.' )
                                continue;
                            if ( substr($subfile, -4) == '.php' )
                                $addons_files[] = "$file/$subfile";
                        }
                        closedir( $plugins_subdir );
                    }
                } else {
                    if ( substr($file, -4) == '.php' )
                        $addons_files[] = $file;
                }

            }
            closedir( $addons_dir );
        }

        if ( empty($addons_files) )
            return $lo_addons;
        
        foreach ( $addons_files as $addons_file ) {
            if ( !is_readable( "$addons_root/$addons_file" ) )
                continue;

            $addons_data = self::get_addons_data( "$addons_root/$addons_file"); 

            if ( empty ( $addons_data['Name'] ) )
                continue;
            $addon_basename = preg_replace('/\.php/','',$addons_file); 
            //$addon_basename = trim($addon_basename, '/');
            $lo_addons[$addon_basename] = $addons_data;
        }

        uasort( $lo_addons, array(__CLASS__,'_sort_uname_callback') );

        $cache_addons = $lo_addons;
        wp_cache_set('lo_addons', $cache_addons, 'lo_addons');

        return $lo_addons;
    }

    static function _sort_uname_callback( $a, $b ) {
        return strnatcasecmp( $a['Name'], $b['Name'] );
    }
	
    static function get_addons_data( $addon_file) {

        $default_headers = array(
            'Name' => 'Addon Name',
            'Version' => 'Version',
            'Description' => 'Description',
            'Author' => 'Author',
            'AuthorURI' => 'Author URI',
            'Id' => 'Addon Id',
            'Class'=>'Class'
        );

        $addon_data = get_file_data( $addon_file, $default_headers, 'lo_addon' );

        return $addon_data;
    }
}
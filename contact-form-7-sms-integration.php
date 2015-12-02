<?php 
/**
 * Plugin Name:       Contact Form 7 - RP SMS
 * Plugin URI:        https://wordpress.org/plugins/contact-form-7-sms-addon-rp-sms
 * Description:       Contact Form 7 - RP SMS
 * Version:           0.1
 * Author:            Varun Sridharan
 * Author URI:        http://varunsridharan.in
 * Text Domain:       cf7-International-sms-integration
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt 
 * GitHub Plugin URI: @TODO
 */

if ( ! defined( 'WPINC' ) ) { die; }
 
class contact_form_7_sms_addon_rp_sms {
	/**
	 * @var string
	 */
	public $version = '0.1';
	
	public $api_link = 'http://sms.rpsms.in/api/';
	
	
	/**
	 * @var array
	 */
	public $plugin_vars = array();
	
	/**
	 * @var WooCommerce The single instance of the class
	 * @since 2.1
	 */
	protected static $_instance = null;
    
    protected static $functions = null;

    /**
     * Creates or returns an instance of this class.
     */
    public static function get_instance() {
        if ( null == self::$_instance ) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    
    /**
     * Class Constructor
     */
    public function __construct() {
        $this->define_constant();
		$this->set_vars();
        $this->load_required_files();
        $this->init_class();
        add_action( 'init', array( $this, 'init' ));
    }
    
    /**
     * Triggers When INIT Action Called
     */
    public function init(){
        add_action('plugins_loaded', array( $this, 'after_plugins_loaded' ));
        add_filter('load_textdomain_mofile',  array( $this, 'load_plugin_mo_files' ), 10, 2);
    }
    
    /**
     * Loads Required Plugins For Plugin
     */
    private function load_required_files(){
       $this->load_files($this->get_vars('PATH').'includes/common-class-*.php');
       if($this->is_request('admin')){
           $this->load_files($this->get_vars('PATH').'admin/class-*.php');
       } 
    }
    
    /**
     * Inits loaded Class
     */
    private function init_class(){
        self::$functions = new contact_form_7_sms_addon_rp_sms_Functions;
        
        if($this->is_request('admin')){
            $this->admin = new contact_form_7_sms_addon_rp_sms_Admin;
        }
    }
    
    
    public function func(){
        return self::$functions;
    }
    

    protected function load_files($path,$type = 'require'){
        foreach( glob( $path ) as $files ){

            if($type == 'require'){
                require_once( $files );
            } else if($type == 'include'){
                include_once( $files );
            }
            
        } 
    }
    
    /**
     * Set Plugin Text Domain
     */
    public function after_plugins_loaded(){
        load_plugin_textdomain(CF7SI_TXT, false, $this->get_vars('LANGPATH') );
    }
    
    /**
     * load translated mo file based on wp settings
     */
    public function load_plugin_mo_files($mofile, $domain) {
        if (CF7SI_TXT === $domain)
            return $this->get_vars('LANGPATH').'/'.get_locale().'.mo';

        return $mofile;
    }
    
    /**
     * Define Required Constant
     */
    private function define_constant(){
        $this->define('CF7SI_NAME',__('Contact Form 7 - RP SMS','contact-form-7-sms-addon-rp-sms')); # Plugin Name
        $this->define('CF7SI_SLUG','contact-form-7-sms-addon-rp-sms'); # Plugin Slug
		$this->define('CF7SI_DB_SLUG','cf7si'); # Plugin DB Slug
        $this->define('CF7SI_TXT','contact-form-7-sms-addon-rp-sms'); #plugin lang Domain
    }
    
	private function set_vars(){
		$this->add_vars('URL',plugins_url('', __FILE__ )); 
		$this->add_vars('FILE',plugin_basename( __FILE__ ));
		$this->add_vars('PATH',plugin_dir_path( __FILE__ )); # Plugin DIR
		$this->add_vars('LANGPATH',$this->get_vars('PATH').'languages');
	}
    
	private function add_vars($key, $val){
		if(!isset($this->plugin_vars[$key])){
			$this->plugin_vars[$key] = $val;
		}
	}
	
	
	public function get_vars($key){
		if(isset($this->plugin_vars[$key])){
			return $this->plugin_vars[$key];
		}
		return false;
	}	
	
    /**
	 * Define constant if not already set
	 * @param  string $name
	 * @param  string|bool $value
	 */
    protected function define($key,$value){
        if(!defined($key)){
            define($key,$value);
        }
    }
    
	
	/**
	 * What type of request is this?
	 * string $type ajax, frontend or admin
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}
    
    
    
}
		   
if(!function_exists('contact_form_7_sms_addon_rp_sms')){
	function contact_form_7_sms_addon_rp_sms(){
		return contact_form_7_sms_addon_rp_sms::get_instance();
	}
	contact_form_7_sms_addon_rp_sms();
}
?>
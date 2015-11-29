<?php
/**
 * The admin-specific functionality of the plugin.
 * @author     Varun Sridharan <varunsridharan23@gmail.com>
 */
if ( ! defined( 'WPINC' ) ) { die; }

class contact_form_7_sms_addon_rp_sms_Admin extends contact_form_7_sms_addon_rp_sms {

    /**
	 * Initialize the class and set its properties.
	 * @since      0.1
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu'));
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ),99);
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_filter( 'plugin_row_meta', array($this, 'plugin_row_links' ), 10, 2 );
        add_action( 'admin_init', array( $this, 'admin_init' ));
        add_action( 'plugins_loaded', array( $this, 'init' ) );
	}
	
	public function add_menu(){
		$this->page_slug = 'cf7isi-options';
		add_submenu_page( 'wpcf7', 
						 __('RP SMS', CF7SI_TXT), 
						 __('RP SMS', CF7SI_TXT), 'manage_options',
						 $this->page_slug, array($this,'admin_page') );
	}
	
	
	public function admin_page(){
		global $Custom_pagetitle,$slugs;
		$this->save_settings();
		$slugs = $this->page_slug; 
		contact_form_7_sms_addon_rp_sms()->load_files(contact_form_7_sms_addon_rp_sms()->get_vars('PATH').'template/cf7-conf-header.php'); 
		contact_form_7_sms_addon_rp_sms()->load_files(contact_form_7_sms_addon_rp_sms()->get_vars('PATH').'template/cf7-conf-footer.php');
	}
	
	public function save_settings(){
		if(isset($_POST['save_api_settings'])){ 
			$authKey = $_POST['authKey'];
			$route = $_POST['route'];
			$senderID = $_POST['senderID'];
			update_option(CF7SI_DB_SLUG.'authKey',$authKey);
			update_option(CF7SI_DB_SLUG.'route',$route);
			update_option(CF7SI_DB_SLUG.'senderID',$senderID);
		}
	}

    /**
     * Inits Admin Sttings
     */
    public function admin_init(){
        new contact_form_7_sms_addon_rp_sms_Plugin_Integration;
    }
 
    /**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() { 
        if(in_array($this->current_screen() , $this->get_screen_ids())) {
            wp_enqueue_style(CF7SI_SLUG.'_core_style',plugins_url('css/style.css',__FILE__) , array(), $this->version, 'all' );  
        }
	}
	
    
    /**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {
        if(in_array($this->current_screen() , $this->get_screen_ids())) {
            wp_enqueue_script(CF7SI_SLUG.'_core_script', plugins_url('js/script.js',__FILE__), array('jquery'), $this->version, false ); 
			wp_enqueue_script(CF7SI_SLUG.'_core_validate', plugins_url('js/validate.js',__FILE__), array('jquery'), $this->version, false ); 
        }
 
	}
    
    /**
     * Gets Current Screen ID from wordpress
     * @return string [Current Screen ID]
     */
    public function current_screen(){
       $screen =  get_current_screen();
       return $screen->id;
    }
    
    /**
     * Returns Predefined Screen IDS
     * @return [Array] 
     */
    public function get_screen_ids(){
        $screen_ids = array();
        $screen_ids[] = 'contact_page_cf7isi-options'; 
        return $screen_ids;
    }
    
    
    /**
	 * Adds Some Plugin Options
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 * @since 0.11
	 * @return array
	 */
	public function plugin_row_links( $plugin_meta, $plugin_file ) {
		if ( contact_form_7_sms_addon_rp_sms()->get_vars('FILE') == $plugin_file ) {
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', '#', __('Settings', CF7SI_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://wordpress.org/plugins/cf7-international-sms-integration/faq', __('F.A.Q', CF7SI_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://github.com/technofreaky/cf7-international-sms-intergation', __('View On Github', CF7SI_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://github.com/technofreaky/cf7-international-sms-intergation/issues', __('Report Issue', CF7SI_TXT) );
            $plugin_meta[] = sprintf('&hearts; <a href="%s">%s</a>', 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=KX225JU6JH8E2', __('Donate', CF7SI_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'http://varunsridharan.in/plugin-support/', __('Contact Author', CF7SI_TXT) );
		}
		return $plugin_meta;
	}	    
}

?>
<?php
/**
 * @package JarmillUserFlow
 */

/**
 * Plugin Name:       User Flow by Jarmill Media
 * Plugin URI:        https://jarmill.com
 * Description:       Plugin managing user login, signup and profile
 * Version:           1.0.0
 * Author:            Vit Srajbr
 * License:           GPL-2.0+
 * Text Domain:       jm-user-flow
 */

//Kill if accessed directly
defined( 'ABSPATH' ) or die( 'Nice try!' );

class Jm_User_Flow 
{
    function __construct() {
        $this->load_dependencies();
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
    }
    
    function activate() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/jm-user-flow-activate.php';
        Jm_User_Flow_Activate::activate();
    }
    
    function deactivate() {
        flush_rewrite_rules();
    }
    
    function enqueue() {
        wp_enqueue_style( 'jm_user_flow_style', plugins_url( '/assets/style.css', __FILE__ ) );
        wp_enqueue_script( 'jm_user_flow_script', plugins_url( '/assets/main.js', __FILE__ ), array('jquery'), false, true );
        //Pass js variable to script
        wp_localize_script( 'jm_user_flow_script', 'ajax_handler', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'loadingmessage' => __('Sending info, please wait...')
        ));
        
        
    }
    function load_dependencies() {
        
        require_once plugin_dir_path( __FILE__ ) . 'includes/jm-user-flow-render.php';
        $jmUserFlowRender = new Jm_User_Flow_Render();
        
        require_once plugin_dir_path( __FILE__ ) . 'includes/jm-user-flow-ajax-handle.php';
        $jmUserFlowAjaxHandle = new Jm_User_Flow_Ajax_Handle();
        
        require_once plugin_dir_path( __FILE__ ) . 'includes/jm-user-flow-redirect.php';
        $jmUserFlowRedirect = new Jm_User_Flow_Redirect();
    }
    public function is_user_logged_in() {
        global $current_user;

        if ( empty( $current_user->ID ) )
            return false;

        return true;
    }
}

//init
if ( class_exists( 'Jm_User_Flow' ) ) {
    $jmUserFlow = new Jm_User_Flow();
}

//activation
register_activation_hook( __FILE__, array( $jmUserFlow, 'activate' ));
//deactivation
register_deactivation_hook( __FILE__, array( $jmUserFlow, 'deactivate' ));
<?php
/**
 * @package JarmillUserFlow
 */
class Jm_User_Flow_Render {
    
    public function is_user_logged_in() {
        global $current_user;

        if ( empty( $current_user->ID ) )
            return false;

        return true;
    }
    
    
    
    public function __construct() {
        //Shortcodes
        add_shortcode( 'jm_user_flow', array( $this, 'render_form' ) );
        add_action( 'wp_footer', array( $this, 'render_popups' ) );
        
        
    }
    public function render_form( $atts, $content = null ) {
        
        if ( is_user_logged_in() && ( $atts['form'] == 'login' || $atts['form'] == 'signup' || $atts['form'] == 'lost-password' ) ) {
			return __( 'You are already signed in.', 'jm-user-flow' );
		} else if  ( $atts['form'] == 'signup' && ! get_option( 'users_can_register' ) ) {
			return __( 'Sorry, signups are not allowed.', 'jm-user-flow' );
		} else if ( !is_user_logged_in() && $atts['form'] == 'profile') {
            $redirect_url = home_url();
        } else {
            return $this->get_template_html( $atts['form'] ); 
        }        
        wp_redirect( $redirect_url );
        die();
    }
    
    private function get_template_html( $template_name ) {		      

		ob_start();

		do_action( 'jm_user_flow_before_' . $template_name );

		require( plugin_dir_path(__FILE__) . 'templates/' . $template_name . '.php');

		do_action( 'jm_user_flow_after_' . $template_name );

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
    
    public function render_popups() {
        if (! is_user_logged_in()) {
            echo '<div class="pop_overlay hidden"><div class="pop_window">' . do_shortcode('[jm_user_flow form="login"]') . do_shortcode('[jm_user_flow form="signup"]') . '</div> </div>';
        } else {
            return;
        }
        
    }
}
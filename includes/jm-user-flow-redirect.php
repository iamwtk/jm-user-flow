<?php
/**
 * @package JarmillUserFlow
 */
class Jm_User_Flow_Redirect 
{
    function __construct() {
        add_action( 'login_form_login', array( $this, 'login_redirect' ) );
        add_action( 'login_form_register', array( $this, 'signup_redirect' ) );        
    }
    
    
    public function login_redirect() {
        
		if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
            
            $redirect_url = home_url('login');
            
			if ( is_user_logged_in() ) {
				$redirect_url = home_url('profile');
			}            
			            
			
			wp_redirect( $redirect_url );
			die();
		}
	}
    
    public function signup_redirect() {
        
		if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
            
            $redirect_url = home_url('signup');
            
			if ( is_user_logged_in() ) {
				$redirect_url = home_url('profile');
			}            
			            
			
			wp_redirect( $redirect_url );
			die();
		}
	}
    
    
} 
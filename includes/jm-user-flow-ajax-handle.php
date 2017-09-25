<?php
/**
 * @package JarmillUserFlow
 */
class Jm_User_Flow_Ajax_Handle { 
    
    public function is_user_logged_in() {
        global $current_user;

        if ( empty( $current_user->ID ) )
            return false;

        return true;
    }
    
    public function __construct() {
               
        if ( ! $this->is_user_logged_in() ) {
            add_action( 'wp_ajax_nopriv_ajaxsignup',array( $this, 'ajax_signup' ));
            add_action( 'wp_ajax_nopriv_ajaxlogin', array( $this,'ajax_login'));
            
        }
        
        add_action( 'wp_ajax_changepwd', array( $this,'ajax_change_password'));
        add_action( 'wp_ajax_userinfo', array( $this,'ajax_update_user_info'));
        
        
    }
    
    public function password_match( $pass1, $pass2 ) {
        if ($pass1 === $pass2) {
            return true;
        } else {
            return false;
        }
    }  
    

    public function ajax_login(){
        
        check_ajax_referer( 'ajax-login-nonce', 'security' );
        
        $user_info = array(
            'user_login' => $_POST['username'],
            'user_password' => $_POST['password'],
            'remember' => $_POST['rememberme']
        ); 

        $user_login = wp_signon( $user_info, false );
        
        if ( is_wp_error( $user_login ) ){
            echo json_encode(array('success'=>false, 'message'=>__('Wrong username or password.')));
        } else {
            echo json_encode(array('success'=>true, 'message'=>__('Login successful, redirecting...'), 'redirect' => home_url('profile') ));
        }
        die();
        
    }
    
    public function ajax_signup(){
 
    
        check_ajax_referer( 'ajax-signup-nonce', 'security' );        

        $user_signup_info = array(
            'user_login' => sanitize_email( $_POST['email']),
            'user_email' => sanitize_email( $_POST['email']),
            'user_pass'  => $_POST['password']
        );	

        $pass_confirm = $_POST['password_2'];

        $user_login_info = array(
            'user_login' => $user_signup_info['user_login'],
            'user_password' => $user_signup_info['user_pass'],
            'remember' => 'forever'
        );    


       if ( ! $this->password_match( $user_signup_info['user_pass'], $pass_confirm) ) {
           echo json_encode(array('success'=>false, 'message'=>__("The two passwords you entered don't match."))); 
       } else {
            
            $user_signup = wp_insert_user( $user_signup_info );

            if ( is_wp_error( $user_signup ) ){	
                $error  = $user_signup->get_error_codes()	;

                if(in_array('empty_user_login', $error))

                    echo json_encode(array('success'=>false, 'message'=>__($user_register->get_error_message('empty_user_login'))));

                elseif(in_array('existing_user_login',$error))

                    echo json_encode(array('success'=>false, 'message'=>__('This username is already taken.')));

                elseif(in_array('existing_user_email',$error))

                    echo json_encode(array('success'=>false, 'message'=>__('This email address is already taken.')));
            } else {
                $this->add_user_info( $user_signup );
                $user_login = wp_signon( $user_login_info, false );
                

                if ( is_wp_error($user_signon) )

                    echo json_encode(array('success'=>false, 'message'=>__('Wrong username or password.')));

                else                 
                    echo json_encode(array('success'=>true, 'message'=>__('Signup successful, logging in...'), 'redirect' => home_url('profile') ));            

            }
        }  
        die();
    }
    
    public function add_user_info($user_id) {
        
        $fields = array(
            '_address_line_1',
            '_address_line_2',
            '_city',
            '_zip_code',
            '_country'
        );
        
        foreach ($fields as $field) {
            update_user_meta( $user_id, $field, '' );
        }             
    }
	

    public function ajax_change_password(){
        global $current_user;
        $pass = $current_user->user_pass;
        
        check_ajax_referer( 'ajax-password-change', 'security' );
        
        
        
        $passwords = array(
            'old_password' => $_POST['old_password'],
            'new_password' => $_POST['new_password'],
            'confirm_password' => $_POST['confirm_password']
        );
     
        
        $is_correct = wp_check_password( $passwords['old_password'], $pass );
        
        if ( $this->password_match( $passwords['new_password'], $passwords['confirm_password'] ) && $is_correct) {
            
            wp_update_user( array ('ID' => $current_user->ID , 'user_pass' => $passwords['new_password'])); 
            
            echo json_encode(array('success'=>true, 'message'=>'Your password was succesfully changed!'));
            
        } else if (!$is_correct) {
            
            echo json_encode(array('success'=>false, 'wrong_pwd'=>true,  'mismatch'=>false, 'message'=>'You entered wrong password!'));
            
        } else if ( ! $this->password_match( $passwords['new_password'], $passwords['confirm_password'] )) {
            
            echo json_encode(array('success'=>false, 'wrong_pwd'=>false,  'mismatch'=>true, 'message'=>"Passwords don't match!"));
            
        }
        
    die();
    }
   
    

    public function ajax_update_user_info(){
        global $current_user;        
        
        check_ajax_referer( 'ajax-update-profile', 'security' );
        
        global $current_user;
        $user_id        = $current_user->ID;
        
        $fields = array(
            'user_email'        => sanitize_email( $_POST['email'] ),
            'user_login'        => sanitize_email( $_POST['email'] ),
            'nickname'          => sanitize_email( $_POST['email'] ),
            'first_name'        => sanitize_text_field( $_POST['first-name'] ),
            'last-name'         => sanitize_text_field( $_POST['last-name'] ),
            '_address_line_1'   => sanitize_text_field( $_POST['address_1'] ),
            '_address_line_2'   => sanitize_text_field( $_POST['address_2'] ),
            '_city'             => sanitize_text_field( $_POST['city'] ),
            '_zip_code'         => sanitize_text_field( $_POST['zip_code'] ),
            '_country'          => sanitize_text_field( $_POST['country'] )
        );
        
        
        
       if ( (!email_exists($user_email) || email_exists($user_email) ==  $user_id) && ( !username_exists($user_email) || username_exists($user_email) == $user_id  )) {
           
           foreach ($fields as $field => $value) {
               
               if ($field == 'user_email' || $field == 'user_login') {
                   wp_update_user( array ('ID' => $user_id , $field => $value ));
               } else {
                   update_user_meta( $user_id, $field, $value );
               }
           }
           
           echo json_encode(array('address_updated'=>true, 'message'=>'Your address was successfully updated.'));   
       } else {
           echo json_encode(array('address_updated'=>false, 'message'=>'This email address is already registered.'));
       }
        
    die();
    }
}





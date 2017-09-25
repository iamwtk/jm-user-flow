<?php
/**
 * @package JarmillUserFlow
 */
class Jm_User_Flow_Activate 
{
    static function activate() {
        self::create_pages();
        flush_rewrite_rules();
    }
    //CREATING PAGES
    function create_pages() {
        $pages = array(
        'login' => array(
            'title' => __('Login', 'JM User Flow'),
            'shortcode' => '[jm_user_flow form="login"]'
        ),
        'signup' => array(
            'title' => __('Signup', 'JM User Flow'),
            'shortcode' => '[jm_user_flow form="signup"]'
        ),
        'profile' => array(
            'title' => __('Profile', 'JM User Flow'),
            'shortcode' => '[jm_user_flow form="profile"]'
        )
       );
        foreach ($pages as $slug => $page) {
            $query = new WP_Query( 'pagename=' . $slug );			
			if (  ! $query->have_posts() ) {  
                $page_settings = array(
                    'post_content'   => $page['shortcode'],
                    'post_name'      => $slug,
                    'post_title'     => $page['title'],
                    'post_status'    => 'publish',
                    'post_type'      => 'page',
                    'ping_status'    => 'closed',
                    'comment_status' => 'closed' 
            );
                wp_insert_post($page_settings);
            }
            
        }
    }
}
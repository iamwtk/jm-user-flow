<div class="jm_pw_change_wrap">
    <p class="message"></p>
    <form class="jm_pw_change_form" method="post">
        <div class="form_group">
            <input name="old_password" class="jm_old_password_input" value="" type="password" placeholder="<?php _e('Password', 'jm-user-flow');?>">
        </div>
        <div class="form_group">
            <input name="new_password" class="jm_new_password_input" value="" type="password" placeholder="<?php _e('Password', 'jm-user-flow');?>">
            <i class="fa fa-lock"></i>
        </div>
        <div class="form_group">
            <input name="password" class="jm_confirm_password_input" value="" type="password" placeholder="<?php _e('Confirm Password', 'jm-user-flow');?>">
            <i class="fa fa-lock"></i>
        </div>        
        <div class="form_group">
            <input name="wp-submit" id="wp-submit" class="button button-primary" value="<?php _e('Change Password', 'jm-user-flow');?>" type="submit">
        </div>
    </form>
    <?php wp_nonce_field( 'ajax-password-change', 'security' );?>    
</div>




















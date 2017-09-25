<div class="jm_login_wrap">
    <p class="message"></p>
    <form class="jm_login_form" method="post">
        <div class="form_group">
            <input name="login" class="jm_login_input" value="" size="20" type="text" placeholder="<?php _e('Email Address', 'jm-user-flow');?>">
            <i class="fa fa-envelope-o"></i>
        </div>
        <div class="form_group">
            <input name="password" class="jm_password_input" value="" type="password" placeholder="<?php _e('Password', 'jm-user-flow');?>">
            <i class="fa fa-lock"></i>
        </div>
        <div class="form_group">
            <label>
                <input name="rememberme" id="rememberme" value="forever" type="checkbox">
                <?php _e('Remember Me', 'jm-user-flow');?>
            </label>
        </div>
        <div class="form_group">
            <input name="wp-submit" id="wp-submit" class="button button-primary" value="<?php _e('Login', 'jm-user-flow');?>" type="submit">
        </div>
    </form>
    <?php wp_nonce_field( 'ajax-login-nonce', 'security' );?>
    <a class="forgot-password" href="<?php echo wp_lostpassword_url(); ?>">
        <?php _e( 'Forgot your password?', 'jm-user-flow' ); ?>
    </a>
</div>
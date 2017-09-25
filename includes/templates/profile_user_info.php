<?php
global $current_user;
$user_id        = $current_user->ID;
$first_name     = $current_user->first_name;
$last_name      = $current_user->last_name;
$user_email     = $current_user->user_email;
$user_pass     = $current_user->user_pass;
$address_line_1 = get_user_meta($user_id, '_address_line_1', true);
$address_line_2 = get_user_meta($user_id, '_address_line_2', true);
$city           = get_user_meta($user_id, '_city', true);
$zip_code       = get_user_meta($user_id, '_zip_code', true);
$country        = get_user_meta($user_id, '_country', true);
?>
<div id="user-address">
    <p class="status"></p>
    <form method="post" id="useraddress">

        <div class="form_group">
            <label for="first-name"><?php _e('First Name', 'profile'); ?></label>
            <input class="text-input" name="first-name" type="text" id="first-name" value="<?php echo $first_name; ?>" required />
        </div>
        <div class="form_group">
            <label for="last-name"><?php _e('Last Name', 'profile'); ?></label>
            <input class="text-input" name="last-name" type="text" id="last-name" value="<?php echo $last_name; ?>" required />
        </div>
        <div class="form_group">
            <label for="email"><?php _e('E-mail *', 'profile'); ?></label>
            <input class="text-input" name="email" type="text" id="email" value="<?php echo $user_email; ?>" required />
        </div>
        <div class="form_group">
            <label for="Country"><?php _e('Country', 'profile'); ?></label>
            <input class="text-input" name="country" type="text" id="country" value="<?php echo $country; ?>" required />
        </div>




        <div class="form_group">
            <label for="address_1"><?php _e('Address line 1', 'profile'); ?></label>
            <input class="text-input" name="address_1" type="text" id="address_1" value="<?php echo $address_line_1; ?>" required />
        </div>
        <div class="form_group">
            <label for="address_2"><?php _e('Address line 2', 'profile'); ?></label>
            <input class="text-input" name="address_2" type="text" id="address_2" value="<?php echo $address_line_2; ?>" />
        </div>
        <div class="form_group city_group">
            <label for="city"><?php _e('City', 'profile'); ?></label>
            <input class="text-input" name="city" type="text" id="city" value="<?php echo $city; ?>" required />
        </div>
        <div class="form_group zip">
            <label for="zip_code"><?php _e('Zip code', 'profile'); ?></label>
            <input class="text-input" name="zip_code" type="text" id="zip_code" value="<?php echo $zip_code; ?>" required />
        </div>



        <div class="form_group ">
            <input name="updateaddress" type="submit" id="update" class=" submit button" value="<?php _e('Update Address', 'profile'); ?>" />
            <?php wp_nonce_field( 'ajax-update-profile', 'security' ); ?>
            <input name="action" type="hidden" id="action" value="update-user" />
        </div>

    </form>
</div>
<?php
global $current_user;
$user_id        = $current_user->ID;
$first_name = $current_user->first_name;
?>
<section id="user_profile_render">
    <h1>Welcome <?php echo $first_name;?></h1>

    <div class="single">
        <div class="top"><button type="button"><i class="fa fa-arrow-down"></i></button><h2 class="title">User info</h2></div>
        <div class="form"><?php echo do_shortcode('[jm_user_flow form="profile_user_info"]');?></div>
    </div>

    <div class="single">
        <div class="top"><button type="button"><i class="fa fa-lock"></i></button><h2 class="title">Change password</h2></div>
        <div class="form"><?php echo do_shortcode('[jm_user_flow form="profile_password_change"]');?></div>
    </div>

</section>
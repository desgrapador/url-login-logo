<?php
/*
Plugin Name: URL Login Logo
Plugin URI: https://martinenrique.com/url-login-logo/
Description: Allows customizing the logo on the login page and changes the link to homepage.
Version: 1.0
Author: Martín Enrique
Author URI: https://martinenrique.com
License: GPL2
*/

// Add configuration field under Settings > General
function url_login_logo_settings() {
  add_settings_section("url_login_logo_section", "URL Login Logo", null, "general");
  add_settings_field("url_login_logo", "Login Logo", "url_login_logo_display", "general", "url_login_logo_section");
  add_settings_field("url_login_logo_width", "Logo Width", "url_login_logo_width_display", "general", "url_login_logo_section");
  add_settings_field("url_login_logo_height", "Logo Height", "url_login_logo_height_display", "general", "url_login_logo_section");
  register_setting("general", "url_login_logo");
  register_setting("general", "url_login_logo_width");
  register_setting("general", "url_login_logo_height");
}
add_action("admin_init", "url_login_logo_settings");

// Change login url to home
function custom_login_url() {
    return home_url();
}
add_filter('login_headerurl', 'custom_login_url');

// Show logo selection field
function url_login_logo_display() {
  $url_login_logo = get_option("url_login_logo");
  ?>
  <input type="text" name="url_login_logo" value="<?php echo esc_attr($url_login_logo); ?>" style="width: 300px;">
  <p class="description">Enter the URL of the logo image to replace the default login logo.</p>
  <?php
}

// Show logo width field
function url_login_logo_width_display() {
  $url_login_logo_width = get_option("url_login_logo_width");
  ?>
  <input type="number" name="url_login_logo_width" value="<?php echo esc_attr($url_login_logo_width); ?>" min="1">
  <p class="description">Enter the width in pixels of the custom logo.</p>
  <?php
}

// Show logo height field
function url_login_logo_height_display() {
  $url_login_logo_height = get_option("url_login_logo_height");
  ?>
  <input type="number" name="url_login_logo_height" value="<?php echo esc_attr($url_login_logo_height); ?>" min="1">
  <p class="description">Enter the height in pixels of the custom logo.</p>
  <?php
}

// Show custom logo on the login page
function url_login_logo() {
  $url_login_logo = get_option("url_login_logo");
  $url_login_logo_width = get_option("url_login_logo_width");
  $url_login_logo_height = get_option("url_login_logo_height");

  if ($url_login_logo) {
    echo '<style type="text/css">
    #login h1 a, .login h1 a { background-image: url(' . esc_attr($url_login_logo) . ');';
    if ($url_login_logo_width) {
      echo ' background-size: ' . esc_attr($url_login_logo_width) . 'px auto;';
    }
    if ($url_login_logo_height) {
      echo ' height: ' . esc_attr($url_login_logo_height) . 'px; width: ' . esc_attr($url_login_logo_width) . 'px;';
    }
    echo '}
    </style>';
  }
}
add_action("login_head", "url_login_logo");

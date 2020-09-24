<?php
/*
Plugin Name: 6.04 - Settings Page
Plugin URI: https://github.com/zgordon/wp-dev-course
Description: Demo plugin for learning about plugin settings pages.
Version: 1.0.0
Contributors: zgordon
Author: Raghav
Author URI: https://zacgordon.com
License: GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wpplugin
Domain Path:  /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function wpplugin_settings_page()
{
    add_menu_page(
        'Plugin Name Demo',
        'Plugin Menu 2',
        'manage_options',
        'wpplugin',
        'wpplugin_settings_page_markup',
        'dashicons-wordpress-alt',
        100
    );

}
add_action( 'admin_menu', 'wpplugin_settings_page' );


function wpplugin_settings_page_markup()
{

    // Double check user capabilities
    if ( !current_user_can('manage_options') ) {
      return;
    }
    ?>
    <div class="wrap">
      <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>
      <p><?php esc_html_e( 'Some content.', 'wpplugin' ); ?></p>
    </div>

    <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields( 'wpplugin_settings' );
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'wpplugin' );
        // output save settings button
        submit_button( __( 'Save Settings', 'textdomain' ) );
        ?>
      </form>

    <?php
    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM wpbe_users"); // Query to fetch data from database table and storing in $results
    if(!empty($results))                        // Checking if $results have some values or not
    {   echo "<div class='wrap'>"; 
        echo "<table width='100%' border='0'>"; // Adding <table> and <tbody> tag outside foreach loop so that it wont create again and again
        echo "<tbody>";      
        foreach($results as $row){   
        $userip = $row->user_ip;               //putting the user_ip field value in variable to use it later in update query
        echo "<tr>";                           // Adding rows of table inside foreach loop
        echo "<th>ID</th>" . "<td>" . $row->ID . "</td>";
        echo "</tr>";
        echo "<td colspan='2'><hr size='1'></td>";
        echo "<tr>";        
        echo "<th>User Login</th>" . "<td>" . $row->user_login. "</td>";   //fetching data from user_ip field
        echo "</tr>";
        echo "<td colspan='2'><hr size='1'></td>";
        echo "<tr>";        
        echo "<th>User Nicename</th>" . "<td>" . $row->user_nicename . "</td>";
        echo "</tr>";
        echo "<td colspan='2'><hr size='1'></td>";
        echo "<tr>";        
        echo "<th>User Email</th>" . "<td>" . $row->user_email . "</td>";
        echo "</tr>";
        echo "<td colspan='2'><hr size='1'></td>";
        }
        echo "</tbody>";
        echo "</table>"; 
        echo "</div>"; 
    }
}

?>

<?php

function wpplugin_settings() {

  // If plugin settings don't exist, then create them
  if( !get_option( 'wpplugin_settings' ) ) {
      add_option( 'wpplugin_settings' );
  }

  // Define (at least) one section for our fields
  add_settings_section(
    // Unique identifier for the section
    'wpplugin_settings_section',
    // Section Title
    __( 'Plugin Settings Section', 'wpplugin' ),
    // Callback for an optional description
    'wpplugin_settings_section_callback',
    // Admin page to add section to
    'wpplugin'
  );

  add_settings_field(
    // Unique identifier for field
    'wpplugin_settings_custom_text',
    // Field Title
    __( 'Custom Text', 'wpplugin'),
    // Callback for field markup
    'wpplugin_settings_custom_text_callback',
    // Page to go on
    'wpplugin',
    // Section to go in
    'wpplugin_settings_section'
  );

  register_setting(
    'wpplugin_settings',
    'wpplugin_settings'
  );

}
add_action( 'admin_init', 'wpplugin_settings' );

function wpplugin_settings_section_callback() {

  esc_html_e( 'Plugin settings section description', 'wpplugin' );

}

function wpplugin_settings_custom_text_callback() {

  $options = get_option( 'wpplugin_settings' );

	$custom_text = '';
	if( isset( $options[ 'custom_text' ] ) ) {
		$custom_text = esc_html( $options['custom_text'] );
	}

  echo '<input type="text" id="wpplugin_customtext" name="wpplugin_settings[custom_text]" value="' . $custom_text . '" />';

}
?>

<!-- <?php
global $wpdb;
$results = $wpdb->get_results( "SELECT * FROM wpbe_users"); // Query to fetch data from database table and storing in $results
if(!empty($results))                        // Checking if $results have some values or not
{   echo "<div class='wrap'>"; 
    echo "<table width='100%' border='0'>"; // Adding <table> and <tbody> tag outside foreach loop so that it wont create again and again
    echo "<tbody>";      
    foreach($results as $row){   
    $userip = $row->user_ip;               //putting the user_ip field value in variable to use it later in update query
    echo "<tr>";                           // Adding rows of table inside foreach loop
    echo "<th>ID</th>" . "<td>" . $row->ID . "</td>";
    echo "</tr>";
    echo "<td colspan='2'><hr size='1'></td>";
    echo "<tr>";        
    echo "<th>User Login</th>" . "<td>" . $row->user_login. "</td>";   //fetching data from user_ip field
    echo "</tr>";
    echo "<td colspan='2'><hr size='1'></td>";
    echo "<tr>";        
    echo "<th>User Nicename</th>" . "<td>" . $row->user_nicename . "</td>";
    echo "</tr>";
    echo "<td colspan='2'><hr size='1'></td>";
    echo "<tr>";        
    echo "<th>User Email ID</th>" . "<td>" . $row->user_email . "</td>";
    echo "</tr>";
    echo "<td colspan='2'><hr size='1'></td>";
    }
    echo "</tbody>";
    echo "</table>"; 
    echo "</div>"; 
}
?> -->

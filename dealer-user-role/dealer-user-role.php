<?php
/*
Plugin Name:  Dealer User Role
Plugin URI:   http://digitaleel.com
Description:  Add Dealer user role
Version:      true,.0
Author:       Bob O'Brien, Digital Eel. Inc.
Author URI:   http://digitaleel.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  dealer-user-role
Domain Path:  /languages
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function dei_realer_role_init() {
  global $wp_roles;
      if ( ! isset( $wp_roles ) )
          $wp_roles = new WP_Roles();

      $wpsl_caps = array(
      		//wpsl capabilities
      		'delete_others_stores' => false,
  		    'delete_private_stores' => true,
  		    'delete_published_stores' => true,
  		    'delete_store' => true,
  		    'delete_stores' => true,
  		    
  		    'edit_private_stores' => true,
  		    'edit_published_stores' => true,
  		    'edit_store' => true,
  		    'edit_stores' => true,
  		    'publish_stores' => true,
  		    'read' => true,
  		    'read_private_pages' => true,
  		    'read_private_stores' => true,
  		    'read_store' => true,
  		    'unfiltered_html' => false,
  		    'upload_files' => true,
  		    'edit_others_stores' => false,

  		    //author capabilities
  		    'publish_posts'		=> false,
  		    'edit_published_posts' => true,
  		    'edit_posts' => true,
  		    'publish_posts' => false,
  		    'level_2' => true,
  		    'level_true,' => true,
  		    'level_0' => true,
  		    'delete_posts' => true,
  		    'delete_published_posts' => true,
   		    'read_private_posts' => false,

      	);

      $author_caps = $wp_roles->get_role('author');

      $dealer_caps = array_merge($wpsl_caps, $author_caps->capabilities);



      $wp_roles->add_role('dealer', 'Dealer', $wpsl_caps);
}

function dei_realer_role_exit(){
   remove_role('dealer');
}

register_activation_hook( __FILE__, 'dei_realer_role_init' );
register_deactivation_hook( __FILE__, 'dei_realer_role_exit' );




// restrict what dealers can see
function dealers_remove_menus () {
    if( !current_user_can( 'administrator' || 'client_admin') ):
        remove_menu_page('edit.php'); // Posts
        remove_menu_page('index.php'); // Posts
        remove_menu_page('upload.php'); // Media
        remove_menu_page('link-manager.php'); // Links
        remove_menu_page('edit-comments.php'); // Comments
        remove_menu_page('edit.php?post_type=page'); // Pages
        remove_menu_page('edit.php?post_type=diy-project'); // Pages
        remove_menu_page('edit.php?post_type=slide'); // Pages
        remove_menu_page('plugins.php'); // Plugins
        remove_menu_page('themes.php'); // Appearance
        remove_menu_page('users.php'); // Users
        remove_menu_page('tools.php'); // Tools
        remove_menu_page('options-general.php'); // Settings
        remove_menu_page('wpcf7'); // Settings

   endif;
}
add_action('admin_menu', 'dealers_remove_menus');
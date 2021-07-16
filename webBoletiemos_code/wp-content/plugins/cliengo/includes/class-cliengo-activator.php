<?php


/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Cliengo
 * @subpackage Cliengo/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cliengo
 * @subpackage Cliengo/includes
 * @author     Your Name <email@example.com>
 */
class Cliengo_Activator {

  /**
   * Short Description. (use period)
   *
   * Long Description.
   *
   * @since    1.0.0
   */
  public function activate() {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $this->execute_initial_querys_cliengo();
  }

  public function execute_initial_querys_cliengo() {
    $this->create_field_cliengo_chatbot_token();
  }

  // CREATE TABLE FUNCTION
  private function create_field_cliengo_chatbot_token() {
    
    global $wpdb;
    
    $wpdb->insert(
             $wpdb->prefix . 'options', 
              array('option_name' => 'cliengo_chatbot_token', 'option_value'=>''),
              array('%s','%s') 
            );
    $wpdb->insert(
              $wpdb->prefix . 'options', 
              array('option_name' => 'position_chatbot', 'option_value'=>'right'),
              array('%s','%s') 
            );
  }
}

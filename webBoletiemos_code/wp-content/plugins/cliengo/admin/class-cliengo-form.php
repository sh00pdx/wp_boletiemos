<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.cliengo.com
 * @since      1.0.0
 *
 * @package    Cliengo
 * @subpackage Cliengo/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cliengo
 * @subpackage Cliengo/admin
 * @author     Your Name <email@example.com>
 */
class Cliengo_Form {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;

  /**
   * Indicates whether we are in production or development state
   */
  const PROD_ENV = true;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   */

  public function __construct( $plugin_name, $version ) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  /**
   * Fetches and returns all session variables
   */
  public function restore_session() {
    $account = get_option( 'cliengo_session' );
    $session = array(
      'token' => stripslashes( get_option( 'cliengo_chatbot_token' ) ),
      'account' => $account != null ? json_decode(stripslashes($account)) : '',
      'position' => stripslashes( get_option( 'cliengo_chatbot_position' ) )
    );

    echo stripslashes(json_encode($session));
    wp_die();
  }

  /**
   * Updates or clears the chabot token in DB
   */
  public function update_chatbot_token()
  {
    $response = $this->update_cliengo_option('cliengo_chatbot_token', $_POST['chatbot_token'])
      && $this->update_cliengo_option('cliengo_chatbot_position', $_POST['position_chatbot']);
    if ($_POST['chatbot_token'] == null) {
      // If it came null, remove script!
      unlink(plugin_dir_path( __FILE__ ) . '../public/js/script_install_cliengo.js');
    } else if ($response) {
      Cliengo_Form::create_install_code_cliengo($_POST['chatbot_token']);
    }

    echo $response;

    wp_die();
  }

  /**
   * Updates the chatbot position
   */
  public function update_chatbot_position()
  {
    echo $this->update_cliengo_option('cliengo_chatbot_position', $_POST['position_chatbot']);

    wp_die();
  }

  /**
   * Updates session (which is the response obtained from wordpress_login and wp_registration)
   */
  public function update_session()
  {
    $response = false;

    if (isset($_POST['chatbot_session'])) {
      $response = $this->update_cliengo_option('cliengo_session', $_POST['chatbot_session']);
    }

    echo $response;

    wp_die();
  }

  /**
   * Attempt to log in to Cliengo via the plugin's admin console.  Response will include company ID and website IDs so
   * the user can choose which website that the chatbot is being installed in.
   */
  public function wordpress_login()
  {
      $api_host = Cliengo_Form::PROD_ENV ? 'https://api.cliengo.com' : 'http://localhost:9000';
      $body = array('username' => $_POST['username'], 'password' => $_POST['password']);
      $api_response = wp_remote_request("$api_host/1.0/wordpress/login", array(
          'method' => 'POST',
          'headers' => array(
              'content-type' => 'application/json',
          ),
          'body' => wp_json_encode($body),
          'timeout' => 30 // Default is 5 seconds
      ));

      if ($api_response['response']['code'] == 200) {
          echo $api_response['body'];
          wp_die();
      } else {
          wp_die("Couldn't log in from the plugin", $api_response['response']['code']);
      }
  }

  /**
   * Updates or creates a WP option entry
   * @param $option - the option's (unique) name
   * @param $new_value - the option's value.
   * @return bool indicating if update was perform successfully or not
   */
  private function update_cliengo_option ($option, $new_value)
  {
    // Obtenemos opción existente.
    $current = get_option($option);

    $response = true;
    // Si la opción ya existe, la actualizamos.
    if ($current !== false)
    {
      if (strcmp($current, $new_value) !== 0)
        // Actualizamos si el valor actual de la opción es distinto al nuevo.
        $response = update_option($option, $new_value);
    }
    else
    {
      // Agregamos nueva opción.
      $response = add_option($option, $new_value);
    }

    return $response;
  }

  /**
   * Bundles the chatbot script installation code and writes it down to the public/js/script_install_cliengo.js file.
   *
   * @param $chatbot_token - the saved chatbot token.
   */
  public static function create_install_code_cliengo($chatbot_token)
  {
    $array_chatbot_token = explode('-',$chatbot_token); //esto se encarga de dividir el chatbot token
    // $array_chatbot_token[0] = Company ID
    // $array_chatbot_token[1] = Website ID
    $install_code_cliengo = '(function(){var ldk=document.createElement("script"); ldk.type="text/javascript";';
    $install_code_cliengo .= 'ldk.async=true; ldk.src="https://s.cliengo.com/weboptimizer/' . $array_chatbot_token[0] . '/';
    $install_code_cliengo .= $array_chatbot_token[1];
    $install_code_cliengo .= '.js?platform=wordpress"; var s=document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ldk, s);})();';

    // Eliminamos cualquier salto de línea posible
    $install_code_cliengo = str_replace(array("\r", "\n"), '', $install_code_cliengo);

    Cliengo_Form::write_to_file_install_code_cliengo_js($install_code_cliengo);
  }

  /**
   * Writes down the cliengo installation code into public/js/script_install_cliengo.js,
   * which then gets injected on every client side page rendering.
   * @param $install_code_cliengo
   */
  public static function write_to_file_install_code_cliengo_js($install_code_cliengo)
  {
    $ruta_install_code_cliengo_file = plugin_dir_path( __FILE__ ) . '../public/js/script_install_cliengo.js';

    $file_open = fopen($ruta_install_code_cliengo_file, 'w');

    fputs($file_open, $install_code_cliengo);

    fclose($file_open);
  }

  /**
   * Registers the user at Cliengo and obtains company and website from server response
   */
  public function wp_registration()
  {
    $api_host = Cliengo_Form::PROD_ENV ? 'https://api.cliengo.com' : 'http://localhost:9000';
    $body = array('username' => $_POST['username'],
      'email' => $_POST['email'],
      'password' => $_POST['password'],
      'sourceName' => $_POST['sourceName'],
      'accountName' => $_POST['accountName']
    );

    $api_response = wp_remote_request("$api_host/1.0/wordpress/signup", array(
      'method' => 'POST',
      'headers' => array(
        'content-type' => 'application/json',
      ),
      'body' => wp_json_encode($body),
      'timeout' => 30 // Default is 5 seconds
    ));
    echo $api_response['body'];
    wp_die('', $api_response['response']['code']);
  }
}

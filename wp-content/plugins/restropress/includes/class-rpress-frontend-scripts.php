<?php
/**
 * Handle frontend scripts
 *
 * @package RestroPress/Classes
 * @version 3.0
 */


if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Frontend scripts class.
 */
 class RP_Frontend_Scripts {


  /**
   * Contains an array of script handles registered by RP.
   *
   * @var array
   */
  private static $scripts = array();

  /**
   * Contains an array of script handles registered by RP.
   *
   * @var array
   */
  private static $styles = array();

  /**
   * Contains an array of script handles localized by RP.
   *
   * @var array
   */
  private static $wp_localize_scripts = array();

  /**
   * Hook in methods.
   */
  public static function init() {
    add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_scripts' ) );
  }


  /**
   * Return asset URL.
   *
   * @param string $path Assets path.
   * @return string
   */
  private static function get_asset_url( $path ) {
    return apply_filters( 'rpress_get_asset_url', plugins_url( $path, RP_PLUGIN_FILE ), $path );
  }

  /**
   * Register a script for use.
   *
   * @uses   wp_register_script()
   * @param  string   $handle    Name of the script. Should be unique.
   * @param  string   $path      Full URL of the script, or path of the script relative to the WordPress root directory.
   * @param  string[] $deps      An array of registered script handles this script depends on.
   * @param  string   $version   String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
   * @param  boolean  $in_footer Whether to enqueue the script before </body> instead of in the <head>. Default 'false'.
   */
  private static function register_script( $handle, $path, $deps = array( 'jquery' ), $version = RP_VERSION, $in_footer = true ) {
    self::$scripts[] = $handle;
    wp_register_script( $handle, $path, $deps, $version, $in_footer );
  }

  /**
   * Register and enqueue a script for use.
   *
   * @uses   wp_enqueue_script()
   * @param  string   $handle    Name of the script. Should be unique.
   * @param  string   $path      Full URL of the script, or path of the script relative to the WordPress root directory.
   * @param  string[] $deps      An array of registered script handles this script depends on.
   * @param  string   $version   String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
   * @param  boolean  $in_footer Whether to enqueue the script before </body> instead of in the <head>. Default 'false'.
   */
  private static function enqueue_script( $handle, $path = '', $deps = array( 'jquery' ), $version = RP_VERSION, $in_footer = true ) {
    if ( ! in_array( $handle, self::$scripts, true ) && $path ) {
      self::register_script( $handle, $path, $deps, $version, $in_footer );
    }
    wp_enqueue_script( $handle );
  }

  /**
   * Register a style for use.
   *
   * @uses   wp_register_style()
   * @param  string   $handle  Name of the stylesheet. Should be unique.
   * @param  string   $path    Full URL of the stylesheet, or path of the stylesheet relative to the WordPress root directory.
   * @param  string[] $deps    An array of registered stylesheet handles this stylesheet depends on.
   * @param  string   $version String specifying stylesheet version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
   * @param  string   $media   The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen', or media queries like '(orientation: portrait)' and '(max-width: 640px)'.
   * @param  boolean  $has_rtl If has RTL version to load too.
   */
  private static function register_style( $handle, $path, $deps = array(), $version = RP_VERSION, $media = 'all', $has_rtl = false ) {
    self::$styles[] = $handle;
    wp_register_style( $handle, $path, $deps, $version, $media );

    if ( $has_rtl ) {
      wp_style_add_data( $handle, 'rtl', 'replace' );
    }
  }

  /**
   * Register and enqueue a styles for use.
   *
   * @uses   wp_enqueue_style()
   * @param  string   $handle  Name of the stylesheet. Should be unique.
   * @param  string   $path    Full URL of the stylesheet, or path of the stylesheet relative to the WordPress root directory.
   * @param  string[] $deps    An array of registered stylesheet handles this stylesheet depends on.
   * @param  string   $version String specifying stylesheet version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
   * @param  string   $media   The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen', or media queries like '(orientation: portrait)' and '(max-width: 640px)'.
   * @param  boolean  $has_rtl If has RTL version to load too.
   */
  private static function enqueue_style( $handle, $path = '', $deps = array(), $version = RP_VERSION, $media = 'all', $has_rtl = false ) {
    if ( ! in_array( $handle, self::$styles, true ) && $path ) {
      self::register_style( $handle, $path, $deps, $version, $media, $has_rtl );
    }
    wp_enqueue_style( $handle );
  }

  /**
   * Register all RP scripts.
   */
  private static function register_scripts() {
    $suffix           = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

    $register_scripts = array(
      'rp-cookie'     => array(
        'src'     => self::get_asset_url( 'assets/js/frontend/rp-cookie.js' ),
        'deps'    => array( 'jquery' ),
        'version' => RP_VERSION,
      ),
      'sticky-sidebar'     => array(
        'src'     => self::get_asset_url( 'assets/js/sticky-sidebar/rpress-sticky-sidebar.js' ),
        'deps'    => array( 'jquery' ),
        'version' => '1.7.0',
      ),
      'timepicker'     => array(
        'src'     => self::get_asset_url( 'assets/js/timepicker/jquery.timepicker' . $suffix . '.js' ),
        'deps'    => array( 'jquery' ),
        'version' => '1.11.14',
      ),
      'jquery-payment' => array(
        'src'     => self::get_asset_url( 'assets/js/jquery.payment' . $suffix . '.js' ),
        'deps'    => array( 'jquery' ),
        'version' => '3.0.0',
      ),
      'jquery-creditcard-validator' => array(
        'src'     => self::get_asset_url( 'assets/js/jquery.creditCardValidator' . $suffix . '.js' ),
        'deps'    => array( 'jquery' ),
        'version' => '1.3.3',
      ),
      'jquery-chosen' => array(
        'src'     => self::get_asset_url( 'assets/js/jquery-chosen/chosen.jquery' . $suffix . '.js' ),
        'deps'    => array( 'jquery' ),
        'version' => '1.8.2',
      ),
      'jquery-flot' => array(
        'src'     => self::get_asset_url( 'assets/js/jquery-flot/jquery-flot' . $suffix . '.js' ),
        'deps'    => array( 'jquery' ),
        'version' => '0.7',
      ),
      'rp-frontend' => array(
        'src'     => self::get_asset_url( 'assets/js/frontend/rp-frontend.js' ),
        'deps'    => array( 'jquery', 'rp-cookie' ),  //'sticky-sidebar'
        'version' => RP_VERSION,
      ),
      'rp-live-search' => array(
        'src'     => self::get_asset_url( 'assets/js/frontend/live-search.js' ),
        'deps'    => array( 'jquery' ),
        'version' => RP_VERSION,
      ),
      'rp-quantity-changer' => array(
        'src'     => self::get_asset_url( 'assets/js/frontend/cart-quantity-changer.js' ),
        'deps'    => array( 'jquery' ),
        'version' => RP_VERSION,
      ),
      'rp-sticky-sidebar' => array(
        'src'     => self::get_asset_url( 'assets/js/frontend/rp-sticky-sidebar.js' ),
        'deps'    => array( 'jquery' ), //'sticky-sidebar'
        'version' => RP_VERSION,
      ),
      'rp-bootstrap-script' => array(
        'src'     => self::get_asset_url( 'assets/js/bootstrap/rp-bootstrap.js' ),
        'deps'    => array( 'jquery' ),
        'version' => RP_VERSION,
      ),

    );

    foreach ( $register_scripts as $name => $props ) {
      self::register_script( $name, $props['src'], $props['deps'], $props['version'] );
    }
  }

  /**
   * Register all RP styles.
   */
  private static function register_styles() {
    $register_styles = array(
      'jquery-chosen'                  => array(
        'src'     => self::get_asset_url( 'assets/css/chosen/chosen.css' ),
        'deps'    => array(),
        'version' => RP_VERSION,
        'has_rtl' => false,
      ),
      'frontend-icons'                  => array(
        'src'     => self::get_asset_url( 'assets/css/frontend-icons.css' ),
        'deps'    => array(),
        'version' => RP_VERSION,
        'has_rtl' => false,
      ),
    );
    foreach ( $register_styles as $name => $props ) {
      self::register_style( $name, $props['src'], $props['deps'], $props['version'], 'all', $props['has_rtl'] );
    }
  }

  /**
   * Register/queue frontend scripts.
   */
  public static function load_scripts() {
    global $post;

    self::register_scripts();
    self::register_styles();

    $in_footer = rpress_scripts_in_footer();

    if ( rpress_is_checkout() ) {
      if ( rpress_is_cc_verify_enabled() ) {
        self::enqueue_script( 'jquery-creditcard-validator' );
        self::enqueue_script( 'jquery-payment' );
      }
    }

    self::enqueue_script( 'sticky-sidebar' );
    self::enqueue_script( 'timepicker' );
    self::enqueue_script( 'checkout' );
    self::enqueue_script( 'jquery-chosen' );
    self::enqueue_script( 'rp-cookie' );
    self::enqueue_script( 'rp-frontend' );
    self::enqueue_script( 'rp-live-search' );
    self::enqueue_script( 'rp-quantity-changer' );
    self::enqueue_script( 'rp-sticky-sidebar' );

    if ( rpress_get_option( 'use_external_bootstrap_script') !== '1' ) {
      wp_enqueue_script( 'rp-bootstrap-script' );
    }

    $add_to_cart    = apply_filters( 'rp_add_to_cart', __( 'Add To Cart', 'restropress' ) );
    $update_cart    = apply_filters( 'rp_update_cart', __( 'Update Cart', 'restropress' ) );
    $added_to_cart  = apply_filters( 'rp_added_to_cart', __( 'Added To Cart', 'restropress' ) );
    $please_wait_text = __( 'Please Wait...', 'restropress' );

    $color = rpress_get_option( 'checkout_color', 'red' );
    $service_options = !empty( rpress_get_option( 'enable_service' ) ) ? rpress_get_option( 'enable_service' ) : 'delivery_and_pickup' ;
    $minimum_order_error_title = !empty( rpress_get_option( 'minimum_order_error_title' ) ) ? rpress_get_option( 'minimum_order_error_title' ) : 'Minimum Order Error' ;
    $service_change_text = apply_filters( 'rp_service_change_text', 'Change?' );

    $params = array(
      'estimated_tax'        => rpress_get_tax_name(),
      'total_text'           => __( 'Subtotal', 'restropress'),
      'ajaxurl'              => rpress_get_ajax_url(),
      'show_products_nonce'  => wp_create_nonce( 'show-products' ),
      'add_to_cart'          => $add_to_cart,
      'update_cart'          => $update_cart,
      'added_to_cart'        => $added_to_cart,
      'please_wait'          => $please_wait_text,
      'at'                   => __( 'at', 'restropress' ),
      'color'                => $color,
      'service_change_text'  => $service_change_text,
      'checkout_page'        => rpress_get_checkout_uri(),
      'add_to_cart_nonce'    => wp_create_nonce( 'add-to-cart' ),
      'service_type_nonce'   => wp_create_nonce( 'service-type' ),
      'service_options'      => $service_options,
      'minimum_order_title'      => $minimum_order_error_title,
      'edit_cart_fooditem_nonce' => wp_create_nonce( 'edit-cart-fooditem' ),
      'update_cart_item_nonce'   => wp_create_nonce( 'update-cart-item' ),
      'clear_cart_nonce'         => wp_create_nonce( 'clear-cart' ),
      'update_service_nonce'     => wp_create_nonce( 'update-service' ),
      'proceed_checkout_nonce'   => wp_create_nonce( 'proceed-checkout' ),
      'error'                    => __( 'Error', 'restropress' ),
      'change_txt'              => __( 'Change?', 'restropress' ),
    );

    wp_localize_script( 'rp-frontend', 'rp_scripts', $params );

    // CSS Styles.
    $enqueue_styles = self::get_styles();
    if ( $enqueue_styles ) {
      foreach ( $enqueue_styles as $handle => $args ) {
        if ( ! isset( $args['has_rtl'] ) ) {
          $args['has_rtl'] = false;
        }
        self::enqueue_style( $handle, $args['src'], $args['deps'], $args['version'], $args['media'], $args['has_rtl'] );
      }
    }
  }

  /**
   * Get styles for the frontend.
   *
   * @return array
   */
  public static function get_styles() {
    return apply_filters( 'rpress_enqueue_styles',
      array(
        'rpress-frontend-icons'      => array(
            'src'     => self::get_asset_url( 'assets/css/frontend-icons.css' ),
            'deps'    => '',
            'version' => RP_VERSION,
            'media'   => 'all',
            'has_rtl' => false,
        ),

        'rp-bootstrap-styles'         => array(
          'src'     => self::get_asset_url( 'assets/css/rpress-bootstrap.css' ),
          'deps'    => array(),
          'version' => RP_VERSION,
          'media'   => 'all',
          'has_rtl' => false,
        ),

        'rp-frontend-styles'         => array(
          'src'     => self::get_asset_url( 'assets/css/rpress.css' ),
          'deps'    => array(),
          'version' => RP_VERSION,
          'media'   => 'all',
          'has_rtl' => false,
        ),
      )
    );
  }

}

 RP_Frontend_Scripts::init();

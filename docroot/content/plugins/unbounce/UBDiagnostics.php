<?php

class UBDiagnostics {

  const SUPPORTED_PHP_VERSION = '5.3';
  const SUPPORTED_WP_VERSION = '4.0';

  public static function working() {
    return !in_array(false, UBDiagnostics::checks());
  }

  public static function checks($domain, $domain_info) {
    return array(
      'Curl Support'                => function_exists('curl_init'),
      'Permalink Structure'         => get_option('permalink_structure', '') !== '',
      'Domain is Authorized'        => UBConfig::is_authorized_domain($domain),
      'Can Fetch Page Listing'      => UBDiagnostics::last_status_success($domain_info),
      'Supported PHP Version'       => version_compare(phpversion(),
                                                       UBDiagnostics::SUPPORTED_PHP_VERSION,
                                                       '>='),
      'Supported Wordpress Version' => version_compare(UBDiagnostics::wordpress_version(),
                                                       UBDiagnostics::SUPPORTED_WP_VERSION,
                                                       '>=')
    );
  }

  public static function details($domain, $domain_info) {
    return array(
      'PHP Version'             => phpversion(),
      'WordPress Version'       => UBDiagnostics::wordpress_version(),
      'Unbounce Plugin Version' => "1.0.18",
      'Permalink Structure'     => get_option('permalink_structure', ''),
      'Domain'                  => $domain,
      'Domain Authorized'       => print_r(UBConfig::is_authorized_domain($domain), true),
      'Has Authorized'          => print_r(UBConfig::has_authorized(), true),
      'Active Plugins'          => print_r(get_option('active_plugins'), true),
      'Plugin Details'          => print_r(get_plugins(), true),
      'Curl Version'            => UBDiagnostics::curl_version(),
      'Configuration Options'   => print_r(ini_get_all(), true),
      'Extensions'              => print_r(get_loaded_extensions(), true),
      'Operating System'        => php_uname(),
      'Checks'                  => print_r(UBDiagnostics::checks($domain, $domain_info), true),
      'Options'                 => print_r(UBDiagnostics::ub_options(), true)
    );
  }

  private static function ub_options() {
    $option_values = array_map(function($key) {
      return get_option($key);
    }, UBConfig::ub_option_keys());

    # Return an array where the key is the option key and the value
    # the option value:
    # array('ub-option-key' => 'option value')
    return array_combine(UBConfig::ub_option_keys(), $option_values);
  }

  private static function curl_version() {
    if(function_exists('curl_version')) {
      return print_r(curl_version(), true);
    } else {
      return 'N/A';
    }
  }

  private static function wordpress_version() {
    global $wp_version;
    include(ABSPATH . WPINC . '/version.php');
    return $wp_version;
  }

  private static function last_status_success($domain_info) {
    $last_status = UBUtil::array_fetch($domain_info, 'last_status');
    return $last_status !== null && $last_status !== 'FAILURE';
  }

}
?>
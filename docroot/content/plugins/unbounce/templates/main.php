<?php
echo '<div class="ub-plugin-wrapper>';

$is_authorized = UBConfig::is_authorized_domain($domain);
$diagnostics_failed = in_array(false, UBDiagnostics::checks($domain, $domain_info));

echo UBTemplate::render('main_header',
                        array('img_url' => plugins_url('img/unbounce-logo-blue.png', __FILE__),
                              'is_authorized' => $is_authorized,
                              'authorization' => UBUtil::get_flash('authorization'),
                              'diagnostics_failed' => $diagnostics_failed));

if($is_authorized) {
  $proxyable_url_set = UBUtil::array_fetch($domain_info, 'proxyable_url_set', array());
  $proxyable_url_set_fetched_at = UBUtil::array_fetch($domain_info, 'proxyable_url_set_fetched_at');
  $last_refreshed = UBUtil::time_ago($proxyable_url_set_fetched_at);
  echo UBTemplate::render('main_authorized',
                          array('domain' => $domain,
                                'proxyable_url_set' => $proxyable_url_set,
                                'last_refreshed' => $last_refreshed));

  add_action('in_admin_footer', function() {
    echo UBTemplate::render('main_authorized_footer');
  });
} else {
  if (UBConfig::has_authorized()) {
    // They've attempted to authorize, but this domain isn't in the list
    echo UBTemplate::render('main_failed_authorization', array('domain' => $domain));
  } else {
    echo UBTemplate::render('main_unauthorized', array('domain' => $domain));
  }

  add_action('in_admin_footer', function() {
    echo UBTemplate::render('main_unauthorized_footer');
  });
}

echo '</div>';
?>
<div class="ub-plugin-wrapper">
  <img class="ub-logo" src="<?php echo $img_url; ?>" />
  <h1 class="ub-unbounce-pages-heading">Unbounce Pages Diagnostics</h1>
  <a href="<?php echo admin_url('admin.php?page=unbounce-pages'); ?>">Main Plugin Page</a>
  <br/>
  <ul class="ub-diagnostics-checks">
  <?php foreach($checks as $check => $success) { ?>
    <?php $css_class = ($success ? 'dashicons-yes' : 'dashicons-no-alt'); ?>
      <li>
        <span class='dashicons <?php echo $css_class; ?>'></span>
        <?php echo $check; ?>
        <?php if(!$success) { ?>
          <?php switch($check) {
            case 'Curl Support': ?>
              <p class="ub-diagnostics-check-description">
                Curl is not currently enabled, please contact your hosting provider or IT professional to enable Curl support.
              </p>
            <?php break; ?>
            <?php case 'Permalink Structure': ?>
              <p class="ub-diagnostics-check-description">
                By default WordPress uses web URLs which have question marks
                and lots of numbers in them; however, this default structure
                will not work with the Unbounce Plugin. Please update your
                <a href="<?php echo $permalink_url; ?>">WordPress Permalink
                Structure</a> and change to anything other than the default
                WordPress setting.
              </p>
            <?php break; ?>
            <?php case 'Domain is Authorized': ?>
              <p class="ub-diagnostics-check-description">
                Your Domain (<?php echo $domain ?>) needs to be added to your
                Unbounce account, please return to the main plugin page, select
                "Add My Domain In Unbounce". After adding your domain in
                Unbounce, return to the main plugin page and select the "Update
                WordPress Enabled Domains".
              </p>
            <?php break; ?>
            <?php case 'Can Fetch Page Listing': ?>
              <p class="ub-diagnostics-check-description">
                We are unable to fetch the page listing from Unbounce, please
                contact your hosting provider or IT professional to ensure Curl
                Supported is installed and enabled.
              </p>
              <?php if($curl_error_message) { ?>
                <p class="ub-diagnostics-check-description"><?php echo $curl_error_message; ?></p>
              <?php } ?>
            <?php break; ?>
            <?php case 'Supported PHP Version': ?>
              <p class="ub-diagnostics-check-description">
                The Unbounce Pages plugin is supported when using PHP version
                5.3 or higher, please contact your hosting provider or IT
                professional and update to a supported version.
              </p>
            <?php break; ?>
            <?php case 'Supported Wordpress Version': ?>
              <p class="ub-diagnostics-check-description">
                The Unbounce Pages plugin is supported on WordPress versions 4.0
                and higher, please contact your hosting provider or IT
                professional and update to a supported version.
              </p>
            <?php break; ?>
          <?php } ?>
        <?php } ?>
      </li>
  <?php } ?>
  </ul>

  <h2>Details</h2>
  <p>
    If you are experiencing problems with the Unbounce Pages plugin, or if the problem
    continues to persist after all checks have passed, please email the following details
    to <a href="mailto:support@unbounce.com">support@unbounce.com</a>. If possible,
    please also provide details on your hosting provider.
  </p>
  <textarea id="ub-diagnostics-text" rows="10" cols="100">
  <?php foreach($details as $detail_name => $detail) { ?>
    <?php echo "[${detail_name}] ${detail}\n"; ?>
  <?php } ?>
  </textarea>
  <div id="ub-diagnostics-copy-result"></div>
  <?php echo get_submit_button('Copy to Clipboard',
                               'primary',
                               'ub-diagnostics-copy',
                               false,
                               array('data-clipboard-target' => '#ub-diagnostics-text')); ?>
</div>

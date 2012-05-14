<?php

// further configure Drupal for development

// add some permissions to the anonymous user, easier for testing
// yes, this is unsafe, but this method of installing is only intended
// for local development, not to deploy on staging/production!
user_role_grant_permissions(1, array('access devel information',
                                     'access environment indicator',));

// try to add the environment indicator config to the settings.php
$settingsphp = conf_path().'/settings.php';
require_once($settingsphp);

global $conf;
if (empty($conf['environment_indicator_text'])) {
  echo "$settingsphp is not configured for environment_indicator. Trying to add config...";
  $do_chmod = FALSE;

  if (!is_writable($settingsphp)) {
    $do_chmod = TRUE;
    chmod($settingsphp, 0666);
  }

  $fh = fopen($settingsphp, 'a');
  if ($fh === FALSE) {
    echo "Could not open $settingsphp";
  } else {
    fwrite($fh, '$conf[\'environment_indicator_text\'] = \'LOCAL      LOCAL      LOCAL      LOCAL      LOCAL      LOCAL      \';'."\n");
    fwrite($fh, '$conf[\'environment_indicator_color\'] = \'green\';'."\n");
    fclose($fh);

    if ($do_chmod) {
      chmod($settingsphp, 0444);
    }
    echo "...success\n";
  }
}


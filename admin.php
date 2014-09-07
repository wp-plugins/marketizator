<?php
add_action('admin_menu', 'mktz_admin_menu');
add_filter('plugin_action_links', 'mktz_plugin_action_links', 10, 2 );
mktz_warnings();

function mktz_nonce_field($action = -1) { return wp_nonce_field($action); }
$mktz_nonce = 'mktz-update-code';

function mktz_plugin_action_links( $links, $file ) {
  if ( $file == plugin_basename( dirname(__FILE__).'/marketizator.php' ) ) {
    $links[] = '<a href="plugins.php?page=marketizator-config">'.__('Settings').'</a>';
  }

  return $links;
}

function mktz_conf() {
  global $mktz_nonce;

  if ( isset($_POST['submit']) ) {
    if ( function_exists('current_user_can') && !current_user_can('manage_options') )
      die(__('Cheatin&#8217; uh?'));

    check_admin_referer( $mktz_nonce );
    $tracking_code = htmlentities(stripslashes($_POST['tracking_code']));

    if ( empty($tracking_code) ) {
      $ms = 'new_code_empty';
      delete_option('mktz_code');
    } else {
      update_option('mktz_code', $tracking_code);
      $ms = 'new_code_saved';
    }

  }

  $messages = array(
    'new_code_empty' => 'Please enter a tracking code to activate Marketizator on this site.',
    'new_code_saved' => 'Your tracking code has been saved. Go with Marketizator!',
    'code_empty' => 'Please enter your tracking code.'
  );
?>
<?php if ( !empty($_POST['submit'] ) ) : ?>
<div id="message" class="updated fade">
  <p>
    <?php _e('<strong>Configuration saved.</strong><br \>'.$messages[$ms]) ?>
  </p>
</div>
<?php endif; ?>
<div class="wrap">
  <h2><?php _e('Marketizator Configuration'); ?></h2>
  <div class="narrow">
    <form action="" method="post" id="mktz-conf">
      <h3>What is Marketizator</h3>
      <p><a href="http://www.marketizator.com" target="_blank">Marketizator</a> is the simplest way to convert your visitors into prospective customers or buyers. It helps increase your conversion or subscription rate.</p>
      <h3>Register now</h3>
      <p>Create an account at <a href="http://www.marketizator.com" target="_blank">marketizator.com</a> and start have fun (and more money) with your website today! After creating an account you can come back to this configuration page and set up your WordPress website to use Marketizator.</p>
      <h3>The magical piece of code</h3>
      <p>Go to <a href="http://web.marketizator.com">marketizator.com/app</a>, make sure you've selected the right website (on the left) and click on &lt;Tracking code&gt;. You can then paste the code in the box below.</p>
      <label for="tracking_code" style="font-weight:bold;">Paste your tracking code:</label>
	  <textarea id="tracking_code" name="tracking_code" style="width:100%; height:80px;"><?php echo get_option('mktz_code'); ?></textarea>
      <?php mktz_nonce_field($mktz_nonce) ?>
      <p class="submit"><input type="submit" name="submit" value="<?php _e('Save configuration &raquo;'); ?>" /></p>
    </form>
  </div>
</div>
<?php
}

function mktz_warnings() {
  if ( !get_option('mktz_code') && !isset($_POST['submit']) ) {
    function mktz_warning() {
      echo "
      <div id='mktz-warning' class='updated fade'><p><strong>".__('Marketizator is almost ready.')."</strong> ".sprintf(__('You must <a href="%1$s">enter your Marketizator tracking code</a> to begin using Marketizator on your site.'), "plugins.php?page=marketizator-config")."</p></div>";
    }
    add_action('admin_notices', 'mktz_warning');
    return;
  } 
}

function mktz_admin_menu() {
	add_submenu_page('plugins.php', __('Marketizator'), __('Marketizator'), 'manage_options', 'marketizator-config', 'mktz_conf');
}


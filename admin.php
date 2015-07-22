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
    'new_code_saved' => 'Your tracking code has been saved. You\'re ready to go!',
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

<div class="wrap" id="sm_div">
		
	<a href="http://www.marketizator.com" target="_blank"><img src="<?php echo plugins_url('logo.png', __FILE__) ?>"/></a>
				
	<div id="poststuff" class="metabox-holder has-right-sidebar">
		<div class="inner-sidebar">
			<div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">
            
                <a href="http://web.marketizator.com/experiments/new" style="display:block; background:#13AB84; color:white; padding:10px 10px; border-radius:5px; font-size:18px; text-decoration:none;" target="_blank">New experiment</a>
                
                <a href="http://web.marketizator.com" style="margin-top:8px; color:#2084B4; display:block;"><b>View experiments</b></a>
                <br />
				<div class="postbox">
					<h3 class="hndle"><span>Ran out of testing ideas?</span></h3>
					<div class="inside">
						<iframe width="260" height="140" src="https://www.youtube.com/embed/9evyF_IiJ_A?rel=0&amp;showinfo=0&amp;controls=0" frameborder="0" allowfullscreen></iframe>
					   
                        <iframe width="260" height="140" src="https://www.youtube.com/embed/fD6fzQpC0ZE?rel=0&amp;showinfo=0&amp;controls=0" frameborder="0" allowfullscreen></iframe>
                    </div>
				</div>
                
                <div class="postbox">
					<h3 class="hndle"><span>Are you stuck?</span></h3>
					<div class="inside">
                        <a href="http://help.marketizator.com">Knowledge base</a>
					</div>
				</div>
			</div>
		</div>
					
		<div class="has-sidebar sm-padded">
			<div id="post-body-content" class="has-sidebar-content">
				<div class="meta-box-sortabless">

                    <div class="postbox">
						<h3 class="hndle"><span>1. Get started</span></h3>
						<div class="inside" style="font-size: 14px;">
							<a href="https://www.marketizator.com" target="_blank">Create an account</a> and start converting more of your traffic today.
						</div>
					</div>
                    
                     <div class="postbox">
						<h3 class="hndle"><span>2. Install the magical piece of code</span></h3>
						<div class="inside" style="font-size: 14px;">
                        <form action="" method="post" id="mktz-conf">
							<p>Go to <a href="http://web.marketizator.com/website/code">web.marketizator.com</a>, make sure you've selected the right website (on the left) and click on &lt;Tracking code&gt;. You can then paste the code in the box below.</p>
                              <label for="tracking_code" style="font-weight:bold;">Paste your tracking code:</label>
                        	  <textarea id="tracking_code" name="tracking_code" style="margin-top:5px; width:100%; height:80px;"><?php echo get_option('mktz_code'); ?></textarea>
                              <?php mktz_nonce_field($mktz_nonce) ?>
                              <p class="submit" style="margin: 5px 0px; padding:0px;"><input type="submit" name="submit" value="<?php _e('Save configuration &raquo;'); ?>" /></p>
						 </form>
                        </div>
					</div>
                    
                    <div class="postbox">
						<h3 class="hndle"><span>3. Run your first experiment</span></h3>
						<div class="inside" style="font-size: 14px;">
							<a href="http://web.marketizator.com" target="_blank">Use the dashboard</a> and create your first experiment.
						</div>
					</div>

				</div>
					

			</div>
		</div>
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


<?php
/*
    Tools - Leaflet Maps Marker Plugin
*/
//info prevent file from being accessed directly
if (basename($_SERVER['SCRIPT_FILENAME']) == 'tpg-settings.php') { die ("Please do not access this file directly. Thanks!"); }
?>
<div class="wrap">
<?php
$action = isset($_POST['action']) ? $_POST['action'] : '';
if (!empty($action)) {
	$tpgnonce = isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : (isset($_GET['_wpnonce']) ? $_GET['_wpnonce'] : '');
	if (! wp_verify_nonce($tpgnonce, 'tpg-nonce') ) { die('<br/>Security check failed - please call this function from the according admin page!'); };
	if ($action == 'change_status') {
		$tpg_new_status = isset($_POST['input_change_status']) ? '1' : '0';
		if ( $tpg_new_status == 1) {
			update_option('tpg_status', 'enabled');
		} else if ( $tpg_new_status == 0) {
			update_option('tpg_status', 'disabled');
		}
		echo '<p><div class="updated" style="padding:10px;">Der Status wurde erfolgreich geändert!</p></div><a class="button-secondary" href="' . TPG_WP_ADMIN_URL . 'options-general.php?page=tpg_settings_page">Zurück zur Einstellungsseite</a>';  
  }
} else {
?>
<h3 style="font-size:23px;">Transparenzgesetz.at</h3>
<p>
Plugin, um ein "Eselsohr" auf Ihrer Webseite anzuzeigen, welches zur Petition auf <a href="https://www.transparenzgesetz.at" target="_blank">https://www.transparenzgesetz.at</a> verlinkt.
<br/><br/>
Bitte geben Sie uns Ihre Webseite auch <a href="https://www.transparenzgesetz.at/teilnehmende-webseite-melden" target="_blank">über dieses Formular</a> an uns senden, damit wir Ihre Webseite zur <a href="https://www.transparenzgesetz.at/banner-webseiten" target="_blank">Liste der teilnehmenden Webseiten</a> hinzufügen können.<br/>
Danke!
</p>
<?php $nonce= wp_create_nonce('tool-nonce'); ?>
<form method="post">
<input type="hidden" name="action" value="change_status" />
<?php wp_nonce_field('tpg-nonce'); ?>

<?php $nonce= wp_create_nonce('tpg-nonce'); ?>
<table class="widefat fixed" style="width:auto;">
	<tr style="background-color:#efefef;">
		<td colspan="3"><strong>Bitte Checkbox aktivieren und speichern!</strong></td>
	</tr>
	<tr>
		<td>
		<form method="post">
		<input type="hidden" name="action" value="change_status" />
		<?php wp_nonce_field('tpg-nonce'); ?>
		</td>
		<td>
		<?php
		$tpg_status = get_option('tpg_status');
		?>
		<input id="input_change_status" type="checkbox" name="input_change_status" <?php checked($tpg_status, 'enabled'); ?>>
		</td>
		<td style="vertical-align:middle;">
		<input style="font-weight:bold;" class="submit button-primary" type="submit" name="submit" value="Status ändern &raquo;" />
		</form>
		</td>
	</tr>
</table>
</form>
</div>
<!--wrap--> 
<?php
}
?>
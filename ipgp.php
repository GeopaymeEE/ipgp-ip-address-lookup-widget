<?php
/*
Plugin Name: Ipgp ip address lookup
Plugin URI: http://www.ipgp.net
Description: Find information about ip address.
Author: Lucian Apostol
Version: 0.3
Author URI: http://www.ipgp.net
*/

add_action('admin_menu', 'create_ipgp_menu');
add_action('admin_init', 'ipgp_actions');

function ipgpFunction() 
{

if($_POST['ipgpvalue']) { 
	
	
	$ipgpip = $_POST['ipgpvalue'];

$ip = $ipgpip;

if(get_option('ipgp_api_key')) $api_key = get_option('ipgp_api_key');
else $api_key = 'wordpressplugin';

$file = "http://www.ipgp.net/api/xml/". $ip ."/".$api_key."";

$iplookup = simplexml_load_file($file);


// The returned data is an object, you can type print_r($iplookup) at the end of the code to see the object content. 


}
  ?>


	<form id="ipgpform" method="post">
		<input type="text" name="ipgpvalue" id="ipgpvalue" size="12" value="<?=$_POST['ipgpvalue']?>" />
		<input type="submit" name="submit" id="submit" value="Go" />
		<div id="ipgpresults">
			<?php if($_POST['ipgpvalue']) { ?><div id="ipgpcountry">Country: <?=$iplookup->Country?></div>
			<div id="ipgpcity">City <?=$iplookup->City?></div>
			<div id="ipgpregion">State: <?=$iplookup->Region?></div>
			<div id="ipgpisp">Isp: <?=$iplookup->Isp?></div> <?php } ?>
		</div>
	</form>

  <?
}

function ipgpWidget($args) {

	 extract($args);
	 echo $before_widget;
	  echo $before_title;?>Ip address lookup<?php echo $after_title;
	 ipgpFunction();
	 echo $after_widget;
}

function iplookup_shortcode( $atts ) {
	
	return ipgpFunction();

}

function create_ipgp_menu() {

			add_options_page(__('IPGP IP Lookup', 'ipgp_admin_page'), __('IPGP IP Lookup', 'ipgp_admin_page')	, 10, basename(__FILE__), 'ipgp_admin' );

}

function ipgp_admin() {
$content = '<div style="margin: 25px 0 0 25px;"><h1>IPGP Lookup Plugin</h1><br>Hello! to get your own API Key <a href="http://www.ipgp.net/get-api-key/">CLICK HERE</a>.<br>
<form name="ipgp_admin_menu_form" action="" method="post">
Insert you API Key here : <input type="text" name="ipgp_api" value="'.get_option('ipgp_api_key').'" /><br>
<input type="submit" name="Submit" value="Submit" />
</form>
</div>
';
echo $content;
}

function ipgp_actions() {
if($_POST['ipgp_api'])
if(!get_option('ipgp_api_key'))
add_option( 'ipgp_api_key', ''.$_POST['ipgp_api'].'', '', 'yes' );
else update_option('ipgp_api_key',$_POST['ipgp_api']);
}

function ipgpInit()
{
  register_sidebar_widget(__('Ip lookup'), 'ipgpWidget');  
  add_shortcode( 'iplookup', 'iplookup_shortcode' );
}


add_action("plugins_loaded", "ipgpInit");
?>
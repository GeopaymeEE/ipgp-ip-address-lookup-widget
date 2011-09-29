<?php
/*
Plugin Name: Ipgp ip address lookup
Plugin URI: http://www.ipgp.net
Description: Find information about ip address.
Author: Lucian Apostol
Version: 0.3
Author URI: http://www.ipgp.net
*/


function ipgpFunction() 
{

if($_POST['ipgpvalue']) { 
	
	
	$ipgpip = $_POST['ipgpvalue'];

$ip = $ipgpip;



$file = "http://www.ipgp.net/api/xml/". $ip ."/wordpressplugin";

$iplookup = simplexml_load_file($file);


// The returned data is an object, you can type print_r($iplookup) at the end of the code to see the object content. 


}
  ?>


	<form id="ipgpform" method="post">
		<input type="text" name="ipgpvalue" id="ipgpvalue" size="12" value="<?=$_POST['ipgpvalue']?>" />
		<input type="submit" name="submit" id="submit" value="Go" />
		<div id="ipgpresults">
			<div id="ipgpcountry">Country: <?=$iplookup->Country?></div>
			<div id="ipgpcity">City <?=$iplookup->City?></div>
			<div id="ipgpregion">State: <?=$iplookup->Region?></div>
			<div id="ipgpisp">Isp: <?=$iplookup->Isp?></div>
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




function ipgpInit()
{
  register_sidebar_widget(__('Ip lookup'), 'ipgpWidget');  
  add_shortcode( 'iplookup', 'iplookup_shortcode' );
}


add_action("plugins_loaded", "ipgpInit");
?>
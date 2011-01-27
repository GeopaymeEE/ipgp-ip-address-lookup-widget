<?php
/*
Plugin Name: Ipgp ip address lookup
Plugin URI: http://www.ipgp.net
Description: Find information about ip address.
Author: Lucian Apostol
Version: 0.3
Author URI: http://www.ipgp.net
*/


function iplookup_contents($parser, $data){ 
	global $predata;
	if($data) {
		$predata[] = $data; 
	 }
} 

function iplookup_startTag($parser, $data){ 
    echo ""; 
} 

function iplookup_endTag($parser, $data){ 
    echo ""; 
} 

function ipgpFunction() 
{

if($_POST['ipgpvalue']) { 
	
	
	$ipgpip = $_POST['ipgpvalue'];

$ip = $ipgpip;



$file = "http://www.ipgp.net/api/xml/". $ip;

global $predata;


$xml_parser = xml_parser_create(); 

xml_set_element_handler($xml_parser, "", ""); 

xml_set_character_data_handler($xml_parser, "iplookup_contents"); 

$fp = fopen($file, "r"); 

$data = fread($fp, 80000); 

if(!(xml_parse($xml_parser, $data, feof($fp)))){ 
    die("Error on line " . xml_get_current_line_number($xml_parser)); 
} 

xml_parser_free($xml_parser); 

fclose($fp); 


// The returned data is an array, you can type print_r($iplookup) at the end of the code to see the array. 

	$iplookup['ip']=$predata[1];
	$iplookup['code']=$predata[3];
	$iplookup['country']="Country:" . $predata[5];
	$iplookup['flag']=$predata[7];
	$iplookup['city']="City:" . $predata[9];
	$iplookup['region']="Region:" . $predata[11];
	$iplookup['isp']="Isp:" . $predata[13];
	$iplookup['latitude']=$predata[15];
	$iplookup['longitude']=$predata[17];


}
  ?>


	<form id="ipgpform" method="post">
		<input type="text" name="ipgpvalue" id="ipgpvalue" size="12" value="<?=$_POST['ipgpvalue']?>" />
		<input type="submit" name="submit" id="submit" value="Go" />
		<div id="ipgpresults">
			<div id="ipgpcountry"><?=$iplookup['country']?></div>
			<div id="ipgpcity"><?=$iplookup['city']?></div>
			<div id="ipgpregion"><?=$iplookup['region']?></div>
			<div id="ipgpisp"><?=$iplookup['isp']?></div>
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
<?php

/*
Plugin Name: Plus 1 - Google +1 Button
Plugin URI: http://www.bigdatatoolkit.org/
Description: Allows users to add +1 buttons to thier blogs
Version: 1.2
Author: Steven Gray
Author URI: http://www.stevenjamesgray.com	
License:GPL2
*/

/*  Copyright 2011  Steven James Gray  (email : steve@stevenjamesgray.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

/*************************************************/
 
// Setting constants
 
// DEBUG constant for developing
// if you are hacking this plugin, set to TRUE, a log will show in admin pages
define('DEBUG', true);    
 
// fix all superglobals
if (get_magic_quotes_gpc()) {
    $_GET = array_map('stripslashes_deep', $_GET);
    $_POST = array_map('stripslashes_deep', $_POST);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
    $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}


/*************************************************/

function addBaseJavascript(){
	echo "<script type=\"text/javascript\" src=\"http://apis.google.com/js/plusone.js\"></script>";
}

function addPlus1($atts){
	global $wpdb;   
        extract(shortcode_atts(array('size' => 'standard', 'url' => ''), $atts));

	if($url != ""){
		$urlPath = "href=\"".$url."\"";
	}
	
	switch ($size){
		case "small":
			$s .= "<g:plusone size=\"small\"".$urlPath."></g:plusone>";
			break;
		case "medium":
                        $s .= "<g:plusone size=\"medium\"".$urlPath."></g:plusone>";
                        break; 
		case "standard":
                        $s .=  "<g:plusone ".$urlPath."></g:plusone>";
                        break; 
		case "tall":
                        $s .= "<g:plusone size=\"tall\" ".$urlPath."></g:plusone>";
                        break; 
		default:
                        $s .= "<g:plusone ".$urlPath."></g:plusone>";
                        break; 
	}

	return $s;
}

function addAtEndPost ($content) {
	$url = get_permalink();

	$array = array('url' => $url);
	$content = $content.addPlus1($array);
	return $content;

}

/********   PRIVATE FUNCTIONS **********************/


add_action('wp_footer', 'addBaseJavascript');
add_shortcode('plus1', 'addPlus1');
add_filter('the_content', 'addAtEndPost' );

?>

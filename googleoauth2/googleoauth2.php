<?php
/**
 * Addon Module Sample File
 *
 * This example addon module demonstrates all the functions an addon module can contain.
 * Please refer to the full documentation @ http://docs.whmcs.com/Addon_Modules for more details.
 *
 * @package    WHMCS
 * @author     WHMCS Limited <development@whmcs.com>
 * @copyright  Copyright (c) WHMCS Limited 2005-2013
 * @license    http://www.whmcs.com/license/ WHMCS Eula
 * @version    $Id$
 * @link       http://www.whmcs.com/
 */

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

function googleoauth2_config() {



    $configarray = array(
    "name" => "Google OAuth 2.0",
    "description" => "OAuth 2.0 allows applications to access your data on your behalf using tokens",
    "version" => "1.0",
    "author" => "LA Tech Guys",
    "language" => "english",
    "fields" => array(
        "client_id" => array ("FriendlyName" => "Client ID", "Type" => "text", "Size" => "50", "Description" => "Get one here: https://code.google.com/apis/console" , ),
        "client_secret" => array ("FriendlyName" => "Client Secret", "Type" => "password", "Size" => "50", "Description" => "Get one here: https://code.google.com/apis/console"  ),
        "redirect_uri" => array ("FriendlyName" => "Redirect URI", "Type" => "text", "Size" => "135", "disabled" => "true" , "Description" => 'Set your web applications OAuth Redirect URI to this', "Default" => 'https://'.$_SERVER["HTTP_HOST"].'/modules/addons/googleoauth2/oauth_callback.php' , ),

    ));


    return $configarray;
}

// generate randomg number 
function googleoauth2_generateRandomString($length = 15) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

function googleoauth2_activate() {



$query = "CREATE TABLE `mod_googleoauth2` (`id` INT( 3 ) NOT NULL AUTO_INCREMENT PRIMARY KEY , `access_token` TEXT,`refresh_token` TEXT,`token_type` TEXT,`expires_in` TEXT,`id_token` TEXT,`created` TEXT )";
$result = mysql_query($query);



// this value is passed to google and returned back to us in the response. we check this against the incoming request to make sure it is coming from google
$table = "tbladdonmodules";
$values = array("module"=>"googleoauth2","setting"=>"state","value"=> googleoauth2_generateRandomString());
insert_query($table,$values);


    return array('status'=>'success','description'=>'Google OAuth 2.0 Activated');
    return array('status'=>'error','description'=>'Something went wrong');

}

function googleoauth2_deactivate() {


    # Remove Custom DB Table
    $query = "DROP TABLE `mod_googleoauth2`";
	$result = mysql_query($query);
	
	
    # Remove Custom DB Table
    //  $query = "DELETE FROM tbladdonmodules WHERE module='googleoauth2' AND setting='access_token';";
    //    $result = mysql_query($query);

    # Return Result
    return array('status'=>'success','description'=>'Google OAuth 2.0 Deactivated. Please go to Addons => Google OAuth 2.0 and click on Get OAuth Access Token');
    return array('status'=>'error','description'=>'Something went wrong');
    return array('status'=>'info','description'=>'If you want to give an info message to a user you can return it here');

}

function googleoauth2_upgrade($vars) {


/*
    $version = $vars['version'];

    # Run SQL Updates for V1.0 to V1.1
    if ($version < 1.1) {
        $query = "ALTER `mod_googleoauth2` ADD `demo2` TEXT NOT NULL ";
    	$result = mysql_query($query);
    }

    # Run SQL Updates for V1.1 to V1.2
    if ($version < 1.2) {
        $query = "ALTER `mod_googleoauth2` ADD `demo3` TEXT NOT NULL ";
    	$result = mysql_query($query);
    }

    */

}

function googleoauth2_output($vars) {

    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $option1 = $vars['option1'];
    $option2 = $vars['option2'];
    $option3 = $vars['option3'];
    $option4 = $vars['option4'];
    $option5 = $vars['option5'];
    $LANG = $vars['_lang'];

    // echo '<p>'.$LANG['intro'].'</p>
    // <p>'.$LANG['description'].'</p>
    // <p>'.$LANG['documentation'].'</p>';

/*
    echo '<p><Strong>Client ID:</Strong> '.$vars['clientid'].'</p>';


    echo '
            <p><Strong>Redirect URI:  <input type="text" size="100" value="https://'.$_SERVER["HTTP_HOST"].'/modules/addons/googleoauth2/oauth_callback.php" disabled="true"></Strong></p>
';

    echo '<p><Strong>Access Token: '.$vars['accesstoken'].'</Strong></p>';



echo '<input type="button" value="Get OAuth Access Token " onclick="window.open(\'http://www.google.com/analytics/\', \'ganalytics\');" style="padding:20px 50px;font-size:20px;"><br/></br>';
    echo '<div id="tabs"><ul>
            <li id="tab0" class="tab tabselected"><a href="javascript:;">Tab0</a></li>
            <li id="tab1" class="tab"><a href="javascript:;">Tab1</a></li>
          </div>

<div id="tab0box" class="tabbox" style="">
  <div id="tab_content">

<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
<tbody><tr><td class="fieldlabel">Direct Shopping Cart Link</td><td class="fieldarea"><input type="text" size="100" value="https://secure.latechguys.net/cart.php?a=add&amp;pid=8" readonly=""></td></tr>
<tr><td class="fieldlabel">Direct Shopping Cart Link Specifying Template</td><td class="fieldarea"><input type="text" size="100" value="https://secure.latechguys.net/cart.php?a=add&amp;pid=8&amp;carttpl=cart" readonly=""></td></tr>
<tr><td class="fieldlabel">Direct Shopping Cart Link Including Domain</td><td class="fieldarea"><input type="text" size="100" value="https://secure.latechguys.net/cart.php?a=add&amp;pid=8&amp;sld=whmcs&amp;tld=.com" readonly=""></td></tr>
<tr><td class="fieldlabel">Product Group Cart Link</td><td class="fieldarea"><input type="text" size="100" value="https://secure.latechguys.net/cart.php?gid=3" readonly=""></td></tr>
</tbody></table>

  </div>
</div>




          ';

    // var_dump($vars);

*/

}

function googleoauth2_sidebar($vars) {

    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $option1 = $vars['option1'];
    $option2 = $vars['option2'];
    $option3 = $vars['option3'];
    $option4 = $vars['option4'];
    $option5 = $vars['option5'];
    $LANG = $vars['_lang'];

    $sidebar = '<span class="header"><img src="images/icons/addonmodules.png" class="absmiddle" width="16" height="16" /> Google OAuth 2.0</span>
<ul class="menu">
        <li><a href="http://latechguys.net">LA Tech Guys</a></li>
        <li><a href="#">Version: '.$version.'</a></li>
    </ul>';
    return $sidebar;

}
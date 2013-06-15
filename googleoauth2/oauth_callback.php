<?php


// for debug purposes 
function print_pre($value) { 
  print '<pre style="text-align:left">' . htmlspecialchars(print_r($value, true)) . '</pre>';
}


		// Start Session
		session_start();
		// DB Info
		require_once $_SERVER['DOCUMENT_ROOT']."/configuration.php";

		if ( !isset($_SESSION['token'])){ 
		
			// Create SQL Connection
			$conn = mysql_connect('localhost', $db_username , $db_password);
			// If error Die
			if (!$conn) { die('Could not connect to mysql ' . mysql_error());}
			// check state 
			$query = 'SELECT  * FROM `tbladdonmodules` WHERE module= "googleoauth2"';

			// select DB from config file
			mysql_select_db($db_name);

			// update field
			$result = mysql_query( $query, $conn );

			if(! $result )
			{
			  die('Could not get data: ' . mysql_error());
			}

			// update field

			while ($data = mysql_fetch_array($result,MYSQL_ASSOC)) {
		
			     if ($data['setting'] == "client_id")  $_SESSION['client_id'] = $data['value'];
			     if ($data['setting'] == "client_secret")  $_SESSION['client_secret'] = $data['value'];
			     if ($data['setting'] == "state")   $_SESSION['state'] = $data['value'];
			     if ($data['setting'] == "redirect_uri")   $_SESSION['redirect_uri'] = $data['value'];
			     if ($data['setting'] == "developerkey")  $_SESSION['developerkey'] = $data['value'];

			}


			mysql_close($conn);

			if ( isset($_GET['state'] )){
			
				if( $_GET['state'] != $_SESSION['state']  ) die('Access Denied');
				
			} 
			else { 
				die('Access Denied'); 
			}

		}



	if (isset($_GET['code'])) {

		// Start Session
		// Database Access
		require_once $_SERVER['DOCUMENT_ROOT']."/modules/addons/googleoauth2/src/Google_Client.php";

		$client = new Google_Client();

		$client->setClientId( $_SESSION['client_id']);
		$client->setClientSecret($_SESSION['client_secret']);
		$client->setRedirectUri($_SESSION['redirect_uri']);


	  	$client->authenticate();
	
	  	$token = $client->getAccessToken();
		
	  
		  $_SESSION['token'] = $token;
		  $token = json_decode($token, true);

		
		// Create SQL Connection
		$conn = mysql_connect('localhost', $db_username , $db_password);
		// If error Die
		if (!$conn) { die('Could not connect to mysql ' . mysql_error());}

		
		// Build the update query
		$sql = 'INSERT INTO mod_googleoauth2 (access_token, token_type,expires_in,refresh_token,created)
		 		VALUES ("'.$token['access_token'].'",
						"'.$token['token_type'].'",
						"'.$token['expires_in'].'",
						"'.$token['refresh_token'].'",
						"'.$token['created'].'")';

		// select DB from config file
		mysql_select_db($db_name);
		
		// update field
		$retval = mysql_query( $sql, $conn );


		if(! $retval )
		{
		  die('Could not update data: ' . mysql_error());
		}

		mysql_close($conn);
				
		   // if Use revoked access, and clicks button to authorize again, remove &revoke	 		
		   $_SERVER['PHP_SELF'] = str_replace("&revoke","",$_SERVER['PHP_SELF']);

		   header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] );


	  	}

	if (isset($_SESSION['token'])) {
			
			// Close window 
			echo '<script>';
			echo 'window.opener.location.reload();';
			echo  'window.close();';
			echo '</script>';

	}


?>
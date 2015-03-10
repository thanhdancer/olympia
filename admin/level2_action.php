<?
	include ( "./globals.php" );
	$action = ( isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '' );
	switch( $action )
	{
		case 'active':
			$id = intval( $_POST['id'] );
			$query = "UPDATE `olp_level2`
						SET `status` = 2
						WHERE `status` = 1";
			mysql_query( $query ) or die ("Query failed: " . mysql_error() );
			
			$query = "UPDATE `olp_level2`
						SET `status` = 1
						WHERE `qid` = " . $id;
			mysql_query( $query ) or die ("Query failed: " . mysql_error() );
			break;
	}
	
?>
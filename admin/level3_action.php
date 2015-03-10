<?php
	include( './globals.php' );
	$id = intval( $_POST['qid'] );
	$action = ( isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : "" );
	switch( $action )
	{
		case 'active':
			$query = "UPDATE `olp_level3`
				SET `status` = 2
				WHERE `status` = 1";
			mysql_query( $query ) or die ("Query failed: " . mysql_error() );
			
			$query = "UPDATE `olp_level3`
						SET `status` = 1
						WHERE `qid` = " . $id;
			mysql_query( $query ) or die ("Query failed: " . mysql_error() );
			break;
	}	
	
?>
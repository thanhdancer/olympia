<?php
	include( './globals.php' );
	$type = ( isset( $_REQUEST['type'] ) ? $_REQUEST['type'] : '' );

			$id = intval( $_REQUEST['id'] );

			$query = "UPDATE `olp_level4`
						SET `status` = 2
						WHERE `status` = 1
								AND `level` = " . intval( $type );
			mysql_query( $query ) or die ("Query failed: " . mysql_error() );

			$query = "UPDATE `olp_level4`
						SET `status` = 1
						WHERE `qid` = " . $id . "
								AND `level` = " . intval( $type );
			mysql_query( $query ) or die ("Query failed: " . mysql_error() );



?>
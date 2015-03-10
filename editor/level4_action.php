<?php
	$action = ( isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '' );
	$type = ( isset( $_REQUEST['type'] ) ? $_REQUEST['type'] : '' );
	switch ( $action )
	{
		case "add":

			$question = ( isset( $_REQUEST['question'] ) ? $_REQUEST['question'] : '' );
			$answer = ( isset( $_REQUEST['answer'] ) ? $_REQUEST['answer'] : '' );

			$query = "INSERT INTO `olp_level4` ( `question`, `answer`, `level` )
						VALUES ('" . mysql_real_escape_string( $question ) . "', '" . mysql_real_escape_string( $answer ) . "', " . intval( $type ) . ")";
			mysql_query( $query ) or die ("Query failed: " . mysql_error() );
			break;
		case "active":
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
			break;
		case "edit":
			$id = intval( $_POST['id'] );
			$question = $_POST['question'];
			$answer = $_POST['answer'];

			$query = "UPDATE `olp_level4`
						SET `question` = '" . mysql_real_escape_string( $question ) . "',
							`answer` = '" . mysql_real_escape_string( $answer ) . "'
						WHERE `qid` = " . $id;
			mysql_query( $query ) or die ("Query failed: " . mysql_error() );
			break;
		case "delete":
			$id = $_POST['id'];
			foreach( $id as $key => $value )
			{
				$ids[] = intval( $key );
			}
			$query = "DELETE FROM `olp_level4`
							WHERE `qid` IN (" . implode( ',', $ids ) . ")";
				mysql_query( $query ) or die ("Query failed: " . mysql_error() );
			break;
		case "deactive":
			$id = $_POST['id'];
			foreach( $id as $key => $value )
			{
				$ids[] = intval( $key );
			}
			$query = "UPDATE `olp_level4`
						SET `status` = 0
						WHERE `qid` IN (" . implode( ',', $ids ) . ")";
				mysql_query( $query ) or die ("Query failed: " . mysql_error() );
			break;
	}
	header("location: ?do=level4" . "&type=$type");
?>
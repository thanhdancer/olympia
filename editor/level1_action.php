<?
$action = ( isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : "" );
	switch ($action)
	{
	case "add":
		$question = $_POST['question'];
		$answer = $_POST['answer'];
		
		$query = "INSERT INTO `olp_level1` (`question`, `answer` )
					VALUES ('" . mysql_real_escape_string( $question ) . "', '" . mysql_real_escape_string( $answer ) . "' )";
		mysql_query( $query ) or die ("Query failed: " . mysql_error() );
		break;
	case "active":
		$id = intval( $_REQUEST['id'] );
		
		$query = "UPDATE `olp_level1`
					SET `status` = 2
					WHERE `status` = 1";
		mysql_query( $query ) or die ("Query failed: " . mysql_error() );
		
		$query = "UPDATE `olp_level1`
					SET `status` = 1
					WHERE `qid` = " . $id;
		mysql_query( $query ) or die ("Query failed: " . mysql_error() );
		break;
	case "edit":
		$id = intval( $_POST['id'] );
		$question = $_POST['question'];
		$answer = $_POST['answer'];
		
		$query = "UPDATE `olp_level1`
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
		$query = "DELETE FROM `olp_level1`
						WHERE `qid` IN (" . implode( ',', $ids ) . ")";
			mysql_query( $query ) or die ("Query failed: " . mysql_error() );
		break;
	case "deactive":
		$id = $_POST['id'];
		foreach( $id as $key => $value )
		{
			$ids[] = intval( $key );
		}
		$query = "UPDATE `olp_level1`
					SET `status` = 0
					WHERE `qid` IN (" . implode( ',', $ids ) . ")";
			mysql_query( $query ) or die ("Query failed: " . mysql_error() );
		break;
	}
	header("location: ?do=level1");
?>				
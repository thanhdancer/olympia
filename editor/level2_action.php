<?
$action = ( isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '' );
switch( $action )
{
	case 'edit':
		$id = intval( $_POST['id'] );
		$question = $_POST['question'];
		$answer = $_POST['answer'];
		
		$answer = str_replace( ' ', '', $answer );
		
		$query = "UPDATE `olp_level2`
					SET `question` = '" . mysql_real_escape_string( $question ) . "',
						`answer` = '" . mysql_real_escape_string( $answer ) . "',
						`status` = 0
					WHERE `qid` = " . $id;
		mysql_query( $query ) or die ("Query failed: " . mysql_error() );
		break;
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
header("location: ?do=level2" . ( isset( $id ) ? '&qid=' . $id : '' ));
?>
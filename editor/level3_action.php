<?
	$id = intval( $_POST['qid'] );
	$action = ( isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : "" );
	switch( $action )
	{
		case 'edit':
			foreach( $_FILES as $key => $info )
			{
				$ext = strtolower( end( explode( '.', $info['name'] ) ) );
				if( in_array( $ext, array( 'jpg','png','bmp' ) ) )
				{
					$picid = substr( $key, 1 );
					$filename = md5( rand( 0, 100 ) . $info['name'] ) . '.' . $ext;
					
					$query = "SELECT `img" . $picid . "`
								FROM `olp_level3`
								WHERE `qid` = " . $id;
					$result = mysql_query( $query ) or die ("Query failed: " . mysql_error() );
					$line = mysql_fetch_row( $result, MYSQL_ASSOC );
					@unlink( '../level3_question/' . $line['img' . $picid] );
					
					move_uploaded_file( $info['tmp_name'], '../level3_question/' . $filename );
					
					$update .= "`img" . $picid . "` = '" . mysql_real_escape_string( $filename ) . "',";
					
				}
			}
			$query = "UPDATE `olp_level3`
						SET " . $update . "
							`status` = 0
						WHERE `qid` = " . $id;
			mysql_query( $query ) or die ("Query failed: " . mysql_error() );
			break;
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
	header("location: ?do=level3" . "&qid=" . $id);
?>
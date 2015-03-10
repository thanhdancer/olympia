<?php
	include( './globals.php' );
	$action = ( isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : "" );
	switch ($action)
	{
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
		case "change_page":
			$perpage = 30;
			$page = ( isset( $_REQUEST['p'] ) ? intval( $_REQUEST['p'] ) : 0 ) * $perpage 	;
			$query = "SELECT *
						FROM `olp_level1`
						ORDER BY `qid`
						LIMIT $page, $perpage";
			$result = mysql_query( $query );
			$res = "";
			$res .=' <tr style="font: normal bold 15px Tahoma">
				<td width="50%">' . $lang['question'] . '</td>
				<td width="30%">' . $lang['answer'] . '</td>
				<td width="20%">' . $lang['action'] . '</td>
			</tr>
			<tr>
				<td colspan="3"><hr /></td>
			</tr>';

			while( $line = mysql_fetch_row( $result,  MYSQL_ASSOC ) )
			{
				switch ( $line['status'] )
				{
					case 0:
						$stt = '<div id="id' . $line['qid'] . '"><a href="#" onclick="return active_question(' . $line['qid'] . ')" style="color: #00AA00" >' . $lang['active'] . '</a></div>';
						break;
					case 1:
						$stt = '<div id="id' . $line['qid'] . '" style="color: #CBAD00" >' . $lang['acting'] . '</div>';
						break;
					case 2:
						$stt = '<div id="id' . $line['qid'] . '" style="color: #FF0000" >' . $lang['actived'] . '</div>';
						break;
				}

				$res .= '<tr>
							<td width="50%"><b>' . $line['question'] . '</a></td>
							<td width="30%"><b>' . $line['answer'] . '</a></td>
							<td width="20%"><b> ' . $stt . ' </b> </td>
						</tr>';
			}
			die($res);
			break;
	}

?>
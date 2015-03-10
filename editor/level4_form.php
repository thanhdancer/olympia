<?php
	$action = ( isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '' );
	if( $action == 'edit' )
	{
		$type = intval( $_REQUEST['type'] );
		$id = intval( $_REQUEST['id'] );
		$query = "SELECT *
					FROM `olp_level4`
					WHERE `qid` = " . $id;
		$result = mysql_query( $query ) or die('Query failed: ' . mysql_error());
		if( mysql_num_rows( $result ) < 1 )
		{
			echo $lang['not_found_question'];
		}
		else
		{
			$line = mysql_fetch_row( $result, MYSQL_ASSOC );
			echo '<center><font size="4">' . $lang['edit_title'] . ' </font></center><br />
			<form method="POST" action="?do=level4_action" >
			' . $lang['question'] . '<br />
			<textarea name="question" rows="6" style="width: 800px">' . $line['question'] . '</textarea><br />
			' . $lang['answer'] . '<br />
			<textarea name="answer" rows="6" style="width: 800px">' . $line['answer'] . '</textarea>
			<input type="hidden" name="type" value ="' . $type . '" />
			<input type="hidden" name="id" value="' . $line['qid'] .'">
			<input type="hidden" name="action" value="edit" />
			<center><input type="submit" value=" Save " /></center>
			</form>';
		}
	}
	else
	{
		$perpage = 30;
		$type = ( isset( $_REQUEST['type'] ) ? $_REQUEST['type'] : 1 );
		$page = ( isset( $_REQUEST['p'] ) ? $_REQUEST['p'] : 0 ) * $perpage;
		$query = "SELECT *
					FROM `olp_level4`
					WHERE `level` = " . intval( $type );
		$result = mysql_query( $query ) or die( 'Query failed: ' . mysql_error() );
		$total_page = mysql_num_rows( $result );

		$query = "SELECT *
					FROM `olp_level4`
					WHERE `level` = " . intval( $type ) . "
					ORDER BY `qid`
					LIMIT $page, $perpage";
		$result = mysql_query( $query ) or die( 'Query failed: ' . mysql_error() );

		echo '<script type="text/javascript">
				function chang_level()
				{
					id = $("#type").val();
					window.location = "?do=level4&type=" + id;
				}
				function change_page()
				{
					a = $("#page").attr("value");
					id = $("#type").val();
					window.location = "?do=level4&p=" + (a-1) + "&type="  + id;
				}
				function check_all(a)
				{
					if( a.checked == true )
					{
						value = true;
					}
					else
					{
						value = false;
					}
					for( i = 1; i < 30; i++ )
					{
						$("#chk" + i).attr("checked", value);
					}
				}
				</script>' . $lang['level4_type'] . '
			<select id="type" onchange="chang_level()">
				<option value="1" ' . ( $type == 1 ? 'selected="selected"' : '' ) . '> 40 ' . $lang['score'] . ' </option>
				<option value="2" ' . ( $type == 2 ? 'selected="selected"' : '' ) . '> 60 ' . $lang['score'] . ' </option>
				<option value="3" ' . ( $type == 3 ? 'selected="selected"' : '' ) . '> 80 ' . $lang['score'] . ' </option>
			</select><br />
			<form action="?do=level4_action" method="POST">
			<table width="100%" style="font-size: 12px; border: 1px #000000 solid; ">
				<tr>
					<td width="49%"> ' . $lang['question'] . ' </td>
					<td width="30%"> ' . $lang['answer'] . ' </td>
					<td width="20%"> ' . $lang['action'] . ' </td>
					<td width="1%"> <input type="checkbox" onclick="check_all(this)" />
				</tr>';
		$i = 0;
		while( $line = mysql_fetch_row( $result, MYSQL_ASSOC ) )
		{
			$i++;
			echo '<tr>
				<td width="40%"><a href="?do=level4&action=edit&id=' . $line['qid'] . '&type=' . $type . '">' . $line['question'] . '</a></td>
				<td width="30%"><a href="?do=level4&action=edit&id=' . $line['qid'] . '&type=' . $type . '">' . $line['answer'] . '</a></td>
				<td width="20%"><b>' . ( $line['status'] == 0 ? '<a href="?do=level4_action&action=active&id=' . $line['qid'] . '&type=' . $type . '"><font color="green">' . $lang['active'] . '</font></a>' : ($line['status'] == 1 ? '<font color="orange">' . $lang['acting'] . '</font>' : '<font color="red">' . $lang['actived'] . '</font>' ) )  . '</b> </td>
				<td width="10%"><input id="chk' . $i . '" type="checkbox" name="id[' . $line['qid'] . ']" /></td>
				</tr>';
		}
		echo '</table>
			<table width="100%">
				<tr>
				<td align="left">
					<div align="left">' . $lang['page'] . ' <select id="page" onchange="change_page()">


			';

			for( $i = 1; $i <= ceil( $total_page / $perpage ) ; $i ++ )
			{
				echo '<option value="' . $i . '" ' . ($i == $_REQUEST['p'] + 1 ? 'selected="selected"' :'' ) . '>' . $i . '</option>';
			}
			echo '
					</select></div>
				</td>
				<td align="right">
					<div>
					<input type="hidden" name="type" value="' . $type . '" />
					<input type="submit" value=" Save " />
						<select id="action" name="action">
							<option value="delete">' . $lang['delete'] . '</option>
							<option value="deactive">' . $lang['deactive'] . '</option>
						</select>

				</td>
				</tr>
			</table>
			</form>
			<hr />
			<form action="?do=level4_action" method="POST">
			<center><font size="4">' . $lang['add_title'] . ' </font></center><br />
			' . $lang['question'] . '<br />
			<textarea name="question" rows="6" style="width: 800px"></textarea><br />
			' . $lang['answer'] . '<br />
			<textarea name="answer" rows="6" style="width: 800px"></textarea>
			<input type="hidden" name="action" value="add" />
			<input type="hidden" name="type" value="' . $type .'" />
			<center><input type="submit" value=" Add " /></center>
			</form>';
	}
?>
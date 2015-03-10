<?
	include( './globals.php' );
	$perpage = 30;
	$page = 0 	;
	$query = "SELECT * FROM `olp_level1`";
	$result = mysql_query( $query ) or die('Query failed: ' . mysql_error());
	$total_page = mysql_num_rows( $result );
	
	
	
	$query = "SELECT * 
				FROM `olp_level1` 
				ORDER BY `qid`
				LIMIT $page, $perpage";
	$result = mysql_query( $query );
	
	echo '<script type="text/javascript">
			function active_question( id )
			{
				for( i = 0; i < $("div").length; i++ )
				{
					if( $("div")[i].id.substr(0,2) == "id" && $("#" + $("div")[i].id).css("color") == "rgb(203, 173, 0)" )
					{
						$("#" + $("div")[i].id).css("color", "#FF0000");
						$("#" + $("div")[i].id).html("' . $lang['actived'] . '");
					}
				}
				$("#id" + id).html("' . $lang['acting'] . '");
				$("#id" + id).css("color", "#CBAD00");
				$.ajax({
					  type: "POST",
					  url: "level1_action.php",
					  data: { id: id, action: "active" }
					});
				return false;
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
			function change_page()
			{
				a = $("#page").attr("value");
				$.ajax({
					  type: "POST",
					  url: "level1_action.php",
					  data: { p: ( a - 1 ), action: "change_page" }
					}).done( function ( msg ) {
						$("#main_table").html(msg);
					});
			}
		</script>
			
		<table id="main_table" width="100%" style="font-size: 12px; border: 1px #000000 solid">
			<tr style="font: normal bold 15px Tahoma">
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
		
		echo '<tr>
					<td width="50%"><b>' . $line['question'] . '</a></td>
					<td width="30%"><b>' . $line['answer'] . '</a></td>
					<td width="20%"><b> ' . $stt . ' </b> </td>
				</tr>';
	}
	echo '</table>
					<div align="right" width="100%">' . $lang['page'] . ' <select id="page" onchange="change_page()">
				
			
			';
			
			for( $i = 1; $i <= ceil( $total_page / $perpage ) ; $i ++ )
			{
				echo '<option value="' . $i . '" ' . ($i == ( isset( $_REQUEST['p'] ) ? $_REQUEST['p'] : 0 ) + 1 ? 'selected="selected"' :'' ) . '>' . $i . '</option>';
			}
			echo '
					</select></div>
			';

?>
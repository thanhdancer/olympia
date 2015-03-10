<?
	include( './globals.php' );
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
				type = $("#type").val();
				$("#id" + id).html("' . $lang['acting'] . '");
				$("#id" + id).css("color", "#CBAD00");
				$.ajax({
					  type: "POST",
					  url: "level4_action.php",
					  data: { id: id, type: type }
					});
				return false;
				
			}
			function chang_level()
			{
				id = $("#type").val();
				$.ajax({
				  type: "GET",
				  url: "level4_form.php?type=" + id
				}).done( function ( msg ) {
					$("#form_content").html(msg);
				});
			}
			function change_page()
			{
				a = $("#page").attr("value");
				id = $("#type").val();
				$.ajax({
					  type: "GET",
					  url: "level4_form.php?type="  + id + "&p=" + (a-1)
					}).done( function ( msg ) {
						$("#form_content").html(msg);
					});
			}
			
			</script>' . $lang['level4_type'] . '
		<select id="type" onchange="chang_level()">
			<option value="1" ' . ( $type == 1 ? 'selected="selected"' : '' ) . '> 40 ' . $lang['score'] . ' </option>
			<option value="2" ' . ( $type == 2 ? 'selected="selected"' : '' ) . '> 60 ' . $lang['score'] . ' </option>
			<option value="3" ' . ( $type == 3 ? 'selected="selected"' : '' ) . '> 80 ' . $lang['score'] . ' </option>
		</select><br />
		
		<table width="100%" style="font-size: 12px; border: 1px #000000 solid; ">
			<tr style="font: normal bold 15px Tahoma">
				<td width="50%">' . $lang['question'] . '</td>
				<td width="30%">' . $lang['answer'] . '</td>
				<td width="20%">' . $lang['action'] . '</td>
			</tr>
			<tr>
				<td colspan="3"><hr /></td>
			</tr>';
	
	while( $line = mysql_fetch_row( $result, MYSQL_ASSOC ) )
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
		
				<div align="left">' . $lang['page'] . ' <select id="page" onchange="change_page()">
			
		
		';
		
		for( $i = 1; $i <= ceil( $total_page / $perpage ) ; $i ++ )
		{
			echo '<option value="' . $i . '" ' . ($i == $_REQUEST['p'] + 1 ? 'selected="selected"' :'' ) . '>' . $i . '</option>';
		}
		echo '
				</select></div>
			
		
		
		';
	
?>
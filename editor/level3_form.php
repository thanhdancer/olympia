<?php
	$q = ( isset( $_REQUEST['qid'] ) ? $_REQUEST['qid'] : -1 );

	if( $q == -1 )
	{
		$query = "SELECT *
					FROM `olp_level3`
					ORDER BY `qid`
					LIMIT 0,1";
	}
	else
	{
		$query = "SELECT *
					FROM `olp_level3`
					WHERE `qid` = " . intval( $q );
	}
	$result = mysql_query( $query ) or die('Query failed: ' . mysql_error());
	$line = mysql_fetch_row( $result, MYSQL_ASSOC );
	$i_default = $line['qid'];
	$q_default = $line['question'];
	$a_default = $line['answer'];
	$s_default = $line['status'];

	for( $i = 1; $i <= 10; $i++ )
	{
		$img_default[$i] = $line['img'.$i];
	}


	switch ( $s_default )
	{
		case 0:
			$style = 'background-color: #00FF00';
			break;
		case 1:
			$style = 'background-color: #FFFF00';
			break;
		case 2:
			$style = 'background-color: #FF0000';
			break;
	}


	echo '<script type="text/javascript">
			var editing = 0;
			$(document).ready(function(){
				$("img").mousemove(function(e){
					if( this.id.substring( 0,3 ) == "pic" )
					{
						$("#preview").html(\'<img src="\' + this.src + \'" height="300px" style="border: 6px #888888 solid; position:absolute; top:\' + ( e.pageY - 150 ) + \'px; left:\' + ( e.pageX + 10 ) + \'px;" >\');
					}
				});
			});
			function change_question()
			{
				a = $("#id").attr("value");
				window.location = "?do=level3&qid=" + a;
			}
			function mouse_out()
			{
				$("#preview").html("");
			}

			function question_active()
			{
				$("#tbl_ground").css("background-color", "#FFFF00");
				$.ajax({
					type: "POST",
					url: "?do=level3_action",
					data: {
						qid: $("#id").attr("value"),
						action: "active"
					}
					});
			}

			function question_edit()
			{
				$("#tbl_ground").css("background-color", "#123456")
				for( i = 1; i <= 10; i++ )
				{
					$("#p" + i).html(\'<input type="file" name="p\' + i + \'" size="5"/>\')
				}
				$("#save").html(\'<input type="submit" value=" Save " />\');
				$("#active").attr("disabled", "disabled");
			}
			</script><form enctype="multipart/form-data"  action="?do=level3_action" method="POST" >' . $lang['question'] . ' <select id="id" name="id" onchange="change_question()">';
	$query = "SELECT `qid`
		FROM `olp_level3`
		ORDER BY `qid`
		LIMIT 0,4
		";
	$result = mysql_query( $query ) or die('Query failed: ' . mysql_error());
	$i = 0;
	while( $line = mysql_fetch_row( $result, MYSQL_ASSOC ) )
	{
		$i++;
		echo '<option value="' . $line['qid'] . '" ' . ( $i_default == $line['qid'] ? 'selected="selected"' : '' ) . ' > ' . $i . ' </option>';
	}
	echo '</select><br />

	<div id="preview"></div><table id="tbl_ground" width="100%" cellpadding="5px" style="' . $style . '; margin-bottom: 10px; border: 1px #123123 solid">
			<tr>';
	for( $i = 1; $i <= 5; $i++ )
	{
		if( !is_file( '../level3_question/' . $img_default[$i] ) )
			$img_default[$i] = 'blank.jpg';
		echo '<td id="p' . $i . '" width="20%"><a href="../level3_question/' . $img_default[$i] .'" ><img id="pic' . $i . '" src="../level3_question/' . $img_default[$i] .'" width="100%" height="100%" onmouseout="mouse_out()" style="border: 2px #345354 solid" /></a></td>';
	}
	echo 	'</tr>
			<tr>';
	for( $i = 6; $i <= 10; $i++ )
	{
		if( !is_file( '../level3_question/' . $img_default[$i] ) )
			$img_default[$i] = 'blank.jpg';
		echo '<td id="p' . $i . '" width="20%"><a href="../level3_question/' . $img_default[$i] .'" ><img id="pic' . $i . '" src="../level3_question/' . $img_default[$i] .'" width="100%" height="100%" onmouseout="mouse_out()" style="border: 2px #345354 solid"  /></a></td>';
	}
	echo 	'</tr>
			</table>
			<center>
			<input type="hidden" name="action" value="edit" />
			<input type="hidden" name="qid" value="' . $i_default . '" />
			<span id="save"><input type="button" value=" Edit " onclick="question_edit()" /></span>
			<input id="active" type="button" value=" ' . $lang['active'] . ' " onclick="question_active()" />
			</center>
			</form>
			';
?>
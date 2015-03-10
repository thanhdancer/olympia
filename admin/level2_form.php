<?
	include( './globals.php' );
	$q = ( isset( $_REQUEST['qid'] ) ? $_REQUEST['qid'] : -1 );
	if( $q == -1 )
	{
		$query = "SELECT *
				FROM `olp_level2`
				ORDER BY `qid`
				LIMIT 0,1";
	}
	else
	{	$query = "SELECT *
					FROM `olp_level2`
					WHERE `qid` = " . intval( $q );
	}
	$result = mysql_query( $query ) or die('Query failed: ' . mysql_error());
	$line = mysql_fetch_row( $result, MYSQL_ASSOC );
	$i_default = $line['qid'];
	$q_default = $line['question'];
	$a_default = $line['answer'];
	$s_default = $line['status'];
	switch ( $s_default )
	{
		case 0:
			$style = 'background-color: #00FF00';
			break;
		case 2:
			$style = 'background-color: #FF0000';
			break;
		case 1:
			$style = 'background-color: #FFFF00';
			break;
	}
	echo '<script type="text/javascript">
		function change_question()
		{
			a = $("#id").attr("value");
			$.ajax({
					  type: "GET",
					  url: "level2_form.php?qid=" + a
					}).done( function ( msg ) {
						$("#form_content").html(msg);
					});
		}
		
		function active_question()
		{
			$("#ques").css("background-color", "#FFFF00");
			$("#ans").css("background-color", "#FFFF00");
			$("#act").attr("disabled", "disabled");
			$.ajax({
				type: "POST",
				url: "level2_action.php",
				data: {
					id: $("#id").attr("value"),
					action: "active"
				}
				});
		}
		</script>
		
		' .$lang['rows'] . '
		<select id="id" name="id" onchange="change_question()">
	';

	$query = "SELECT `qid`
				FROM `olp_level2`
				ORDER BY `qid`
				";
	$result = mysql_query( $query ) or die('Query failed: ' . mysql_error());
	$i = 0;
	while( $line = mysql_fetch_row( $result, MYSQL_ASSOC ) )
	{	
		$i++;
		echo '<option value="' . $line['qid'] . '" ' . ( $i_default == $line['qid'] ? 'selected="selected"' : '' ) . ' > ' . $i . ' </option>';
	}
	echo '</select><br />';


	echo  $lang['question'] . ' <br />
			<textarea id="ques" name="question" style="width: 100%; ' . $style .'">' . $q_default . '</textarea><br />'
		. $lang['answer'] . '<br />
		<input id="ans" type="text" style="width: 100%; ' . $style . '" name="answer" value="' . $a_default . '" autocomplete="off" /><br />
		<center><input id="act" type="button" value="' . $lang['active'] . '" ' . ( $s_default != 0 ? 'disabled="disabled"' : '' ) . ' onclick="active_question()"/>
		';
?>
<?php
	include( "globals.php"  );
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title> ..:: Olympia - Administrator ::.. </title>
		<script type="text/javascript" src="http://localhost:8092/socket.io/socket.io.js"></script>
		<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
		<script type="text/javascript">
			var socket = io.connect('http://localhost:8092');

			function hideshowScore()
			{
				if( $("#user_show").val() == " Show " )
				{
					$("#user_show").val(" Hide ");
					socket.emit( 'toScreen', 'showScore|' );
				}
				else
				{
					$("#user_show").val(" Show ");
					socket.emit( 'toScreen', 'hideScore|' );
				}
			}

			function update_user()
			{
				var user = new Array();
				var score = new Array();
				for( i = 0; i < $("input").length; i++ )
				{
					if( $("input")[i].name.substr(0,4) == "user" )
					{
						user[$("input")[i].name.substr(4)] = $("input")[i].value;
					}

					if( $("input")[i].name.substr(0,5) == "score" )
					{
						score[$("input")[i].name.substr(5)] = $("input")[i].value;
					}
				}
				toScreen = 'updateScore|<table id="score"><tr><th class="score"><?php echo $lang['name']?></th><th class="score"><?php echo $lang['score']?></th></tr><tr><td class="name">' + user[1] + '</td><td class="score">' + score[1] + '</td></tr><tr><td class="name">' + user[2] + '</td><td class="score">' + score[2] + '</td></tr><tr><td class="name">' + user[3] + '</td><td class="score">' + score[3] + '</td></tr><tr><td class="name">' + user[4] + '</td><td class="score">' + score[4] + '</td></tr></table>';
				socket.emit( 'toScreen', toScreen );
				$.ajax({
					  type: "POST",
					  url: "user_action.php",
					  data: {
							user1: user[1],
							user2: user[2],
							user3: user[3],
							user4: user[4],
							score1: score[1],
							score2: score[2],
							score3: score[3],
							score4: score[4]
					}
					});
			}

			function Screen_changeBG( a, page, link )
			{
				for( i = 0; i < $("a").length; i++ )
				{
					if( a.id == $("a")[i].id )
					{
						$("#"+$("a")[i].id).css({"font-size": "20px", "color": "#FF6633"});
					}
					else
					{
						$("#"+$("a")[i].id).css({"font-size": "15px", "color": "#0560a6"});
					}
				}
				var msg = 'changeBackground|' + link;
				socket.emit( 'toScreen', msg );
				if ( page != '' )
				{
					$.ajax({
						  type: "GET",
						  url: page + "_form.php"
						}).done( function ( msg ){
							$("#form_content").html( msg );
						});
				}
				else
				{
					$("#form_content").html('');
				}
				return false;
			}

			function send_mess()
			{
				var mess = $("#test").val();
				var msg = 'messSent|' + mess;
				socket.emit( 'toScreen', msg );
			}
			socket.emit( 'keep-alive' );
			socket.on( 'keep-alive', function( data ){
				$("#connection").html("<b><font color=\"#00AA00\">Connected</font></b>");
			});
		</script>
		<style type="text/css">
			body {
				background-color: #E1E1E2;
				font: normal normal 12 verdana;
			}
			#container {
				width: 800px;
				font: 15px Verdana;
				margin: auto auto;
			}
			a:link, body_alink{
				color: #0560a6;
				text-decoration: none;
				font-weight: bold;
			}
			a:visited, body_avisited{
				color: #0560a6;
				text-decoration: none;
				font-weight: bold;
			}
			a:hover, a:active, body_ahover{
				color: #FF6633;
				text-decoration: none;
				font-weight: bold;
			}
			#menu	{
				margin-top: 40px;
			}

		</style>
	</head>
<body>
	<div id="container">
		<b>Status:</b> <span id="connection">Connecting...</span>
		<div id="menu" align="center">
			<a id="link1" href="#" onclick="return Screen_changeBG(this, '', '../images/khung.jpg')"> <?php echo $lang['user'] ?> </a> ||
			<a id="link2" href="#" onclick="return Screen_changeBG(this, 'level1', '../images/KhoiDong.jpg')"> <?php echo $lang['level1'] ?> </a> ||
			<a id="link3" href="#" onclick="return Screen_changeBG(this, 'level2', '../images/vcnv copy.jpg')"> <?php echo $lang['level2'] ?> </a> ||
			<a id="link4" href="#" onclick="return Screen_changeBG(this, 'level3', '../images/tangtoc copy1.jpg')"> <?php echo $lang['level3'] ?> </a> ||
			<a id="link5" href="#" onclick="return Screen_changeBG(this, 'level4', '../images/vedich copy.jpg')"> <?php echo $lang['level4'] ?> </a> ||
			<a href="../editor/?do=level4" ><u> <?php echo $lang['editor'] ?> </u></a>
		</div>
		<hr />
		<div id="user">
			<?php
			$query = "SELECT * FROM olp_user";
			$result = @mysql_query( $query );
			?>
			<div style="margin: auto auto">

				<table>
					<tr>
						<td width="30%"></td>
						<td width="60%"> <?php echo $lang['name'] ?></td>
						<td width="10%"> <?php echo $lang['score'] ?></td>
					</tr>
			<?php
			$i = 0;
			while( $line = mysql_fetch_array( $result, MYSQL_ASSOC ) )
			{
				$i++
				?>
				<tr>
					<td width="30%"> <?php echo $lang['userid'] . ' ' . $i ?> </td>
					<td width="60%"><input type="text" size="50" name="user<?php echo $line['id'] ?>" value="<?php echo $line['name'] ?>" /> </td>
					<td width="60%"><input type="text" name="score<?php echo $line['id'] ?>" value="<?php echo $line['score'] ?>" /> </td>
				</tr>
			<?php
			}
			?>
				</table>
				<input type="hidden" name="do" value="user_update" />
				<center><input type="button" value=" Save " onclick="update_user()" /><input id="user_show" type="button" value=" Show " onclick="hideshowScore()"</center>
				<hr />
			</div>
		</div>
		<div id="form_content">
		</div>
	</div>
</body>
</html>
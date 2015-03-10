<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title> ..:: Olympia - Administrator ::.. </title>
		<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
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



<?php
	include( "globals.php"  );
	if( !isset( $_REQUEST['do'] ) || !in_array( $_REQUEST['do'], array( 'level4_action', 'level3_action', 'level2_action', 'level1_action', 'user_update', 'user', 'level1', 'level2', 'level3', 'level4' ) ) )
	{
		$_REQUEST['do'] = 'user';
	}

	/////////////////////////////// USER ACTION ////////////////////////////////
	if( $_REQUEST['do'] == 'user_update' )
	{
		include( 'user_action.php' );
	}

	/////////////////////////////// LEVEL 1 ACTION /////////////////////////////
	if( $_REQUEST['do'] == 'level1_action' )
	{
		include( 'level1_action.php' );
	}

	////////////////////////////////LEVEL 2 ACTION//////////////////////////////
	if( $_REQUEST['do'] == 'level2_action' )
	{
		include( 'level2_action.php' );
	}

	if( $_REQUEST['do'] == 'level3_action' )
	{
		include( 'level3_action.php' );
	}

	if( $_REQUEST['do'] == 'level4_action' )
	{
		include( 'level4_action.php' );
	}
?>
<body>
	<div id="container">
		<div id="menu" align="center">
			<a href="?do=user" > <?php echo $lang['user'] ?> </a> ||
			<a href="?do=level1" > <?php echo $lang['level1'] ?> </a> ||
			<a href="?do=level2" > <?php echo $lang['level2'] ?> </a> ||
			<a href="?do=level3" > <?php echo $lang['level3'] ?> </a> ||
			<a href="?do=level4" > <?php echo $lang['level4'] ?> </a> ||
			<a href="../admin/?do=level4" ><u> <?php echo $lang['monitor'] ?> </u></a>
		</div>
		<hr />
		<div id="form_content">
<?php
	///////////////////// FORM UPDATE USER /////////////////////////////////////
	if( $_REQUEST['do'] == 'user' )
	{
		include( 'user_form.php' );
	}

	/////////////////////// FORM UPDATE LEVEL 1 ////////////////////////////////
	if( $_REQUEST['do'] == 'level1' )
	{
		include ( 'level1_form.php' );
	}

	///////////////////// FORM UPDATE LEVEL 2 //////////////////////////////////
	if( $_REQUEST['do'] == 'level2' )
	{
		include( 'level2_form.php' );
	}

	///////////////////// FORM UPDATE LEVEL 3 /////////////////////////////////
	if( $_REQUEST['do'] == 'level3' )
	{
		include( 'level3_form.php' );
	}
	//////////////////// FORM UPDATE LEVEL 4 //////////////////////////////////
	if( $_REQUEST['do'] == 'level4' )
	{
		include ( 'level4_form.php' );
	}

?>		</div>
	</div>
</body>
</html>
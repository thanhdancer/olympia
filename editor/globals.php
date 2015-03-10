<?php
	include( "../config.php" );
	include( "../includes/functions.php" );
	include( "lang_vi.php" );
	// global variable
	$admin_name = "admin";
	$admin_pass = "e10adc3949ba59abbe56e057f20f883e"; // default password is 123456
	
	$u = ( isset( $_POST['username'] ) ? $_POST['username'] : '' );
	$p = ( isset( $_POST['password'] ) ? $_POST['password'] : '' );
	
	if( $u == $admin_name && $admin_pass == md5( $p ) )
	{
		setcookie( "login", $admin_name, time() + 86400 );
		setcookie( "pass", $admin_pass, time() + 86400 );
	}
	
	// check login
	if ( !isset( $_COOKIE['login'] ) || $_COOKIE['login'] != $admin_name || !isset( $_COOKIE['pass'] ) && $_COOKIE['pass'] != $admin_pass  )
	{
		echo '<form method="POST">
		<table style="margin: auto auto;">
		<tr>
			<td> Username: </td>
			<td><input type="text" name="username" /></td>
		</tr>
		<tr>
			<td>Password: </td>
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center"> <input type="submit" value="Login" /> </td>
		</tr>
		</table>

		</form>';
		die();
	}	
	
	$MYSQL = database_connect();
?>

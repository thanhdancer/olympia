<?php
function database_connect()
{
	$link = mysql_connect( HOST, USERNAME, PASSWORD )
    or die('Could not connect: ' . mysql_error());
	mysql_select_db( DATABASE ) or die('Could not select database');

	return $link;
}
?>
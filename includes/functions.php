<?php
function database_connect()
{
	$link = mysql_connect( base64_decode( HOST ), base64_decode( USERNAME ), base64_decode( PASSWORD ) )
    or die('Could not connect: ' . mysql_error());
	mysql_select_db( base64_decode( DATABASE ) ) or die('Could not select database');
	
	return $link;
}
?>
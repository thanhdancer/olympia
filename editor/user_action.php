<?
if( !isset( $_POST ) )
	header( "location: ?do=user" );
	
foreach( $_POST as $tmp => $value )
{
	if( substr( $tmp, 0, 4 ) == 'user' )
	{
		$id = substr( $tmp, 4 );
		$query = "UPDATE `olp_user`
					SET `name` = '" . mysql_real_escape_string( trim( $value ) ) . "'
					WHERE `id` = " . $id;
		mysql_query( $query );
	}
	else
	{
		$id = substr( $tmp, 5 );
		$query = "UPDATE `olp_user`
					SET `score` = '" . mysql_real_escape_string( trim( $value ) ) . "'
					WHERE `id` = " . $id;
		mysql_query( $query );
	}
}
header( "location: ?do=user" );
?>
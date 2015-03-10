<?
	$query = "SELECT * FROM olp_user";
	$result = @mysql_query( $query );
	?>
	<div style="margin: auto auto">
		<form action="" method="post">
		<table>
			<tr>
				<td width="30%"></td>
				<td width="60%"> <? echo $lang['name'] ?></td>
				<td width="10%"> <? echo $lang['score'] ?></td>
			</tr>
	<?
	$i = 0;
	while( $line = mysql_fetch_array( $result, MYSQL_ASSOC ) )
	{
		$i++
		?>
		<tr>
			<td width="30%"> <? echo $lang['userid'] . ' ' . $i ?> </td>
			<td width="60%"><input type="text" size="50" name="user<? echo $line['id'] ?>" value="<? echo $line['name'] ?>" /> </td>
			<td width="60%"><input type="text" name="score<? echo $line['id'] ?>" value="<? echo $line['score'] ?>" /> </td>
		</tr>
	<?
	}
	?>
		</table>
		<br />
		<input type="hidden" name="do" value="user_update" />
		<center><input type="submit" value=" Save " /></center>
		</form>
	</div>
		
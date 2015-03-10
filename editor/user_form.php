<?php
	$query = "SELECT * FROM olp_user";
	$result = @mysql_query( $query );
	?>
	<div style="margin: auto auto">
		<form action="" method="post">
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
		<br />
		<input type="hidden" name="do" value="user_update" />
		<center><input type="submit" value=" Save " /></center>
		</form>
	</div>

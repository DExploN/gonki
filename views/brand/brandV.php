<form method='post' action='/action/admin/brandaction/' enctype="multipart/form-data" >
	<table  cellpadding='5' cellspacing='0' width='100%'>
		<tr>
			<td width='1'>Игра</td>
			<td>
				<?echo form::select($games,NULL,'name="gameId"','id','h1')?>
			</td>
		</tr>
		<tr>
			<td width='1'>Изоражение</td>
			<td>
				<input type='file' name='img' />
			</td>
		</tr>
		<tr>
			<td width='1'></td>
			<td>
				<input type='submit' name='add' value='Добавить' />
			</td>
		</tr>
	</table>
</form>
<br /><br /><br />
<table cellpadding='5' cellspacing='0' width='100%'>
	<tr>
		<td><b>Игра</b></td>
		<td ><b>Картинка</b></td>
		<td width='1'></td>
	</tr>
	<?foreach($list as $item){?>
		
		<tr>
		<td><a href='/g-<?=$item['newid']?>-<?=$item['url']?>/'><?=$item['h1']?></td>
		<td><a href='/uploads/brand/<?=$item['id']?>.jpg'><img src='/uploads/brand/<?=$item['id']?>.jpg'  width='100' height='80' /></a></td>
		<td><form method='post' action='/action/admin/brandaction/'> <input type='submit' value='Удалить' name='del' /> <input type='hidden' name='id' value='<?=$item['id']?>' /></form></td>
	</tr>
	<?}?>
</table>
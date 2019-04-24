<?=$right?>

	<div class='content conL'>
			<ul class="social-likes" style='float:right;margin-top:3px'>
					<li class="vkontakte" title="Поделиться ссылкой во Вконтакте">Поделиться</li>
					<li class="facebook" title="Поделиться ссылкой на Фейсбуке">Нравится</li>
					<li class="twitter" title="Поделиться ссылкой в Твиттере">Твитнуть</li>
					<li class="odnoklassniki" title="Поделиться ссылкой в Одноклассниках">Класс!</li>
					<li class="mailru" title="Поделиться ссылкой в Моём мире">Нравится</li>
					
			</ul>
			<h1><?=$h1?></h1>
			
			
			
			
			
			
			
		
	<div class='text'>
				<?=$text?>
		</div>
	
	<div class='gorblock' style='margin:20px'><?=adsenseM::getGor()?></div>
	
	
	<?if($games){?>
		<h2>Игры  c <?=$h1?>:</h2>
	<?}?>
	<?foreach($games as $item){?>
		<?$i++;?>
		<div class='itemblockMin'>
			<a href='/game/<?=$item['id']?>/<?=$item['url']?>/'>
				<img alt='<?=$item['h1']?>' src='/uploads/news/<?=$item['id']?>.jpg' />
				<div><?=$item['h1']?></div>
			</a>
		</div>
		<?if(($i%4)==0){?><div class='clear'></div><?}?>
	<?}?>
	
	<div class='clear'></div>
	
	<div class='gorblock' style='margin:20px'><?=adsenseM::getGor2()?></div>
	
	<?foreach($news as $cat){?>
		<?$i=0;?>
		<div class='clear'></div>
		<br /><h2><?=$cat['h1']?> <?=$h1?>:</h2>
			<?foreach($cat['items'] as $item){?>
			<?$i++;?>
			<div class='itemblockMin'>
				<a href='/news/<?=$item['id']?>/<?=$item['url']?>/'>
					<img alt='<?=$item['h1']?>' src='/uploads/news/<?=$item['id']?>.jpg' />
					<div><?=$item['h1']?></div>
				</a>
			</div>
			<?if(($i%4)==0){?><div class='clear'></div><?}?>
			<?}?>
	<?}?>
	
	
	
	<div class='clear'></div>
			<div class='blueline clear' style="margin:10px 0px;"></div>
			
	</div>
<?=$right?>
<?if(!$noadsense){?>
<div class='gorblock' style='margin:10px;margin-left:35px;'><?=adsenseM::getGor()?></div>
<?}?>
	<div class='content conL'>
			<ul class="social-likes" style='float:right;margin-top:3px'>
					<li class="vkontakte" title="Поделиться ссылкой во Вконтакте">Поделиться</li>
					<li class="facebook" title="Поделиться ссылкой на Фейсбуке">Нравится</li>
					<li class="twitter" title="Поделиться ссылкой в Твиттере">Твитнуть</li>
					<li class="odnoklassniki" title="Поделиться ссылкой в Одноклассниках">Класс!</li>
					<li class="mailru" title="Поделиться ссылкой в Моём мире">Нравится</li>
				
			</ul>
			<h1><?=$h1?></h1>
			
			
			
			
			
		<?if($id!=10){?>		
			<?$i=0;?>
			<?if($games){?>
				<h2>Игры раскраски:</h2>
				<?foreach($games as $item){?>
				<?$i++;?>
					<div class='itemblockMin'>
						<a href='/game/<?=$item['id']?>/<?=$item['url']?>/'>
							<img  alt='<?=$item['h1']?>' src='/uploads/news/<?=$item['id']?>.jpg' />
							<div><?=$item['h1']?></div>
						</a>
					</div>
					<?if(($i%4)==0){?><div class='clear'></div><?}?>
				<?}?>
				
			<?}?>			
			<div class='clear'></div>
			
			
			
			<?if($games){?><br /><h2>Картинки раскраски:</h2><?}?>
			<?$i=0;?>
			<?foreach($list as $item){?>
			<?$i++;?>
				<div class='itemblockMin'>
					<a href='/news/<?=$item['id']?>/<?=$item['url']?>/'>
						<img alt='<?=$item['h1']?>' <?=$height?> src='/uploads/news/<?=$item['id']?>.jpg' />
						<div><?=$item['h1']?></div>
					</a>
				</div>
				<?if(($i%4)==0){?><div class='clear'></div><?}?>
			<?}?>
			<div class='clear'></div>
			
		<?}?>
	
		<div class='clear'></div>
		
		<?if(!$noadsense){?>
		<div class='gorblock' style='margin:10px 20px;'><?=adsenseM::getGor()?></div>
		<?}?>


			<div class='blueline clear' style="margin:10px 0px;"></div>
			
			<div class='text'>
				<?if($h2){?><h2><?=$h2?></h2><?}?>
				<?=$text?>
			</div>
			
		<?if($id==10){?>
			<br /><br />
			<h2>Клипы и музыкальные видео отрывки::</h2>	
			<?foreach($list as $item){?>
			<?$i++;?>
				<div class='itemblockMin'>
					<a href='/news/<?=$item['id']?>/<?=$item['url']?>/'>
						<img alt='<?=$item['h1']?>' src='/uploads/news/<?=$item['id']?>.jpg' />
						<div><?=$item['h1']?></div>
					</a>
				</div>
				<?if(($i%4)==0){?><div class='clear'></div><?}?>
			<?}?>
			<div class='clear'></div>
					
		<div class='clear'></div>
		<?}?>
	
			
			
			
	</div>
	
	
	
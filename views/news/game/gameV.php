

		
		<div id='gamedetail'>
			<div class='ads' ><?=adsenseM::getGor()?></div>
			<?if($breadcrumb){?>
				<?=$breadcrumb?>
			<?}?>
			<h1>Игра «<?=$h1?>»</h1>
			
	
			<?
				if(!$gamewidth)$gamewidth=640;
				if($gamewh){
					$height=round($gamewidth/$gamewh);
				}else{
					$height=510;
				}
			?>
			
			<?if($swf){?>
			 <object type='application/x-shockwave-flash' data='<?=$swf?>'  width='<?=$gamewidth?>' height='<?=$height?>' wmode='direct' id='flashobj'>
					<param name='movie' value='<?=$swf?>'>
					<param name='allowScriptAccess' value='sameDomain' />
					<param name='quality' value='high' />
					<param name='wmode' value='direct' />
					<embed src='<?=$swf?>'  width='<?=$gamewidth?>' height='<?=$height?>' quality='high' allowScriptAccess='sameDomain' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />	
			</object>
			<?}?>
			<?if($gametext){?>
				<div id='flashobj'>
				<?=$gametext?>
				</div>
			<?}?>
			
			<!--noindex-->
			<div id='nextgame'>
				&rarr; ИГРАТЬ В СЛЕДУЮЩУЮ ИГРУ &larr;
			</div>
			<!--/noindex-->
			
			<ul class="social-likes gamelike">
					<li class="vkontakte" title="Поделиться ссылкой во Вконтакте">Поделиться</li>
					<li class="facebook" title="Поделиться ссылкой на Фейсбуке">Нравится</li>
					<li class="twitter" title="Поделиться ссылкой в Твиттере">Твитнуть</li>
					<li class="odnoklassniki" title="Поделиться ссылкой в Одноклассниках">Класс!</li>
					<li class="mailru" title="Поделиться ссылкой в Моём мире">Нравится</li>
				
			</ul>
			
			<?if($controls){?>
			<div id='controls'>
				<h2 style='margin-bottom:10px'>Управление и как играть в гонку:</h2> <span><?=$controls?></span>
			</div>
			
			<?}?>
			
			<div class='ads' style='margin:20px 0px;'><?=adsenseM::getGor2()?></div>
			
			<?if(!$gamevid){?>			
			<h2 style='margin-bottom:10px'>Еще бесплатные онлайн игры:</h2>
			<div id='perelink8' class='pergames'>
			<?foreach($perelink as $item){?>				
				<div class='gameitem'><?if($item['gamevid']){?><div class='videobut' data-link='<?=$item['gamevid']?>'></div><?}?><a href='/g-<?=$item['id']?>-<?=$item['url']?>/' title='<?=$item['h1']?>'><img src='/uploads/news/<?=$item['id']?>.jpg' alt='<?=$item['h1']?>'/><span><?=$item['h1']?></span></a></div>
			<?}?>
			</div>
			
			
			<?}else{?>
			
				<div style='overflow:hidden'>
					<div id='gamevid'>
						<h2>Видео прохождение:</h2>
						<iframe width="380" height="269" src="<?=$gamevid?>" allowfullscreen ></iframe>
						*Для увеличения видео нажмите на квадратик в правом нижнем углу плеера
					</div>
					
					<div  id='perelink4' class='pergames'>
						<h2 >Еще бесплатные онлайн игры:</h2>
						<?foreach($perelink as $item){?>	
								<div class='gameitem'><?if($item['gamevid']){?><div class='videobut' data-link='<?=$item['gamevid']?>'></div><?}?><a href='/g-<?=$item['id']?>-<?=$item['url']?>/' title='<?=$item['h1']?>'><img src='/uploads/news/<?=$item['id']?>.jpg' alt='<?=$item['h1']?>'/><span><?=$item['h1']?></span></a></div>
						<?}?>
					</div>
				</div>	
			<?}?>
			<div class='blueline clear' style="margin:10px 0px;"></div>
				<div class='text'>
					<img src='/uploads/news/<?=$id?>.jpg' style='margin:1px 5px;float:left' title='<?=$h1?>' alt='Игра <?=$h1?>' width='160' height='120' />
					<h2>Описание игры «<?=$h1?>»:</h2>
					<?=$text?>
			</div>
		
		</div>
		
		<div id='right'>
			<?$item=array_shift($right)?>
				<div class='gameitem'>
					<?if($item['gamevid']){?><div class='videobut' data-link='<?=$item['gamevid']?>'></div><?}?>
					<a href='/g-<?=$item['id']?>-<?=$item['url']?>/' title='<?=$item['h1']?>'>
						<img src='/uploads/news/<?=$item['id']?>.jpg' alt='<?=$item['h1']?>'/>
						<span><?=$item['h1']?></span>
					</a>
				</div>
			
			<div class='ads' style='margin-bottom:10px'> <?=adsenseM::getVert()?></div>
			
			<?foreach($right as $item){?>	
				<div class='gameitem'><?if($item['gamevid']){?><div class='videobut' data-link='<?=$item['gamevid']?>'></div><?}?><a href='/g-<?=$item['id']?>-<?=$item['url']?>/' title='<?=$item['h1']?>'><img src='/uploads/news/<?=$item['id']?>.jpg' alt='<?=$item['h1']?>'/><span><?=$item['h1']?></span></a></div>
			<?}?>
			
		</div>
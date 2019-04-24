<?/*
<div class='squareblock' style='margin:10px 70px;float:left;'><?=adsenseM::getSquare2()?></div>
<div class='squareblock' style='margin:10px 70px;float:left;'><?=adsenseM::getSquare3()?></div>
<div class='clear'></div>
*/?>




<div class='grid'>

					<h1><?=$h1?></h1>
					
					<div class='txtcentr'>
						
						<ul class="social-likes" >
							<li class="vkontakte" title="Поделиться ссылкой во Вконтакте">Поделиться</li>
							<li class="facebook" title="Поделиться ссылкой на Фейсбуке">Нравится</li>
							<li class="twitter" title="Поделиться ссылкой в Твиттере">Твитнуть</li>
							<li class="odnoklassniki" title="Поделиться ссылкой в Одноклассниках">Класс!</li>
							<li class="mailru" title="Поделиться ссылкой в Моём мире">Нравится</li>
						</ul>
						
					</div>	
				
					<?/*<div class='gridtis'></div>*/?>
					<?$i=1;?>
					<?foreach($list as $item){?><?if($i==1 && count($list)>=6 && !$noadsense){?><div class='gridtis ads'><?=adsenseM::getSquare1()?></div><?}?>	<?if($i==17 && count($list)>=20 && !$noadsense){?><div class='gridtis ads'><?=adsenseM::getSquare2()?></div><?}?>
						<div class='gameitem'><?if($item['gamevid']){?><div class='videobut' data-link='<?=$item['gamevid']?>'></div><?}?><a href='/g-<?=$item['id']?>-<?=$item['url']?>/' title='<?=$item['h1']?>'><img src='/uploads/news/<?=$item['id']?>.jpg' alt='<?=$item['h1']?>'/><span><?=$item['h1']?></span></a></div>
					<?$i++;}?>
				<div class='clear'></div>
	<?if($paginator){?>			
		<?=$paginator?>
	<?}?>	
	<?if(!$noadsense){?><div class='ads' style='margin:20px 80px;'><?=adsenseM::getGor()?></div><?}?>

	<div class='line clear' ></div>
	<?if($page==1){?>
		<div class='text'>
			<?=$text?>
		</div>
	<?}?>	
				
				
</div>
<div id='right'>
			<?foreach($list1 as $item){?>
				<div class='itemblockMin'>
					<a href='/game/<?=$item['id']?>/<?=$item['url']?>/'>
						<img alt='<?=$item['h1']?>' src='/uploads/news/<?=$item['id']?>.jpg' />
						<div><?=$item['h1']?></div>
					</a>
				</div>
			<?}?>
			
			<?if($adsense){?><div class='vertblock' style='float:left;margin:20px 7px'><?=adsenseM::getVert()?></div><?}?>
			
			<?foreach($list2 as $item){?>
				<div class='itemblockMin'>
					<a href='/game/<?=$item['id']?>/<?=$item['url']?>/'>
						<img alt='<?=$item['h1']?>' src='/uploads/news/<?=$item['id']?>.jpg' />
						<div><?=$item['h1']?></div>
					</a>
				</div>
			<?}?>
</div>
$(document).ready(function(){
	if (window.issue!=1){
		$(".ads").hide();
	}
	
	$(".videobut").click(function(){
		var link=$(this).data('link');
		/*
		$.fancybox(
		'<iframe width="560" height="315" src="'+link+'" frameborder="0" allowfullscreen></iframe>',
			{
				'autoDimensions'	: false,
				'width'         	: 315,
				'height'        	: 'auto',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			}
		);
		*/
		$.magnificPopup.open({
			items: {
					 src: link
			},
			type: 'iframe',
			iframe: {
				patterns: {
					youtube: {
						  index: 'youtube.com/', 
						  id: 'embed/', 
						  src: '//www.youtube.com/embed/%id%?autoplay=1' 
					}
				},
			 }
		});
	});
	
	$("#nextgame").click(function(){
		location.href=$(".pergames .gameitem").eq(0).find('a').attr('href');
	});
	
	$("#nextpagebut").click(function(){
		location.href=$(".nextpage").eq(0).attr('href');
	});
});

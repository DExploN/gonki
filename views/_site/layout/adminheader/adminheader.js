$(document).ready(function(){
	$(".delbut").click(function(){
		if (!confirm("Удалить?"))return false;
	})
	
	$('[name=gamevid]').on('change',function(){
		var str=$(this).val();
		var pattern='src\=[\"\'](.+?)[\"\']';
		var found=str.match(pattern);
		$(this).val(found[1]);
	})
})

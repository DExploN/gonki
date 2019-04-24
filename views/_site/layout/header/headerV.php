<!doctype html>
<html lang="ru">
<head>
<title><?=$title?></title>
<?if($description){?><meta name="description" content="<?=$description?>"  />
<?}?>
<?if($keywords){?><meta name="keywords" content="<?=$keywords?>"  />
<?}?>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<?if(!$noindex){?>
<meta name="robots" content="all" />
<?}else{?>
<meta name="robots" content="noindex, nofollow" />
<?}?>
<script src="/js/advert.js"  type="text/javascript" ></script>
<script src="/js/jquery.js"  type="text/javascript" ></script>
<?/*
<link rel="stylesheet" href="/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css"  />
<script type="text/javascript" src="/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
*/?>
<link rel="stylesheet" href="/js/plugins/magnific-popup/magnific-popup.css" type="text/css" />
<script type="text/javascript" src="/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<?
echo $this->getScripts();
echo $this->getStyles();
?>
<?if($og_image){?>
<meta property="og:image" content="<?=$og_image?>" />
<?}else{?>
<meta property="og:image" content="http://gonki-games.ru/img/logo.jpg" />
<?}?>
<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />

</head>
<body>
	<div id='container'>
			<div id='content'>
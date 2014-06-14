<?php 
if(isset($_REQUEST['album'])){
	$primary= file_get_contents("http://crichard.fr/flickr/func.php?action=getPhotosetPrimary&album=".$_REQUEST['album']);
	$url	= file_get_contents("http://crichard.fr/flickr/func.php?action=getPhotoUrl&photo=$primary");
	$title	= file_get_contents("http://crichard.fr/flickr/func.php?action=getPhotoTitle&photo=$primary");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<base href="/flickr/" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<!-- for Google -->
		<meta name="keywords" content="" />

		<meta name="author" content="C.Richard" />
		<meta name="copyright" content="C.Richard 2014" />
		<meta name="application-name" content="C.Richard Gallery" />

		<!-- for Facebook -->          
		<meta property="og:title" content="<?php echo "$title"; ?>" />
		<meta property="og:type" content="article" />
		<meta property="og:image" content="<?php echo "$url"; ?>" />
		<meta property="og:url" content="" />
		<!-- for Twitter -->          
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:title" content="<?php echo $title; ?>" />
		<meta name="twitter:image" content="<?php echo $url; ?>" />
		
		<title>C.Richard's gallery</title>
		<link href="css/dark-hive/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/waypoints.min.js"></script>
		<script type="text/javascript">
			var actualAlbumId = "<?php echo isset($_REQUEST['album'])?$_REQUEST['album']:'0'; ?>";
			var actualPhoto = "<?php echo isset($_REQUEST['photo'])?$_REQUEST['photo']:'0'; ?>";
		</script>
		<script type="text/javascript" src="js/script.js"></script>
	</head>
	<body>

		<div id="loadingNotif"></div>
		<div id="dialog" title="Photo" style="display: none; text-align:center;">
			<img id="imgLoading" src="css/img/loading.gif" />
			<img id="photoHD" src="" />
		</div>

		<div id="menu-container">
			<ul id="navigationMenu">
			</ul>
		</div>
		<div id="SetTitle"></div>
		<div id="content"></div>
		<footer></footer>
	</body>
</html>

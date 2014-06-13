<?php 
$url	= file_get_contents("http://crichard.fr/flickr/func.php?action=getPhotoUrl&photo=".$_REQUEST['photo']);
$title	= file_get_contents("http://crichard.fr/flickr/func.php?action=getPhotoTitle&photo=".$_REQUEST['photo']);
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
		<script type="text/javascript">
			var photoId = "<?php echo isset($_REQUEST['photo'])?$_REQUEST['photo']:'0'; ?>";
			$(function () {
				$("#photoHD").css('max-height', .90 * $(window).height()).css('max-width', .90 * $(window).width());
				$.getJSON("https://api.flickr.com/services/rest/?method=flickr.photos.getAllContexts&api_key=acf8e0e35f7d224d8f071714e46a851d&photo_id="+photoId+"&format=json&nojsoncallback=1", function (data) {
					if(data.stat == "ok"){
						$("#SetTitle").text(data.set[0].title);
					}else{
						alert('Erreur dans l\'albumId');
					}
				});
				
				$.getJSON("https://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=acf8e0e35f7d224d8f071714e46a851d&photo_id="+photoId+"&format=json&nojsoncallback=1", function (data) {
					if(data.stat == "ok"){
						imageId=$("#photoHD");
						$.each(data.sizes.size, function ( index, size, imageTag) {
							if (size.label == "Original") {
								imageId.attr('src', size.source);
							}
						});
						imageId.load(function () {
							$("#imgLoading").remove();
							$("#photoHD").show();
						});
					}else{
						alert('Erreur dans le photoId');
					}
				});
			});
			
			$( window ).resize(function() {
				$("#photoHD").css('max-height', .90 * $(window).height()).css('max-width', .90 * $(window).width());
			});
		</script>
	</head>
	<body>
		<div id="SetTitle"></div>
		<div id="dialog" title="Photo" style="text-align:center;">
			<img id="imgLoading" src="css/img/loading.gif" />
			<img id="photoHD" src="" style="display:none;" />
		</div>
	</body>
</html>

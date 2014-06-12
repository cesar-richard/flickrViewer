<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<base href="/flickr/" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>C.Richard's gallery</title>
		<link href="css/dark-hive/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script type="text/javascript">
			var albumId = "<?php echo isset($_REQUEST['album'])?$_REQUEST['album']:'0'; ?>";
			var photoId = "<?php echo isset($_REQUEST['photo'])?$_REQUEST['photo']:'0'; ?>";
			$.getJSON("https://api.flickr.com/services/rest/?method=flickr.photosets.getInfo&api_key=acf8e0e35f7d224d8f071714e46a851d&photoset_id="+albumId+"&format=json&nojsoncallback=1", function (data) {
				if(data.stat == "ok"){
					$("#SetTitle").text(data.photoset.title._content);
				}else{
					alert('Erreur dans l\'albumId');
				}
			}
			);
		</script>
	</head>
	<body>
		<div id="SetTitle"></div>
		<div id="dialog" title="Photo" style="text-align:center;">
			<img id="imgLoading" src="css/img/loading.gif" />
			<img id="photoHD" src="" />
		</div>
	</body>
</html>

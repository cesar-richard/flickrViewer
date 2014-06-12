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

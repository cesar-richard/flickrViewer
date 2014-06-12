<?php
if(isset($_REQUEST['rel'])){
echo "{";
	if(isset($_REQUEST['album']))
		echo "album:".$_REQUEST['album'];
	if(isset($_REQUEST['album'])&&isset($_REQUEST['photo']))
		echo ",";
	if(isset($_REQUEST['photo']))
		echo "photo:".$_REQUEST['photo'];
echo "}";
}else{
echo "OK";
}
?>
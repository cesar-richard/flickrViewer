<?php

ini_set('display_errors',1); 
if(isset($_REQUEST['debug'])){
	echo "{album:".(isset($_REQUEST['album'])?$_REQUEST['album']:0).", photo:".(isset($_REQUEST['photo'])?$_REQUEST['photo']:0)."}";
}else{
	// include class
	include_once 'Phlickr/Request.php';
	include_once 'Phlickr/Api.php';
	// instantiate service object with API key and secret
	$api = new Phlickr_Api('acf8e0e35f7d224d8f071714e46a851d', '021768673e024b43'); 
	// use the photo list and photo list iterator to display the titles and urls
	// of each of the photos.

	if(isset($_REQUEST['action'])){
		switch($_REQUEST['action']){
			case 'getPhotoUrl':
				$resp=$api->executeMethod(
					'flickr.photos.getSizes',
					array('photo_id' => $_REQUEST['photo'])
				);
				foreach ($resp->xml->sizes->size as $size) {
					if($size['label']=='Original')
						print $size['source'];
				}
			break;
			
			case 'getPhotoTitle':
				$resp=$api->executeMethod(
					'flickr.photos.getAllContexts',
					array('photo_id' => $_REQUEST['photo'])
				);
				print $resp->xml->set[0]->attributes()['title'];
			break;
			case 'getPhotosetPrimary':
				$resp=$api->executeMethod(
					'flickr.photosets.getInfo',
					array('photoset_id' => $_REQUEST['album'])
				);
				print $resp->xml->photoset->attributes()['primary'];
			break;
		}
	}else{
		echo "DIE !!!";
	}
}
?>
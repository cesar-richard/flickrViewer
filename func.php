<?php

ini_set('display_errors',1); 
if(!isset($_REQUEST['debug'])){
echo "{album:".(isset($_REQUEST['album'])?$_REQUEST['album']:0).", photo:".(isset($_REQUEST['photo'])?$_REQUEST['photo']:0)."}";
}else{
	// include class
	require_once 'Phlickr/Framework/ObjectBase.php';
	include_once 'Phlickr/Cache.php';
	include_once 'Phlickr/Request.php';
	include_once 'Phlickr/PhotoList.php';
	include_once 'Phlickr/PhotoListIterator.php';
	include_once 'Phlickr/Photo.php';
	include_once 'Phlickr/Api.php';
	// instantiate service object with API key and secret
	$api = new Phlickr_Api('acf8e0e35f7d224d8f071714e46a851d', '021768673e024b43');

$request = $api->createRequest(
    'flickr.people.getPublicPhotos',
    array(
        'user_id' => $_REQUEST['album'],
		'per_page' => 2,
		'page' => 1
    )
);

 
// use the photo list and photo list iterator to display the titles and urls
// of each of the photos.

$photolist = new Phlickr_PhotoList($request);
$iterator = new Phlickr_PhotoListIterator($photolist);

foreach ($iterator as $photos) {
    foreach ($photos as $photo) {
        print "Photo: {$photo->getTitle()}\n";
        print "\t{$photo->buildImgUrl(Phlickr_Photo::SIZE_500PX)}\n";
    }
}

}
?>
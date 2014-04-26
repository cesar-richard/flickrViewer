$(function(){
	$("#photoHD").css('max-height', .90*$( window ).height());
	$("#photoHD").css('max-width', .90*$( window ).width());	

	getAlbums();
	
	dispPublicPhotos();

	$.ajaxSetup({
		"error":function() { $("#content").append("Such problems");  }
	});

	initializeUI();
	
});




			
function getPhotosFromAlbum(albumId){
	$.getJSON("https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=acf8e0e35f7d224d8f071714e46a851d&photoset_id="+albumId+"&format=json&nojsoncallback=1",
	function(data){
		$("#content").empty();			
		$("#SetTitle").text(data.photoset.title);
		$.each(data.photoset.photo,function( index, photo ) {
			$("#content").append("<img height='333px' photoId='"+photo.id+"' src='" + "http://c2.staticflickr.com/" + photo.farm + "/" + photo.server + "/" + photo.id + "_" + photo.secret + ".jpg'/>");
		});
		initializeUI();
	});
}

function getAlbums(){
	$.getJSON("https://api.flickr.com/services/rest/?method=flickr.photosets.getList&api_key=acf8e0e35f7d224d8f071714e46a851d&user_id=106549958%40N08&format=json&nojsoncallback=1",
	function(data){
		$("#navigationMenu").empty();
		$.each(data.photosets.photoset,function( index, album ) {
			$("#navigationMenu").append("<li><a albumId='" + album.id + "' href=\"#\" class=\"normalMenu\">" + album.title._content + "</a></li>");
		});
		initializeUI();
		//$("#navigationMenu").prepend("<li><a id="home" href=\"#\" class=\"selectedMenu\">Accueil</a></li>").click(dispPublicPhotos());
	});
}

function initializeUI(){
	$(".selectedMenu").each(function(){
		$(this).removeClass().addClass("normalMenu").before($(this).children().clone().removeClass().addClass('hoverMenu'));
        });


	$('#navigationMenu li .normalMenu').each(function(){
		$(this).before($(this).clone().removeClass().addClass('hoverMenu'));
	});
	
	$('#navigationMenu li').each(function(){
		$(this).click(function(){
			$(".selectedMenu").each(function(){
                		$(this).removeClass().addClass("normalMenu");
				$("#navigationMenu li a[albumId="+id+"]").before($(this).clone().removeClass().addClass('hoverMenu'));
		        });
			
			id = $(this).children().attr("albumId");
			getPhotosFromAlbum(id);
			$("#content img").click(function(event){
               			event.preventDefault();
               			PreviewImage($(this).attr('photoId'));
	        	});

			$("#navigationMenu li a[albumId=\""+id+"\"].hoverMenu").remove();
			$("#navigationMenu li a[albumId="+id+"]").removeClass().addClass("selectedMenu");
		});
	});
	
	$('#navigationMenu li').hover(function(){
	
		$(this).find('.hoverMenu').stop().animate({marginTop:'0px'},200);

	},
	
	function(){
	
		$(this).find('.hoverMenu').stop().animate({marginTop:'-25px'},200);

	});
	$("#content").ready(function(){
		$("#content img").click(function(event){
			event.preventDefault();
			PreviewImage($(this).attr('photoId'));
		});
	});
}

function dispPublicPhotos(){
	$.getJSON("https://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key=acf8e0e35f7d224d8f071714e46a851d&user_id=106549958%40N08&per_page=20&format=json&nojsoncallback=1",
        function(data){
                $("#navigationMenu").empty();
		$("#SetTitle").text("Dernières photos");
                $.each(data.photos.photo,function( index, photo) {
			$("#content").append("<img height='333px' photoId='"+photo.id+"' src='" + "http://c2.staticflickr.com/" + photo.farm + "/" + photo.server + "/" + photo.id + "_" + photo.secret + ".jpg'/>");
                });
		initializeUI();
        });	
}

PreviewImage = function(photoId) {

  //Get the HTML Elements
  imageId = $("#photoHD");

  //Set the image src
  getPhotoSize(photoId,"Original",imageId.attr('id'));

  //When the image has loaded, display the dialog
  imageId.load(function(){

    $('#dialog').dialog({
      modal: true,
      resizable: false,
      draggable: false,
      height: 'auto',
      width:  'auto',
      title: $("#SetTitle").text()
    });
  });   
}

getPhotoSize = function(photoId, wishedSize, imageId){
	$.getJSON("https://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=acf8e0e35f7d224d8f071714e46a851d&photo_id="+photoId+"&format=json&nojsoncallback=1",
        function(data){
                $.each(data.sizes.size,function( index, size, imageTag ) {
                        if(size.label == wishedSize){
				$("#"+imageId).attr('src', size.source);
			}
                });
	});
}


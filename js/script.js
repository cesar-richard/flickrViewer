var actualPage = 1;
var totalPages = 1;
var actualAlbumId = 0;
$(function () {
    getAlbums();
	
	dispPublicPhotos();
    $.ajaxSetup( {
        "error" : function () {
            $("#content").append("Such problems");
        }
    }
    );
     initializeUI();
}
);
function getPhotoAPIUrl(albumId, page) {
    return "https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=acf8e0e35f7d224d8f071714e46a851d&photoset_id=" + albumId + "&per_page=1&page=" + page + "&format=json&nojsoncallback=1";
}
function initWaypoints() {
    $.waypoints('destroy');
    var $loading = $("<div class='loading'><H1><p>Loading more items&hellip;</p></H1></div>");
    $footer = $('footer');
    opts = {
        offset : 'bottom-in-view'
    };
    $footer.waypoint(function (event, direction) {
        if (actualPage < totalPages) {
            $.waypoints('disable');
            $('#loadingNotif').append($loading).fadeIn('slow');
            $.getJSON(getPhotoAPIUrl(actualAlbumId, actualPage + 1), function (data) {
                actualPage = parseInt(data.photoset.page);
                $("#content").append("<div id='page" + actualPage + "' class='imgContainer' style='display:none;'>");
                $.each(data.photoset.photo, function ( index, photo) {
                    $("#page" + actualPage).append("<a rel='tab' href='func.php?rel&album="+actualAlbumId+"&photo="+photo.id+"'><img photoPage='" + actualPage + "' photoId='" + photo.id + "' src='" + constructPhotoUrl(photo.id, photo.farm, photo.server, photo.secret) + "'/></a>");
                }
                );
                $("#content").append("</div>");
                $("#page" + actualPage).fadeIn('slow');
				$('#loadingNotif').fadeOut('slow');
                $('.loading').remove();
                $.waypoints('enable');
                $footer.waypoint(opts);
            }
            );
        }
    }
    , opts);
}
function constructPhotoUrl(id, farm, server, secret) {
    return "http://c2.staticflickr.com/" + farm + "/" + server + "/" + id + "_" + secret + ".jpg";
}
function getPhotosFromAlbum(albumId) {
    actualAlbumId = albumId;
    $.getJSON(getPhotoAPIUrl(albumId, 1), function (data) {
        $("#content").empty();
        $("#SetTitle").text(data.photoset.title);
        totalPages = parseInt(data.photoset.pages);
        $.each(data.photoset.photo, function ( index, photo) {
            $("#content").append("<div id='page1' class='imgContainer'><a rel='tab' href='func.php?rel&album="+albumId+"&photo="+photo.id+"'><img photoPage='1' photoId='" + photo.id + "' src='" + constructPhotoUrl(photo.id, photo.farm, photo.server, photo.secret) + "'/></a></div>");
        }
        );
         initWaypoints();
        //repaintMenu();
    }
    );
}
function getAlbums() {
    $.getJSON("https://api.flickr.com/services/rest/?method=flickr.photosets.getList&api_key=acf8e0e35f7d224d8f071714e46a851d&user_id=106549958%40N08&format=json&nojsoncallback=1", function (data) {
        $("#navigationMenu").empty();
        $.each(data.photosets.photoset, function ( index, album) {
            $("#navigationMenu").append("<li><a albumId='" + album.id + "' href=\"#\" class=\"normalMenu\">" + album.title._content + "</a></li>");
        }
        );
        repaintMenu();
    }
    );
}
function initializeUI() {
    $(document).on("click", "#content img", function (event) {
        event.preventDefault();
        PreviewImage($(this).attr('photoId'));
    }
    );
	
	$(document).on('click',"a[rel='tab']",function (event){
		//get the link location that was clicked
		pageurl = $(this).attr('href');
		
		//to get the ajax content and display in div with id 'content'
		$.ajax({url:pageurl+'?rel=tab',success: function(data){
			$('#content').html(data);
		}});
		
		//to change the browser URL to 'pageurl'
		if(pageurl!=window.location){
			window.history.pushState({path:pageurl},'',pageurl);	
		}
		return false;
	});
	
    $(document).on("click", "#photoHD", function (event) {
        $('#dialog').dialog('close');
    });
	
	$( window ).resize(function() {
		$("#photoHD").css('max-height', .90 * $(window).height()).css('max-width', .90 * $(window).width());
		$(".ui-dialog").position( {
            my : 'center',
			at : 'center',
			of : window,
			collision : 'fit'
        });
	});
	
    $(document).on('click', '#navigationMenu li', function () {
        $(".selectedMenu").each(function () {
            $(this).removeClass().addClass("normalMenu");
            $("#navigationMenu li a[albumId=" + id + "]").before($(this).clone().removeClass().addClass('hoverMenu'));
        }
        );
        id = $(this).children().attr("albumId");
        getPhotosFromAlbum(id);
        $("#navigationMenu li a[albumId=\"" + id + "\"].hoverMenu").remove();
        $("#navigationMenu li a[albumId=" + id + "]").removeClass().addClass("selectedMenu");
    }
    );
    $(document).on('mouseenter', '#navigationMenu li', function () {
        $(this).find('.hoverMenu').stop().animate( {
            marginTop : '0px'
        }
        , 200);
    }
    );
    $(document).on('mouseleave', '#navigationMenu li', function () {
        $(this).find('.hoverMenu').stop().animate( {
            marginTop : '-25px'
        }
        , 200);
    }
    );
    $("#photoHD").css('max-height', .90 * $(window).height()).css('max-width', .90 * $(window).width());
    //repaintMenu();
}
function repaintMenu() {
    $(".selectedMenu").each(function () {
        $(this).removeClass().addClass("normalMenu").before($(this).children().clone().removeClass().addClass('hoverMenu'));
    }
    );
    $('#navigationMenu li .normalMenu').each(function () {
        $(this).before($(this).clone().removeClass().addClass('hoverMenu'));
    }
    );
}
function dispPublicPhotos() {
    $.getJSON("https://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key=acf8e0e35f7d224d8f071714e46a851d&user_id=106549958%40N08&per_page=6&format=json&nojsoncallback=1", function (data) {
        $("#navigationMenu").empty();
        $("#SetTitle").text("Dernières photos");
        $.each(data.photos.photo, function ( index, photo) {
            $("#content").append("<div class='imgContainer'><img photoId='" + photo.id + "' src='" + constructPhotoUrl(photo.id, photo.farm, photo.server, photo.secret) + "'/></div>");
        }
        );
        //repaintMenu();
    }
    );
}
PreviewImage = function (photoId) {
    //Get the HTML Elements
    imageId = $("#photoHD");
    imgLoadingId = $("#imgLoading");
    imgLoadingId.show();
    imageId.hide();
    $('#dialog').dialog( {
        modal : true,
		resizable : false,
		draggable : false,
		height : 'auto',
		width : 'auto',
		title : $("#SetTitle").text(),
		position : 'center'
    }
    );
    //Set the image src
    getPhotoSize(photoId, "Original", imageId.attr('id'));
    //When the image has loaded, display the dialog
    imageId.load(function () {
        imgLoadingId.hide();
        imageId.show();
        $(".ui-dialog").position( {
            my : 'center',
			at : 'center',
			of : window,
			collision : 'fit'
        }
        );
    }
    );
}
getPhotoSize = function (photoId, wishedSize, imageId) {
    $.getJSON("https://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=acf8e0e35f7d224d8f071714e46a851d&photo_id=" + photoId + "&format=json&nojsoncallback=1", function (data) {
        $.each(data.sizes.size, function ( index, size, imageTag) {
            if (size.label == wishedSize) {
                $("#" + imageId).attr('src', size.source);
            }
        }
        );
    }
    );
}

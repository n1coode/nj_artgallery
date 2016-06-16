/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var __njartgallery_extkey			= 'tx_njartgallery'
var __njartgallery					= '.' + __njartgallery_extkey;

//controller: artist
var __njartgallery_artist			= __njartgallery + '.artist';
var __njartgallery_artist_focus		= __njartgallery_artist + '.focus';

//controller: exhibition
var __njartgallery_exhibition			= __njartgallery + '.exhibition';
var __njartgallery_exhibition_focus		= __njartgallery_exhibition + '.focus';

var __njartgallery_exhibition_teaser		= __njartgallery_exhibition + '.actualTeaser'; 
var __njartgallery_exhibition_teaser_ribbon = __njartgallery_exhibition_teaser + ' .ribbon';
var __njartgallery_exhibition_teaser_banner = __njartgallery_exhibition_teaser + ' .banner';

var __njartgallery_exhibition_impressions = __njartgallery_exhibition + ' .impressions';
var __njartgallery_exhibition_artworks = __njartgallery_exhibition + ' .artworks';

var _njartgallery_ajax_ACTION_image = 'image';
var _njartgallery_ajax_EXTKEY		= __njartgallery_extkey + '_pi1';

var _njartgallery_exhibition_artworks_alreadyViewed = false;

//
// Event-Handler : document.ready -> on('click','mouseenter','mouseleave')
//
$(document).ready(function() 
{
	//init
	if(
		$(__njartgallery_exhibition_teaser).length > 0 &&
		$(__njartgallery_exhibition_teaser + ' .ribbon').css('display') !== 'none') 
	{
		tx_njartgallery_exhibition_teaser_init();
	}
	
	/**
	 * on click -> artist : show Artwork
	 */
	$(document).on('click',__njartgallery_artist_focus + ' .artworks .thumbnail',function()
	{
		$(this).animateCss("flipInY");
		
		if($(this).attr('data-artwork')) 
		{
			var params = [];
			params['action'] = _njartgallery_ajax_ACTION_image;
			params['artwork'] = $(this).attr('data-artwork');
			params['model'] = 'artist';
			params['collection'] = tx_njartgallery_getCollection(params,$(this).parent().find('.thumbnail'));
			tx_njartgallery_ajaxCall(params);
		}
	});
	
	/**
	 * on click -> exhibition : show Artwork
	 */
	$(document).on('click',__njartgallery_exhibition_focus + ' .artworks .thumbnail',function()
	{
		$(this).animateCss("flipInY");
		
		if($(this).attr('data-artwork')) 
		{
			var params = [];
			params['action'] = _njartgallery_ajax_ACTION_image;
			params['artwork'] = $(this).attr('data-artwork');
			params['model'] = 'exhibition';
			params['collection'] = tx_njartgallery_getCollection(params,$(this).parent().find('.thumbnail'));
			tx_njartgallery_ajaxCall(params);
			
		}
	});
	
	$(document).on('click','#n1ajax .prev,#n1ajax .next',function()
	{
		var params = [];
			params['prevnext'] = 1;
			params['action'] = _njartgallery_ajax_ACTION_image;
			params['artwork'] = $(this).attr('data-artwork');
			params['collection'] = $(this).attr("data-collection");
			tx_njartgallery_ajaxCall(params);
	});
	
	$(document).on('click','#n1ajax .close',function() 
	{
		tx_njartgallery_ajax_close();
	});
	
	
	$(document).on('click','.impressions .navigation li.inactive',function()
	{
		tx_njartgallery_exhibition_impressions_navClick($(this));
	});
	
	if($(__njartgallery_exhibition_impressions).length > 0)
	{
		tx_njartgallery_exhibition_impressions_init();
	}
	
	
	
	
	$(document).on('mouseenter', __njartgallery_exhibition_artworks + ' IMG',function()
	{
		$(this).addClass('blur');
	});
	$(document).on('mouseleave', __njartgallery_exhibition_artworks + ' IMG',function()
	{
		$(this).removeClass('blur');
	});
	
});



$(document).ready(function() 
{
	$(window).scroll(function() 
	{
		if(!_njartgallery_exhibition_artworks_alreadyViewed
			&& tx_njcollection_getDimensions(_ACTION_GET_WIDTH_VIEWPORT) >= 800)
		{
			tx_njartgallery_exhibition_teaser_artworks_show();
		}
	});
});

$(document).ready(function() 
{
	$(window).on("orientationchange",function(event)
	{
		if(_njartgallery_exhibition_artworks_alreadyViewed)
		{
			var display = 'block';
			if(tx_njcollection_orientationIsPortrait())
			{
				display = 'none';
			}
			$(__njartgallery_exhibition_teaser + ' .artwork').css('display',display);
		}
	});
});


/**
 * Exhibitions : actual teaser 
 */

/**
 * .actHeight,.actWidth
 * .initHeight,.initTitleSize,.initWidth
 * @type Array
 */
var _njartgallery_exhibition_teaser_ribbon = [];


function tx_njartgallery_exhibition_teaser_init()
{
	tx_njartgallery_exhibition_teaser_dim_set();
}


function tx_njartgallery_exhibition_teaser_dim_set(resize)
{
	var setDimensions = false;
	if($(__njartgallery_exhibition_teaser + " .ribbon").css('display') !== 'none')
	{
		setDimensions = true;
	}
	
	if(setDimensions)
	{
		var width = $(__njartgallery_exhibition_teaser).outerWidth();
		height = (width * 9) / 16;
		$(__njartgallery_exhibition_teaser).css({height:height});

		var ribbonDimensions = tx_njartgallery_exhibition_teaser_ribbon_dim_set(resize);

		$(__njartgallery_exhibition_teaser + " .ribbon .title H2").css({
			lineHeight: ribbonDimensions.actHeight+'px',
			fontSize: ribbonDimensions.actHeight * 0.7
		});
		$(__njartgallery_exhibition_teaser + " .banner").css({
			marginTop: ribbonDimensions.actHeight - 1
		});
		$(__njartgallery_exhibition_teaser + " .banner H3").css({
			fontSize: int(ribbonDimensions.initTitleSize) / (ribbonDimensions.initWidth / ribbonDimensions.actWidth),
			paddingTop : int(25) / (ribbonDimensions.initWidth / ribbonDimensions.actWidth)
		});
		
		var fontSizeMax = int(ribbonDimensions.initTextSize);
		var fontSize = (int(ribbonDimensions.initTextSize) / (ribbonDimensions.initWidth / ribbonDimensions.actWidth)) * 1.5;
		if(fontSize > fontSizeMax) { fontSize = fontSizeMax; }
		$(__njartgallery_exhibition_teaser + " .artists,"+__njartgallery_exhibition_teaser + " .date").css({
			fontSize: fontSize
		});

		tx_njartgallery_exhibition_teaser_artworks_set();
	}
	else
	{
		$(__njartgallery_exhibition_teaser).css('height','');
	}
}


function tx_njartgallery_exhibition_teaser_ribbon_dim_set(resize)
{
	if($(__njartgallery_exhibition_teaser + ' .ribbon .flexitem[data-position="center"] svg').length > 0)
	{
		var svg = document.getElementById($(__njartgallery_exhibition_teaser + ' .ribbon .flexitem[data-position="center"] svg').attr('id'));
		var rect = svg.getElementsByClassName("main")[0];
		
		var dimensions = _njartgallery_exhibition_teaser_ribbon;
		
		if(!resize)
		{
			dimensions.initWidth = svg.viewBox.baseVal.width;
			dimensions.initHeight = rect.height.animVal.value;

			dimensions.initTitleSize = $(__njartgallery_exhibition_teaser + " .banner h3" ).css('fontSize');
			dimensions.initTextSize = $(__njartgallery_exhibition_teaser + " .artists" ).css('fontSize');
		}
		
		dimensions.actWidth = $(__njartgallery_exhibition_teaser + " .ribbon .flexitem").width();
		dimensions.actHeight = (dimensions.actWidth / dimensions.initWidth) * dimensions.initHeight;
	
		_njartgallery_exhibition_teaser_ribbon = dimensions;
		
		return dimensions;
	}
}


function tx_njartgallery_exhibition_teaser_artworks_set()
{
	var top = int($(__njartgallery_exhibition_teaser + " .ribbon").height()) * 2;
	$(__njartgallery_exhibition_teaser + " .artwork IMG").css({marginTop:top+"px"});
}


function tx_njartgallery_exhibition_teaser_artworks_show()
{
	if($(__njartgallery_exhibition_teaser + ' .flexitem').isOnScreen()
		&& $(__njartgallery_exhibition_teaser + ' .flexitem').offset().top >= tx_njcollection_getDimensions(_ACTION_GET_HEIGHT_VIEWPORT) / 3
	)
	{
		setTimeout(function()
		{
			$(__njartgallery_exhibition_teaser + ' .artwork.left').show(0).animateCss('bounceInLeft');
			$(__njartgallery_exhibition_teaser + ' .artwork.right').show(0).animateCss('bounceInRight');

		},250);
		_njartgallery_exhibition_artworks_alreadyViewed = true;
	}
}

jQuery.fn.isOnScreen = function()
{
    var win = jQuery(window);
 
    var viewport = {
        top : win.scrollTop(),
        left : win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();
 
    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();
 
    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
 
};


function tx_njartgallery_exhibition_teaser_scale()
{
	tx_njartgallery_exhibition_teaser_dim_set(true);
}



var n1resizeTimer;
$(window).on('resize', function(e) 
{
	clearTimeout(n1resizeTimer);
	resizeTimer = setTimeout(function() 
	{
		tx_njartgallery_exhibition_teaser_scale();
	}, 250);
});

/** end of Exhibitions : teaser actual */


/**
 * 
 * @param {object} $this
 * @returns {void}
 */
function tx_njartgallery_exhibition_impressions_navClick($this)
{
	var settings = __njartgallery_exhibition_impressions_settings;
	
	
	var index = parseInt($this.attr('data-index'));
	
	$(settings['image']+','+settings['navigation']+' LI').removeClass(_STATUS_INACTIVE + ' ' + _STATUS_ACTIVE);
	$(settings['image']+'[data-index="'+index+'"],'+settings['navigation']+' LI[data-index="'+index+'"]').addClass(_STATUS_ACTIVE);
	$(settings['image']+'[data-index!="'+index+'"],'+settings['navigation']+' LI[data-index!="'+index+'"]').addClass(_STATUS_INACTIVE);
		
	var positionCenter = (settings['widthScreen'] - settings['widthImage']) / 2;
	
	var center = Math.ceil(settings['imagesToRender'] / 2);
	var itm = Math.floor(settings['imagesToRender'] / 2);
//	alert(settings['imagesToRender']+','+Math.ceil(settings['imagesToRender'] / 2)+','+itf);
	//alert(index - itm);
	
	setTimeout(function()
	{
		var center = Math.ceil(settings['imagesToRender'] / 2);
		var itm = Math.floor(settings['imagesToRender'] / 2); //images to move
		
		$(settings['image']+'.active').animateCss('flipInX');
		
		//left hand
		if((index - itm) > -1)
		{
			for(var i=itm;i>0;i--)
			{
				//alert(settings['image']+'[data-index="'+(index-i)+'"]');
				setImage('left',(index-i),i);
				//$(settings['image']+'[data-index="'+(index-i)+'"]').animate({left:positionCenter - (settings['widthImage'] * i)},250);
			}	
		}
		else if((index - itm) === -1)
		{
			var i=1;
			setImage('left',(index-i),i);
			i=2;
			setImage('left',(settings['noi'] - 1),i);
		}
		else
		{
			for(var i=itm;i>0;i--)
			{
				setImage('left',(settings['noi'] - i),i);
			}	
		}
		
		//right hand
		if((index + itm) <= (settings['noi'] - 1))
		{
			for(var i=1;i<=itm;i++)
			{
				setImage('right',(index+i),i);
			}	
		}
		else {
			if((index + itm) === (settings['noi']))
			{
				var i=1;
				setImage('right',(index+i),i);
				i=2;
				setImage('right',(0),i);
			}
			else
			{
				for(var i=1;i<=itm;i++)
				{
					setImage('right',(i - 1),i);
				}	
			}
		}	
		
	},250);
	$(settings['image']).animateCss('fadeOut');
	$(settings['image']).animate({left:positionCenter},150);
	
	function setImage(side,dataIndex,i) {
		var position;
		
		if(side === 'left') { position = parseInt(positionCenter) - (parseInt(settings['widthImage'] * i)); }
		else { position = parseInt(positionCenter) + (parseInt(settings['widthImage'] * i)); }
		
		$(settings['image']+'[data-index="'+dataIndex+'"]').animate({left:position},250);
	}
}


var __njartgallery_exhibition_impressions_settings = [];

var __njartgallery_exhibition_impressions_collection;
var __njartgallery_exhibition_impressions_image;
var __njartgallery_exhibition_impressions_noi = 0; //number of images





function tx_njartgallery_exhibition_impressions_init()
{
	var settings = [];
	settings['collection'] = __njartgallery_exhibition_impressions + " .collection";
	settings['image'] = settings['collection'] + " >DIV";
	settings['noi'] = $(settings['image']).length; //number of images
	
	
	if(settings['noi'] > 0)
	{	
		settings['height'] = $(settings['image']).height();
		settings['margin'] = 2.5;
		settings['navigation'] = __njartgallery_exhibition_impressions + " .navigation";
		settings['widthImage'] = $(settings['image']).width() + (2 * settings['margin']);
		settings['widthScreen'] = tx_njcollection_getDimensions(_ACTION_GET_WIDTH_VIEWPORT);
		settings['widthCollection'] = settings['widthImage'] * settings['noi'];
		
		var positionCenter = (settings['widthScreen'] - settings['widthImage']) / 2;
		
		$(settings['collection']).css({height:settings['height']});
		
		
		$(settings['image']).css({left: positionCenter,position:'absolute',width:settings['widthImage']});
		$(settings['image'] + ' IMG').css({marginLeft:settings['margin']});
		
		$(settings['image']+'[data-index="0"],'+settings['navigation']+' LI[data-index="0"]').addClass(_STATUS_ACTIVE);
		$(settings['image']+'[data-index!="0"],'+settings['navigation']+' LI[data-index!="0"]').addClass(_STATUS_INACTIVE);
		
		settings['imagesPerScreen'] = tx_njcollection_mathRoundDown(settings['widthScreen'] / settings['widthImage']);
		settings['imagesToRender'] = settings['widthScreen'] / settings['widthImage'] > 0 ? settings['imagesPerScreen'] +  2 : settings['imagesPerScreen'];
		
		
		
		var index = parseInt($(settings['image']+'.active').attr('data-index'));
		var center = Math.ceil(settings['imagesToRender'] / 2);
		var position = index + 1;
		
		var itf = center - position; //images to flip
		
		if(position < center)
		{
			for(var i=itf;i>0;i--)
			{
				$(settings['image']+':nth-child('+(settings['noi']-i)+')').css({left:positionCenter - (settings['widthImage'] * i)});
			}
		} 
		
		for(var i=1;i<=itf;i++)
		{
			
			$(settings['image']+':nth-child('+(position+i)+')').css({left:positionCenter + (settings['widthImage'] * i)});
			//$(settings['image']+':nth-child('+(settings['noi']-i)+')').css({left:positionCenter - (settings['widthImage'] * i)});
		}
		
		
		$(settings['image']).fadeIn(250);
		
	//	$(settings['navigation'] + ' LI').first().addClass(_STATUS_ACTIVE);
	//	$(settings['navigation'] + ' LI').not($(settings['navigation'] + ' LI').first()).addClass(_STATUS_INACTIVE);
		
		
	
		__njartgallery_exhibition_impressions_settings = settings;
		
	}
}





function tx_njartgallery_getCollection(params,selector)
{
	var collection = '';
	
	$(selector).not($(selector).last()).each(function()
	{
		collection += $(this).attr('data-artwork') + ',';
	});
	collection += $(selector).last().attr('data-artwork');
	
	return collection;
}






//
// AJAX
//
function tx_njartgallery_ajaxCall(params)
{
	params['lang_iso'] = $("html").attr("lang");

	switch(params["action"]) 
    {
		case _njartgallery_ajax_ACTION_image:
			
			params['width'] = tx_njcollection_getDimensions(_ACTION_GET_WIDTH_VIEWPORT);
			params['height'] = tx_njcollection_getDimensions(_ACTION_GET_HEIGHT_VIEWPORT);
			tx_njartgallery_ajaxHandler(true, params);
		break;
		
		default:;
	}
	
} //end of function tx_njportfolio_ajaxCall


function tx_njartgallery_ajaxHandler(loader, params)
{
	params['controller']    = "Ajax";
	n1console(params);
	
	n1console(_njartgallery_settings);
	
	var data = 'index.php?id='
		+ _njartgallery_settings['pageId'] 
		+ '&type=' 
        + _njartgallery_settings['typeNum'] 
        + '&L='
        + _njartgallery_settings['langId'];
	
	for(var index in params) 
    {
        data = data.concat("&"+_njartgallery_ajax_EXTKEY+"[",index,"]=",params[index]);
    }
	
	n1console(data,'data');
	
	$.ajax(
	{
		async: 'true',
		url: data,
		type: 'POST',
		dataType: 'json',
		data: {},
		beforeSend: function()
		{
			switch(params.action)
			{
				case _njartgallery_ajax_ACTION_image:
					tx_njartgallery_ajax_before_image(params);
					break;
				default:;
			}
		}
	}).done(function(data)
	{
		
		var funcName = 'tx_njartgallery_ajax_done_'+params.action;
		
		var func = window[funcName];
		if (typeof func === 'function') {
			func(data);
		}
		
	}).fail(function(xhr,e)
	{
		var message = '';
		
		if(xhr.status==0){
				message = 'You are offline!!\n Please Check Your Network.';
		}else if(xhr.status==404){
				message = 'Requested URL not found.\n' + xhr.responseText;
		}else if(xhr.status==500){
				message = 'Internel Server Error.\n' + xhr.responseText;
		}else if(e=='parsererror'){
				message = 'Parsing JSON Request failed.\n' + xhr.responseText;
		}else if(e=='timeout'){
				message = 'Request Time out.';
		}else {
				message = 'Unknown Error.\n' + xhr.responseText;
		}
		
		$('#n1footer').prepend(message);
	}).always();

}

function tx_njartgallery_ajax_before_image(params)
{
	if(params['prevnext'] == 1)
	{
		$('#n1ajax .title').animateCss('flipOutX');
		$('#n1ajax .title').remove();
		$('#n1ajax .artist').animateCss('flipOutX');
		$('#n1ajax .artist').remove();
		$('#n1ajax .info').remove();
		$('#n1ajax .prev').animate({left:-1*$('#n1ajax .prev').outerWidth(true)},125,function(){$(this).remove();});
		$('#n1ajax .next').animate({right:-1*$('#n1ajax .next').outerWidth(true)},125,function(){$(this).remove();});
		$('body #n1ajax .artwork').animateCss('flipOutX');
		$('body #n1ajax .artwork').remove();
		tx_njartgallery_ajax_loader_toggle(_ACTION_SHOW);
	}
	else
	{
		
		if($('body #n1ajax').length > 0)
		{
			$('body #n1ajax').fadeOut('fast').remove();
		}
		setTimeout(function()
		{
			$('body').addClass('noscrollbar');
			$('body #n1ajax').slideDown(200).append(tx_njartgallery_ajax_loader('3balls'));
			setTimeout(function()
			{
				$('#n1ajax .overlay').fadeIn(500,function(){
					$('#n1ajax').prepend('<div class="close">'
						+ '<div class="icon"><i class="fa fa-times-circle"></i></div>'
						+ '<div class="bg"></div>'
						+ '</div>');
					setTimeout(function()
					{
						$('#n1ajax .close').animate({top:0,right:0},125,function()
						{
							$(this).find("I").animateCss('flipInX');
						});
					},50);
				});
			},200);

		},125);
		$('body').append('<div id="n1ajax"><div class="overlay"></div></div>');
	}
}
function tx_njartgallery_ajax_done_image(data)
{
	if(data.success)
	{
		$('#n1ajax').append(data.content);
	
		var width = $("#n1ajax").find("IMG").attr("width");
		var height = $("#n1ajax").find("IMG").attr("height");
		var top = tx_njcollection_getDimensions(_ACTION_GET_HEIGHT_VIEWPORT) - height;
		if(top > 0) { top = top / 2; }
		var left = tx_njcollection_getDimensions(_ACTION_GET_WIDTH_VIEWPORT) - width;
		if(left > 0) { left = left / 2; }
		
		tx_njartgallery_ajax_loader_toggle(_ACTION_HIDE);
		$('#n1ajax')
			.find('.artwork')
				.css({width:width,height:height,top:top,left:left})
				.animateCss('flipInX');
		
		$('#n1ajax .next').css('top',(tx_njcollection_getDimensions(_ACTION_GET_HEIGHT_VIEWPORT) - $('#n1ajax .next').height()) / 2);
		$('#n1ajax .prev').css('top',(tx_njcollection_getDimensions(_ACTION_GET_HEIGHT_VIEWPORT) - $('#n1ajax .prev').height()) / 2);			
		$('#n1ajax .prev').animate({left:0},125,function(){});
		$('#n1ajax .next').animate({right:0},125,function(){});
		$('#n1ajax .info').animateCss('bounceInUp');
	}
}


function tx_njartgallery_ajax_loader_toggle(action,loader)
{
	var loader = loader ? loader : '#n1ajax .loader';
	
	switch(action){
		case _ACTION_HIDE:
			$(loader).animateCss('zoomOut');
			$(loader).fadeOut(125);
			break;
		case _ACTION_SHOW:
			$(loader).fadeIn(125);
			$(loader).animateCss('zoomIn');
		default:;
	}
}

function tx_njartgallery_ajax_close()
{
	$('#n1ajax').slideUp(250,function(){$('#n1ajax').remove();});
	$('body').removeClass('noscrollbar');
}

$.fn.extend({
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $(this).addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
        });
    }
});

/**
 * 
 * @param {string} version
 * @returns {string}
 */
function tx_njartgallery_ajax_loader(version)
{
	var loader = '<div class="loader">';
	switch(version)
	{
		case '3balls':
			loader += '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
			break;
		default:;
	}
	loader += '</div>';
	return loader;
}
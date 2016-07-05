var _tx_njartgallery = '.tx_njartgallery';
var _tx_njartgallery_controller_artist = 'artist';
var _tx_njartgallery_action_focus = 'focus';
var _tx_njartgallery_action_list = 'list';

var _tx_njartgallery_section_artworks = 'artworks'


var itemSelector = '.tx_njartgallery.artist.list .grid-item';
var columnWidth = '.tx_njartgallery.artist.list .grid-sizer';
var gutter = '.tx_njartgallery.artist.list .gutter-sizer';

var _tx_njartgallery_artist_list = _tx_njartgallery+'.'+_tx_njartgallery_controller_artist+'.'+_tx_njartgallery_action_list+'.vertical';
var _tx_njartgallery_artist_focus_artworks = _tx_njartgallery+'.'+_tx_njartgallery_controller_artist+'.'+_tx_njartgallery_action_focus+'.'+_tx_njartgallery_section_artworks;

require( [ 
	'require', 
	'jquery', 
	'masonry' 
],function( require, $, Masonry ) {
	// require jquery-bridget, it's included in masonry.pkgd.js
	require( [ 'jquery-bridget/jquery-bridget' ],
	function() {
		$.bridget( 'masonry', Masonry ); // make Masonry a jQuery plugin

		if($(_tx_njartgallery_artist_list).length > 0) {
			var artistListMsnry = new Masonry(_tx_njartgallery_artist_list + ' .grid.masonry', {
				itemSelector: _tx_njartgallery_artist_list + ' .grid-item',
				columnWidth: _tx_njartgallery_artist_list + ' .grid-sizer',
				percentPosition: true,
				gutter: _tx_njartgallery_artist_list + ' .gutter-sizer',
				isResizable:true,
			});
		}

		if($(_tx_njartgallery_artist_focus_artworks).length > 0) {
			var artistFocusMsnry = new Masonry(_tx_njartgallery_artist_focus_artworks + ' .grid.masonry', {
				itemSelector: _tx_njartgallery_artist_focus_artworks + ' .grid-item',
				columnWidth: _tx_njartgallery_artist_focus_artworks + ' .grid-sizer',
				percentPosition: true,
				gutter: _tx_njartgallery_artist_focus_artworks + ' .gutter-sizer',
				isResizable:true,
			});
			$(window).resize(function () {
				$(_tx_njartgallery_artist_focus_artworks + ' .grid.masonry').masonry('reloadItems');
			});
		}
	});
});		
	


if(typeof _tx_njartgallery_artist_focus_artworks !== undefined) 
{	
	requirejs([
		'jquery','njPage'
	],function($) {
		
		$(document).on("mouseenter", _tx_njartgallery_artist_focus_artworks + " .artwork",function(){
			$(this).animateCss('fadeIn');
		});
		
		
		$(document).on("mouseenter", "#n1sidebar li a.inactive",function(){
			$(this)
				.css({'backgroundSize': '0%'})
				.stop().animate({"backgroundSize":"100%"},125);
		});
		$(document).on("mouseleave", "#n1sidebar li a.inactive",function(){
			$(this).stop().animate({"backgroundSize":"0%"},125,function(){
				
			});
		});
		
		$(document).on("click", "#n1sidebar li a",function(){
			if($(this).hasClass('inactive')) {
				$("#n1sidebar li a").removeClass("inactive").removeClass("active");
				$("#n1sidebar li a").not($(this)).addClass("inactive");
				$(this).addClass("active");
			}
		});
	});
	
	requirejs([
		'jquery','jquery.anchorScroll','jquery.scrollNav'
	],function($) {
		
		
		$(document).ready( function() {
			//$(document).on("scroll", detectSectionOnScroll);
			$('.anchor-scroll').anchorScroll({
				scrollSpeed: 500 // scroll speed
			});

			function detectSectionOnScroll(event){
				var scrollPos = $(document).scrollTop();
				$('#menu a').each(function () {
					var currLink = $(this);
					var refElement = $(currLink.attr("href"));
					if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
						$('#menu a').removeClass("active").removeClass('inactive');
						currLink.addClass("active");
						$('#menu a').not(currLink).addClass('inactive');
					}
					else{
						currLink.removeClass("active");
					}
				});
			}

		});
	});
	
	requirejs([
		'jquery','njPage'
	],function($) {
		$(document).ready( function() {
			$(".artwork[data-onsale=1]").on('click','.n1button.enquiry',function() {
				var params = _tx_njartgallery_artist_focus;
				params['action'] = 'enquiry'
				params['artwork'] = $(this).parents(".artwork").attr('data-uid');
				tx_njartgallery_ajaxCall(params);
			});
			
			$(document).on('click','body > .ajax.overlay.fullscreen',function(){
				tx_njartgallery_ajaxOverlay_hide($(this));
			});
			
		});
		
		$(document).ajaxComplete(function() {
    
		});
		
		function tx_njartgallery_ajaxOverlay_show(belongsTo)
		{
			if($('body > .ajax.overlay.fullscreen').length < 1) {
				$('<div class="ajax overlay fullscreen" data-close="'+belongsTo+'"></div>').appendTo('body');
			}
			$('body > .ajax.overlay.fullscreen').fadeIn(250);
		}
		
		function tx_njartgallery_ajaxOverlay_hide(element)
		{
			var selector = element.attr('data-close');
			if($(selector).length > 0) {
				$(selector).animate({right:'100%'}).hide(0).remove();
			}
			element.remove();
		}
		
		function tx_njartgallery_ajaxCall(params) {
			var loader = 0;
			switch(params['action']) {
				case 'enquiry':
					loader = 0;
					break;
				default:;
			}
			tx_njartgallery_ajaxHandler(1,params);
		};
		
		function tx_njartgallery_ajaxHandler(loader, params) {
			var ext_key = 'tx_njartgallery';
			
			console.log(params);
			
			params['controller']    = "Ajax";
			
			var data = 'index.php?type=' 
				+ params['typeNum'] 
				+ '&L='
				+ params['langId'];
			
			for(var index in params) 
			{
				if(index.match("pageId"))
				{
					data = data.concat('&id=',params[index]);
				}
				else
				{
					data = data.concat("&"+ext_key+"_pi1[",index,"]=",params[index]);
				}
			}
			
			$.ajax(
			{
				async: 'true',
				url: data,
				type: 'POST',
				dataType: 'json',
				data: {
				},
				beforeSend: function() 
				{
					switch(params["action"]) 
					{
						case "enquiry":
							$('body').append('<div class="n1ajaxInfo"></div>');
							break;
						default:
							//nothing to do
						;    
					}

				},
				success: function(data) 
				{
					switch(params["action"]) 
					{
						case "enquiry":
							tx_njartgallery_ajaxOverlay_show('.tx_njartgallery.ajax.enquiry');


							var left = ($(window).width() - 900) / 2;
							var top = ($(window).height() - 550) / 2;
							


							$(data.content).appendTo('body').css('top',top+'px').animate({maxWidth:'100%',left:left+'px'},125).animateCss('bounceIn');
							break;
						default:
							//nothing to do
						;    
					}
				},
				error: function(xhr,e) 
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

					//if(params['controller'].valueOf() == 'Directory' && loader)
					//{
					//	var selectorResults = 'DIV.'+jqExtKey+'.'+params['controller'].toLowerCase()+'.resultList';
					//	$('body > DIV.ajaxLoader.std.large').remove();

					switch(params["action"]) 
					{
						case "uploadFile":
							$("FIELDSET[name=uploadData] .error_output").html(message);
							break;
						default:
							$('#n1ajaxInfo').html(message);
					}
				}
			});
		};
	});
}

requirejs([
	'jquery','jqueryUI'
],function($) {
	$( document ).ajaxComplete(function() {
		var parentPos = $('.tx_njartgallery.ajax.enquiry .artwork').offset();
		var childPos = $('.draggable').offset();
		$( ".draggable" ).draggable({
			axis:'y',
			scroll: false,
			drop: function(){
				
			}
		});
	});
});
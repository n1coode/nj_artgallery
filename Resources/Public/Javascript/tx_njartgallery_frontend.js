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


if(typeof _tx_njartgallery_artist_list)
{
	requirejs( [ 
		'require', 
		'jquery', 
		'masonry' 
	],function( require, $, Masonry ) {
		// require jquery-bridget, it's included in masonry.pkgd.js
		require( [ 'jquery-bridget/jquery-bridget' ],
		function() {
			$.bridget( 'masonry', Masonry ); // make Masonry a jQuery plugin
			
			var artistListMsnry = new Masonry(_tx_njartgallery_artist_list + ' .grid.masonry', {
				itemSelector: _tx_njartgallery_artist_list + ' .grid-item',
				columnWidth: _tx_njartgallery_artist_list + ' .grid-sizer',
				percentPosition: true,
				gutter: _tx_njartgallery_artist_list + ' .gutter-sizer',
				isResizable:true,
			});
			
			$(window).resize(function () {
				$(_tx_njartgallery_artist_list + ' .grid.masonry').masonry('reloadItems');
			});
		});
	});
}


if(typeof _tx_njartgallery_artist_focus_artworks !== undefined) 
{
	
	requirejs( [ 
		'require', 
		'jquery', 
		'masonry' 
	],function( require, $, Masonry ) {
		// require jquery-bridget, it's included in masonry.pkgd.js
		require( [ 'jquery-bridget/jquery-bridget' ],
		function() {
			$.bridget( 'masonry', Masonry ); // make Masonry a jQuery plugin
		  
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
		
		});
	});

	
	requirejs([
		'jquery'
	],function($) {
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
}
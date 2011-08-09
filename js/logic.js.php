<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
/* prevent console message errors when firebug isn't active or available */
if (!window.console || !console.firebug)
{
    var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml",
    "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];

    window.console = {};
    for (var i = 0; i < names.length; ++i)
        window.console[names[i]] = function() {}
}

var _push_happened=0;
//scary global var - thank you .js for global abatement
var the_print = "";
var scrollbarSettings = {
	showArrows: false,
	scrollbarWidth: 5,
	scrollbarMargin: 10,
	topCapHeight: 0,
	bottomCapHeight: 10
};
var mma_site_data='';
$(document).ready(function () {
	if(buildContentFromJson()){
		//init cycle
		initPrintCycle("");
	}
	//tooltips
	$("#banner a.littleicon").tipTip({maxWidth: "360px", defaultPosition:"bottom"});
	$("#beta_link").tipTip({maxWidth: "360px", defaultPosition:"right"});
	$("a.tipthis").tipTip({maxWidth: "360px", defaultPosition:"left"});
	
	
	// buy does nothing right now... :( // oh yes it does 1-11-11
	$("a[href=#buy]").live('click', function(e){
		e.preventDefault();
	});
	
	$("#footer a").click(function(){
		$("#footer a").removeClass("curr_selected");
		$(this).addClass("curr_selected");
	});
	
	$("a.hard_link").live('click', function(e){
		var old_url = window.location.hash;
		//console.log("prevent default link click"+ $(this).attr("href"));
		var this_locObj = $.deparam.fragment($(this).attr("href"));
		$.bbq.pushState({
			series: this_locObj.series,
			print: this_locObj.print
		});
		document.title = this_locObj.print + " in the " + this_locObj.series + " by Mad Monkey Apparel | MDMNKY";
		initPrintCycle($(this).attr("href"), old_url);
		e.preventDefault();
	});
	$(".next_arrow_link").live("click", function(event){
		var _this_locObj = $.deparam.fragment(window.location.hash);
		$("#"+ _this_locObj.series + "_content").cycle('next');
		//console.log("next callback");
		event.preventDefault();
	});
	$(".prev_arrow_link").live("click", function(event){
		var _this_locObj = $.deparam.fragment(window.location.hash);
		$("#"+ _this_locObj.series + "_content").cycle('prev');
		//console.log("prev callback");
		event.preventDefault();
	});
	
	$(window).bind('hashchange', function(){
		//console.log("hashchange");
		initPrintCycle(window.location.hash);
		
	});
	
	//keystrokes
	$(document.documentElement).keyup(function (event) {
		//console.log(event);
	    // handle cursor keys
	    if (event.keyCode == 37) {
	      	//console.log("direction = 'prev item'");
			var _this_locObj = $.deparam.fragment(window.location.hash);
			$("#"+ _this_locObj.series + "_content").cycle('prev');
			
	    } else if (event.keyCode == 39) {
	      	//console.log("direction = 'next item'");
			var _this_locObj = $.deparam.fragment(window.location.hash);
			$("#"+ _this_locObj.series + "_content").cycle('next');
			
	    } else if (event.keyCode == 38){
			//up arrow
			$("#seriess").cycle('prev');
			//console.log("direction = 'prev album'");
		
		} else if (event.keyCode == 40){
			//down arrow
			$("#seriess").cycle('next');
			//console.log("direction = 'next album'");
		}

	  });//body keyup

});//document.ready

function initPrintCycle(urlstr, oldurlstr){
	//console.log("in init printcycle");
	
	var _locObj = "";
	var _currhash = window.location.hash.toLowerCase();
	
	if(urlstr != ""){
		if(urlstr == oldurlstr){
			//if initPrintCycle is called with the same url, exit, do nothing!
			//console.log(urlstr+" == "+oldurlstr+" EXIT printcycle you are looking at: "+the_print);
			return;
		}
		if(_currhash.indexOf(the_print) > 1){
			//the url has the print you are trying to cycle to, we are already here, go away, do nothing!
			//console.log("the url has: "+the_print+" in it, EXIT");
			return;
		}
		//we want urlstr passed into the function
		_locObj = $.deparam.fragment(urlstr);
	}
	else{
		//else we will use the browser hash to prepare cycle
		_locObj = $.deparam.fragment(_currhash);
	}
	$("#footer a").removeClass("curr_selected");
	if(_locObj.print=="about-us"){
		$("#abt_us").addClass("curr_selected");
		
	}else if(_locObj.print=="collection-cover"){
		$("#ser_lnk").addClass("curr_selected");
	}else if(_locObj.print=="contact-us"){
		$("#ctc_us").addClass("curr_selected");
	}
	else{console.log($("#footer a:first"));$("#footer a:first").addClass("curr_selected");}
	
	
	//zero based offet of the print id, will be used as the startingSlide for the cycle
	var _series_index, _print_index = 0;
	var _series_id, _print_id = "";
	
	//console.log(_locObj);
	if (_locObj.series) {
		//console.log("series is set");
		//console.log(_locObj);
		//_locObj comes from $.deparam.fragment(hash); should contain series and print string
		var _series_id = _locObj.series;
		var _print_id = _locObj.print;
		
		_series_index = $("#" + _series_id).prevAll().length;
		
		if ($("#" + _series_id).find("#" + _print_id).length) {
			_print_index = $("#" + _series_id).find("#" + _print_id).prevAll().length;
		}
		
	}//if(_locObj.series) 
	else {
		//defaults
		//console.log("set defaults");
		//console.log(mma_site_data.series[0].id + " print: " + mma_site_data.series[0].prints[0].id);
		_series_id = mma_site_data.series[0].id;
		_print_id = mma_site_data.series[0].prints[0].id;
	}
	if(_series_index===undefined){_series_index = 0;}
	//console.log("init cycle for series, default: " + _series_id + " start at index: "+ _series_index);
	
	
	
	
	//init series cycle
	$("#seriess").cycle("destroy").cycle({
		fx: 'scrollVert',
		timeout: 0,
		speed: 500,
		prev: 'a.prev_album',
		next: 'a.next_album',
		sync: 1,
		startingSlide: _series_index,
		onPrevNextEvent: function(isNext, zeroBasedSlideIndex, seriesElem){
			lastseriesSlide = $(seriesElem).prev().attr("id");
			nextseriesSlide = $(seriesElem).next().attr("id");
			setTimeout(function(){// wait 1000ms and then reset previous and next series to their first print
				if(lastseriesSlide!=undefined)
					$("#" + lastseriesSlide + "_content").cycle(0).cycle("destroy");
				if(nextseriesSlide!=undefined)
					$("#" + nextseriesSlide + "_content").cycle(0).cycle("destroy");
				//console.log("destroy last cycle - last #" + lastseriesSlide + "_content: next: #" + nextseriesSlide + "_content");
			}, 1000);
		},
		after: function(sa_currSlideElement, sa_nextSlideElement, sa_options, sa_forwardFlag){
			//set the series url hash after cycle
			var the_series = $(sa_nextSlideElement).attr("id");
			//console.log("in series after,  you are looking at series: "+ the_series);
			the_print = $(sa_nextSlideElement).attr("id") + "-cover";
			
			var starting_indx = 0;
			if(_print_id != "science-cover"){
				the_print = $.deparam.fragment(window.location.hash).print;
				//console.log("if print is not science cover set the print to hash :"+$.deparam.fragment(window.location.hash).print);
				if ($("#" + the_series).find("#" + the_print).length) {
					starting_indx = $("#" + the_series).find("#" + the_print).prevAll().length;
					//console.log("in series after,  print starting index will be: "+ starting_indx);
				}
				_print_id = "science-cover";
			}
				
			$("#" + the_series + "_nav").css("z-index", 0);
			//console.log($("#"+the_series+"_content"));
			$("#"+the_series+"_content").find("img").fadeIn(1500);
			
			//content cycle
			$("#" + the_series + "_content").cycle("destroy").cycle({
				fx: 'scrollHorz',
				timeout: 0,
				speed: 500,
				//prev: '.prev_item_' + the_series,
				//next: '.next_item_' + the_series,
				sync: 1,
				startingSlide: starting_indx,
				after: function(a_currSlideElement, a_nextSlideElement, a_options, a_forwardFlag){
					//set the print hash after cycle
					the_print = $(a_nextSlideElement).attr("id");
					//captify plugin, cover description
					$("#"+the_print).find("img.captify").captify({spanWidth:"937px", opacity:"0.8"});
					//nothing in cart yet :( coming soon //not anymore... 1-11-11
					$("#"+the_print).find(".top .buy a").each(function(){
						//console.log($(this));
						if($(this).hasClass("onsale")){
							//do not add the coming soon tooltip
							
						}else if($(this).hasClass("guestbook")){
							$(this).tipTip({maxWidth: "auto", defaultPosition:"top", content: "see what others are saying..."});
						}else{
							$(this).tipTip({maxWidth: "auto", defaultPosition:"top", content: "coming soon..."});
						}
					});
					$("#"+the_print).find("div.holder").jScrollPane(scrollbarSettings).animate({opacity:"1"}, 1000);
					$.bbq.pushState({
						series: the_series,
						print: the_print
					});
					document.title = the_print + " print in the " + the_series + " series by Mad Monkey Apparel | MDMNKY";
					
					//dynamic tracking
					var _gaq = _gaq || [];
					_gaq.push(['_setAccount', 'UA-9617848-1']);
					_gaq.push(['_trackPageview', the_series + " : " + the_print]);
					
					
				}//print after
				
				
			});//$("#" + the_series + "_content").cycle
			
			//artwork cycle for "See more"
			$("#" + the_series + "_content").find(".artwork").cycle("destroy").cycle({
				fx: 'scrollRight',
				timeout: 0,
				speed: 500,
				startingSlide: 0,
				next: 'a.other_side',
				sync: 1
			});
			thez = $("#" + the_series+"_content").children().length + 2;
			$("#" + the_series+ "_nav").css("z-index", thez).delay(1500).fadeIn(500);
			
			//pulsearrows
			pulsearrows();
			
		
		}//series after
	});
	
	
}//end function initPrintCycle


function buildContentFromJson(){
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	
	<?php require 'json_site_content.php'; ?>
	// attach the template
	$("#seriess").setTemplateElement("template", null, {filter_data: false});

	// process the template
	$("#seriess").processTemplate(mma_site_data);
	
	return mma_site_data;
}
function pulsearrows(){
	//PULSE ARROWS
	setTimeout(function(){
	$("a.prev_arrow_link:visible")
		.animate({left:"-455px"},"fast")
		.delay(100)
		.animate({left:"-450px"},"fast")
		.delay(100)
		.animate({left:"-455px"},"fast")
		.delay(100)
		.animate({left:"-450px"},"fast")
		.delay(100)
		.animate({left:"-455px"},"fast")
		.delay(100)
		.animate({left:"-450px"},"fast");

		$("a.next_arrow_link:visible")
			.animate({right:"-35px"},"fast")
			.delay(100)
			.animate({right:"-30px"},"fast")
			.delay(100)
			.animate({right:"-35px"},"fast")
			.delay(100)
			.animate({right:"-30px"},"fast")
			.delay(100)
			.animate({right:"-35px"},"fast")
			.delay(100)
			.animate({right:"-30px"},"fast");
		}, 2000);
}
//	CUT	 ///////////////////////////////////////////////////////////////////
/* This license and copyright apply to all code until the next "CUT"
http://github.com/jherdman/javascript-relative-time-helpers/

The MIT License

Copyright (c) 2009 James F. Herdman

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.


 * Returns a description of this past date in relative terms.
 * Takes an optional parameter (default: 0) setting the threshold in ms which
 * is considered "Just now".
 *
 * Examples, where new Date().toString() == "Mon Nov 23 2009 17:36:51 GMT-0500 (EST)":
 *
 * new Date().toRelativeTime()
 * --> 'Just now'
 *
 * new Date("Nov 21, 2009").toRelativeTime()
 * --> '2 days ago'
 *
 * // One second ago
 * new Date("Nov 23 2009 17:36:50 GMT-0500 (EST)").toRelativeTime()
 * --> '1 second ago'
 *
 * // One second ago, now setting a now_threshold to 5 seconds
 * new Date("Nov 23 2009 17:36:50 GMT-0500 (EST)").toRelativeTime(5000)
 * --> 'Just now'
 *
 */
Date.prototype.toRelativeTime = function(now_threshold) {
  var delta = new Date() - this;

  now_threshold = parseInt(now_threshold, 10);

  if (isNaN(now_threshold)) {
	now_threshold = 0;
  }

  if (delta <= now_threshold) {
	return 'Just now';
  }

  var units = null;
  var conversions = {
	millisecond: 1, // ms	 -> ms
	second: 1000,	// ms	 -> sec
	minute: 60,		// sec	 -> min
	hour:	60,		// min	 -> hour
	day:	24,		// hour	 -> day
	month:	30,		// day	 -> month (roughly)
	year:	12		// month -> year
  };

  for (var key in conversions) {
	if (delta < conversions[key]) {
	  break;
	} else {
	  units = key; // keeps track of the selected key over the iteration
	  delta = delta / conversions[key];
	}
  }

  // pluralize a unit when the difference is greater than 1.
  delta = Math.floor(delta);
  if (delta !== 1) { units += "s"; }
  return [delta, units].join(" ");
};

/*
 * Wraps up a common pattern used with this plugin whereby you take a String
 * representation of a Date, and want back a date object.
 */
Date.fromString = function(str) {
  return new Date(Date.parse(str));
};

//	CUT	 ///////////////////////////////////////////////////////////////////

// utility functions
jQuery.fn.center = function () { 
	this.css('position','absolute');  
	this.css('top', ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + 'px');  
	this.css('left', ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + 'px');
	this.fadeIn("fast");
	return this;
}
/*
 * Calculate the x,y coordinate of the given element
 */
var getLocation = function(e) {
  	var posx = 0;
	var posy = 0;
	if (!e) var e = window.event;

	if (e.pageX || e.pageY)		{
		posx = e.pageX;
		posy = e.pageY;
	}
	else if (e.clientX || e.clientY)	{
		posx = e.clientX + document.body.scrollLeft
			+ document.documentElement.scrollLeft;
		posy = e.clientY + document.body.scrollTop
			+ document.documentElement.scrollTop;
	}
	// posx and posy contain the mouse position relative to the document
	return ( {curr_left:posx, curr_top:posy} );
};
  
util = {
  urlRE: /https?:\/\/([-\w\.]+)+(:\d+)?(\/([^\s]*(\?\S+)?)?)?/g, 

  //  html sanitizer 
	toStaticHTML: function(inputHtml) {
		inputHtml = inputHtml.toString();
		return inputHtml.replace(/&/g, "&amp;")
						.replace(/</g, "&lt;")
						.replace(/>/g, "&gt;");
 	}, 

	//pads n with zeros on the left,
	//digits is minimum length of output
	//zeroPad(3, 5); returns "005"
	//zeroPad(2, 500); returns "500"
	zeroPad: function (digits, n) {
		n = n.toString();
		while (n.length < digits) 
		  n = '0' + n;
		return n;
	},

	//it is almost 8 o'clock PM here
	//timeString(new Date); returns "19:49"
	timeString: function (date) {
		var minutes = date.getMinutes().toString();
		var hours = date.getHours().toString();
		return this.zeroPad(2, hours) + ":" + this.zeroPad(2, minutes);
	  },
	timeID: function (date) {
		return date.getTime().toString();
	},
  //does the argument only contain whitespace?
  isBlank: function(text) {
	var blank = /^\s*$/;
	return (text.match(blank) !== null);
  }
};

//LETS DO THIS
var curr_pos = {curr_left:'0', curr_top:'0'};//default coordinates
$(document).ready(function(){
	
	$("span.intro").center();
	
	$("span.comment_body").live({
		mouseenter:
			function()
			{
				$(this).stop().animate({backgroundColor:'#ccc'}, 300);
			},
		mouseleave:
			function()
			{
				$(this).stop().animate({backgroundColor:'#fff'}, 100);
			},
		click:
			function(e)
			{
				var offset = $(this).offset();
				curr_pos = {curr_left:offset.left+35, curr_top:offset.top+25};
				
				//curr_pos = {curr_left:35, curr_top:35};
				showCommentBox($(this).parent("span.comment").attr("id"), curr_pos);
				
				e.stopPropagation();
				return false;
				
			},
		dblclick:
			function(e)
			{
				//alert("comment");
				e.stopPropagation();
				return false;
				
			}
		}
	);

	$("div#wrapper").dblclick(function(e){
		//alert("wrapper");
		//var self = ;
		curr_pos = getLocation(e) ;
		
		showCommentBox($(this).attr("id"), curr_pos);
		
			
		
	});//END $("div#wrapper").dblclick(function(e){
	$("span.xnay").live("click",function(){
		deleteMessage($(this).attr("rel").replace("x_",""));
	});
	$("span.comment_who").live("click",function(e){
		
		$("span.comment_body").css({visibility:"hidden",display:"none"});
		$(this).next("span.comment_body").css({visibility:"visible",display:"block"});
	});
	
	// check browser support for placeholder
	$.support.placeholder = 'placeholder' in document.createElement('input');
	if(!($.support.placeholder)){//browser DOES NOT support placeholders
		$("#comment").val($("#comment").attr("placeholder"));
	
		$("#comment").focus(function(){
			if($(this).val()===$("#comment").attr("placeholder")){
				//on focus if the value of the input box equals the placeholder text, blank it out
				$(this).val('');
			}
		});
	}//no support for html5 placeholder
	 
	$("#comment").bind('keyup',function(e) {

		if (e.keyCode != 13 /* Return */) return;
		var msg = $("#comment").val().replace("\n", "");
		if (!util.isBlank(msg)){
			
			var from = {
				profile_url:"",
				img_url:""
			};
			
			//in order of preference, facebook profile will always take precedence
			if( (user_social.fb_img === "") && (user_social.tw_img === "") ){
				from.img_url = "";
				from.profile_url = "";
			}
			
			if( (user_social.tw_img !== "") && (user_social.tw_url !== "") ){
				from.img_url = user_social.tw_img;
				from.profile_url = user_social.tw_url;
			}
			if( (user_social.fb_img !== "") && (user_social.fb_url !== "") ){
				from.img_url = user_social.fb_img;
				from.profile_url = user_social.fb_url;
			}
			var the_date = new Date();
			addMessage (from, msg, the_date,curr_pos,true,"",$("#comment").attr("rel"));
			
			
			$("#comment").fadeOut("fast").val('');
		}//IF NOT BLANK 
		//hide text box
		
	});

	//put this in a timer for real time?
	getComments();

});//END DOCUMENT READY

//renders an input box on the page
function showCommentBox(parent_id){
	
	if($("#please_consider").length>0){
		$("div#sigi").stop().animate({backgroundColor:'#ffffff', "left":"0"}, 300, function(){
			$("div#sigi").animate({backgroundColor:'#C0F785', "left":"25%"}, 1000);
		});
		setTimeout(function(){
			$("div#sigi").stop().animate({backgroundColor:'#ffffff', "left":"0"}, 500)
			//$("#please_consider").remove();
		}, 3000);
		return;
	}
	
	if( (user_social.fb_url === "") && (user_social.tw_url === "") ){
		$("div#sigi").prepend('<span id="please_consider" style="display:block;padding-right:3px;"><small>if you don&apos;t mind, please : </small></span>').stop().animate({backgroundColor:'#C0F785', "left":"25%"}, 1000);
		setTimeout(function(){
			$("div#sigi").stop().animate({backgroundColor:'#ffffff', "left":"0"}, 500)
			//$("#please_consider").remove();
		}, 3000);
		
		return;
	}
	
	if($("#comment").is(":visible")){
		$("#comment").fadeOut("fast", function(){
			$("#comment").css({top:curr_pos.curr_top+"px",left:curr_pos.curr_left+"px"}).fadeIn("slow");
		});
	}else{
		$("#comment").css({top:curr_pos.curr_top+"px",left:curr_pos.curr_left+"px"}).fadeIn("slow");
	}
	
	$("#comment").attr("rel", parent_id);
	//if($("#comment").val()==""){
		$("#comment").focus();
	//}
	
}

//inserts an event into the stream for display
//the event may be a msg, join or part type
//from is the user, text is the body and time is the timestamp, defaulting to now
//_class is a css class to apply to the message, usefull for system events
function addMessage (_from, text, time, the_pos, write_to_db, uid, the_rel) {
	
	if (text === null)
		return;
	
	if (time == null) {
		// if the time is null or undefined, use the current time.
		time = new Date();
	} else if (((time instanceof Date) === false) && (write_to_db) ) {
		// if it's a timestamp, interpret it
		time = new Date(time);
	}//else time will stay as is


	var messageElement = $(document.createElement("span"));

	// sanitize
	text = util.toStaticHTML(text);

	
	// replace URLs with links
	//text = text.replace(util.urlRE, '<a target="_blank" href="$&">$&</a>');
	//console.log(_from);
	var content = "";
	var who_said = "anonymous";
	var at_time = time;
	var uniqueid = uid;
	var is_papi = "";
	if(write_to_db){
		var loc_time = new Date();
		uniqueid = loc_time.getTime().toString();
		at_time = util.timeString(time);
		
	}
	if(_is_tha_mayn !== "exnay"){
		is_papi = '<span class="'+_is_tha_mayn+'" rel=x_'+uniqueid+'> x </span>';
	}
	if ( (_from.profile_url !=="") && (_from.img_url !=="") ){
		var icon = '<span class="network">FB</span>';
		if(_from.profile_url.indexOf("twitter")>0){
			//alert(_from.profile_url);
			icon = '<span class="network">TW</span>';
		}
		who_said = '<img src="'+_from.img_url.replace("https","http")+'" width="50" height="50" alt="'+_from.profile_url.split("/",4)[3]+' profile pic"/><a href="'+_from.profile_url+'" target="_blank">'+icon+'</a>';
	}
	content = is_papi+'<span class="comment_who">'
				+'<small>'+ who_said
				+ ' said: </small>'
			+ '</span>'
			+ '<span class="comment_body">'
				+ '<span class="comment_text">' + text + '</span> '
				+ '<span class="comment_time"><small>[at: ' + at_time + ']</small></span>'
				+ '<span class="action_reply">  Reply...</span>'
			+ '</span> '
			;
		
	messageElement.html(content);
	messageElement.addClass("comment");
		//TODO: COLLISION DETECTION
	messageElement.css({top:the_pos.curr_top+'px', left:the_pos.curr_left+'px', position:'absolute', display:"none"});
	messageElement.attr("id", uniqueid);
	messageElement.draggable();
	//the new element will hold it's parent element's id in it's rel attribute
	messageElement.attr("rel", the_rel);
	
	
	$("#wrapper").append(messageElement);
	
	//define ajax config object  
	if(write_to_db){
		var ajaxOpts = {  
		    type: "post",  
		    url: "comment.php?says=1",  
		    data: "&the_text="+text+"&top="+curr_pos.curr_top+"&left="+curr_pos.curr_left+"&id="+uniqueid+"&rel="+$("#comment").attr("rel")+"&profile_url="+_from.profile_url+"&img_url="+_from.img_url+"&time_string="+util.timeString(time)+"&the_series="+mdmnky_item.the_series+"&the_print="+mdmnky_item.the_print,  
		    success: function(data) {  
				
		    	bink_body();
				$("span.comment_body").fadeOut("fast");
				messageElement.find("span.comment_body").css("display","block");
				messageElement.fadeIn(1000);

		    }  
		  };  

		  $.ajax(ajaxOpts);
	}
}
function deleteMessage(the_id){
	//alert(the_id);
	var ajaxOpts = {  
	    type: "post",  
	    url: "comment.php?remove=1",  
	    data: "&the_id="+the_id,  
	    success: function(data) {  
			
			$("#"+the_id).remove();
	    	bink_body();
			
	    }  
	  };  
	  $.ajax(ajaxOpts);
}
function getComments(){
	
	
	$.ajax({
			url: "comment.php?the_series="+mdmnky_item.the_series+"&the_print="+mdmnky_item.the_print+"&jsoncallback=?",
			async: false,
			dataType: 'json',
			success: function(data) {
				//console.log(data);
				//loop through all items in the JSON array  
				if(data === null){return;}
				for (var x = 0; x < data.length; x++) {
					
					var from = {
						profile_url:data[x].profile_url,
						img_url:data[x].img_url.replace("https","http")
					};
					var db_item_pos = {curr_left:data[x].left, curr_top:data[x].top};
					
					var msg = data[x].the_text;
					
					addMessage (from, msg, data[x].time_string, db_item_pos, false, data[x].id, data[x].rel);
					
				}//END FOR
				$("#wrapper").animate({backgroundColor:'#ccc'}, 500, function(){
					var show_comment_interval = setInterval(function(){
						//alert("yo");
					
						$(".comment:hidden:first").fadeIn(100);
					
						if($(".comment:hidden").length == 0){
							$(".comment:last").find("span.comment_body").fadeIn("slow");
							clearInterval(show_comment_interval);
							$("#wrapper").delay(3000).animate({backgroundColor:'#fff'}, 2000);
						}
					},800);
				});
			}
		});
	
	//retrieve comments to display on page
}
function bink_body(){
	$("#wrapper").stop().animate({backgroundColor:'#C0F785'}, 1000).delay(500).animate({backgroundColor:'#fff'}, 1000);
}
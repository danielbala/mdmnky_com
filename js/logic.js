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
	
	//tooltips
	$("#banner a.littleicon").tipTip({maxWidth: "360px", defaultPosition:"bottom"});
	$("#beta_link").tipTip({maxWidth: "360px", defaultPosition:"right"});
	$("a.tipthis").tipTip({maxWidth: "360px", defaultPosition:"left"});
	
	if(buildContentFromJson()){
		//init cycle
		initPrintCycle("");
	}
	
	// buy does nothing right now... :(
	$("a[href=#buy]").live('click', function(e){
		e.preventDefault();
	});
	$("a.hard_link").live('click', function(e){
		var old_url = window.location.hash;
		//console.log("prevent default link click"+ $(this).attr("href"));
		var this_locObj = $.deparam.fragment($(this).attr("href"));
		$.bbq.pushState({
			series: this_locObj.series,
			print: this_locObj.print
		});
		document.title = this_locObj.series + " / " + this_locObj.print + " by Mad Monkey Apparel - MDMNKY";
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
					//nothing in cart yet :( coming soon
					$("#"+the_print).find(".top .buy a").tipTip({maxWidth: "auto", defaultPosition:"left", content: "coming soon..."});
					$("#"+the_print).find("div.holder").jScrollPane(scrollbarSettings).animate({opacity:"1"}, 1000);
					$.bbq.pushState({
						series: the_series,
						print: the_print
					});
					document.title = the_series + " series / " + the_print + " print by Mad Monkey Apparel - MDMNKY";
					
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
mma_site_data = 
	{series:[
		{id:'science',
		title:'Series / Science',
		prints:[
			{id:'science-cover', title:'cover',visible:'true',
			artwork:[{src:'images/science_cover.gif',alt:'Mad Monkey is creating a universe, a universe which consists of Robots and Creatures. This series is called Science. It shows and explains who, what, how and why we interact with our universe...'}], 
			multiple_art:'false',
			description:'',
			bottom_nav:''
			},
			{id:'deus-ex', title:'Print 005 / Deus Ex Machina',visible:'true',
			artwork:[{src:'images/deusex_artwork.jpg',alt:'Deus Ex Machina'}], 
			multiple_art:'false',
			description:'<p>A deus ex machina or "god from the machine" is a plot device whereby a seemingly inextricable problem is suddenly and abruptly solved with the contrived and unexpected intervention of some new character, ability, or object. </p>',
			bottom_nav:'<a href="http://www.youtube.com/watch?v=vFix7VLor88&amp;feature=related" target="_blank">We Like: Flying Lotus - <em>Cosmogramma</em></a>'
			},
			{id:'astrodot', title:'Print 004 / Astrodot',visible:'true',
			artwork:[
				{src:'images/astrodot_artwork.jpg',alt:'Astrodot Artwork'}, 
				{src:'images/astrodot_intent.jpg',alt:'Astrodot Intent'}], 
			multiple_art:'true',
			description:'<img src="images/science_nebulus.jpg" width="360" height="430" /><p>You are looking at Astrodot, this is an integral piece in preparation for the journey... </p>',
			bottom_nav:''
			},
			{id:'satellite', title:'Print 003 / Satellite',visible:'true',
			artwork:[
				{src:'images/satellite_intent.jpg',alt:'Satellite Intent'}, 
				{src:'images/satellite_artwork.jpg',alt:'Satellite Artwork'}], 
			multiple_art:'true',
			description:'<p>in space, which way is up?</p>',
			bottom_nav:''
			},
			{id:'nerdmonkey', title:'Print 002 / Nerd Monkey',visible:'true',
			artwork:[
				{src:'images/nerdmonkey_intent.jpg',alt:'NerdMonkey Intent'},
				{src:'images/nerdmonkey_flip_artwork.jpg',alt:'NerdMonkey Flipside'}, 
				{src:'images/nerdmonkey_artwork.jpg',alt:'NerdMonkey'}], 
			multiple_art:'true',
			description:'<p>...</p>',
			bottom_nav:'You might also like: <a class="hard_link" href="#series=mma&amp;print=bighead">Bighead</a>'
			},
			{id:'astronot', title:'Print 001 / Astro Not',visible:'true',
			artwork:[{src:'images/astronot_artwork.jpg',alt:'AstroNot'}], 
			multiple_art:'false',
			description:'<p>why do you piss your opportunities away? don\'t you know that you have all the tools you need to succeed...</p>',
			bottom_nav:''
			}
		]},
		{id:'robot',
		title:'Series / Robot',
		prints:[
			{id:'robot-cover', title:'cover',visible:'true',
			artwork:[{src:'images/robot_cover.jpg',alt:'Robots are awesome! They work as hard as we push them, they get hot, they cool down, they don\'t talk back (unless we want them to) seriously! Meet some of our crew...'}], 
			multiple_art:'false',
			description:'',
			bottom_nav:''
			},
			{id:'starbot', title:'Print 005 / Starbot',visible:'true',
			artwork:[
				{src:'images/starbot_intent.jpg',alt:'Starbot Intent'}, 
				{src:'images/starbot_artwork.jpg',alt:'Starbot Artwork'}], 
			multiple_art:'true',
			description:'<p>"trust me, i have a star" or better yet "trust me, I am a star."</p>',
			bottom_nav:'You might also like: <a href="#starbot">this_shirt</a>'
			},
			{id:'pinkrobot', title:'Print 004 / Pink Robot',visible:'true',
			artwork:[
				{src:'images/pinkrobot_intent.jpg',alt:'Pink Robot Intent'}, 
				{src:'images/pinkrobot_intent2.jpg',alt:'Pink Robot Intent2'},
				{src:'images/pinkrobot_artwork.jpg',alt:'Pink Robot Artwork'}],
			multiple_art:'true',
			description:'<p>"fix me, I can\'t fix myself"</p>',
			bottom_nav:''
			},
			{id:'gorillabot', title:'Print 003 / Gorillabot',visible:'true',
			artwork:[{src:'images/gorillabot_artwork.jpg',alt:'Gorillabot Artwork'}],
			multiple_art:'false',
			description:'<p>"i am big bad and impressive, use me... please" actually "look at me, what am I good for?"</p>',
			bottom_nav:''
			},
			{id:'tribots', title:'Print 002 / TriBots',visible:'true',
			artwork:[
				{src:'images/3robots_intent.jpg',alt:'TriBots Intent'},
				{src:'images/3robots_artwork.jpg',alt:'TriBots Artwork'}],
			multiple_art:'true',
			description:'<p>"3 robots walking as one!"</p>',
			bottom_nav:''
			},
			{id:'teddy', title:'Print 001 / Teddy',visible:'true',
			artwork:[
				{src:'images/teddy_intent.jpg',alt:'Teddy Intent'}, 
				{src:'images/teddy_ong.jpg',alt:'Teddy on G'},
				{src:'images/teddy_artwork.jpg',alt:'Teddy Artwork'}],
			multiple_art:'true',
			description:'<p>How else could we illustrate sheep in wolves clothing...</p><p>Andy says: "my flesh... illustrated"</p>',
			bottom_nav:''
			}
		]},
		{id:'creatures',
		title:'Series / Creatures',
		prints:[
			{id:'creatures-cover', title:'cover',visible:'true',
			artwork:[{src:'images/creatures_cover.jpg',alt:'WE ARE NOT ALONE...'}], 
			multiple_art:'false',
			description:'',
			bottom_nav:''
			},
			{id:'hawkins', title:'Print 004 / Hawkins',visible:'true',
			artwork:[
				{src:'images/hawkins_intent.jpg',alt:'Hawkins Intent'}, 
				{src:'images/hawkins_artwork.jpg',alt:'Hawkins Artwork'}], 
			multiple_art:'true',
			description:'<p>hawkins ...is he an elephant or mouse</p>',
			bottom_nav:'You might also like: <a class="hard_link" href="#series=robot&amp;print=teddy">Teddy</a>'
			},
			{id:'badbunny', title:'Print 003 / Bad! Bunny',visible:'true',
			artwork:[
				{src:'images/badbunny_intent.jpg',alt:'badbunny Intent'}, 
				{src:'images/badbunny_artwork.jpg',alt:'badbunny Artwork'}],
			multiple_art:'true',
			description:'<p>badbunny ...</p>',
			bottom_nav:''
			},
			{id:'mansaurus', title:'Print 002 / Mansaurus',visible:'true',
			artwork:[
				{src:'images/mansaurus_intent.jpg',alt:'mansaurus Intent'}, 
				{src:'images/mansaurus_artwork.jpg',alt:'mansaurus Artwork'}],
			multiple_art:'true',
			description:'<p>mansaurus ...</p>',
			bottom_nav:''
			},
			{id:'fupayme', title:'Print 001 / F. U. Payme',visible:'true',
			artwork:[
				{src:'images/fupayme_intent.jpg',alt:'fupayme Intent'}, 
				{src:'images/fupayme_artwork.jpg',alt:'fupayme Artwork'}],
			multiple_art:'true',
			description:'<p>first name Frank, middle name Unger last name Payme.</p>',
			bottom_nav:''
			}
		]},
		{id:'naija',
		title:'Series / Native Experiments',
		prints:[
			{id:'naija-cover', title:'cover',visible:'true',
			artwork:[{src:'images/naija_cover.jpg',alt:'At our core, is NAIJA. We reflect on classical nigerian art and illustration. This is our interpretation of old and new school native art.'}], 
			multiple_art:'false',
			description:'',
			bottom_nav:''
			},
			{id:'horses', title:'Print 002 / Horses',visible:'true',
			artwork:[
				{src:'images/horses_artwork1.jpg',alt:'Horses on Trina'},
				{src:'images/horses_artwork2.jpg',alt:'Horses on Trina'},
				{src:'images/horses_artwork.jpg',alt:'Horses Artwork'}], 
			multiple_art:'true',
			description:'<p>Extracted from the "<a href="http://en.wikipedia.org/wiki/Coat_of_arms_of_Nigeria" target="_blank"><em>Coat of arms of Nigeria</em></a>", the two white horses represent Nigeria\'s dignity... yeah right!</p><p>WHAT DIGNITY?</p>',
			bottom_nav:'R.I.P Yaradua'
			},
			{id:'fela', title:'Print 001 / Fela',visible:'true',
			artwork:[
				{src:'images/fela_intent1.jpg',alt:'fela'},
				{src:'images/fela_intent2.jpg',alt:'fela'},
				{src:'images/fela_artwork.jpg',alt:'fela Artwork'}], 
			multiple_art:'true',
			description:'<p>FELA! (the show on broadway) is the true story of the legendary Nigerian musician Fela Kuti, whose soulful Afrobeat rhythms ignited a generation.</p><p>Inspired by his mother, a civil rights champion, he defied a corrupt and oppressive military government and devoted his life and music to the struggle for freedom and human dignity.</p><p>FELA! is a triumphant tale of courage, passion and love, featuring Fela Kuti’s captivating music and the visionary direction and choreography of Tony-Award winner Bill T. Jones.</p>',
			bottom_nav:'<a href="http://www.felaonbroadway.com/" target="_blank">Check out Fela! on - <em>Broadway</em></a>'
			}
		]},
		{id:'mma',
		title:'Series / Mad Monkey',
		prints:[
			{id:'mma-cover', title:'cover',visible:'true',
			artwork:[{src:'images/mma_cover.jpg',alt:'Mad Monkey Inc. was originally formed by 3 (nigerian-born) friends. They are products of expatriate families - traveling away from their native homes to find opportunity overseas...'}], 
			multiple_art:'false',
			description:'',
			bottom_nav:''
			},
			{id:'bigheadblak', title:'Print 002 / BigheadBlak',visible:'true',
			artwork:[
				{src:'images/bigheadblak_intent.jpg',alt:'BIG HEAD BLAK'},
				{src:'images/bigheadblak_intent2.jpg',alt:'BIG HEAD BLAK'}], 
			multiple_art:'true',
			description:'<p>...</p>',
			bottom_nav:''
			},
			{id:'bighead', title:'Print 001 / Bighead',visible:'true',
			artwork:[
				{src:'images/bighead_bedside.jpg',alt:'BIG HEAD Bedside'},
				{src:'images/bighead_artwork.jpg',alt:'BIG HEAD'}], 
			multiple_art:'true',
			description:'<p><strong>Our Manifesto</strong></p><p>coming soon...</p>',
			bottom_nav:'<a href="http://cargocollective.com/blakrobot" target="_blank">Obi</a> | <a href="http://dbala.com" target="_blank">Bala</a> | Gbenro'
			}
		]}
	]};
		
		/*{'name':'collections','default':'false',prints:[{}]}*/
		
		
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
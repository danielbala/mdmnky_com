<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); 
header("Content-Type: text/css; charset=utf-8");
header("Cache-Control: max-age=36000");
?>
/*
	Name: main.css
	Date: May 2010
	Description: mdmnky main css file.
	Version: 1.0
	Author: bala peterson
	Autor URI: http://mdmnky.com
*/

/* Imports */
/*
	Name: Reset Stylesheet
	Description: Resets browser's default CSS
	Author: Eric Meyer
	Author URI: http://meyerweb.com/eric/tools/css/reset/
*/

/* v1.0 | 20080212 */
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
	background: transparent;
	border: 0;
	font-size: 100%;
	margin: 0;
	outline: 0;
	padding: 0;
	vertical-align: baseline;
}

body {line-height: 1;}

ol, ul {list-style: none;}

blockquote, q {quotes: none;}

blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}

/* remember to define focus styles! */
:focus {
	outline: 0;
}

/* remember to highlight inserts somehow! */
ins {text-decoration: none;}
del {text-decoration: line-through;}

/* tables still need 'cellspacing="0"' in the markup */
table {
	border-collapse: collapse;
	border-spacing: 0;
}


.jScrollPaneContainer {
	position: relative;
	overflow: hidden;
	z-index: 1;margin:15px 0;
}

.jScrollPaneTrack {
	background:none repeat scroll 0 0 #CCCCCC;
	cursor:pointer;
	height:100%;
	position:absolute;
	right:0;
	top:0px;
}
.jScrollPaneDrag {
	position: absolute;
	background: #333;
	cursor: pointer;
	overflow: hidden;
}
.jScrollPaneDragTop {
	position: absolute;
	top: 0;
	left: 0;
	overflow: hidden;
}
.jScrollPaneDragBottom {
	position: absolute;
	bottom: 0;
	left: 0;
	overflow: hidden;
}
a.jScrollArrowUp {
	display: block;
	position: absolute;
	z-index: 1;
	top: 0;
	right: 0;
	text-indent: -2000px;
	overflow: hidden;
	/*background-color: #666;*/
	height: 9px;
}
a.jScrollArrowUp:hover {
	/*background-color: #f60;*/
}

a.jScrollArrowDown {
	display: block;
	position: absolute;
	z-index: 1;
	bottom: 0;
	right: 0;
	text-indent: -2000px;
	overflow: hidden;
	/*background-color: #666;*/
	height: 9px;
}
a.jScrollArrowDown:hover {
	/*background-color: #f60;*/
}
a.jScrollActiveArrowButton, a.jScrollActiveArrowButton:hover {
	/*background-color: #f00;*/
}

/*
	Name: Global Form Styles
	Description: Default styling for forms.
				 Message classes borrowed from
				 http://www.blueprintcss.org/
	Coder: Enrique Ramirez
	Coder URI: http://enrique-ramirez.com
*/

fieldset {
	background: #f9f9f9;
	margin: 1.5em;
	padding: 2em;
	
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}
legend {font-size: 1.25em; margin-bottom: 0 !important; margin-bottom: 1.429em; padding: 0 .5em;}
label {font-size: 1.1em; height: 25px; line-height: 25px;}

	/* Input Types */
	input[type='text'],
	input[type='email'],
	input[type='url'],
	textarea {
		background: #eee;
		border: 1px dashed #ccc;
		color: #999;
		font-family: inherit;
		font-size: inherit;
		padding: 2px;
		margin-bottom:7px;
	}
	input[type='text']:hover,
	input[type='email']:hover,
	input[type='url']:hover,
	textarea:hover {
		background: #FFFBEF;
		border-color: #ff0;
		cursor: text;
	}
	input[type='text']:focus,
	input[type='email']:focus,
	input[type='url']:focus,
	textarea:focus {
		background: #ffC;
		border-color: #ff1;
		color: #0d0d0d;
	}
	
	input[type='checkbox'], input[type='radio'] {
		display: block;
		margin-top: 4px;
	}
	
	input[type='submit'] {
		background: #C74350;
		border: 0;
		border-radius: 5px;
		color: #fff;
		cursor: pointer;
		font-family: inherit;
		font-size: inherit;
		padding: .3em 2em;
		text-shadow: 1px 1px 1px #000;
	}
	
	input:required, textarea:required {outline: 1px solid #C74350;}
	
	/* Textarea */
	textarea {width: 80%; margin-bottom: 7px;}

	/* Alignments */
	div.left {margin-left: 1em;}
	div.right {margin-right: 1em;}
	
	.labels-left label, div.left label {
		clear: left;
		float: left;
		margin-right: .5em;
		text-align: right;
	}
	.labels-left input, div.left input, .labels-left select, div.left select {float: left;}
	
	.labels-right label, div.right label {
		float: left;
		margin-left: .5em;
		text-align: right;
	}
	.labels-right input, div.right input, .labels-right select, div.right select {clear: left; float: left;}
	
	.labels-top label, div.top label {display: block;}
	.labels-top input, div.top input {margin-bottom: 0;}
	
	/* Columns */
	.columns-2 div.column1, .columns-2 div.column2 {float: left; width: 48%;}
	.columns-2 input.text {width: 150px;}
	
	.columns-3 div.column1, .columns-3 div.column2, .columns-3 div.column3 {float: left; width: 33%;}
	.columns-3 input.text {width: 120px;}
	
	.columns-2 div.left, .columns-2 div.right, .columns-2 div.top {width: 32%;}
	.columns-3 div.left, .columns-3 div.right, .columns-3 div.top {width: 29%;}
	
/* Messages classes */
.req {color: #C74350;}
.error,.notice, .success {
	padding: .2em;
	margin-bottom: 1em;
	border: 2px solid #ddd;
}

.error {background: #FBE3E4; border-color: #FBC2C4; color: #8a1f11;}
.notice {background: #FFF6BF; border-color: #FFD324; color: #514721;}
.success {background: #E6EFC2; border-color: #C6D880; color: #264409;}

.error a {color: #8a1f11;}
.notice a {color: #514721;}
.success a {color: #264409;}

/* TipTip CSS - Version 1.2 */

#tiptip_holder {
	display: none;
	position: absolute;
	top: 0;
	left: 0;
	z-index: 99999;
}

#tiptip_holder.tip_top {
	padding-bottom: 5px;
}

#tiptip_holder.tip_bottom {
	padding-top: 5px;
}

#tiptip_holder.tip_right {
	padding-left: 5px;
}

#tiptip_holder.tip_left {
	padding-right: 5px;
}

#tiptip_content {
	font-size: 13px;
	color: #fff;
	text-shadow: 0 0 2px #000;
	padding: 4px 8px;
	border: 1px solid rgba(255,255,255,0.25);
	background-color: rgb(25,25,25);
	background-color: rgba(25,25,25,0.92);
	background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(transparent), to(#000));
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	box-shadow: 0 0 3px #555;
	-webkit-box-shadow: 0 0 3px #555;
	-moz-box-shadow: 0 0 3px #555;
}

#tiptip_arrow, #tiptip_arrow_inner {
	position: absolute;
	border-color: transparent;
	border-style: solid;
	border-width: 6px;
	height: 0;
	width: 0;
}

#tiptip_holder.tip_top #tiptip_arrow {
	border-top-color: #fff;
	border-top-color: rgba(255,255,255,0.35);
}

#tiptip_holder.tip_bottom #tiptip_arrow {
	border-bottom-color: #fff;
	border-bottom-color: rgba(255,255,255,0.35);
}

#tiptip_holder.tip_right #tiptip_arrow {
	border-right-color: #fff;
	border-right-color: rgba(255,255,255,0.35);
}

#tiptip_holder.tip_left #tiptip_arrow {
	border-left-color: #fff;
	border-left-color: rgba(255,255,255,0.35);
}

#tiptip_holder.tip_top #tiptip_arrow_inner {
	margin-top: -7px;
	margin-left: -6px;
	border-top-color: rgb(25,25,25);
	border-top-color: rgba(25,25,25,0.92);
}

#tiptip_holder.tip_bottom #tiptip_arrow_inner {
	margin-top: -5px;
	margin-left: -6px;
	border-bottom-color: rgb(25,25,25);
	border-bottom-color: rgba(25,25,25,0.92);
}

#tiptip_holder.tip_right #tiptip_arrow_inner {
	margin-top: -6px;
	margin-left: -5px;
	border-right-color: rgb(25,25,25);
	border-right-color: rgba(25,25,25,0.92);
}

#tiptip_holder.tip_left #tiptip_arrow_inner {
	margin-top: -6px;
	margin-left: -7px;
	border-left-color: rgb(25,25,25);
	border-left-color: rgba(25,25,25,0.92);
}

/* Webkit Hacks  */
@media screen and (-webkit-min-device-pixel-ratio:0) {	
	#tiptip_content {
		padding: 4px 8px 5px 8px;
		background-color: rgba(45,45,45,0.88);
	}
	#tiptip_holder.tip_bottom #tiptip_arrow_inner { 
		border-bottom-color: rgba(45,45,45,0.88);
	}
	#tiptip_holder.tip_top #tiptip_arrow_inner { 
		border-top-color: rgba(20,20,20,0.92);
	}
}
/* caption styling */

.caption-top, .caption-bottom {
	color: #000000;	
	padding: 1.2em;	
	font-weight: normal;
	font-size: 13px;	
	font-family: arial;	
	cursor: default;
	border: 0px solid transparent;
	background: #eeeeee;
	text-shadow: 1px 1px 0 #cccccc;
}
.caption-top {
   border-width: 0px 0px 8px 0px;
}
.caption-bottom {
   border-width: 8px 0px 0px 0px;
}
.caption a, .caption a {
	border: 0 none;
	text-decoration: none;
	background: #000000;
	padding: 0.3em;
}
.caption a:hover, .caption a:hover {
	background: #334143;
}
.caption-wrapper {
	float: left;
}
br.c { clear: both; }

/***** Global *****/
/* Body */
	body {
		background-color: #fff;
		color: #333;
		font-family: Arial;
		font-size: 12px;
	}

/* Headings */


h2, h3, h4, h5, h6 {
}
	
/* Anchors */
a {outline: 0; cursor:pointer; color:#333;}
a img {border: 0px; text-decoration: none;}
a:link, a:visited {
	text-decoration: none;
}
a:hover, a:active{
	text-shadow: 1px 1px 1px #ccc;
	text-decoration: underline;
}
a.cover-img:hover, a.cover-img:active {text-shadow: 0px 0px 0px #ccc;
text-decoration: none;}
a.other_side, #footer a{border: 1px solid #F4ED2A;background-color:#F4ED2A;padding:0 5px;}
	#footer a.curr_selected{border-color:#fff;background-color:#fff;color:#000;}
	#footer a{font-weight:bold;border: 0px solid #FFF;background-color:#FFF;color:#f3006e;}
#banner a:hover, #banner a:active {
	text-shadow: 1px 1px 1px #ccc;
	   -moz-box-shadow: 0px 0px 2px #acacac;
	   -webkit-box-shadow: 0px 0px 2px #acacac;
}
	
/* Paragraphs */
p {padding:5px 0px;line-height:15px;clear:both;float:none;}
* p:last-child {margin-bottom: 0;}

strong, b {font-weight: bold;}

#deus-ex .description strong{
	display:block;
	float:left;
	height:46px;
	padding-right:5px;color:#999;font-size:9px;
}
#deus-ex .description br{clear:both;float:none;}

em, i {font-style: italic;}

::-moz-selection {background: #F6CF74; color: #fff;}
::selection {background: #F6CF74; color: #fff;}

/* Lists */
ul, ol {
	list-style: none;
}

/* Quotes */
blockquote {font-style: italic;}

	
/* HTML5 tags */
header, section, footer,
aside, nav, article, figure {
	display: block;
}
.empty{display:none;}
hr{display:none;}
/***** Layout *****/
div#wrapper{width:1024px;/*width:968px;*/height:705px;margin:0 auto;/*border: 1px solid red;*/overflow:hidden;}

#banner{background-color:transparent;height:100px;position:relative;margin:0 auto;margin-top:15px;width:964px;}
	#banner div#copyright{
		position:relative;left:1px;
		font-size:10px;width:155px;height:100px;text-indent:-9999em;
	}
	#banner div#social{
		height:33px;
		position:absolute;right:1px;top:0px;
	}
	#banner a{position:relative;top:10px;margin-right:15px;}
	#banner #social a {
		
		height:33px;display:block;float:left;text-indent:-9999em;
	}
	#banner #social a.tipthis{width:30px;height:34px;}
	#banner #social a#fb{width:10px;background-position:0 0;}
	#banner #social a#rss{width:16px;background-position:-26px 0;}
	#banner #social a#tw{width:26px;background-position:-53px 0;margin-right:0px;}
	
	
	.next_prev_arrow_link{
		background-color:transparent;
		display:block;
		height:454px;
		position:absolute;
		top:32px;
		width:30px;
	}
	#banner #social a{background:url("https://s3.amazonaws.com/mdmnky_assets/icons.jpg") no-repeat scroll 0 0 #fff;}
	#banner #social a.tipthis{background:url("https://s3.amazonaws.com/mdmnky_assets/icons.jpg") no-repeat scroll -79px 9px transparent;}
	#home_link{background:url("https://s3.amazonaws.com/mdmnky_assets/icons.jpg") no-repeat scroll -36px -31px transparent;display:block;width:24px;height:33px;float:left;}
	#beta_link{background:url("https://s3.amazonaws.com/mdmnky_assets/icons.jpg") no-repeat scroll 0px -31px transparent;display:block;width:32px;height:32px;float:left;}
	a.prev_arrow_link {background:url("https://s3.amazonaws.com/mdmnky_assets/icons.jpg") no-repeat scroll -115px 167px transparent;left: -450px;}
	a.prev_arrow_link:hover{background:url("https://s3.amazonaws.com/mdmnky_assets/icons.jpg") no-repeat scroll -145px 167px #FFFFFF;}
	a.next_arrow_link {background:url("https://s3.amazonaws.com/mdmnky_assets/icons.jpg") no-repeat scroll -175px 167px transparent;right: -30px;}
	a.next_arrow_link:hover{background:url("https://s3.amazonaws.com/mdmnky_assets/icons.jpg") no-repeat scroll -205px 167px #FFFFFF;}
	

/*
	nav
*****************/
#copyright span.title{font-size: 12px;}
span.title{font-weight:bold;}
span.navigate{margin-left:15px;}
.albums{position:relative;}

.series_nav{width:420px;float:left; background-color:#fff;position:absolute;top:20px;z-index:4;display:none;padding-left:30px;}
.ser_page{background-color:#F8F8F8;/*border:1px solid red;*/height:454px;margin:30px;width:960px;}
.cover-img{margin:30px 0 0 30px;display:block;cursor:pointer;}
* html .series_nav{top:-20px;}
.print .nav{height:12px;width:544px;position:relative;float:none;clear:both;left:420px;background-color:#fff;padding:10px 0;z-index:9999;margin-left:30px;/*border: 1px solid red;*/}

.print .nav span{font-size:11px;line-height:12px;}
	.print .nav span.title{padding-left:10px;}
	.print .nav span.buy{text-transform:uppercase;font-weight:bold;position:absolute;right:0px;}
	.print .bottom span.buy{text-transform:inherit;font-weight:normal;}
	.print .top .navigate{text-indent:-99999em;}
.content{width:9999999em;height:520px;margin:10px auto;/*border: 1px solid red;*/background-color:#fff;float:none;clear:both;}
	.content .print{width:1024px;/*width:968px;*/height:518px;float:left; margin:0 0px;position:relative;/*background-color:yellow;*/}
	.content .print img{display:none;}
	.content .description{margin-left:30px;width:419px;height:454px;float:left;border-right:1px dashed #ccc;background-color:#f8f8f8;cover}
		.content .description div.holder{height:425px; width:380px;padding:0px 0px 0 15px;overflow:hidden;opacity:0;}
			.content .description div.holder img{display:block;}
	.content .artwork{width:544px;height:454px;float:left;position:relative;background-color:#f8f8f8;overflow-x:hidden;overflow-y:auto;}
		.content .artwork img{display:block;float:none; clear:both;}
	
#footer{width:964px;margin:20px auto;/*border: 1px solid red;*/height:20px;position:relative;clear: both;float: none;}
	#footer ul li{float:left;padding-right:30px;line-height:20px;}
	#collection-cover ul li li{float:none;padding-right:0;line-height:12px;}
	#footer span.cpyr{position:absolute;right:1px;font-size:10px;}
	
#about.body{font-size:15px;color:#fff;line-height:22px;padding:10px;text-align:justify;}
	#about.body a{color:#7c7c7c;}

#collection_content ul{padding: 30px 0 0 15px;}
    #collection-cover ul ul{padding: 0px;}
#collection-cover li{margin-right: 20px;float: left;line-height:20px;}
    #collection-cover li li{padding: 5px 0px;}
#collection-cover li strong{ text-transform: uppercase;}



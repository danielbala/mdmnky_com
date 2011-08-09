<?php header("Cache-Control: max-age=604800"); if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?><!DOCTYPE html>
<html>
	<head>
		<title>Mad Monkey Apparel - MDMNKY</title>
		<meta charset="utf-8" />
		<meta property="fb:admins" content="715090896" />
		<link rel="stylesheet" href="https://s3.amazonaws.com/mdmnky_assets/style.css" type="text/css" />
		<link rel="shortcut icon" type="image/x-icon" href="https://s3.amazonaws.com/mdmnky_assets/BIGHEAD.ico" />
		<style>
			span.sepr{color:#ccc;font-weight:normal;}
			.guestbook{color:#24B5F5;}
		</style>
	</head>
	<body id="index" class="home">
	<!-- Template content -->
			<p style="display:none">
				<textarea id="template" rows="0" cols="0"><!--
				{#foreach $T.series as the_tmpl_serie}
				<div id="{$T.the_tmpl_serie.id}" class="albums"><hr/>
					<div id="{$T.the_tmpl_serie.id}_nav" class="series_nav">
						<span class="title">{$T.the_tmpl_serie.title}</span>
						<span class="navigate"><a title="Previous Album" class="prev_album">Previous</a> - <a title="Next Album" class="next_album">Next</a></span>
					</div>
					<div id="{$T.the_tmpl_serie.id}_content" class="content">
						{#foreach $T.the_tmpl_serie.prints as the_tmpl_print}
						{#if $T.the_tmpl_print.visible == 'true'}
						<div class="print" id="{$T.the_tmpl_print.id}"><hr/>
							<div class="nav top">
								{#if $T.the_tmpl_print.title != 'cover'}<span class="title">{$T.the_tmpl_print.title}</span>{#/if}
								<span class="navigate">
									<a title="Previous Print" class="next_prev_arrow_link prev_arrow_link prev_item_{$T.the_tmpl_serie.id}">Previous |</a>  
									<a title="Next Print" class="next_prev_arrow_link next_arrow_link next_item_{$T.the_tmpl_serie.id}">Next</a>
								</span>
								
								<span class="buy">
								{#if $T.the_tmpl_print.title != 'cover'}
									<a class="guestbook" href="http://bala.me/wabs/?series={$T.the_tmpl_serie.id}&print={$T.the_tmpl_print.id}">Guestbook</a> 
									<span class="sepr"> | </span>
								{#/if}
								{#if $T.the_tmpl_print.onsale == 'true' && $T.the_tmpl_print.title != 'cover'}
									<a class="onsale" href="{$T.the_tmpl_print.onsale_url}">Buy This Shirt!</a>
								{#/if}
								{#if $T.the_tmpl_print.onsale == 'false' && $T.the_tmpl_print.title != 'cover'}
									<a href="#buy">Buy This Shirt!</a>
								{#/if}
								</span>
							</div>
							{#if $T.the_tmpl_print.title == 'cover'}
							<img src="{$T.the_tmpl_print.artwork[0].src}" width="964" height="454" alt="{$T.the_tmpl_print.artwork[0].alt}" class="cover-img next_arrow_link captify next_item_{$T.the_tmpl_serie.id}"/>
							{#else}
							<div class="description">
								<div class="holder scroll-pane">
									{$T.the_tmpl_print.description}
								</div>
							</div>
							<div class="artwork">
								{#foreach $T.the_tmpl_print.artwork as the_tmpl_print_artwork}
								<img src="{$T.the_tmpl_print_artwork.src}" alt="{$T.the_tmpl_print_artwork.alt}" width="544" height="454"/>
								{#/for}
							</div>
							<div class="nav bottom">
								<span class="navigate">{$T.the_tmpl_print.bottom_nav}</span>
								{#if $T.the_tmpl_print.multiple_art == 'true'}<span class="buy"><a href="#flip" class="other_side">See More...</a></span>{#/if}
							</div>{#/if}<hr/>
						</div>{#/if}{#/for}
					</div>
				</div>{#/for}
				<div id="collection" class="albums"><hr/>
					<div id="collection_nav" class="series_nav">
						<span class="title">Series </span>
						<span class="navigate"><a class="prev_album">Previous</a> - <a class="next_album">Next</a></span>
					</div>
					<div id="collection_content" class="content">
						<div class="print" id="collection-cover"><hr/>
							<div class="ser_page">
								<ul>{#foreach $T.series as the_tmpl_serie}
								<li>
									<strong><a class="hard_link" href="#series={$T.the_tmpl_serie.id}&amp;print={$T.the_tmpl_serie.id}-cover">{$T.the_tmpl_serie.title}</a></strong>
									<ul>{#foreach $T.the_tmpl_serie.prints as the_tmpl_print}
									{#if $T.the_tmpl_print.visible == 'true' && $T.the_tmpl_print.title != 'cover'}
										<li><a class="hard_link" href="#series={$T.the_tmpl_serie.id}&amp;print={$T.the_tmpl_print.id}">{$T.the_tmpl_print.title}</a></li>{#/if}{#/for}</ul></li>{#/for}</ul>
							</div><hr/>
							</div>
							<div class="print" id="about-us">
								<hr/><div class="ser_page"><ul><li>
										<strong>About Mad Monkey Inc.</strong>
										<p>Hello,</p>
										<p>MadMonkey Inc. (MDMNKY) is a design and identity company that produces apparel for sale, as well as providing group and event identity services. MDMNKY has seen the effects that unique apparel has on group dynamics. We know that once a cause is identified, a strong identity for the cause has significant effects on the productivity, and the overall success of the group. Our mission is to create identity and apparel that connects on an emotional level.</p>
										<p>If you would like to find out more about us, or see some samples, or just to say hello, please <a href="/#series=collection&print=contact-us"><strong><em>get in touch</em></strong>.</a></p>
										<p>Thank you for stopping by.</p>
									</li></ul></div><hr/>
							</div>
							<div class="print" id="contact-us"><hr/><div class="ser_page"><ul style="text-align:center;"><li><strong>Got Something to Say?</strong><form action="gdform.php" method="post" id="contact_us_form" accept-charset="utf-8"><input type="hidden" name="subject" value="Mail from MDMNKY" /><input type="hidden" name="redirect" value="/#series=collection&amp;print=thank-you" /><ul class="form-section"><li><label for="full_name">My name is:</label><input type="text" id="input_0" name="full_name" size="20" maxlength="100" /></li><li><label for="txt_message">Message:</label><input type="text" style="height: 50px;width: 577px;" id="txt_message" name="txt_message" /></li><li><label for="email_address">E-mail me at:</label><input type="email" id="email_address" name="email_address" size="20" maxlength="100" /></li><li><button id="submit_btn" type="submit">Hello</button></li></ul></form></li></ul></div><hr/>
							</div>
							<div class="print" id="thank-you">
								<hr/><div class="ser_page"><ul><li><strong>Thank you!</strong></li></ul></div><hr/>
							</div>
						</div>
					</div>-->
			</textarea></p>
			
		<div id="wrapper">
			<div id="banner" class="body">
				<div id="copyright">
					<a id="home_link" href="/" title="home" class="littleicon">Home</a>
					<a id="beta_link" href="#series=collection&amp;print=contact-us" class="hard_link title" rel="Contact Mad Monkey" title=" this means we need your help! we need storytellers and we need your feedback. please contact us!">Contact Us</a>
				</div>
				<div id="social">
					<a class="tipthis" href="#buy" title="on your keyboard: press the left and right arrows for prints; press the up and down arrows for series. enjoy!"></a>
					<a href="http://www.facebook.com/pages/Earth/MAD-MONKEY/76370635106" target="_blank" id="fb" title="facebook" class="littleicon">facebook | </a>
					<a href="http://twitter.com/mdmnky" target="_blank" id="tw" title="twitter" class="littleicon">twitter</a>
				</div>
			</div>
			
			<div id="seriess">
				
			</div>
			
			<div id="footer">
				<ul>
					<li><a class="hard_link curr_selected" href="#series=science&amp;print=science-cover" rel="Look Book">Look Book</a></li>
					<li><a class="hard_link" href="#series=collection&amp;print=about-us" rel="About Mad Monkey" id="abt_us">About Mad Monkey</a></li>
					<li><a class="hard_link" href="#series=collection&amp;print=collection-cover" rel="The Series" id="ser_lnk">Apparel</a></li>
					<li><a class="hard_link" href="#series=collection&amp;print=contact-us" rel="Contact Mad Monkey" id="ctc_us">Contact Us</a></li>
					<li><a class="" href="http://madmonkey.bigcartel.com" rel="Our Online Store" id="the_store">Store</a></li>
				</ul>
				<span class="cpyr">&copy; <script type="text/javascript">var now = new Date; document.write(now.getFullYear());</script> Mad Monkey Inc.</span>
			</div>
			<!-- /#footer -->
		</div><!--/#wrapper-->
		
		
		<script type="text/javascript" charset="utf-8" src="https://s3.amazonaws.com/mdmnky_assets/jq.cycle.mousewheel.jsScrollPane.bbq.captify.tiptip.jtemplates.js"></script>
		<script type="text/javascript" src="js/logic.js.php"></script>
		<script type="text/javascript"> 
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script> 
		<script type="text/javascript"> 
		try {
		var pageTracker = _gat._getTracker("UA-9617848-1");
		pageTracker._trackPageview();
		} catch(err) {}
		</script> 
	</body>
</html>

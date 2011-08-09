<?php

	require 'src/facebook.php';
	// Create our FB Application instance
	$facebook = new Facebook(array(
	  
	  'cookie' => true,
	));
	// We may or may not have this data based on a $_GET or $_COOKIE based session.
	//
	// If we get a session here, it means we found a correctly signed session using
	// the Application Secret only Facebook and the Application know. We dont know
	// if it is still valid until we make an API call using the session. A session
	// can become invalid if it has already expired (should not be getting the
	// session back in this case) or if the user logged out of Facebook.
	$session = $facebook->getSession();

	$me = null;
	// Session based API call.
	if ($session) {
	  try {
		$uid = $facebook->getUser();
		$me = $facebook->api('/me');
		//$response = $facebook->api('/me/feed', "message=dude where is my car");
	  } catch (FacebookApiException $e) {
		error_log($e);
	  }
	}

	// login or logout url will be needed depending on current user state.
	if ($me) {
		$logoutUrl = $facebook->getLogoutUrl();
		$fb_img = "https://graph.facebook.com/". $uid."/picture?type=square";
		$fb_url = $me['link'];
		
	} else {
		$loginUrl = $facebook->getLoginUrl();
		$fb_img = "";
		$fb_url = "";
	}
	// This call will always work since we are fetching public data.
	//$naitik = $facebook->api('/danielbala');
	//END FACEBOOK, START TWITTER
	
	require 'src/tmhOAuth.php';
	$tmhOAuth = new tmhOAuth(array(
	  'consumer_key'	=> '9TOuQjNokYQOPmpmo0XFg',
	  'consumer_secret' => 'ksblMTwEMQeZ5yovlwpJNMK0FpHLu0xmFTe0uUvk',
	));

	$here = $tmhOAuth->php_self();
	session_start();
	$tw_img = "";
	$tw_url = "";
	$is_papi = "exnay";
	$tw_content = '<span><a href="?twitter_signin=1" class="tw_signin"><small>Sign in with Twitter</small></a></span>';
	// reset?
	if ( isset($_REQUEST['wipe'])) {
	  session_destroy();
	  header("Location: {$here}");

	// already got some credentials stored?
	} elseif ( isset($_SESSION['access_token']) ) {
		$tmhOAuth->config['user_token']  = $_SESSION['access_token']['oauth_token'];
		$tmhOAuth->config['user_secret'] = $_SESSION['access_token']['oauth_token_secret'];
		$tmhOAuth->request('GET', $tmhOAuth->url('1/account/verify_credentials'));
		//$tmhOAuth->pr(json_decode($tmhOAuth->response['response']));
		$resp_json_obj = json_decode($tmhOAuth->response['response']);
		$tw_content = '<img src="'.$resp_json_obj->profile_image_url.'" style="float:left;" /><span>'.$resp_json_obj->name.' <a href="?wipe=1"><small>Twitter Logout</small></a></span>';
		$tw_img = $resp_json_obj->profile_image_url;
		$tw_screen_name = $resp_json_obj->screen_name;
		$tw_url = "http://twitter.com/".$tw_screen_name;
		
		if($tw_screen_name === "mdmnky"){//only person allowed to delete comments
			$is_papi = "xnay";
		}
		
	
	// we're being called back by Twitter
	} elseif (isset($_REQUEST['oauth_verifier'])) {
		$tmhOAuth->config['user_token']  = $_SESSION['oauth']['oauth_token'];
		$tmhOAuth->config['user_secret'] = $_SESSION['oauth']['oauth_token_secret'];
		
		$tmhOAuth->request('POST', $tmhOAuth->url('oauth/access_token', ''), array(
		'oauth_verifier' => $_REQUEST['oauth_verifier']
		));
		
		$_SESSION['access_token'] = $tmhOAuth->extract_params($tmhOAuth->response['response']);
		
		unset($_SESSION['oauth']);
		header("Location: {$here}");

	// start the OAuth dance
	} elseif ( isset($_REQUEST['twitter_signin']) || isset($_REQUEST['allow']) ) {
	  $callback = isset($_REQUEST['oob']) ? 'oob' : $here;

	  $tmhOAuth->request('POST', $tmhOAuth->url('oauth/request_token', ''), array(
		'oauth_callback' => $callback
	  ));

	  if ($tmhOAuth->response['code'] == 200) {
		$_SESSION['oauth'] = $tmhOAuth->extract_params($tmhOAuth->response['response']);
		$method = isset($_REQUEST['twitter_signin']) ? 'authenticate' : 'authorize';
		$force	= isset($_REQUEST['force']) ? '&force_login=1' : '';
		$forcewrite	 = isset($_REQUEST['force_write']) ? '&oauth_access_type=write' : '';
		$forceread	= isset($_REQUEST['force_read']) ? '&oauth_access_type=read' : '';
		header("Location: " . $tmhOAuth->url("oauth/{$method}", '') .  "?oauth_token={$_SESSION['oauth']['oauth_token']}{$force}{$forcewrite}{$forceread}");

	  }
	}
	$the_series = "creatures";
	$the_print = "hawkins";
	
	//if a query string is passed in, use it, else if a session is set, use it, otherwise we default to hawkins
	if(isset($_REQUEST['series'])){
		$_SESSION['the_series'] = $_REQUEST['series'];
		$the_series = $_SESSION['the_series'];
	}elseif(isset($_SESSION['the_series'])){
		$the_series = $_SESSION['the_series'];
	}
	if(isset($_REQUEST['print'])){
		$_SESSION['the_print'] = $_REQUEST['print'];
		$the_print = $_SESSION['the_print'];
	}elseif(isset($_SESSION['the_print'])){
		$the_print = $_SESSION['the_print'];
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>mdmnky guestbook by danielbalapeterson</title>
	<link rel="stylesheet" href="css/style.css" type="text/css"/>
	<script src="https://www.google.com/jsapi?key=ABQIAAAA8py4yqCxQaO1DL8XTnYfQxQeWU_u9MsnLhByUpWUKG5X8sUlQBRqKt25TsK7lNG0fTz0tUJ6Cyr8ug" type="text/javascript"></script>
	<script>
		google.load("jquery", "1.4.4");
		google.load("jqueryui", "1.8.7");
		WebFontConfig = {
				google: { families: [ 'Covered+By+Your+Grace', 'Raleway:100' ] }
			  };
			  (function() {
				var wf = document.createElement('script');
				wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
					'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
				wf.type = 'text/javascript';
				wf.async = 'true';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(wf, s);
			  })();
			var _is_tha_mayn = "<?php echo $is_papi; ?>";
			var user_social = {
				fb_img:"<?php echo $fb_img; ?>",
				fb_url:"<?php echo $fb_url; ?>",
				tw_img:'<?php echo $tw_img; ?>',
				tw_url:'<?php echo $tw_url; ?>'
			};
			var mdmnky_item = {
				the_series:"<?php echo $the_series; ?>",
				the_print:"<?php echo $the_print; ?>"
			};
	</script>
	<script src="js/lib.js" type="text/javascript"></script>
</head>

<body id="index" class="home">
	<div id="wrapper" style="">
		<div id="sigi">
			<?php if ($me): ?>
				<img src="https://graph.facebook.com/<?php echo $uid; ?>/picture?type=square" style="float:left;" />
				<span>
					<?php echo $me['name']; ?> <a href="<?php echo $logoutUrl; ?>"><small>Facebook Logout</small></a>
				</span>
			<?php else: ?>
				<span>
					<a href="<?php echo $loginUrl; ?>"><small>Signin with facebook </small></a> 
				</span>
			<?php endif ?>
			<?php echo $tw_content; ?>
		</div>
		<span class="intro"><a href="http://dbala.com" target="_blank">hello...</a> tell us what you think... <br /> 
			<img width="544" height="454" alt="<?php echo $the_print; ?> Artwork" src="https://s3.amazonaws.com/mdmnky_assets/<?php echo $the_print; ?>_artwork.jpg"/>
			<small><em>...DOUBLE CLICK anywhere.</em><em style="display: inline-block;text-indent: 80px;">...hit ENTER to submit.</em></small></span>
		<input id="comment" type="text" tabindex="1" placeholder="type your comment here ...hit enter to submit" />
		<div id="soc" style="position:absolute;top:0;right:0;">
			
			<a href="http://twitter.com/share" class="twitter-share-button" data-text="I just signed the mdmnky guestbook for Hawkins... you should too" data-count="none" data-via="mdmnky">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
			<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmdmnky.com%2F%23series%3D<?php echo $the_series; ?>%26print%3D<?php echo $the_print; ?>&amp;layout=button_count&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; height: 25px;overflow: hidden;width: 76px;position: relative;top: 5px;" allowTransparency="true"></iframe>
			<span style="font-size:15px;padding-right:5px;position: relative;top: -4px;"><a href="http://mdmnky.com/#series=<?php echo $the_series; ?>&print=<?php echo $the_print; ?>">lookbook &gt;&gt;</a></span>
		</div>
	</div>
	<script>
	  window.fbAsyncInit = function() {
		FB.init({
		  appId	  : '<?php echo $facebook->getAppId(); ?>',
		  session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
		  status  : true, // check login status
		  cookie  : true, // enable cookies to allow the server to access the session
		  xfbml	  : true // parse XFBML
		});

		// whenever the user logs in, we refresh the page
		/*FB.Event.subscribe('auth.login', function() {
		  window.location.reload();
		});*/
	  };

	  (function() {
		/*var e = document.createElement('script');
		e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		e.async = true;
		document.getElementById('fb-root').appendChild(e);*/
	  }());
	</script>
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

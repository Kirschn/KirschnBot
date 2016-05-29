
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>KirschnBot</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Twitch Chat Moderation Bot" />
	<meta name="keywords" content="irc, bot, twitch, chat bot, twitch bot, twitch chatbot, chatbot, tiwtch chat bot, chat, link, timeout" />
	<meta name="author" content="Kirschn" />

  <!-- 
	//////////////////////////////////////////////////////

	FREE HTML5 TEMPLATE 
	DESIGNED & DEVELOPED by FREEHTML5.CO
		
	Website: 		http://freehtml5.co/
	Email: 			info@freehtml5.co
	Twitter: 		http://twitter.com/fh5co
	Facebook: 		https://www.facebook.com/fh5co

	//////////////////////////////////////////////////////
	 -->

  <!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,400italic,700' rel='stylesheet' type='text/css'>
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Simple Line Icons -->
	<link rel="stylesheet" href="css/simple-line-icons.css">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">

	<!-- 
	Default Theme Style 
	You can change the style.css (default color purple) to one of these styles
	
	1. pink.css
	2. blue.css
	3. turquoise.css
	4. orange.css
	5. lightblue.css
	6. brown.css
	7. green.css

	-->
	<link rel="stylesheet" href="css/style.css">

	<!-- Styleswitcher ( This style is for demo purposes only, you may delete this anytime. ) -->
	<link rel="stylesheet" id="theme-switch" href="css/style.css">
	<!-- End demo purposes only -->


	<style>
	/* For demo purpose only */
	
	/* For Demo Purposes Only ( You can delete this anytime :-) */
	#colour-variations {
		padding: 10px;
		-webkit-transition: 0.5s;
	  	-o-transition: 0.5s;
	  	transition: 0.5s;
		width: 140px;
		position: fixed;
		left: 0;
		top: 100px;
		z-index: 999999;
		background: #fff;
		/*border-radius: 4px;*/
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
		-webkit-box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
		-moz-box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
		-ms-box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
		box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
	}
	#colour-variations.sleep {
		margin-left: -140px;
	}
	#colour-variations h3 {
		text-align: center;;
		font-size: 11px;
		letter-spacing: 2px;
		text-transform: uppercase;
		color: #777;
		margin: 0 0 10px 0;
		padding: 0;;
	}
	#colour-variations ul,
	#colour-variations ul li {
		padding: 0;
		margin: 0;
	}
	#colour-variations li {
		list-style: none;
		display: inline;
	}
	#colour-variations li a {
		width: 20px;
		height: 20px;
		position: relative;
		float: left;
		margin: 5px;
	}
	#colour-variations li a[data-theme="style"] {
		background: #6173f4;
	}
	#colour-variations li a[data-theme="pink"] {
		background: #f64662;
	}
	#colour-variations li a[data-theme="blue"] {
		background: #2185d5;
	}
	#colour-variations li a[data-theme="turquoise"] {
		background: #00b8a9;
	}
	#colour-variations li a[data-theme="orange"] {
		background: #ff6600;
	}
	#colour-variations li a[data-theme="lightblue"] {
		background: #5585b5;
	}
	#colour-variations li a[data-theme="brown"] {
		background: #a03232;
	}
	#colour-variations li a[data-theme="green"] {
		background: #65d269;
	}

	.option-toggle {
		position: absolute;
		right: 0;
		top: 0;
		margin-top: 5px;
		margin-right: -30px;
		width: 30px;
		height: 30px;
		background: #f64662;
		text-align: center;
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
		color: #fff;
		cursor: pointer;
		-webkit-box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
		-moz-box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
		-ms-box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
		box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
	}
	.option-toggle i {
		top: 2px;
		position: relative;
	}
	.option-toggle:hover, .option-toggle:focus, .option-toggle:active {
		color:  #fff;
		text-decoration: none;
		outline: none;
	}
	</style>
	<!-- End demo purposes only -->


	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body data-theme="blue">
	<header role="banner" id="fh5co-header">
			<div class="container">
				<!-- <div class="row"> -->
			    <nav class="navbar navbar-default">
		        <div class="navbar-header">
		        	<!-- Mobile Toggle Menu Button -->
					<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
		          	<a class="navbar-brand" href="index.html">KirschnBot</a>
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		          <ul class="nav navbar-nav navbar-right">
		            <li class="active"><a href="#" data-nav-section="home"><span>Home</span></a></li>
		            <li><a href="#" data-nav-section="features"><span>Features</span></a></li>
		            <li><a href="https://kirschnbot.tk/login.php"><span>Login</span></a></li>
		          </ul>
		        </div>
			    </nav>
			  <!-- </div> -->
		  </div>
	</header>

	<div id="slider" data-section="home">
		<div class="owl-carousel owl-carousel-fullwidth">
			<!-- You may change the background color here. -->
		    <div class="item" style="background: #352f44;">
		    	<div class="container" style="position: relative;">
		    		<div class="row">
					    <div class="col-md-7 col-sm-7">
			    			<div class="fh5co-owl-text-wrap">
						    	<div class="fh5co-owl-text">
						    		<h1 class="fh5co-lead to-animate">KirschnBot</h1>
									<h2 class="fh5co-sub-lead to-animate">Free and open source Twitch Chat Moderation Bot</h2>
									<p class="to-animate-2"><a href="https://kirschnbot.tk/login.php" class="btn btn-primary btn-lg">Get started now</a></p>
						    	</div>
						    </div>
					    </div>
					    <div class="col-md-4 col-md-push-1 col-sm-4 col-sm-push-1 iphone-image">
					    	<div class="to-animate-2 iphone"><img src="images/chat.png" alt="Example Chat"></div>
					    </div>

		    		</div>
		    	</div>
		    </div>
			<!-- You may change the background color here.  -->
		    <div class="item" style="background: #38569f;">
		    	<div class="container" style="position: relative;">
		    		<div class="row">
		    			<div class="col-md-7 col-md-push-1 col-md-push-5 col-sm-7 col-sm-push-1 col-sm-push-5">
			    			<div class="fh5co-owl-text-wrap">
						    	<div class="fh5co-owl-text">
						    		<h1 class="fh5co-lead to-animate">Simple Interface</h1>
									<h2 class="fh5co-sub-lead to-animate">Easily control the bot from any internet-connected device!</h2>
									<p class="to-animate-2"><a href="https://kirschnbot.tk/login.php" class="btn btn-primary btn-lg">Get started now</a></p>
						    	</div>
						    </div>
					    </div>
					    <div class="col-md-4 col-md-pull-7 col-sm-4 col-sm-pull-7 iphone-image">
					    	<div class="to-animate-2 iphone"><img src="images/webinterface.png" alt="Webinterface"></div>
					    </div>

		    		</div>
		    	</div>
		    </div>

		    <div class="item" style="background-image:url(images/slide_5.jpg)">
		    	<div class="overlay"></div>
		    	<div class="container" style="position: relative;">
		    		<div class="row">
		    			<div class="col-md-8 col-md-offset-2 text-center">
		    				<div class="fh5co-owl-text-wrap">
						    	<div class="fh5co-owl-text">
		    						<h1 class="fh5co-lead to-animate">Open Source</h1>
									<h2 class="fh5co-sub-lead to-animate">The source code of the bot and webinterface is fully available on GitHub</h2>
									<p class="to-animate-2"><a href="https://github.com/Kirschn/KirschnBot" target="_blank" class="btn btn-primary btn-lg">See the awesome!</a></p>
								</div>
							</div>
		    			</div>
		    		</div>
		    	</div>
		    </div>

		</div>
	</div>

	<div id="fh5co-our-services" data-section="features">
		<div class="container">
			<div class="row row-bottom-padded-sm">
				<div class="col-md-12 section-heading text-center">
					<h2 class="to-animate">Features</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 to-animate">
							<h3>Every software needs some purposes, so here are some:</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="box to-animate">
						<div class="icon colored-1"><span><i class="icon-exclamation" ></i> </span></div>
						<h3>Custom Commands</h3>
						<p>Sometimes your moderators get tired of pasting everytime their pastas, so why not create a !command and let the bot do the work?</p>
					</div>
					<div class="box to-animate">
						<div class="icon colored-4"><span><i class="icon-clock"></i></span></div>
						<h3>Timed Actions</h3>
						<p>Just set an interval and the bot will execute automatically some tasks, e.g. execute a command</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box to-animate">
						<div class="icon colored-2"><span><i class="icon-ban"></i></span></div>
						<h3>Automatic Timeouts</h3>
						<p>Automatically purge people who post links or "bad words". Also useful to prevent spambots from killing your chat experience.</p>
					</div>
					<div class="box to-animate">
						<div class="icon colored-5"><span><i class="icon-user"></i></span></div>
						<h3>Extremely customizable Usersystem</h3>
						<p>You like someone and wish to give him access to more commands or prevent someone from executing commands? Just decrease or increase the userlevel from this person!</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box to-animate">
						<div class="icon colored-3"><span><i class="glyphicon glyphicon-fast-forward"></i></span></div>
						<h3>Fast</h3>
						<p>The bot is built around a high-performance framework which allows to timeout spammers even before their message appears in the twitch webchat!</p>
					</div>
					<div class="box to-animate">
						<div class="icon colored-6"><span><i class="icon-wrench"></i></span></div>
						<h3>Customizable Name</h3>
						<p>Don't like to have the name "KirschnBot" in your channel? Create a Twitch Account with your botname, generate a Token and insert it on the "Options" page in the webinterface.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	


	<footer id="footer" role="contentinfo">
		<div class="container">
			<div class="row row-bottom-padded-sm">
				<div class="col-md-12">
					<p class="copyright text-center">&copy; 2015 <a href="https://kirschn.de">Kirschn</a></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<ul class="social social-circle">
						<li><a href="http://twitter.com/KirschnBot"><i class="icon-twitter"></i></a></li>
						<li><a href="http://github.com/Kirschn/KirschnBot"><i class="icon-github"></i></a></li>
						<li><a href="http://reddit.com/r/KirschnBot"><i class="icon-reddit"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	
	
	<!-- For demo purposes Only ( You may delete this anytime :-) -->

	<!-- End demo purposes only -->

	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Owl Carousel -->
	<script src="js/owl.carousel.min.js"></script>

	<!-- For demo purposes only styleswitcher ( You may delete this anytime ) -->
	<script src="js/jquery.style.switcher.js"></script>
	<script>
	$(function(){
		$('#colour-variations ul').styleSwitcher({
			defaultThemeId: 'theme-switch',
			hasPreview: false,
			cookie: {
	          	expires: 30,
	          	isManagingLoad: true
	      	}
		});	
		$('.option-toggle').click(function() {
			$('#colour-variations').toggleClass('sleep');
		});
	});
	</script>
	<!-- End demo purposes only -->

	<!-- Main JS (Do not remove) -->
	<script src="js/main.js"></script>

	</body>
</html>

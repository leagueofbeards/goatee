<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<?php include('config.php') ?>
		<title><?php echo $firstName . ", " . $jobTitle . " at " . $companyName . "."; ?></title>
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/foundation.min.css">
		<script src="js/vendor/custom.modernizr.js"></script>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="js/vendor/chirp.min.js"></script>
		<script src="js/vendor/engage.lastfm-min.js"></script>
		<style>
			body { 
				background: url('<?php echo $backgroundPath; ?>') no-repeat center center fixed;
				filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='.<?php echo $backgroundPath; ?>', sizingMethod='scale');
				-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $backgroundPath; ?>', sizingMethod='scale')";
				font-family: <?php echo $fontFamily; ?> !important; }
			h1, h2, h3, h4, h5, h6 { font-family: <?php echo $fontFamily; ?> !important; }
			.league {
				background: <?php echo $companyColor ?>; }
				.league:hover {
					color: <?php echo $companyColor ?>;	}
		</style>
		<script type="text/javascript">
			$(document).ready(function(){

				$('div#scrobbled').lastFM({
					username: '<?php echo $lastfmUser; ?>',
					apikey: '02bdccd1f8357d1820e423b0c1d0ffa4',
					number: <?php echo $numListened; ?>,
					artSize: 'large',
					noart: 'images/blank_insert.gif',
					onComplete: function(){
						//Done
					}
				});
				
				$.ajax({
		          type: "GET",
		          url: "http://api.trakt.tv/activity/user.json/13fc39c1edc9a660e974c9432e9bec04/<?php echo $traktUser; ?>/all/scrobble", 
		          dataType: "jsonp",
		          success: function (json) {
	            // Runs for every node within the outputs activity module.         
	            $.each(json.activity, function(i,item){
	              // This limits the output to only three, how cruel.
	              if (i == <?php echo $numWatched; ?>){ return false; }
	            
	              // Checks if it's a movie or a show
	              if (item.type == "movie") {
	                var movieTitle = item.movie.title;
	                var moviePoster = item.movie.images.poster.replace('.jpg','-300.jpg');
	                var movieYear = item.movie.year;
	                $("<dl/>").html("<dt class='trkt_poster'><img src="+moviePoster+" /></dt><dd class='trkt_title'>"+movieTitle+"</dd><dd class='trkt_info'>"+movieYear+"</dd>").appendTo("#trakt #watched");
	                  
	              } else if (item.type == "episode" || item.type == "show") {
	                var showTitle = item.show.title;
	                var showPoster = item.show.images.poster.replace('.jpg','-300.jpg');
	                var episodeName = item.episode.title;
	                var episodeNumber = item.episode.episode;
	                var episodeSeason = item.episode.season;
	                $("<dl/>").html("<dt class='trkt_poster'><img src="+showPoster+" /></dt><dd class='trkt_title'>"+showTitle+"</dd><dd class='trkt_info'>"+episodeName+" ("+episodeSeason+"X"+episodeNumber+")</dd>").appendTo("#trakt #watched");
	              } else {
	                $("<dl/>").html("What?!").appendTo("#trakt #watched");
	              }
	            });
	            
	            // There for some reason are no nodes to show, throw an pie in the users face.          
	            if (json.activity.length == 0) {
	              $("<dl/>").html("<dd class='trkt_title'>Seems something has gone horrifically wrong. Sorry about this...</dd>").appendTo("#trakt #watched");
	            }
	          },
		          error: function(){
		            // And now it's hit the metaphorical fan
		            $("<div/>").html("Seems something has gone horrifically wrong. Sorry about this...").appendTo("#trakt #watched");
		          }
		        });
		    });
		</script>
		<script src="js/vendor/dribbble.js"></script>
	    <script type="text/javascript">
	        getShotsForID('<?php echo $dribbbleUser; ?>', 'shots', <?php echo $numShots; ?>);
	    </script>
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="css/<?php echo $themeValue; ?>.css">
	</head>
	<body>
		<div class="row">
			<div class="large-12 columns">
				<header class="large-10 columns large-centered">
					<h1>I am <b><?php echo $firstName; ?>.</b>
						<div class="contact">
							<a href="mailto:<?php echo $contactEmail; ?>" alt="Email me">
									<svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						 width="32px" height="24px" viewBox="0 0 100 75.422" enable-background="new 0 0 100 75.422" xml:space="preserve">
										<path d="M100,75.422H0V0h100V75.422L100,75.422z M11.833,68.445h76.333L63.048,42.73l-4.756,4.787
											c-2.059,2.058-5.007,3.236-8.105,3.236c-0.017,0-0.035-0.003-0.052-0.003c-3.11-0.013-6.067-1.216-8.115-3.304l-4.835-4.895
											L11.833,68.445L11.833,68.445z M6.977,11.973v51.461L32.282,37.59L6.977,11.973L6.977,11.973z M67.964,37.78l25.059,25.651V12.551
											L67.964,37.78L67.964,37.78z M11.849,6.979l35.143,35.573c0.761,0.774,1.916,1.218,3.174,1.221c0.008,0,0.014,0,0.021,0
											c1.24,0,2.421-0.438,3.161-1.182L88.722,6.979H11.849L11.849,6.979z" class="svgfill"/>
									</svg>
								</a>
							<a alt="iMessage me" href="<?php 
								$useragent = $_SERVER['HTTP_USER_AGENT']; 
								if(preg_match('/Macintosh/',$useragent)) $os = 'imessage';
								elseif(preg_match('/iPhone/',$useragent)) $os = 'sms';
								else $os = 'sms';
								echo $os;
							?>:<?php echo $contactMessages; ?>"> <!--iMessage?-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="56px" height="44px" viewBox="0 0 100 63.62" enable-background="new 0 0 100 63.62" xml:space="preserve" style="position: relative; top: 5px; left: -20px;">
										<path d="M45.178,26.205v20.168c0,4.211,3.263,7.627,7.289,7.627h19.21c2.658,3.145,5.313,6.289,7.97,9.434  c0.354,0.42,1.036,0.068,1.036-0.428c0-3.002,0-6.004,0-9.006h12.029c4.025,0,7.288-3.416,7.288-7.627V26.205  c0-4.212-3.263-7.629-7.288-7.629H52.467C48.441,18.576,45.178,21.992,45.178,26.205z" class="svgfill" />
									</svg>
								</a>
						</div>
					</h1>
					<h2>I am <?php echo $jobTitle; ?> at <a class="verb league" href="<?php echo $companyURL; ?>" target="_blank"><?php echo $companyName; ?></a></h2>
				</header>
				<div class="large-10 columns large-centered" id="dribbble">
					<h2>I am <a class="verb dribbble" href="http://dribbble.com/players/<?php echo $dribbbleUser; ?>" target="_blank">working</a> on...</h2>
					<div id="shots" class="large-12 columns large-centered"></div>
				</div>
				<div class="large-10 columns large-centered" id="twitter">
					<h2>I am <a class="verb twitter" href="http://twitter.com/<?php echo $twitterUser; ?>" target="_blank">talking</a> about...</h2>
					<div id="tweets" class="large-12 columns large-centered">
						<script>
							Chirp({
						      user:'<?php echo $twitterUser; ?>',
						      max: <?php echo $numTweets; ?>,
						      templates: {
						      	base: '<ul class="chirp">{{tweets}}</ul>',
						      	tweet: '<li><p>{{html}}</p><span class="meta"><time><a href="http://twitter.com/{{user.screen_name}}/statuses/{{id_str}}">{{time_ago}}</a></time></span></li>'
						      }
	      					})
    					</script>
					</div>
				</div>
				<div class="large-10 columns large-centered" id="trakt">
					<h2>I am <a class="verb trakt" href="http://trakt.tv/user/<?php echo $traktUser; ?>" target="_blank">watching</a> a little...</h2>
					<div id="watched" class="large-12 columns large-centered">
					</div>
				</div>
				<div class="large-10 columns large-centered" id="lastfm">
					<h2>I am <a class="verb lastfm" href="http://last.fm/user/<?php echo $lastfmUser; ?>" target="_blank">listening</a> to...</h2>
					<div id="scrobbled" class="large-12 columns large-centered">
						<dl>
							<a href="#"><dt class="lfm_art"></dt>
							<dd class="lfm_artist"></dd></a>
							<dd class="lfm_song"></dd>
						</dl>
					</div>
				</div>
				<div id="login-pop" class="large-12 columns">
					<div id="pass-pop" class="large-4 columns large-centered">
						<div class="large-12 columns large-centered">
							<a href="http://github.com/leagueofbeards/goatee"><img src="img/poweredby@2x.png"></a>
						</div>
					</div>
				</div>
				<footer class="large-10 columns large-centered">
					<div class="large-3 columns large-centered">
						<img id="goatee-logo" src="img/goatee@2x_gray.png">
					</div>
				</footer>
				<div class="large-12 columns"></div>
			</div>
		</div>
	<script>
	document.write('<script src=' +
	('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
	'.js><\/script>')
	</script>
	
	<script src="js/foundation.min.js"></script>
	<!--
	
	<script src="js/foundation/foundation.js"></script>
	
	<script src="js/foundation/foundation.alerts.js"></script>
	
	<script src="js/foundation/foundation.clearing.js"></script>
	
	<script src="js/foundation/foundation.cookie.js"></script>
	
	<script src="js/foundation/foundation.dropdown.js"></script>
	
	<script src="js/foundation/foundation.forms.js"></script>
	
	<script src="js/foundation/foundation.joyride.js"></script>
	
	<script src="js/foundation/foundation.magellan.js"></script>
	
	<script src="js/foundation/foundation.orbit.js"></script>
	
	<script src="js/foundation/foundation.placeholder.js"></script>
	
	<script src="js/foundation/foundation.reveal.js"></script>
	
	<script src="js/foundation/foundation.section.js"></script>
	
	<script src="js/foundation/foundation.tooltips.js"></script>
	
	<script src="js/foundation/foundation.topbar.js"></script>
	
	-->
	<script type="text/javascript">
		$(document).ready(function(){
			$('#goatee-logo').click(function(){
				$('#login-pop #pass-pop').fadeToggle();
				$('#passphrase').focus();
			});
		});
	</script>
	<script>
	$(document).foundation();
	</script>
	</body>
</html>

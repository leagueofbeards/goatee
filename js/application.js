$(document).ready(function() {
	$('div#scrobbled').lastFM({
		username: GOTEE.lastfmUser,
		apikey: '02bdccd1f8357d1820e423b0c1d0ffa4',
		number: GOTEE.numListened,
		artSize: 'large',
		noart: 'images/blank_insert.gif',
		onComplete: function(){
			//Done
		}
	});
	
	$.ajax({
      type: "GET",
      url: "http://api.trakt.tv/activity/user.json/13fc39c1edc9a660e974c9432e9bec04/" + GOTEE.traktUser + "/all/scrobble", 
      dataType: "jsonp",
      success: function (json) {
    // Runs for every node within the outputs activity module.         
    $.each(json.activity, function(i,item){
      // This limits the output to only three, how cruel.
      if ( i == GOTEE.numWatched ){ return false; }
    
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

	$('#goatee-logo').click(function() {
		$('#login-pop #pass-pop').fadeToggle();
		$('#passphrase').focus();
	});
});
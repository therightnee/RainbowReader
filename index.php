<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="main.css">
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="nav">
	<bold id="title">Rainbow Reader</bold>
	<div class="category" id="news"><a href="index.php#current=news">News</a></div>
	<div class="category" id="sports"><a href="index.php#current=sports">Sports</a></div>
	<div class="category" id="tech"><a href="index.php#current=tech">Technology</a></div>
	<div class="category" id="life"><a href="index.php#current=life">Life</a></div>
	<div class="category" id="music"><a href="index.php#current=music">Music</a></div>
	<div class="category" id="religion"><a href="index.php#current=religion">Religion</a></div>
	<div class="category" id="biz"><a href="index.php#current=biz">Business</a></div>
</div>
<div id="holder">
</div>
<script src="rss_feeds.js"></script>
<script>

//Store all the feeds into a singular array

var catagories = [news, sports, technology, life, music, religion, business];

var tracker = 0;

//Request Function handles the AJAX request

function request(count){

var current = catagories[count]

$.ajax({
        type: "POST",
        url: "SimplePie/parser.php",
        data: {feed : JSON.stringify(current)},
        async: false,
        success: function(data) {
            $("#holder").empty().hide();
            $("#holder").delay(800).fadeIn(400).append(data);
        }
    });
}

//Keyboard Navigation Section

$("body").keydown(function(e) {
  if(e.keyCode == 37) { // left
  	if (tracker == 0) {
  		tracker = 6
  	}

  	else {
  		tracker -= 1
  	}
  request(tracker)
  }
  else if(e.keyCode == 39) { // right
  	$("#holder").empty();
  	if (tracker == 6) {
  		tracker = 0
  	}

  	else {
  		tracker += 1
  	}
  request(tracker)
  }
});

//Click Navigation Section
$(".category").click(function(e) {

  current = e.target.href.split("=");

if (current[1] == "news"){
  tracker = 0;
}
if (current[1] == "sports"){
  tracker = 1;
}
if (current[1] == "tech"){
  tracker = 2;
}
if (current[1] == "life"){
  tracker = 3;
}
if (current[1] == "music"){
  tracker = 4;
}
if (current[1] == "religion"){
  tracker = 5;
}
if (current[1] == "biz"){
  tracker = 6;
}
  request(tracker);
});

//Initiate the page

$(document).ready(request(tracker));

//Reload every 10 minutes
setInterval(function(){
	request(tracker)
}, 600000);

//CSS mods based on section

</script>
</body>
</html>
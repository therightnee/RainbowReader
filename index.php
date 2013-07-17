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
	<div class="category" id="news">News</div>
	<div class="category" id="sports">Sports</div>
	<div class="category" id="tech">Technology</div>
	<div class="category" id="life">Life</div>
	<div class="category" id="music">Music</div>
	<div class="category" id="religion">Religion</div>
	<div class="category" id="business">Business</div>
</div>
<div id="holder">
</div>
<script src="rss_feeds.js"></script>
<script>

//Store all the feeds into a singular array

var categories = [news, sports, technology, life, music, religion, business];

var tracker = 0;

//Request Function handles the AJAX request

function request(count, show){

var current = categories[count]

$.ajax({
        type: "POST",
        url: "SimplePie/parser.php",
        data: {feed : JSON.stringify(current)},
        async: false,
        success: function(data) {
          if (show == 1) {
            $("#holder").empty().hide();
            $("#holder").delay(800).fadeIn(400).append(data);
          };
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
  request(tracker, 1)
  cssmod();
  }
  else if(e.keyCode == 39) { // right
  	$("#holder").empty();
  	if (tracker == 6) {
  		tracker = 0
  	}

  	else {
  		tracker += 1
  	}
  request(tracker, 1)
  cssmod();
  }
});

//Click Navigation Section
$(".category").click(function() {

  current = this.id;

  match(current);
});

function match(word) {

if (word == "news"){
  tracker = 0;
};
if (word == "sports"){
  tracker = 1;
};
if (word == "tech"){
  tracker = 2;
};
if (word == "life"){
  tracker = 3;
};
if (word == "music"){
  tracker = 4;
};
if (word == "religion"){
  tracker = 5;
};
if (word == "business"){
  tracker = 6;
};
  request(tracker, 1);
  cssmod();
};

//Initiate the page

$(document).ready(function () {

starter = window.location.href.split("=");

match(starter[1])

reload();
cssmod();

});

//Reload every 10 minutes
setInterval(function(){
	reload();
}, 60000);

//Reload function regenerates the cache every 10 minutes

function reload() {
  for (var i=0;i<categories.length;i++) {
    request(i, 0);
  };
};

//CSS mods based on section


function cssmod() {
if (tracker == 0){
  $(".format").width("116px");
  $("#holder").width("1560px");  
  $("#nav").css("background-color", "#e74c3c");
//This to change the url to match the current section
  window.location.replace("index.php#current=news");
};
if (tracker == 1){
  $(".format").width("250px");
  $("#holder").width("1160px");  
  $("#nav").css("background-color", "#f39c12");

  window.location.replace("index.php#current=sports");
};
if (tracker == 2){
  $(".format").width("116px");
  $("#holder").width("1560px");  
  $("#nav").css("background-color", "#F1C319");

  window.location.replace("index.php#current=tech");
};
if (tracker == 3){
  $(".format").width("200px");
  $("#holder").width("1440px");  
  $("#nav").css("background-color", "#2ecc71");

  window.location.replace("index.php#current=life");
};
if (tracker == 4){
  $(".format").width("250px");
  $("#holder").width("1160px");  
  $("#nav").css("background-color", "#3498db");

  window.location.replace("index.php#current=music");
};
if (tracker == 5){
  $(".format").width("250px");
  $("#holder").width("1160px");  
  $("#nav").css("background-color", "#34495e");

  window.location.replace("index.php#current=religion");
};
if (tracker == 6){
  $(".format").width("180px");
  $("#holder").width("1540px");  
  $("#nav").css("background-color", "#8e44ad");

  window.location.replace("index.php#current=business");
};
};

</script>
</body>
</html>
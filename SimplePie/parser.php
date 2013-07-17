<?php

if (isset($_POST["feed"]) && !empty($_POST["feed"])) { 
    $selector = json_decode($_POST["feed"], true);  
 
include_once('autoloader.php');
include_once('idn/idna_convert.class.php');
 

foreach ($selector as $label => $url) {
    $selector[$label] = new SimplePie();
    $selector[$label]->set_feed_url($url);
    $selector[$label]->strip_htmltags(array('img', 'embed','marquee','strong', 'div', 'b', 'i'));
    $selector[$label]->init();
    $selector[$label]->handle_content_type();
    $selector[$label]->enable_cache(true);
    $selector[$label]->set_cache_location($_SERVER['DOCUMENT_ROOT'] . '/cache/' . $label);
    $selector[$label]->set_cache_duration(6000);
    
}

}
else{

    echo "Please check that the feed has been set";
}
?><!DOCTYPE html>
<html>
<body>

<?php

foreach ($selector as $label => $url):
?>
<div class="format">
    <h1><?php echo $label; ?></h1>
    <?php
    /*
    Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
    */
    foreach ($selector[$label]->get_items(0,10) as $item):
    ?>
    <div class="item">
    <?php //Limits Titles to 10 words
        $build = $item->get_title();
        $area = explode(" ", $build);
        $result = count($area);
        if ($result > 10) {
            $build = implode(" ", array_slice($area, 0, 9 )).'...';
            $title = $build;
        }
        else {
            $title = $item->get_title();
        }
    ?>
    <!--this feed contains links from google news which need to be decoded-->
    <h2><a href="<?php echo urldecode($item->get_permalink()); ?>" title="<?php echo $item->get_title();?>">
    <?php echo $title;?>
    </a></h2>
            <!--<p><?php echo $item->get_description(); ?></p>-->
            <p><small>Posted on 
                <?php 
                if ($item->get_date('F j Y | g:i a') == null) {
                    echo "Hackers News";
                }
                else {
                    echo $item->get_date('F j Y | g:i a');
                }
                 ?></small></p>
        </div>
 
    <?php endforeach; ?>
</div>
<?php endforeach; ?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <?php
    $movie = $_GET["film"];
    $info = file("$movie/info.txt");
    if($info[2] < 60){$img = "https://webster.cs.washington.edu/images/rottenlarge.png"; 
    }else{$img = "https://webster.cs.washington.edu/images/freshlarge.png";}
    $reviews = array();
    $files = scandir("./$movie/");

    foreach ($files as $file) {
        if (strpos($file, "review") !== False){
            $reviews[] = $file;
        }
    }
    $count = count($reviews);
    ?>
    <title>Rancid Tomatoes - <?=$info[0]?></title>

    <meta charset="utf-8"/>
    <link href="movie.css" type="text/css" rel="stylesheet"/>
</head>

<body id="bgimg">
<div id="banner">
    <img src="https://webster.cs.washington.edu/images/rancidbanner.png" alt="Rancid Tomatoes" class="bannerimg"/>
</div>
<div id="banner2">
    <img src="https://webster.cs.washington.edu/images/rancidbanner.png" alt="Rancid Tomatoes" class="bannerimg"/>
</div>
<h1><?=$info[0] ?><?="($info[1])" ?></h1>
<div id="maincontent">
    <div id="reviewtop">
    <img src=<?=$img?> alt="picture" class="mainicon"/>
    <div class="percent"><?=$info[2]."%"?></div>
    </div>
    <img id="overviewimage" src=<?="$movie/overview.png"?> alt="general overview"/>
    <div id="overview">
    <dl>
        <?php 
        $overview = file("$movie/overview.txt");
        foreach ($overview as $element) {
            $element = explode(":", $element);
            ?>
             <dt><?=array_shift($element)?></dt><dd><?php foreach ($element as $el) {
            print($el);
             }?></dd>
            
       <?php } ?>
    </div>

    <div id="reviews">
        <div class="reviewcolumn">
        <?php 
        for($i = 0; $i <= $count/2; $i++){
            $rev = file("$movie/{$reviews[$i]}"); 
            $pub = array_pop($rev);
            $auth = array_pop($rev);
            $q = trim(strtolower(array_pop($rev))).'.gif';
            ?>
            <div class="fullrev">
            <p class="arev">
            <img src=<?="https://webster.cs.washington.edu/images/$q"?> alt=<?=$q?> class="icons"/>
            <?=implode($rev);?>
            </p>
            <p>
                <img src="https://webster.cs.washington.edu/images/critic.gif" alt="Critic" class="icons"/>
                 <?=$auth?><br/>
                    <em><?=$pub?></em>
            </p>
         </div>
        <?php } ?>
        </div>
        <div class="reviewcolumn">
            <?php 
        for($i = ($count/2)+1; $i < $count; $i++){
            $rev = file("$movie/{$reviews[$i]}"); 
            $pub = array_pop($rev);
            $auth = array_pop($rev);
            $q = trim(strtolower(array_pop($rev))).'.gif';
            ?>
            <div class="fullrev">
            <p class="arev">
            <img src=<?="https://webster.cs.washington.edu/images/$q"?> alt=<?=$q?> class="icons"/>
            <?=implode($rev);?>
            </p>
            <p>
                <img src="https://webster.cs.washington.edu/images/critic.gif" alt="Critic" class="icons"/>
                 <?=$auth?><br/>
                    <em><?=$pub?></em>
            </p>
         </div>
        <?php } ?>
        </div>
    </div>

    <div id="bottompart">
        (1-<?=count($reviews)?>) of <?=count($reviews)?>
    </div>
    <div id="reviewbot">

    <div class="blok"></div>
        <img src=<?=$img?> alt="picture" class="mainicon"/>
        <div class="percent"><?=$info[2]."%"?></div>

    </div>


    
</div>
<div id="w3cicons">
    <a href="https://webster.cs.washington.edu/validate-html.php"><img
            src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5"/></a><br/>
    <a href="https://webster.cs.washington.edu/validate-css.php"><img
            src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS"/></a>
</div>
</body>
</html>

<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

use app\services\ScoreService;

include VIEWS."header.php";
include VIEWS."navbar.php";
?>

<div class="container">

    <h1>Global High Scores</h1>
    <p style="color: white; text-align: center">Top 50 High Scores</p>

    <?php

    $scores = ScoreService::getScores();

    foreach ($scores as $score){
            echo '<p style="color: white; text-align: center"><strong>'.$score["score"]."</strong> by  ".$score["username"]." on ".date("d F Y H:i:s",$score["date"]).'</p>';
    }
    ?>
</div>

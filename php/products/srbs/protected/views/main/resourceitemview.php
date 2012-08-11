<div id="player_area">

    <div id="player_close">

        <div class="pict_player"><img src="img/pict_player.jpg" alt="pict_player"></div>
        
        <div class="middle_player">
            <div class="title_player"><b><?php echo $data->name; ?></b></div>
            
            <?php
            
            $author = $data->getPropertyByName('author-name');
            if (isset($author))
                echo "<div class=\"text_player\"><i>$author->value</i></div>";
            
            ?>
            
            
            <div class="main_player"><img class="volume" src="img/volume.gif" alt="volume"><img class="play" src="img/play.gif" alt="play"></div>
        </div>

        <div class="variable_more"><a href="/">more...</a></div>
        <div class="line_player"><img src="img/line_player.gif" alt="line_player"></div>
    </div>

</div>
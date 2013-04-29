<?php $this->load->view('header'); ?>

        <div class="container">

            <!-- Example row of columns -->
        	<?php
            $i = 0; $flag = 0;
            foreach ($movies as $movie):
                $flag = 0; $i++;
            ?>
            <?php if ($i == 1) { ?><div class="row"><?php } ?>
                <div class="span4">
                    <h2 class="text-center"><?=$movie['movieTitle']?></h2>
                    <p class="text-center"><img class="poster" src="/static/img/posters/<?=file_exists(getcwd().'/static/img/posters/'.$movie['imdbID'].'.jpg')?$movie['imdbID'].'.jpg':'no-poster.png'?>"></p>
                    <p><?=$movie['moviePlot']?></p>
                    <p><a class="btn" href="/movies/view/<?=$movie['imdbID']?>">View details &raquo;</a></p>
                </div>
            <?php
            if ($i == 3) { ?></div><?php $i = 0; $flag = 1; }
            endforeach;
            if ($flag == 0) { ?></div><?php } ?>

            <hr>

            <footer>
                <p>&copy; WATCH YOUTUBE MOVIES 2012</p>
            </footer>

        </div> <!-- /container -->

<?php $this->load->view('footer'); ?>
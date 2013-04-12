<?php $this->load->view('header'); ?>

        <div class="container">

            <!-- Example row of columns -->
            <div class="row">
                <?php if(isset($notif)): ?>
                <div class="span12 alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Thank you!</strong> We will look at your report as soon as possible.
                </div>
                <?php endif; ?>
            	<div class="span4">
                    <p><img class="big-poster" src="/static/img/posters/<?=file_exists(getcwd().'/static/img/posters/'.$movie[0]['imdbID'].'.jpg')?$movie[0]['imdbID'].'.jpg':'no-poster.png'?>"></p>
                </div>
                <div class="span4">
                    <h2><?=$movie[0]['movieTitle']?></h2>
                    <p><?=$movie[0]['moviePlot']?></p>
                    <p>Rating: <?=$movie[0]['imdbRating']?> (<?=$movie[0]['imdbVotes']?> votes)</p>
                    <p>Year: <?=$movie[0]['movieYear']?></p>
                    <p>Rated: <?=$movie[0]['movieRated']?></p>
                    <p>Released: <?=$movie[0]['movieReleased']?></p>
                    <p>Runtime: <?=$movie[0]['movieRuntime']?></p>
                    <p>Genre: 
                    <?php
                        $tok = strtok($movie[0]['movieGenre'], " ,");
                        while ($tok !== false) {
                            echo '<a href="/movies/browse/genre/'.$tok.'">'.$tok.'</a>';
                            $tok = strtok(" ,");
                            if ($tok !== false) echo ", ";
                        }
                    ?>
                    </p>
                    <p>Director: <?=$movie[0]['movieDirector']?></p>
                    <p>Writer: <?=$movie[0]['movieWriter']?></p>
                    <p>Actors: <?=$movie[0]['movieActors']?></p>
                    <p><a href="http://www.imdb.com/title/<?=$movie[0]['imdbID']?>/">IMDB page</a></p>
                </div>
                <div class="span4">
	                <h3>Youtube Links</h3>
					<?php for ($x=1;$x<=count($movie);$x++): ?>
                    <p><a href="#watchlink<?=$x?>" data-toggle="modal" data-backdrop="static" data-keyboard="false">Watch link #<?=$x?></a></p>
                    <?php endfor; ?>
                </div>
            </div>

            <hr>

            <footer>
                <p>&copy; WATCH YOUTUBE MOVIES 2012</p>
            </footer>

        </div> <!-- /container -->

        <?php
        //Youtube modals
        $x = 1;
        foreach ($movie as $link):
        ?>
        <div id="watchlink<?=$x++?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="watchlink<?=$x?>Label" aria-hidden="true">
            <div class="modal-header">
                <span class="label label-info">Now watching</span>
                <h3 id="watchlink<?=$x?>Label"><?=$movie[0]['movieTitle']?></h3>
            </div>
            <div class="modal-body">
                <p><object width="560" height="315"><param name="movie" value="https://www.youtube-nocookie.com/v/<?=$link['youtubeId']?>?hl=en_US&amp;version=3&amp;rel=0&amp;showinfo=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="https://www.youtube-nocookie.com/v/<?=$link['youtubeId']?>?hl=en_US&amp;version=3&amp;rel=0&amp;showinfo=0" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed></object></p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger" href="/movies/report/<?=$link['youtubeId']?>">Report</a>
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <?php endforeach; ?>

<?php $this->load->view('footer'); ?>
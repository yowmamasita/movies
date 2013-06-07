<?php $this->load->view('header'); ?>

        <div class="container">

            <!-- Example row of columns -->
            <div class="row">
            	<div class="span12">
                    <h2>All movies arranged by <?=$params?></h2>
            	<?php
            	$before = '';
                if ($params == 'rating' || $params == 'unrated') { $ratings = range(0, 9); }
            	foreach ($movies as $movie):
            		//check if unique
            		if ($movie['imdbID'] == $before)
            		{
            			continue;
            		}
            		$before = $movie['imdbID'];
                    if ($params == 'rating' || $params == 'unrated')
                    {
                        $rating = (int)$movie['imdbRating'];
                        if (($loc = array_search($rating, $ratings)) !== false)
                        {
                            unset($ratings[$loc]);
                            echo "<p><strong>Rating:</strong> $rating+</p>";
                        }
                    }
            	?>
                    <p><a href="/movies/view/<?=$movie['imdbID']?>"><?=$movie['movieTitle']?></a> (<?=$movie['movieYear']?>)</p>
                <?php endforeach; ?>
                </div>
            </div>

            <hr>

            <footer>
                <p>&copy; WATCH YOUTUBE MOVIES 2012</p>
            </footer>

        </div> <!-- /container -->

<?php $this->load->view('footer'); ?>

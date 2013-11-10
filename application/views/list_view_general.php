<?php $this->load->view('header'); ?>

        <div class="container">

            <!-- Example row of columns -->
            <div class="row">
            	<div class="span12">
                    <h2><?=ucfirst($type)?> movies arranged by <?=$params?></h2>
                    <?php
                    $red = '/browse/';
                    if ($url[0] == 'all')
                    {
                        $red .= $url[0].'/';
                    }
                    else
                    {
                        $red .= $url[0].'/'.$url[1].'/';                        
                    }
                    ?>
                    <p class="well text-center"><strong>Sort:</strong> <a href="<?=$red?>atoz">Alphabetically</a>, <a href="<?=$red?>rating">by Rating</a>, <a href="<?=$red?>year">by Year</a>, <a href="<?=$red?>popularity">by Popularity</a>, <a href="<?=$red?>unrated">Unrated</a></p>
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
                    <p><a href="/_<?=substr($movie['imdbID'], 2)?>/<?=preg_replace('/[^A-Za-z0-9\- ]/', '', str_replace(' ','-',$movie['movieTitle']))?>"><?=$movie['movieTitle']?></a> (<?=$movie['movieYear']?>)</p>
                <?php endforeach; ?>
                </div>
            </div>

            <hr>

            <footer>
                <p>&copy; WATCH YOUTUBE MOVIES 2012</p>
            </footer>

        </div> <!-- /container -->

<?php $this->load->view('footer'); ?>

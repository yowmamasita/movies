<?php $this->load->view('header'); ?>

        <div class="container">

            <!-- Example row of columns -->
            <div class="row">
            	<div class="span12">
                    <h2>List of <?=ucfirst($type)?> <?=isset($params)?"'".$params."' ":''?>movies</h2>
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
            		<p class="well text-center">
		        		<?php
		        		foreach (range('A', 'Y') as $char) echo '<a href="#'.$char.'">'.$char.'</a> - ';
		        		?>
		        		<a href="#Z">Z</a>
            		</p>
            	</div>
            	<div class="span12">
            	<?php
            	$before = '';
            	$anchors = range('A', 'Z');
            	foreach ($movies as $movie):
            		//check if unique
            		if ($movie['imdbID'] == $before)
            		{
            			continue;
            		}
            		$before = $movie['imdbID'];
            		//check if first
            		$first = 0;
            		if (($loc = array_search(substr($movie['movieTitle'], 0, 1), $anchors)) !== false)
            		{
            			unset($anchors[$loc]);
            			$first = 1;
            		}
            	?>
                    <p><a <?=$first?'name="'.substr($movie['movieTitle'], 0, 1).'" ':''?>href="/_<?=substr($movie['imdbID'], 2)?>/<?=preg_replace('/[^A-Za-z0-9\- ]/', '', str_replace(' ','-',$movie['movieTitle']))?>"><?=$movie['movieTitle']?></a> (<?=$movie['movieYear']?>)</p>
                <?php endforeach; ?>
                </div>
            </div>

            <hr>

            <footer>
                <p>&copy; WATCH YOUTUBE MOVIES 2012</p>
            </footer>

        </div> <!-- /container -->

<?php $this->load->view('footer'); ?>
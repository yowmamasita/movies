<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>WATCH YOUTUBE MOVIES - <?=$movie[0]['movieTitle']?></title>
        <meta name="description" content="watch full movies on youtube this site only serves as a directory">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="/static/css/bootstrap.css">
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="/static/css/bootstrap-responsive.css">
        <link rel="stylesheet" href="/static/css/main.css">

        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="/static/js/html5shiv.js"><\/script>')</script>
        <![endif]-->
    </head>
    <body>

        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="/">WATCH YOUTUBE MOVIES</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="/welcome/browse">Browse</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#contact">Contact</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Nav header</li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">

            <!-- Example row of columns -->
            <div class="row">
            	<div class="span4">
                    <p><img class="big-poster" src="<?=$movie[0]['moviePoster']?>"></p>
                </div>
                <div class="span4">
                    <h2><?=$movie[0]['movieTitle']?></h2>
                    <p><?=$movie[0]['moviePlot']?></p>
                    <p>Rating: <?=$movie[0]['imdbRating']?></p>
                    <p>Year: <?=$movie[0]['movieYear']?></p>
                    <p>Rated: <?=$movie[0]['movieRated']?></p>
                    <p>Released: <?=$movie[0]['movieReleased']?></p>
                    <p>Runtime: <?=$movie[0]['movieRuntime']?></p>
                    <p>Genre: <?=$movie[0]['movieGenre']?></p>
                    <p>Director: <?=$movie[0]['movieDirector']?></p>
                    <p>Writer: <?=$movie[0]['movieWriter']?></p>
                    <p>Actors: <?=$movie[0]['movieActors']?></p>
                    <p><a href="http://www.imdb.com/title/<?=$movie[0]['imdbID']?>/">IMDB page</a></p>
                </div>
                <div class="span4">
	                <h3>Youtube Links</h3>
					<?php
					$x = 1;
					foreach ($movie as $link):
					?>
                    <p><a href="<?=$link['youtubeUrl']?>">Watch link #<?=$x++?></a></p>
                    <?php endforeach; ?>
                </div>
            </div>

            <hr>

            <footer>
                <p>&copy; WATCH YOUTUBE MOVIES 2012</p>
            </footer>

        </div> <!-- /container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script>window.jQuery || document.write('<script src="/static/js/vendor/jquery-1.9.1.js"><\/script>')</script>

        <script src="/static/js/bootstrap.js"></script>

        <script src="/static/js/main.js"></script>

        <!--<script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>-->
    </body>
</html>

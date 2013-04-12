<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>WATCH YOUTUBE MOVIES - Report a movie</title>
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
                            <li><a href="/movies/browse">Browse</a></li>
                            <li><a href="/misc/about">About</a></li>
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
            	<div class="span12">
                    <?php if(isset($notif)): ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Nope!</strong> Try again.
                    </div>
                    <?php endif; ?>
            		<h2><?=$movie[0]['movieTitle']?></h2>
                    <p>Subject: <?=$movie[0]['youtubeId']?></p>
                    <p><img src="http://img.youtube.com/vi/<?=$movie[0]['youtubeId']?>/1.jpg">&nbsp;<img src="http://img.youtube.com/vi/<?=$movie[0]['youtubeId']?>/2.jpg">&nbsp;<img src="http://img.youtube.com/vi/<?=$movie[0]['youtubeId']?>/3.jpg"></p>
                    <form method="POST">
                    <p>
                        <label class="radio">
                            <input type="radio" name="reportReason" id="reportReason1" value="diff_movie" checked>
                            This video is for a different movie
                        </label>
                        <label class="radio">
                            <input type="radio" name="reportReason" id="reportReason2" value="dead">
                            This video is dead (or not working)
                        </label>
                        <label class="radio">
                            <input type="radio" name="reportReason" id="reportReason2" value="incomplete">
                            This video is incomplete
                        </label>
                    </p>
                    <p><button class="btn btn-danger" type="submit">Submit report</button></p>
                    <p>For other reasons, please use the Contact form</p>
                    </form>
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

<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>WATCH YOUTUBE MOVIES<?=isset($title)?" - ".$title:""?></title>
        <meta name="description" content="Watch full movies on Youtube for free!">
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
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-45576489-1', 'movie.jp');
          ga('send', 'pageview');

        </script>

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
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Browse <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/browse/all/atoz">Alphabetical</a></li>
                                    <li><a href="/browse/all/popularity">Popularity</a></li>
                                    <li><a href="/browse/all/rating">Rating</a></li>
                                    <li><a href="/browse/all/year">Year</a></li>
                                    <li><a href="/browse/genre">Genre</a></li>
                                    <li><a href="/browse/all/unrated">Unrated</a></li>
                                </ul>
                            </li>
                            <li><a href="/search">Search</a></li>
                            <li><a href="/about">About</a></li>
                            <!--<li><a href="/misc/contact">Contact</a></li>-->
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

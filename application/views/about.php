<?php $this->load->view('header'); ?>

        <div class="container">

            <!-- Example row of columns -->
            <div class="row">
                <div class="span12">
                    <h2>About Us</h2>
                    <p>Something something freedom something</p>
                    <p>PHP (front-end) --> MongoDB <-- Python (back-end)</p>
                    <p>Movie count: <?=$count?></p>
                    <p>Crawler: <?=$d_running?'<span class="label label-success">Running</span>':'<span class="label label-important">Stopped</span>'?></p>
                </div>
            </div>

            <hr>

            <footer>
                <p>&copy; WATCH YOUTUBE MOVIES 2012</p>
            </footer>

        </div> <!-- /container -->

<?php $this->load->view('footer'); ?>
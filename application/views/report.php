<?php $this->load->view('header'); ?>

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

<?php $this->load->view('footer'); ?>
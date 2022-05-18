<?php
    function display_error($title, $msg, $content, $retry) {
        echo
            "<section class=\"parallax parallax-bg\">\n
				<h1>Whoops! An error has occured!</h1>\n
			</section>\n
			<section class=\"no-parallax\">\n
				<h3>$title: $msg.</h3>\n
                <p>$content. Please go back and <a href=\"$retry\">retry.</a></p>\n
			</section>\n
        ";
    }
?>
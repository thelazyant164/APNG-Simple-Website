<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta name="description" content="APNG markquiz"/>
		<meta name="keywords" content="APNG, animated portable network graphics, markquiz"/>
		<meta name="author" content="Aly"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>APNG markquiz</title>
		<link href="styles/style.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Google+Sans" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
	<body>
		<input type="checkbox" id="toggleMode">
		<?php
            require("header.inc");
            createHeader();
        ?>
		<main id="parallax-container">
			<section class="parallax parallax-bg">
				<h1>Quiz results</h1>
			</section>
			<section class="no-parallax">
				<h2>How well did you do?</h2>
			</section>
			<section class="parallax parallax-bg">
				<h2>Grades</h2>
			</section>
			<section class="no-parallax">
				<?php
                    require("submission.php");
                    submit();
					require("display.php");
					display_total_grade();
				?>
			</section>
			<section class="parallax parallax-bg">
				<h2>Detailed assessment</h2>
			</section>
			<section class="no-parallax">
				<?php
                    display_grades();
                ?>
			</section>
            <?php
                display_answers($attempt_no);
            ?>
		</main>
        <?php
            require("footer.inc");
            createFooter();
        ?>
	</body>
</html>
<!DOCTYPE html>
<html lang="en">
	<!-- Grade student's quiz attempt and display result -->
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
			if (!isset($_POST)) {
				header('location: quiz.php');
				exit('Direct URL access detected. Script execution terminated.');
			}
            include("header.inc");
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
                    require("modules/submission.php");
                    $submission = submit();
					require("modules/display.php");
					display_total_grade($submission);
				?>
			</section>
			<section class="parallax parallax-bg">
				<h2>Detailed assessment</h2>
			</section>
			<section class="no-parallax">
				<?php
                    display_grades($submission);
					display_retry_prompt($submission);
                ?>
			</section>
            <?php
                display_answers($submission);
            ?>
		</main>
        <?php
            include("footer.inc");
        ?>
	</body>
</html>
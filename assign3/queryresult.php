<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta name="description" content="query results"/>
		<meta name="keywords" content="admin, query, results"/>
		<meta name="author" content="Aly"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>APNG query results</title>
		<link href="styles/style.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Google+Sans" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>

	<body>
		<input type="checkbox" id="toggleMode">
		<?php
            include("header.inc");
            createHeader();
        ?>
		<main id="parallax-container">
			<section class="parallax parallax-bg">
				<h1>Query results</h1>
			</section>
			<section class="no-parallax">
				<h2>Here is the result you requested, admin!</h2>
			</section>
			<section class="parallax parallax-bg">
				<h2>Results found</h2>
			</section>
			<section class="no-parallax">
				<h3>Query returned:</h3>
				<?php
					require("adminquery.php");
					admin_query();
				?>
			</section>
			<section class="parallax parallax-bg">
				<h2>Assessments</h2>
			</section>
			<section class="no-parallax">
				<h3>How did user abcxyz do?</h3>
				<p>
					User abcxyz performed poorly...
				</p>
				<h3>Overall ranking</h3>
				<ol>
					<li>Overall: 2/5</li>
					<li>For Question 1: 3/5</li>
					<li>For Question 2: 1/5</li>
					<li>For Question 3: 2/5</li>
					<li>For Question 4: 5/5</li>
					<li>For Question 5: 0/5</li>
				</ol>
			</section>
			<section class="parallax parallax-bg">
				<h2>Statistics</h2>
			</section>
			<section class="no-parallax">
                <?php
					require('adminstatistics.php');
					assess_all();
                    ?>
            <p>
                <?php
                echo '<img src="all_attempt_scores.php" alt="Line graph of both">';
                
                echo '<img src="perquestionscore.php" alt="Per question score">';
                

                ?>
            </p>
			</section>
		</main>
        <?php
            include("footer.inc");
            createFooter();
        ?>
	</body>
</html>
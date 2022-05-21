<!DOCTYPE html>
<html lang="en">
	<!-- Returns admin's query results -->
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
			if (!isset($_POST)) {
				header('location: manage.php');
				exit('Direct URL access detected. Script execution terminated.');
			}
            include("header.inc");
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
					require("modules/adminquery.php");
				?>
			</section>
			<section class="parallax parallax-bg">
				<h2>Statistics</h2>
			</section>
			<section class="no-parallax">
				<h3>Highlights & trends</h3>
                <?php
					require('statistics/admin/adminstatistics.php');
                ?>
			</section>
		</main>
        <?php
            include("footer.inc");
        ?>
	</body>
</html>
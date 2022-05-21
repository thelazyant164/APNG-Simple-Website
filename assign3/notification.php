<!DOCTYPE html>
<html lang="en">
	<!-- Error page -->
	<head>
		<meta charset="utf-8"/>
		<meta name="description" content="error message"/>
		<meta name="keywords" content="error, notification, message, rejection"/>
		<meta name="author" content="Aly"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Notification</title>
		<link href="styles/style.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Google+Sans" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>

	<body>
		<input type="checkbox" id="toggleMode">
		<?php
            include("header.inc");
        ?>
		<main id="parallax-container">
			<?php
				if (!isset($_SESSION['error'])) {
					header('location: index.php');
					exit('Direct URL access detected. Script execution terminated.');
				}
                require("modules/errorhandling.php");
                display_error($_SESSION["error"]["title"], $_SESSION["error"]["msg"], $_SESSION["error"]["content"], $_SESSION["error"]["retry"]);
            ?>
		</main>
        <?php
            include("footer.inc");
        ?>
	</body>
</html>
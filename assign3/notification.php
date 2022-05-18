<!DOCTYPE html>
<html lang="en">
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
            createHeader();
        ?>
		<main id="parallax-container">
			<?php
                require("lib/errorhandling.php");
                display_error($_SESSION["error"]["title"], $_SESSION["error"]["msg"], $_SESSION["error"]["content"], $_SESSION["error"]["retry"]);
                unset($_SESSION["error"]);
            ?>
		</main>
        <?php
            include("footer.inc");
            createFooter();
        ?>
	</body>
</html>
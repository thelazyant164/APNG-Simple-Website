<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
		<meta name="description" content="APNG homepage"/>
		<meta name="keywords" content="APNG, animated portable network graphics, homepage"/>
		<meta name="author" content="Jack"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="styles/style.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Google+Sans" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <title>APNG Homepage</title>
    </head>
    <body>
        <input type="checkbox" id="toggleMode">
        <?php
            require("header.inc");
            createHeader();
        ?>
        <main id="bg-container">
            <h1 id="title">Animated Portable Network Graphics</h1>
            <p id="subtitle">
                Animated Portable Network Graphics or .APNG for short
                is a file format which originates from Portable Network Graphics (.PNG) 
                but allows animated images that work similarly to animated .GIF files.
                By exploring this website you learn more about the .APNG file type and how 
                it's used. 
            </p>
            <a href="topic.php" id="learn-more" target="_blank">Learn more</a>
        </main>
        <?php
            require("footer.inc");
            createFooter();
        ?>
    </body>
</html>
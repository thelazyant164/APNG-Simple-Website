<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta name="description" content="APNG login"/>
		<meta name="keywords" content="APNG, animated portable network graphics, login"/>
		<meta name="author" content="Aly"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>APNG login</title>
		<link href="styles/style.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Google+Sans" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
	
	<body>
		<!--Hidden dark mode toggler-->
		<input type="checkbox" id="toggleMode">
		<?php
            include("header.inc");
            createHeader();
        ?>
		
		<main id="container">

			<form action="authentication.php" method="POST" novalidate="novalidate">

				<h1 id="title">Management login</h1>
				<h2 id="subtitle">In order to query database, your identity needs to be verified.</h2>

                <!-- Radio choice: which query admin would like to make -->
                <div class="bubble" id="bubble1">
                    <fieldset class="grow">
                        <legend>Administrator credentials</legend>
                        <div class="question">
                            <div class="content">
								<div>
									<label for="username">Username:</label>
									<input type="text" id="username" name="username" placeholder="Username..." pattern="^[\w\d\-_]{10,30}$" required="required" >
								</div>    
								<div>
									<label for="password">Password:</label>
									<input type="text" id="password" name="password" placeholder="Password..." pattern="^.{10,30}$" required="required" >
								</div>
                            </div>
                        </div>
                    </fieldset>
                </div>

				<!-- Login button -->
				<div class="bubble" id="submit-bubble-shorter">
					<div class="not-grow">
						<div class="content">
							<label for="login">Login</label>
							<input type="submit" id="login" value="Login"/>
						</div>
					</div>
				</div>
			</form>
		</main>

		<!-- Footer -->
		<?php
            include("footer.inc");
            createFooter();
        ?>
	</body>
</html>
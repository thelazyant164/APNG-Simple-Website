<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta name="description" content="APNG manage"/>
		<meta name="keywords" content="APNG, animated portable network graphics, manage"/>
		<meta name="author" content="Aly"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>APNG manage</title>
		<link href="styles/style.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Google+Sans" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
	
	<body>
		<!--Hidden dark mode toggler-->
		<input type="checkbox" id="toggleMode">
		<?php
			require("header.inc");
			createHeader();
			#Safeguard against direct php access through URL
			if (!$_SESSION["login"]) {
				header("location: login.php");
				exit("Direct access through URL detected. Script execution aborted.");
			}
        ?>
		
		<main id="container">

			<form action="queryresult.php" method="POST" novalidate="novalidate">

				<h1 id="title">Management</h1>
				<h2 id="subtitle">Welcome back,
				<?php
					echo $_SESSION['username'];
				?>
				!</h2>

                <!-- Radio choice: which query admin would like to make -->
                <div class="bubble" id="bubble1">
                    <fieldset class="grow">
                        <legend>What would you like to do today?</legend>
                        <div class="question">
                            <div class="content">
                                <div class="multiple-choice">
                                    <input type="radio" id="list_all" name="request" value="list_all" required="required">
                                    <label for="list_all">List all attempts</label>
                                </div>
                                <div class="multiple-choice">
                                    <input type="radio" id="list_specific" name="request" value="list_specific">
                                    <label for="list_specific">List all attempts for a particular student (using student ID or name)</label>
                                </div>
                                <div class="multiple-choice">
                                    <input type="radio" id="list_full" name="request" value="list_full">
                                    <label for="list_full">List all first 100% attempts</label>
                                </div>
                                <div class="multiple-choice">
                                    <input type="radio" id="list_half" name="request" value="list_half">
                                    <label for="list_half">List all second &lt;50% attempts</label>
                                </div>
                                <div class="multiple-choice">
                                    <input type="radio" id="delete_attempts" name="request" value="delete_attempts">
                                    <label for="delete_attempts">Delete all attempts for a particular student (using student ID)</label>
                                </div>
                                <div class="multiple-choice">
                                    <input type="radio" id="update_score" name="request" value="update_score">
                                    <label for="update_score">Change score for an attempt (using student ID and attempt number)</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

				<!-- Query form -->
				<div class="bubble" id="bubble2">
					<fieldset class="grow">
						<legend>Find student</legend>
						<div class="question">
							<div class="content">
								<div>
									<label for="first_name">First name:</label>
									<input type="text" id="first_name" name="first_name" placeholder="First name..." pattern="^[a-zA-Z\s-]{1,30}$">
								</div>    
								<div>
									<label for="last_name">Last name:</label>
									<input type="text" id="last_name" name="last_name" placeholder="Last name..." pattern="^[a-zA-Z\s-]{1,30}$">
								</div>    
								<div>
									<label for="student_id">Student ID:</label>
									<input type="text" id="student_id" name="student_id" placeholder="Student ID..." pattern="^\d{7}|\d{10}$">        
								</div>
                                <div>
									<label for="attempt_no">Attempt:</label>
									<input type="text" id="attempt_no" name="attempt_no" placeholder="1/2 ..." pattern="^[12]$">
								</div>
								<div>
									<label for="score">New score:</label>
									<input type="text" id="score" name="score" placeholder="50 ..." pattern="^\d{1,3}$">
								</div>
							</div>
						</div>        
					</fieldset>
				</div>    

				<!-- Execute button -->
				<div class="bubble" id="submit-bubble-short">
					<div class="not-grow">
						<div class="content">
							<label for="execute">Execute</label>
							<input type="submit" id="execute" value="Execute"/>
						</div>
					</div>
				</div>
			</form>
		</main>

		<!-- Footer -->
		<?php
            require("footer.inc");
            createFooter();
        ?>
	</body>
</html>
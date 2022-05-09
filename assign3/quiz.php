<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta name="description" content="APNG quiz"/>
		<meta name="keywords" content="APNG, animated portable network graphics, quiz"/>
		<meta name="author" content="Aly"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>APNG quiz</title>
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
        ?>
		
		<main id="container">

			<form action="markquiz.php" method="POST" novalidate="novalidate">

				<h1 id="title">Quiz time!</h1>
				<h2 id="subtitle">Test your knowledge by filling out these reinforcement questions!</h2>

				<!-- Info -->
				<div class="bubble" id="info">
					<fieldset class="grow">
						<legend>Info</legend>
						<div class="question">
							<div class="content">
								<div>
									<label for="first_name">First name:</label>
									<input type="text" id="first_name" name="first_name" placeholder="First name..." required="required" pattern="^[a-zA-Z\s-]{1,30}$">
								</div>
								<div>
									<label for="last_name">Last name:</label>
									<input type="text" id="last_name" name="last_name" placeholder="Last name..." required="required" pattern="^[a-zA-Z\s-]{1,30}$">
								</div>
								<div>
									<label for="student_id">Student ID:</label>
									<input type="text" id="student_id" name="student_id" placeholder="Student ID..." required="required" pattern="^\d{7}|\d{10}$">
								</div>
							</div>
						</div>
					</fieldset>
				</div>

				<!-- Text input question -->
				<div class="bubble" id="bubble1">
					<fieldset class="grow">
						<legend>Question 1: Support for what sets APNG apart from GIF?</legend>
						<div class="question">
							<div class="content">
								<div>
									<label for="question1">Answer:</label>
									<input type="text" id="question1" name="support_for" placeholder="Your answer..." pattern="^[\w\s\d]{2,50}$" required="required">
								</div>
							</div>
						</div>
					</fieldset>
				</div>

				<!-- Radio choice question -->
				<div class="bubble" id="bubble2">
					<fieldset class="grow">
						<legend>Question 2: When was APNG first developed?</legend>
						<div class="question">
							<div class="content">
								<div class="multiple-choice">
									<input type="radio" id="first_choice" name="year_developed" value="2002" required="required">
									<label for="first_choice">2002</label>
								</div>
								<div class="multiple-choice">
									<input type="radio" id="second_choice" name="year_developed" value="2003">
									<label for="second_choice">2003</label>
								</div>
								<div class="multiple-choice">
									<input type="radio" id="third_choice" name="year_developed" value="2004">
									<label for="third_choice">2004</label>
								</div>
								<div class="multiple-choice">
									<input type="radio" id="fourth_choice" name="year_developed" value="2005">
									<label for="fourth_choice">2005</label>
								</div>
							</div>
						</div>
					</fieldset>
				</div>

				<!-- Checkbox question -->
				<div class="bubble" id="bubble3">
					<fieldset class="grow">
						<legend>Question 3: Tick all browsers whose current version supports APNG?</legend>
						<div class="question">
							<div class="content">
								<div class="multiple-choice">
									<input type="checkbox" id="first_option" name="browser_support[]" value="Chrome">
									<label for="first_option">Chrome</label>
								</div>
								<div class="multiple-choice">
									<input type="checkbox" id="second_option" name="browser_support[]" value="Edge">
									<label for="second_option">Edge</label>
								</div>
								<div class="multiple-choice">
									<input type="checkbox" id="third_option" name="browser_support[]" value="Opera">
									<label for="third_option">Opera</label>
								</div>
								<div class="multiple-choice">
									<input type="checkbox" id="fourth_option" name="browser_support[]" value="Internet Explorer">
									<label for="fourth_option">Internet Explorer</label>
								</div>
							</div>
						</div>
					</fieldset>
				</div>

				<!-- Drop-down question -->
				<div class="bubble" id="bubble4">
					<fieldset class="grow">
						<legend>Question 4: Who developed APNG?</legend>
						<div class="question">
							<div class="content">
								<div>
									<label for="question4">Answer:</label>
									<select id="question4" name="developer">
										<option value="Microsoft">Microsoft</option>
										<option value="Google">Google</option>
										<option value="Apple">Apple</option>
										<option value="Mozilla">Mozilla</option>
									</select>
								</div>
							</div>
						</div>
					</fieldset>
				</div>

				<!-- Text area question -->
				<div class="bubble" id="bubble5">
					<fieldset class="grow">
						<legend>Question 5: What is APNG's full name?</legend>
						<div class="question">
							
							<div class="content">
								<label for="textarea">Answer: </label>
								<textarea id="textarea" name="long_name" rows="5" cols="120" placeholder="Write your answer..."></textarea>
							</div>
						</div>
					</fieldset>
				</div>

				<!-- Submit button -->
				<div class="bubble" id="submit-bubble">
					<div class="not-grow">
						<div class="content">
							<label for="submit">How did I do?</label>
							<input type="submit" id="submit"/>
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
<!-- To be edited when enhancements are all finalized-->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta name="description" content="php, mysql, enhancements"/>
		<meta name="keywords" content="login, credentials, session, normalise, relation, primary, foreign"/>
		<meta name="author" content="Aly"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>APNG PHP/MySQL enhancements</title>
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
			<section class="parallax parallax-bg">
				<h1>What enhancements did you (not) spot?</h1>
			</section>
			<section class="no-parallax">
				<h2>Via connection with the backend, 3 enhancements have been used.</h2>
				<p>Two should be immediately visible, but the last one is a hidden implementation detail.</p>
			</section>
			<section class="parallax parallax-bg">
				<h2>Data visualization</h2>
			</section>
			<section class="no-parallax">
				<h3>Using JPgraph, a PHP library for visualization</h3>
				<p>
					Once an administrator has received the result for their query, they also receive an overview and statistics visualization 
					generated from all entry in the database. Data retrieval for this is done separately after the supervisor's original query 
					has been executed, which means in case of network congestion or other connection issues, the main functionality of the site 
					will be prioritized.
				</p>
				<h3>What are the steps to do it?</h3>
				<ol>
					<li>Create a file to plot the visualization.</li>
					<li>Include the main JPgraph library module (jpgraph.php), and the specific module required depending on use case 
						(in this instance, jpgraph_line.php).</li>
					<li>Query to the database to retrieve real-time data.</li>
					<li>Create a new Graph object and pass in the relevant data as an array.</li>
					<li>Create an &lt;img&gt; tag with the "src" attribute pointing to the location of the file.</li>
				</ol>
				<p class="citation">
					<span class="italic">Chapter 15. Different types of linear (cartesian) graph types.</span> (n.d.).<br/>
					<span class="indent"></span>Jpgraph.net.<br/>
					<span class="indent"></span><a href="https://jpgraph.net/download/manuals/chunkhtml/ch15.html#sec2.creating-line-graph" target="_blank" rel="noreferrer noopener">https://jpgraph.net/download/manuals/<wbr/>chunkhtml/ch15.html#sec2.creating-line-graph</a>
				</p>
			</section>
			<section class="parallax parallax-bg">
				<h2>Login/logout</h2>
			</section>
			<section class="no-parallax">
				<h3>Using PHP superglobal "$_SESSION"</h3>
				<p>
					State management within a user's session is implemented using PHP's built-in session_start() and the superglobal $_SESSION.
					Conditional rendering is then applied to the header to display a "Log out" button whenever a user is logged in. Administrator's
					credentials is saved to the database in a separate table, and supervisors are required to login before they are allowed to make
					queries and potentially alter database records.
				</p>
				<p class="citation">
					JavaTPoint. (n.d.). <span class="italic">PHP MySQL Login System.</span><br/>
					<span class="indent"></span><a href="https://www.javatpoint.com/php-mysql-login-system" target="_blank" rel="noreferrer noopener">https://www.javatpoint.com/<wbr/>php-mysql-login-system</a>
				</p>
			</section>
			<section class="parallax parallax-bg">
				<h2>Data normalisation</h2>
			</section>
			<section class="no-parallax">
				<h3>Using two separate tables interlinked with primary/foreign key</h3>
				<p>
					Rather than storing all data in a single table, data normalisation has been applied to separate data and reduce coupling.
					"Students" table has been elected as the parent table, using "Student ID" as each entry's unique primary key. The interlinked
					"attempts" table is then linked back via "student ID" as a foreign key, enforced with the "DELETE CASCADE" rule to ensure
					data remain consistent and cohesive across the database.
				</p>
				<p class="citation">
					W3schools. (2019). <span class="italic">SQL FOREIGN KEY Constraint.</span><br/>
					<span class="indent"></span><a href="https://www.w3schools.com/sql/sql_foreignkey.asp" target="_blank" rel="noreferrer noopener">https://www.w3schools.com/<wbr/>sql/sql_foreignkey.asp</a>
				</p>
			</section>
		</main>
        <?php
            include("footer.inc");
        ?>
	</body>
</html>
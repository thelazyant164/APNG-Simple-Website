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
				<h3>Using (external modulesrary name)</h3>
				<p>
					Placeholder text
				</p>
				<h3>What are the steps to do it?</h3>
				<ol>
					<li>Give the parent container the {perspective: 1px;} attribute. This is so that all children of that element
						would be placed in a 3D-simulated environment rather than the traditional 2D plane of the viewport.</li>
					<li>Seperate the HTML into multiple segments, each within a &lt;section&gt; with either the class "parallax" or "no-parallax".
						Give all of them the attribute {transform-style: preserve-3d;}</li>
					<li>Apply to the parallax elements the attributes {position: absolute; top: 0; right: 0; left: 0; bottom: 0;}.
						Apply the transformation functions above as well. Finally, give it a different Z-index to separate it to a different
						layer than the base.</li>
					<li>If the elements scale up bigger than the viewport, scrollbars will appear by default. To prevent this, add the
						attributes {overflow-x: hidden} to the container.</li>
				</ol>
				<p class="citation">
					Trigo, A. (2021, March 25). <span class="italic">How to create a parallax effect with CSS only.</span><br/>
					<span class="indent"></span>Alvaro Trigo’s Blog - Web Developing and Design.<br/>
					<span class="indent"></span><a href="https://alvarotrigo.com/blog/how-to-create-a-parallax-effect-with-css-only" target="_blank" rel="noreferrer noopener">https://alvarotrigo.com/blog/<wbr>how-to-create-a-parallax-effect-with-css-only/</a>
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
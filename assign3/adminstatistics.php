<?php
	function plot_error() {

	}
	function plot_bar() {

	}
    function assess_all() {
        #For queryresult.php

		#Import database information, password, username and other config
		require_once("settings.php");
		#Establish connection with database
		$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

		$sql_table1 = "students";
		$sql_table2 = "attempts";

        $query = "SELECT " . $sql_table2 . ".student_id, support_for, year_developed,
			browser_support, developer, long_name, score, attempt_no, date_attempt
            FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
            . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id";

		#Queries to database server
		$result = mysqli_query($conn, $query);

		$all_attempts = [];
		#Extract all fields of both attempt types (1&2) and put inside ordered array
		while ($row = mysqli_fetch_assoc($result)) {
			$all_attempts += $row; 
		}
		mysqli_free_result($result);
		mysqli_close($conn);

		#TODO: Organize data (split all attempts by type (1&2)...)
		#TODO: re-grade answers by percentage

        #Highlight table (contains average score 1&2&total, how many attempts 1&2 taken,
		#easiest & hardest question)
		#TODO: complete highlight table

        #Score distribution graph (bar/line chart)
        #Error plot graphs for range of score for each attempts
		#TODO: plot graphs...
        echo "
			<h3>Here are some useful insights:</h3>\n
			<p>\n
				Quiz Question 1 accuracy: (JPgraph chart)\n
			</p>\n
			<p>\n
				Quiz Question 2 accuracy: (JPgraph chart)\n
			</p>\n
			<p>\n
				Quiz Question 3 accuracy: (JPgraph chart)\n
			</p>\n
			<p>\n
				Quiz Question 4 accuracy: (JPgraph chart)\n
			</p>\n
			<p>\n
				Quiz Question 5 accuracy: (JPgraph chart)\n
			</p>\n
			<h3>Quiz attempts in real-time</h3>\n
			<p>\n
				Placeholder: (graph showing attempt quiz trends)\n
			</p>\n
        ";
    }
?>
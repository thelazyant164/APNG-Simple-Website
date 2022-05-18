<?php
	#Data retrieval and preprocessing prior to plotting for queryresults.php
	function extract_data($arr_assoc_array, $key) {
		$extracted = [];
		foreach ($arr_assoc_array as $array_item) {
			$extracted[] = $array_item[$key];
		}
		return $extracted;
	}
	function extract_grade_percentage($arr_assoc_array, $key, $answer) {
		$student_answers = extract_data($arr_assoc_array, $key);
		$scores = [];
		foreach ($student_answers as $each_answer) {
			if (is_numeric($answer)) {
				#For question 2
				if ($each_answer == $answer) {
					$scores[] = 100;
				} else {
					$scores[] = 0;
				}
			} elseif (is_string($answer))
				#For questions 1, 4, 5
				if (strtolower($each_answer) == $answer) {
					$scores[] = 100;
				} else {
					$scores[] = 0;
				}
			else {
				#For question 3
				$score = 0;
				$browsers = explode(',', $each_answer);
				foreach ($browsers as $browser) {
					if (in_array(strtolower(trim($browser)), $answer)) {
						$score += 100/3;
					} else {
						$score -= 100/3;
					}
				}
				$scores[] = $score;
			}
		}
	}
    
	#Import database information, password, username and other config
	require("../../../env/settings.php");
	#Establish connection with database
	$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
	if ($conn) {
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
			$all_attempts[] = $row;
		}
		mysqli_free_result($result);
		mysqli_close($conn);
		#Organize data: split all attempts by type (1&2)
		$all_attempts1 = [];
		$all_attempts2 = [];
		foreach ($all_attempts as $attempt) {
			if ($attempt['attempt_no'] == 1) {
				$all_attempts1[] = $attempt;
			} else {
				$all_attempts2[] = $attempt;
			}
		}
		#Extract data: collect all total scores
		$all_scores = extract_data($all_attempts, 'score');
		#Extract data: collect all attempt1 scores
		$all_attempt1_scores = extract_data($all_attempts1, 'score');
		#Extract data: collect all attempt1 scores
		$all_attempt2_scores = extract_data($all_attempts2, 'score');
		#Extract data: collect each question's scores from each type of attempts as percentage
		$all_attempt1_question1_scores = extract_grade_percentage($all_attempts1, 'support_for', 'transparency');
		$all_attempt1_question2_scores = extract_grade_percentage($all_attempts1, 'year_developed', 2004);
		$all_attempt1_question3_scores = extract_grade_percentage($all_attempts1, 'browser_support', ['chrome', 'edge', 'opera']);
		$all_attempt1_question4_scores = extract_grade_percentage($all_attempts1, 'developer', 'mozilla');
		$all_attempt1_question5_scores = extract_grade_percentage($all_attempts1, 'long_name', 'animated portable network graphics');
		$all_attempt2_question1_scores = extract_grade_percentage($all_attempts2, 'support_for', 'transparency');
		$all_attempt2_question2_scores = extract_grade_percentage($all_attempts2, 'year_developed', 2004);
		$all_attempt2_question3_scores = extract_grade_percentage($all_attempts2, 'browser_support', ['chrome', 'edge', 'opera']);
		$all_attempt2_question4_scores = extract_grade_percentage($all_attempts2, 'developer', 'mozilla');
		$all_attempt2_question5_scores = extract_grade_percentage($all_attempts2, 'long_name', 'animated portable network graphics');
		#Extract_data: collect all attempt dates
		$all_dates = extract_data($all_attempts, 'date_attempt');
		#Highlight table (contains average score 1&2&total, how many attempts 1&2 taken, easiest & hardest question)
		#TODO: complete highlight table
		#Score distribution graph (bar/line chart)
		#Attempt time summary (bar/line chart)
		#Error plot graphs for range of score for each attempts
        // echo '<img src="adminstatistics.php" alt="Line graph of both">';
        // echo '<img src="perquestionscore.php" alt="Per question score">';
		// #Error plot graphs for range of score for each question
	} else {
		echo "<p>Unable to connect to database for statistics.</p>";
	}
?>
<?php
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
	function plot_error($data) {
		// #DEBUG
		// print_r($data);
		#TODO: calculate average from array
		#TODO: plot error graph for students' score
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
	function plot_bar($data) {
		#TODO: plot line/bar chart for students' score
		// #DEBUG
		// print_r($data);
	}
    function assess_all() {
        #For queryresult.php

		#Import database information, password, username and other config
		include("settings.php");
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
			#TODO: re-grade answers by percentage

			#Extract data: collect all total scores
			$all_scores = extract_data($all_attempts, 'score');
			#Extract data: collect all attempt1 scores
			$all_attempt1_scores = extract_data($all_attempts1, 'score');
			#Extract data: collect all attempt1 scores
			$all_attempt2_scores = extract_data($all_attempts2, 'score');
			#Extract data: collect each question's scores from each type of attempts as percentage
			$q1 = []
			$q2 = []
			$q3 = []
			$q4 = []
			$q5 = []

			$all_attempt1_question1_scores = extract_grade_percentage($all_attempts1, 'support_for', 'transparency');
			array_push($q1,$all_attempt1_question1_scores)
			$all_attempt1_question2_scores = extract_grade_percentage($all_attempts1, 'year_developed', 2004);
			array_push($q2,$all_attempt1_question2_scores)
			$all_attempt1_question3_scores = extract_grade_percentage($all_attempts1, 'browser_support', ['chrome', 'edge', 'opera']);
			array_push($q3,$all_attempt1_question3_scores)
			$all_attempt1_question4_scores = extract_grade_percentage($all_attempts1, 'developer', 'mozilla');
			array_push($q4,$all_attempt1_question4_scores)
			$all_attempt1_question5_scores = extract_grade_percentage($all_attempts1, 'long_name', 'animated portable network graphics');
			array_push($q5,$all_attempt1_question5_scores)
			$all_attempt2_question1_scores = extract_grade_percentage($all_attempts2, 'support_for', 'transparency');
			array_push($q1,$all_attempt2_question1_scores)
			$all_attempt2_question2_scores = extract_grade_percentage($all_attempts2, 'year_developed', 2004);
			array_push($q2,$all_attempt2_question2_scores)
			$all_attempt2_question3_scores = extract_grade_percentage($all_attempts2, 'browser_support', ['chrome', 'edge', 'opera']);
			array_push($q3,$all_attempt2_question3_scores)
			$all_attempt2_question4_scores = extract_grade_percentage($all_attempts2, 'developer', 'mozilla');
			array_push($q4,$all_attempt2_question4_scores)
			$all_attempt2_question5_scores = extract_grade_percentage($all_attempts2, 'long_name', 'animated portable network graphics');
			array_push($q5,$all_attempt2_question5_scores)
			#Extract_data: collect all attempt dates
			$all_dates = extract_data($all_attempts, 'date_attempt');

			#Highlight table (contains average score 1&2&total, how many attempts 1&2 taken,

			#check the minimumm score out of both attempts for each question
			$min1 = min ($q1)
			$min2 = min ($q2)
			$min3 = min ($q3)
			$min4 = min ($q4)
			$min5 = min ($q5)

			#check the max score out of both attempts for each question
			$max1 = max ($q1)
			$max2 = max ($q2)
			$max3 = max ($q3)
			$max4 = max ($q4)
			$max5 = max ($q5)

			#check which question has the lowest min
			if $min1 < $min2
				if $min1 < $min3
					if $min1 < $min4
						if $min1 < $min5
							$minimum_question = "Question 1" 
							$minimum_score = $min1
			
			if $min2 < $min1
				if $min2 < $min3
					if $min2 < $min4
						if $min2 < $min5
							$minimum_question = "Question 2" 
							$minimum_score = $min2
			
			if $min3 < $min1
				if $min3 < $min2
					if $min3 < $min4
						if $min3 < $min5
							$minimum_question = "Question 3" 
							$minimum_score = $min3
			

			if $min4 < $min2
				if $min4 < $min3
					if $min4 < $min4
						if $min4 < $min5
							$minimum_question = "Question 4" 
							$minimum_score = $min4

			if $min5 < $min1
				if $min5 < $min2
					if $min5 < $min3
						if $min5 < $min4
							$minimum_question = "Question 5" 
							$minimum_score = $min5
			
			if $min1 < $min2
				if $min1 < $min3
					if $min1 < $min4
						if $min1 < $min5
							$minimum_question = "Question 1" 
							$minimum_score = $min1
			
			if $min2 < $min1
				if $min2 < $min3
					if $min2 < $min4
						if $min2 < $min5
							$minimum_question = "Question 2" 
							$minimum_score = $min2
			
			if $min3 < $min1
				if $min3 < $min2
					if $min3 < $min4
						if $min3 < $min5
							$minimum_question = "Question 3" 
							$minimum_score = $min3
			

			if $min4 < $min2
				if $min4 < $min3
					if $min4 < $min4
						if $min4 < $min5
							$minimum_question = "Question 4" 
							$minimum_score = $min4

			if $min5 < $min1
				if $min5 < $min2
					if $min5 < $min3
						if $min5 < $min4
							$minimum_question = "Question 5" 
							$minimum_score = $min5

			if $max1 < $max2
				if $max1 < $max3
					if $max1 < $max4
						if $max1 < $max5
							$maximum_question = "Question 1" 
							$maximum_score = $max1
			if $max2 < $max1
				if $max2 < $max3
					if $max2 < $max4
						if $max2 < $max5
							$maximum_question = "Question 2" 
							$maximum_score = $max2

			if $max3 < $max1
				if $max3 < $max2
					if $max3 < $max4
						if $max3 < $max5
							$maximum_question = "Question 3" 
							$maximum_score = $max3
			
			if $max4 < $max2
				if $max4 < $max3
					if $max4 < $max4
						if $max4 < $max5
							$maximum_question = "Question 4" 
							$maximum_score = $max4

			if $max5 < $max1
				if $max5 < $max2
					if $max5 < $max3
						if $max5 < $max4
							$maximum_question = "Question 5" 
							$maximum_score = $max5
			

				
			
			if (!$student_answers) {
                echo "<p>Something is wrong with $query.</p>";
            #For all list_* queries
            } else if (substr($_POST["request"], 0, 4) == "list") {
                echo "<table border=\"1\">\n";
                echo "<tr>\n"
                    ."<th scope=\"col\">Highlights </th>\n"
                    ."<th scope=\"col\">values</th>\n"
                    ."</tr>\n";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>\n";
                    echo "<td>", $row['first_name'], "</th>\n";
                    echo "</tr>\n";
                }
                echo "</table>\n";
                mysqli_free_result($result);


				if (!$result) {
					echo "<p>Something is wrong with $query.</p>";
				#For all list_* queries
				} else if (substr($_POST["request"], 0, 4) == "list") {
					echo "<table border=\"1\">\n";
					echo "<tr>\n"
						."<th scope=\"col\">Highlights</th>\n"
						."<th scope=\"col\">Values</th>\n"
						."</tr>\n";
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>\n";
						echo "<td>", $row['all_scores'], "</th>\n";
						echo "<td>", $row['all_attempt1_scores'], "</th>\n";
						echo "<td>", $row['all_attempt2_scores'], "</th>\n";
						echo "<td>", $row['maximum_score'], "</th>\n";
						echo "<td>", $row['minimum_scores'], "</th>\n";
						echo "</tr>\n";
					}
					echo "</table>\n";
					mysqli_free_result($result);

			#easiest & hardest question)
			#TODO: complete highlight table

			#Score distribution graph (bar/line chart)
			plot_bar($all_scores);
			#Attempt time summary (bar/line chart)
			plot_bar($all_dates);
			#Error plot graphs for range of score for each attempts
            // echo '<img src="all_attempt_scores.php" alt="Line graph of both">';
            // echo '<img src="perquestionscore.php" alt="Per question score">';
           

			plot_error($all_attempt1_scores);
			plot_error($all_attempt2_scores);
			// #Error plot graphs for range of score for each question
			plot_error($all_attempt1_question1_scores);
		} else {
			echo "<p>Unable to connect to database for statistics.</p>";
		}
    }
?>
<?php
	#Data retrieval and preprocessing prior to plotting for queryresults.php
	function extract_data($arr_assoc_array, $key) {
		$extracted = [];
		foreach ($arr_assoc_array as $array_item) {
			$extracted[] = $array_item[$key];
		}
		return $extracted;
	}
    function retrieve_data($link) {
		#Import database information, password, username and other config
		require($link);
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

			return [
				"all_scores" => $all_scores,
				"all_attempt1_scores" => $all_attempt1_scores,
				"all_attempt2_scores" => $all_attempt2_scores,
			];
		} else {
			echo "<p>Unable to connect to database for statistics.</p>";
		}
	}
?>
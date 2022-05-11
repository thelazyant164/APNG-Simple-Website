<?php
    function assess_all() {
        #For queryresult.php

        $query = "SELECT " . $sql_table2 . ".student_id, score, attempt_no, date_attempt
            FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
            . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id";

        #Highlight table (contains average score 1&2&total,
        #how many attempts 1&2 taken, easiest & hardest question)

        #Score distribution graph (bar/line chart)
        #Error plot graphs for range of score for each attempts
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
<?php
    #Perform statistics on student's first (and second) attempt
    function assess_single_attempt($total, $scores) {
        // #DEBUG
        // print($total);
        // print_r($scores);
        #Pie chart for completion
        #Score is an associative array with "score1" => score of question 1...
        #TODO: convert to percentage, then format data into array and plot pie chart here
        echo "
			<!-- Test example JP graph -->
			<img src='jpgraph/src/example0.php'>
		";
    }
    function assess_single_student($submission) {
        #For markquiz.php
        #Show scores for current attempt
        $total = $submission['score'];
        $scores = $submission['scores'];
        assess_single_attempt($total, $scores);
        if ($submission['attempt_no'] == 2) {
            #Compare scores between 2 attempts -> 2 pie chart
            #Retrieve score data of first attempt from database and plot pie chart

            #Import database information, password, username and other config
            include("../env/settings.php");
            #Establish connection with database
            $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
            if ($conn) {
                $sql_table1 = "students";
                $sql_table2 = "attempts";
                $student_id = $submission['student_id'];

                $query = "SELECT * FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id"
                . " WHERE " . $sql_table1. ".student_id = '$student_id'"
                . " AND attempt_no = 1 ";

                #Queries to database server
                $result = mysqli_query($conn, $query);

                #Extract all fields of attempt1 and put inside associative array
                $row = mysqli_fetch_assoc($result);

                #Split question 3 back into array
                $browsers = explode(',', $row['browser_support']);
                for ($i = 0; $i < count($browsers); $i++) {
                    $browsers[$i] = trim($browsers[$i]);
                }

                #Mark first attempt from answers retrieved from database, then plot
                $scores2 = mark_all($row['support_for'], $row['year_developed'], $browsers, $row['developer'], $row['long_name']);
                $total2 = array_sum($scores2);
                assess_single_attempt($total2, $scores2);

                mysqli_free_result($result);
                mysqli_close($conn);
            } else {
                echo "<p>Unable to connect to database for statistics.</p>";
            }
        }
    }
?>
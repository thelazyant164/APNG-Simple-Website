<?php
	#Data retrieval and preprocessing prior to plotting for markquiz.php
    #Show scores for current attempt
    $total = $submission['score'];
    $scores = $submission['scores'];
    if ($submission['attempt_no'] == 2) {
        #Compare scores between 2 attempts -> 2 pie chart
        #Retrieve score data of first attempt from database and plot pie chart
        #Import database information, password, username and other config
        require("../../../env/settings.php");
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
            mysqli_free_result($result);
            mysqli_close($conn);
        } else {
            echo "<p>Unable to connect to database for statistics.</p>";
        }
    }
?>
<?php
    require("sanitise.php");
    #Helper function submit; to be called inside markquiz.php to record new attempt to database
    #and perform marking/grading functions as well as field validation
    function submit() {
        #Field validation
        function validate_data($data, $type) {
            switch($type) {
                case "name":
                    return preg_match("/^[\w\s-]{1,30}$/", $data);
                case "id":
                    return preg_match("/^\d{7}$|^\d{10}$/", $data);
                case "required":
                    return !empty($data);
                default:
                    return false;
            }
        }
        function validate_all($all_var) {
            if (!validate_data($all_var["first_name"], "name")) {
                $_SESSION["error"] = [
                    "content" => "Invalid field: First name (input: \"" . $_POST['first_name'] . "\")"
                ];
                return false;
            }
            if (!validate_data($all_var["last_name"], "name")) {
                $_SESSION["error"] = [
                    "content" => "Invalid field: Last name (input: \"" . $_POST['last_name'] . "\")"
                ];
                return false;
            }
            if (!validate_data($all_var["student_id"], "id")) {
                $_SESSION["error"] = [
                    "content" => "Invalid field: Student ID (input: \"" . $_POST['student_id'] . "\").<br/>
                    Student ID must comprise of either 7 or 10 digits."
                ];
                return false;
            }
            if (!validate_data($all_var["support_for"], "required")) {
                $_SESSION["error"] = [
                    "content" => "Missing answer for required Question 1: \"Support for what sets APNG apart from GIF?\""
                ];
                return false;
            }
            if (!validate_data($all_var["year_developed"], "required")) {
                $_SESSION["error"] = [
                    "content" => "Missing answer for required Question 2: \"When was APNG first developed?\""
                ];
                return false;
            }
            return true;
        }
        if (!validate_all($_POST)) {
            $_SESSION["error"] += [
                "title" => "Submission rejected",
                "msg" => "invalid field detected during validation. Submission attempt rejected",
                "retry" => "quiz.php"
            ];
            header("location: notification.php");
            exit("Please go back and try again.");
        }

        #Marking
        function mark_all($support_for, $year_developed, $browser_support, $developer, $long_name) {
            $score_answer1 = 0;
            $score_answer2 = 0;
            $score_answer3 = 0;
            $score_answer4 = 0;
            $score_answer5 = 0;
            if (strtolower($support_for) == "transparency") {
                $score_answer1 = 10;
            }
            if ($year_developed == 2004) {
                $score_answer2 = 20;
            }
            if (in_array("Chrome", $browser_support)) {
                $score_answer3 += 5;
            }
            if (in_array("Edge", $browser_support)) {
                $score_answer3 += 5;
            }
            if (in_array("Opera", $browser_support)) {
                $score_answer3 += 5;
            }
            if ($developer == "Mozilla") {
                $score_answer4 = 5;
            }
            if (strtolower($long_name) == "animated portable network graphics") {
                $score_answer5 = 50;
            }
            return ['score_answer1' => $score_answer1,
                    'score_answer2' => $score_answer2,
                    'score_answer3' => $score_answer3,
                    'score_answer4' => $score_answer4,
                    'score_answer5' => $score_answer5];
        }

        #Import database information, password, username and other config
        require_once("settings.php");

        #Establish connection with database
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

        #Connection fails
        if (!$conn) {
            echo "<p>Database connection failure</p>";

        #Connection succeeds
        } else {
            $sql_table1 = "students";
            $sql_table2 = "attempts";

            #Creates new "students" table if table doesn't exist yet
            $query_create1 = "CREATE TABLE IF NOT EXISTS " . $sql_table1 . " (
                student_id VARCHAR(10) PRIMARY KEY NOT NULL,
                first_name VARCHAR(30) NOT NULL,
                last_name VARCHAR(30) NOT NULL
            )";
            #Creates new "attempts" table if table doesn't exist yet
            $query_create2 = "CREATE TABLE IF NOT EXISTS " . $sql_table2 . " (
                attempt_id INT PRIMARY KEY AUTO_INCREMENT NULL,
                student_id VARCHAR(10) NOT NULL,
                support_for VARCHAR(50) NOT NULL,
                year_developed VARCHAR(4) NOT NULL,
                browser_support VARCHAR(100),
                developer VARCHAR(9),
                long_name VARCHAR(1000),
                attempt_no INT NOT NULL,
                score INT NOT NULL,
                date_attempt DATETIME NOT NULL,
                FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
            )";
            $result_create1 = mysqli_query($conn, $query_create1);
            $result_create2 = mysqli_query($conn, $query_create2);

            #Escape all fields and trim all whitespaces
            $first_name = sanitise($_POST["first_name"]);
            $last_name = sanitise($_POST["last_name"]);
            $student_id = sanitise($_POST["student_id"]);
            $support_for = sanitise($_POST["support_for"]);
            $year_developed = sanitise($_POST["year_developed"]);
            $browser_support = [];
            if (isset($_POST["browser_support"])) {
                for ($i = 0; $i < count($_POST["browser_support"]); $i++) {
                    array_push($browser_support, sanitise($_POST["browser_support"][$i]));
                }
            }
            $developer = sanitise($_POST["developer"]);
            $long_name = sanitise($_POST["long_name"]);
            date_default_timezone_set("Australia/Melbourne");
            $date_attempt = date('Y-m-d H:i:s');

            #Determine attempt count
            $query_find = "SELECT * FROM $sql_table2 WHERE student_id = '$student_id'";
            $result_find = mysqli_query($conn, $query_find);
            if (mysqli_num_rows($result_find) == 0) {
                $attempt_no = 1;
            } else if (mysqli_num_rows($result_find) == 1) {
                $attempt_no = 2;
                mysqli_free_result($result_find);
            #DEVELOPMENT
            } else {
                $attempt_no = mysqli_num_rows($result_find) + 1;
            #PRODUCTION
            // } else {
            //     while ($row = mysqli_fetch_assoc($result_find)) {
            //         $date1 = $row["date_attempt"];
            //     }
            //     mysqli_free_result($result_find);
            //     $date2 = $date_attempt;
            //     $_SESSION["error"] = [
            //         "title" => "Quiz submission rejected",
            //         "msg" => "maximum attempt count (2) detected. Submission attempt unsuccessful",
            //         "content" => "Previous 2 attempts have been recorded: first on $date1 and later on $date2",
            //         "retry" => "quiz.php"
            //     ];
            //     header("location: notification.php");
            //     exit("Max attempt count exceeded.");
            }

            #Determine score
            $scores = mark_all($support_for, $year_developed, $browser_support, $developer, $long_name);
            $score = array_sum($scores);

            $stringify_browser_support = implode(", ", $browser_support);

            #Define INSERT query into students table
            $query_insert1 = "INSERT INTO $sql_table1
                (first_name, last_name, student_id)
                VALUES
                ('$first_name', '$last_name', '$student_id')";
            #Define INSERT query into attempts table
            $query_insert2 = "INSERT INTO $sql_table2
                (student_id, support_for, year_developed,
                browser_support, developer, long_name, attempt_no, score, date_attempt)
                VALUES
                ('$student_id', '$support_for', '$year_developed',
                '$stringify_browser_support', '$developer', '$long_name', '$attempt_no', '$score', '$date_attempt')";

            #Perform INSERT query into students table (only on first attempt)
            if ($attempt_no == 1) {
                $result_insert1 = mysqli_query($conn, $query_insert1);
            } else {
                $result_insert1 = true;
            }
            #Perform INSERT query into attempts table
            $result_insert2 = mysqli_query($conn, $query_insert2);

            #Server responds
            if (!$result_create1) {
                echo "<p>Something is wrong with $query_create1.</p>";
            } else if (!$result_create2) {
                echo "<p>Something is wrong with $query_create2.</p>";
            } else if (!$result_find) {
                echo "<p>Something is wrong with $query_find.</p>";
            } else if (!$result_insert1) {
                echo "<p>Something is wrong with $query_insert1.</p>";
            } else if (!$result_insert2) {
                echo "<p>Something is wrong with $query_insert2.</p>";
            } else {
                #If successful submit, return what has just been submitted
                echo "<div class=\"overflowTable\">\n<table border=\"1\">\n";
                echo "<tr>\n"
                    ."<th scope=\"col\">First name</th>\n"
                    ."<th scope=\"col\">Last name</th>\n"
                    ."<th scope=\"col\">Student ID</th>\n"
                    ."<th scope=\"col\">Attempt no</th>\n"
                    ."<th scope=\"col\">Date/time</th>\n"
                    ."<th scope=\"col\">Score</th>\n"
                ."</tr>\n"
                ."<tr>\n"
                    ."<td>", $first_name, "</th>\n"
                    ."<td>", $last_name, "</th>\n"
                    ."<td>", $student_id, "</th>\n"
                    ."<td>", $attempt_no, "</th>\n"
                    ."<td>", $date_attempt, "</th>\n"
                    ."<td>", $score, "</th>\n"
                ."</tr>\n"
                ."</table>\n</div>\n";
            }
            mysqli_close($conn);
            unset($_POST);
        }
        return ['score' => $score,
                'scores' => $scores,
                'attempt_no' => $attempt_no,
                'support_for' => $support_for,
                'year_developed' => $year_developed,
                'browser_support' => $stringify_browser_support,
                'developer' => $developer,
                'long_name' => $long_name];
    }
?>
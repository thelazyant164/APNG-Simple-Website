<?php
    #Helper function submit; to be called inside markquiz.php to record new attempt to database
    #and perform marking/grading functions as well as field validation
    function submit() {
        #Field validation
        function validate_data($data, $type) {
            switch($type) {
                case "name":
                    return preg_match("/^[\w\s-]{1,30}$/", $data);
                case "id":
                    return preg_match("/^[\d]{7}|[\d]{10}$/", $data);
                case "required":
                    return !empty($data);
                default:
                    return false;
            }
        }
        function validate_all($all_var) {
            #If access without going through quiz.php, redirects back
            if (!isset($all_var["first_name"])
            or !isset($all_var["last_name"])
            or !isset($all_var["student_id"])
            or !isset($all_var["support_for"])
            or !isset($all_var["year_developed"])
            or !isset($all_var["browser_support[]"])
            or !isset($all_var["developer"])
            or !isset($all_var["long_name"])) {
                header("location: quiz.php");
            }
            return validate_data($all_var["first_name"], "name")
            and validate_data($all_var["last_name"], "name")
            and validate_data($all_var["student_id"], "id")
            and validate_data($all_var["support_for"], "required")
            and validate_data($all_var["year_developed"], "required");
        }
        if (!validate_all($_POST)) {
            echo "<p>Data invalid. Attempt has not been recorded.</p>";
        }

        #Marking
        function mark_all($support_for, $year_developed, $browser_support, $developer, $long_name) {
            $score = 0;
            if ($support_for == "transparency") {
                $score += 10;
            }
            if ($year_developed == 2004) {
                $score += 20;
            }
            if (in_array("Chrome", $browser_support)) {
                $score += 5;
            }
            if (in_array("Edge", $browser_support)) {
                $score += 5;
            }
            if (in_array("Opera", $browser_support)) {
                $score += 5;
            }
            if ($developer == "Mozilla") {
                $score += 5;
            }
            if ($long_name == "Animated Portable Network Graphics") {
                $score += 50;
            }
            return $score;
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
            $sql_table = "attempts";

            #Creates new table if table doesn't exist yet
            $query_create = "CREATE TABLE IF NOT EXISTS " . $sql_table . " (
                id INT PRIMARY KEY AUTOINCREMENT NULL,
                first_name VARCHAR(30) NOT NULL,
                last_name VARCHAR(30) NOT NULL,
                student_id VARCHAR(10) NOT NULL,
                support_for VARCHAR(50) NOT NULL,
                year_developed VARCHAR(4) NOT NULL,
                browser_support SET('Chrome', 'Edge', 'Opera', 'Internet Explorer'),
                developer VARCHAR(9),
                long_name VARCHAR(1000),
                attempt_no INT NOT NULL,
                score INT NOT NULL,
                date_attempt DATETIME NOT NULL
            )";
            $result_create = mysqli_query($conn, $query_create);

            #Escape all fields and trim all whitespaces
            $first_name = htmlspecialchars(trim($_POST["first_name"]));
            $last_name = htmlspecialchars(trim($_POST["last_name"]));
            $student_id = htmlspecialchars(trim($_POST["student_id"]));
            $support_for = htmlspecialchars(trim($_POST["support_for"]));
            $year_developed = htmlspecialchars(trim($_POST["year_developed"]));
            $browser_support = [];
            for ($i = 0; $i < count($_POST["browser_support[]"]); $i++) {
                array_push($browser_support, htmlspecialchars(trim($_POST["browser_support[]"][$i])));
            }
            $developer = htmlspecialchars(trim($_POST["developer"]));
            $long_name = htmlspecialchars(trim($_POST["long_name"]));
            $date_attempt = date('Y-m-d H:i:s');

            #Determine attempt count
            $query_find = "SELECT * FROM $sql_table
                        WHERE first_name = '$first_name'
                            AND last_name = '$last_name'
                            AND student_id = '$student_id'";
            $result_find = mysqli_query($conn, $query_find);
            if (mysqli_num_rows($result_find) == 0) {
                $attempt_no = 1;
            } else if (mysqli_num_rows($result_find) == 1) {
                $attempt_no = 2;
            } else {
                exit("Max attempt count exceeded.");
            }

            #Determine score
            $score = mark_all($support_for, $year_developed, $browser_support, $developer, $long_name);

            #Define INSERT query
            $query_insert = "INSERT INTO $sql_table
                    (first_name, last_name, student_id, support_for, year_developed,
                    browser_support, developer, long_name, attempt_no, score, date_attempt)
                    VALUES
                    ('$first_name', '$last_name', '$student_id', '$support_for', '$year_developed',
                    '$browser_support', '$developer', '$long_name', '$attempt_no', '$score', '$date_attempt')";
            
            #Perform INSERT query
            $result_insert = mysqli_query($conn, $query_insert);

            #Server responds
            if (!$result_create) {
                echo "<p>Something is wrong with $query_create.</p>";
            } else if (!$result_find) {
                echo "<p>Something is wrong with $query_find.</p>";
            } else if (!$result_insert) {
                echo "<p>Something is wrong with $query_insert.</p>";
            } else {
                #Right now, if successful submit, return what has just been submitted
                #TODO: change this into marking/grading
                echo "<table border=\"1\">\n";
                echo "<tr>\n"
                    ."<th scope=\"col\">Attempts Taken</th>\n"
                    ."<th scope=\"col\">First name</th>\n"
                    ."<th scope=\"col\">Last name</th>\n"
                    ."<th scope=\"col\">Student ID</th>\n"
                    ."<th scope=\"col\">Score</th>\n"
                    ."<th scope=\"col\">1. Support for</th>\n"
                    ."<th scope=\"col\">2. Year developed</th>\n"
                    ."<th scope=\"col\">3. Browser support</th>\n"
                    ."<th scope=\"col\">4. Developer</th>\n"
                    ."<th scope=\"col\">5. Long name</th>\n"
                    ."</tr>\n";
                while ($row = mysqli_fetch_assoc($result_insert)) {
                    echo "<tr>\n";
                    echo "<td>", $row['attempt_no'], "</th>\n";
                    echo "<td>", $row['first_name'], "</th>\n";
                    echo "<td>", $row['last_name'], "</th>\n";
                    echo "<td>", $row['student_id'], "</th>\n";
                    echo "<td>", $row['score'], "</th>\n";
                    echo "<td>", $row['support_for'], "</th>\n";
                    echo "<td>", $row['year_developed'], "</th>\n";
                    echo "<td>", $row['browser_support'], "</th>\n";
                    echo "<td>", $row['developer'], "</th>\n";
                    echo "<td>", $row['long_name'], "</th>\n";
                    echo "</tr>\n";
                }
                echo "</table>\n";
                mysqli_free_result($result_insert);
            }
            mysqli_close($conn);
        }
    }
?>
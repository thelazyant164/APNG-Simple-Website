<?php
    #Helper function admin_query to perform field validation on admin's query,
    #perform queries on database, and return tabular results/(un)successful messages
    function admin_query() {
        #Field validation (for unsafe requests - update, delete)
        function validate_data($data, $type) {
            switch($type) {
                case "name":
                    return preg_match("/^[\w\s-]{1,30}$/", $data);
                case "id":
                    return preg_match("/^[\d]{7}|[\d]{10}$/", $data);
                case "no":
                    return $data == 1 or $data == 2;
                case "score":
                    return 0 <= $data and $data <= 100;
                case "required":
                    return !empty($data);
                default:
                    return false;
            }
        }
        function list_all($sql_table1, $sql_table2) {
            return "SELECT " . $sql_table2 . ".student_id, first_name, last_name, score, attempt_no
                FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id";
        }
        function list_specific($all_var, $sql_table1, $sql_table2) {
            #Escape all fields and trim all whitespaces
            $first_name = htmlspecialchars(trim($all_var["first_name"]));
            $last_name = htmlspecialchars(trim($all_var["last_name"]));
            $student_id = htmlspecialchars(trim($all_var["student_id"]));

            return "SELECT * FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
            . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id"
                . " WHERE first_name = '$first_name'
                AND last_name = '$last_name'
                OR " . $sql_table1. ".student_id = '$student_id'";
        }
        function list_full($sql_table1, $sql_table2) {
            return "SELECT " . $sql_table2 . ".student_id, first_name, last_name, score, attempt_no
                FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id"
                . " WHERE score = 100 AND attempt_no = 1";
        }
        function list_half($sql_table1, $sql_table2) {
            return "SELECT " . $sql_table2 . ".student_id, first_name, last_name, score, attempt_no
                FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id"
                . " WHERE score < 50 AND attempt_no = 2";
        }
        function delete_attempts($all_var, $sql_table) {
            #Escape all fields and trim all whitespaces
            $student_id = htmlspecialchars(trim($all_var["student_id"]));
            #Validate student_id to be deleted
            $valid = validate_data($student_id, "id");

            if (!$valid) {
                echo "<p>Invalid field detected when trying to query. Delete attempt unsuccessful.</p>";
                exit("Please go back and try again.");
            }

            return "DELETE FROM " . $sql_table . " WHERE student_id = '$student_id'";
        }
        function update_score($all_var, $sql_table) {
            #Escape all fields and trim all whitespaces
            $student_id = htmlspecialchars(trim($all_var["student_id"]));
            $attempt_no = htmlspecialchars(trim($all_var["attempt_no"]));
            $score = htmlspecialchars(trim($all_var["score"]));
            #Validate score to be updated
            $valid = validate_data($score, "score");

            if (!$valid) {
                echo "<p>Invalid field detected when trying to query. Update attempt unsuccessful.</p>";
                exit("Invalid field detected when trying to query. Please go back and try again.");
            }

            return "UPDATE " . $sql_table. " SET score = '$score'
                WHERE student_id = '$student_id'
                AND attempt_no = '$attempt_no'";
        }

        #Safeguard against direct php access through URL
        if (!isset($_POST["request"])) {
            header("location: manage.php");
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
            #Determine query
            switch ($_POST["request"]) {
                case "list_all":
                    $query = list_all($sql_table1, $sql_table2);
                    break;
                case "list_specific":
                    $query = list_specific($_POST, $sql_table1, $sql_table2);
                    break;
                case "list_full":
                    $query = list_full($sql_table1, $sql_table2);
                    break;
                case "list_half":
                    $query = list_half($sql_table1, $sql_table2);
                    break;
                case "delete_attempts":
                    $query = delete_attempts($_POST, $sql_table1);
                    break;
                case "update_score":
                    $query = update_score($_POST, $sql_table2);
                    break;
                default:
                    header("location: manage.php");
            }

            #Queries to database server
            $result = mysqli_query($conn, $query);

            #Server responds
            if (!$result) {
                echo "<p>Something is wrong with $query.</p>";
            #For all list_* queries
            } else if (substr($_POST["request"], 0, 4) == "list") {
                #TODO: beautify this
                echo "<table border=\"1\">\n";
                echo "<tr>\n"
                    ."<th scope=\"col\">First name</th>\n"
                    ."<th scope=\"col\">Last name</th>\n"
                    ."<th scope=\"col\">Student ID</th>\n"
                    ."<th scope=\"col\">Score</th>\n"
                    ."<th scope=\"col\">Attempt</th>\n"
                    ."</tr>\n";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>\n";
                    echo "<td>", $row['first_name'], "</th>\n";
                    echo "<td>", $row['last_name'], "</th>\n";
                    echo "<td>", $row['student_id'], "</th>\n";
                    echo "<td>", $row['score'], "</th>\n";
                    echo "<td>", $row['attempt_no'], "</th>\n";
                    echo "</tr>\n";
                }
                echo "</table>\n";
                mysqli_free_result($result);
            #For delete queries
            } else if ($_POST["request"] == "delete_attempts") {
                echo "<p>Delete success. Record no longer exists in database.</p>\n";
            } else if ($_POST["request"] == "update_score") {
                echo "<p>Update success. Record has been modified in database.</p>\n";
            }
            mysqli_close($conn);
        }
    }  
?>
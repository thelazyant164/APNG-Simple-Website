<?php
    require("sanitise.php");
    #Helper function admin_query to perform field validation on admin's query,
    #perform queries on database, and return tabular results/(un)successful messages
    function admin_query() {
        #Field validation (for unsafe requests - update, delete)
        function validate_data($data, $type) {
            switch($type) {
                case "name":
                    return preg_match("/^[\w\s-]{1,30}$/", $data);
                case "id":
                    return preg_match("/^\d{7}$|^\d{10}$/", $data);
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
        function list_all($sql_table1, $sql_table2, $conn) {
            #Check to make sure record exists in database
            $query_find = "SELECT " . $sql_table2 . ".student_id
                FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id";
            $result = mysqli_query($conn, $query_find);
            if (!mysqli_fetch_array($result)) {
                session_start();
                $_SESSION["error"] = [
                    "title" => "Select query failed",
                    "msg" => "no existing entry exists in record",
                    "content" => "No entry in database found",
                    "retry" => "manage.php"
                ];
                header("location: notification.php");
                exit("Select failure: no existing entry in database found.");
            } else {
                mysqli_free_result($result);
            }

            return "SELECT " . $sql_table2 . ".student_id, first_name, last_name, score, attempt_no
                FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id";
        }
        function list_specific($all_var, $sql_table1, $sql_table2, $conn) {
            #Escape all fields and trim all whitespaces
            $first_name = sanitise($all_var["first_name"]);
            $last_name = sanitise($all_var["last_name"]);
            $student_id = sanitise($all_var["student_id"]);

            #Check to make sure record exists in database
            $query_find = "SELECT " . $sql_table2 . ".student_id
                FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id";
            $result = mysqli_query($conn, $query_find);
            if (!mysqli_fetch_array($result)) {
                session_start();
                $_SESSION["error"] = [
                    "title" => "Select query failed",
                    "msg" => "no existing entry exists in record",
                    "content" => "No entry in database found",
                    "retry" => "manage.php"
                ];
                header("location: notification.php");
                exit("Select failure: no existing entry in database found.");
            } else {
                mysqli_free_result($result);
            }

            return "SELECT * FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
            . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id"
                . " WHERE first_name = '$first_name'
                AND last_name = '$last_name'
                OR " . $sql_table1. ".student_id = '$student_id'";
        }
        function list_full($sql_table1, $sql_table2, $conn) {
            #Check to make sure record exists in database
            $query_find = "SELECT " . $sql_table2 . ".student_id
                FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id";
            $result = mysqli_query($conn, $query_find);
            if (!mysqli_fetch_array($result)) {
                session_start();
                $_SESSION["error"] = [
                    "title" => "Select query failed",
                    "msg" => "no existing entry exists in record",
                    "content" => "No entry in database found",
                    "retry" => "manage.php"
                ];
                header("location: notification.php");
                exit("Select failure: no existing entry in database found.");
            } else {
                mysqli_free_result($result);
            }

            return "SELECT " . $sql_table2 . ".student_id, first_name, last_name, score, attempt_no
                FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id"
                . " WHERE score = 100 AND attempt_no = 1";
        }
        function list_half($sql_table1, $sql_table2, $conn) {
            #Check to make sure record exists in database
            $query_find = "SELECT " . $sql_table2 . ".student_id
                FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id";
            $result = mysqli_query($conn, $query_find);
            if (!mysqli_fetch_array($result)) {
                session_start();
                $_SESSION["error"] = [
                    "title" => "Select query failed",
                    "msg" => "no existing entry exists in record",
                    "content" => "No entry in database found",
                    "retry" => "manage.php"
                ];
                header("location: notification.php");
                exit("Select failure: no existing entry in database found.");        
            } else {
                mysqli_free_result($result);
            }

            return "SELECT " . $sql_table2 . ".student_id, first_name, last_name, score, attempt_no
                FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id"
                . " WHERE score < 50 AND attempt_no = 2";
        }
        function delete_attempts($all_var, $sql_table, $conn) {
            #Escape all fields and trim all whitespaces
            $student_id = sanitise($all_var["student_id"]);
            #Validate student_id to be deleted
            $valid = validate_data($student_id, "id");

            if (!$valid) {
                session_start();
                $_SESSION["error"] = [
                    "title" => "Delete query request rejected",
                    "msg" => "invalid field detected when trying to query. Delete attempt unsuccessful",
                    "content" => "Invalid field: Student ID (input: \"" . $_POST['student_id'] . "\").<br/>
                    Student ID must comprise of either 7 or 10 digits.",
                    "retry" => "manage.php"
                ];
                header("location: notification.php");
                exit("Please go back and try again.");
            }

            #Check to make sure record exists in database
            $query_find = "SELECT " . $sql_table2 . ".student_id, score, attempt_no
                FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id"
                . " WHERE " . $sql_table2 . ".student_id = " . $student_id;
            $result = mysqli_query($conn, $query_find);
            if (!mysqli_fetch_array($result)) {
                session_start();
                $_SESSION["error"] = [
                    "title" => "Delete query failed",
                    "msg" => "no existing entry exists in record",
                    "content" => "No entry in database with student ID \"$student_id\" found",
                    "retry" => "manage.php"
                ];
                header("location: notification.php");
                exit("Delete failure: no existing entry in database found.");
            } else {
                mysqli_free_result($result);
            }

            return "DELETE FROM " . $sql_table . " WHERE student_id = '$student_id'";
        }
        function update_score($all_var, $sql_table, $conn) {
            #Escape all fields and trim all whitespaces
            $student_id = sanitise($all_var["student_id"]);
            $attempt_no = sanitise($all_var["attempt_no"]);
            $score = sanitise($all_var["score"]);

            #Validate student_id to be updated
            $valid = validate_data($student_id, "id");
            if (!$valid) {
                session_start();
                $_SESSION["error"] = [
                    "title" => "Update query request rejected",
                    "msg" => "invalid field detected when trying to query. Update attempt unsuccessful",
                    "content" => "Invalid field: Student ID (input: \"" . $student_id . "\").<br/>
                    Student ID must comprise of either 7 or 10 digits.",
                    "retry" => "manage.php"
                ];
                header("location: notification.php");
                exit("Please go back and try again.");
            }

            #Validate attempt_no to be updated
            $valid = validate_data($attempt_no, "no");
            if (!$valid) {
                session_start();
                $_SESSION["error"] = [
                    "title" => "Update query request rejected",
                    "msg" => "invalid field detected when trying to query. Update attempt unsuccessful",
                    "content" => "Invalid field: Attempt (input: \"" . $attempt_no . "\").<br/>
                    Attempt number must be either \"1\" or \"2\"",
                    "retry" => "manage.php"
                ];
                header("location: notification.php");
                exit("Please go back and try again.");
            }

            #Validate score to be updated
            $valid = validate_data($score, "score");
            if (!$valid) {
                session_start();
                $_SESSION["error"] = [
                    "title" => "Update query request rejected",
                    "msg" => "invalid field detected when trying to query. Update attempt unsuccessful",
                    "content" => "Invalid field: New score (input: \"" . $score . "\").<br/>
                    New score must be greater than \"0\" and lesser than \"100\"",
                    "retry" => "manage.php"
                ];
                header("location: notification.php");
                exit("Please go back and try again.");
            }

            #Check to make sure record exists in database
            $query_find = "SELECT " . $sql_table2 . ".student_id, score, attempt_no
                FROM " . $sql_table1 . " INNER JOIN " . $sql_table2
                . " ON " . $sql_table1 . ".student_id = " . $sql_table2 . ".student_id"
                . " WHERE " . $sql_table2 . ".student_id = " . $student_id
                . " AND attempt_no = " . $attempt_no;
            $result = mysqli_query($conn, $query_find);
            if (!mysqli_fetch_array($result)) {
                session_start();
                $_SESSION["error"] = [
                    "title" => "Update query failed",
                    "msg" => "no existing entry exists in record",
                    "content" => "No entry in database with attempt number \"$attempt_no\"
                    and student ID \"$student_id\" found",
                    "retry" => "manage.php"
                ];
                header("location: notification.php");
                exit("Update failure: no existing entry in database found.");
            } else {
                mysqli_free_result($result);
            }
            
            return "UPDATE " . $sql_table. " SET score = '$score'
                WHERE student_id = '$student_id'
                AND attempt_no = '$attempt_no'";
        }

        #Safeguard against direct php access through URL
        if (!isset($_POST["request"])) {
            session_start();
            $_SESSION["error"] = [
                "title" => "Unknown query request",
                "msg" => "no query selected",
                "content" => "Please choose from the list of available queries you would like to perform on database.",
                "retry" => "manage.php"
            ];
            header("location: notification.php");
            exit("Direct access through URL detected. Script execution aborted.");
        }

        #Import database information, password, username and other config
        require_once("settings.php");
        #Establish connection with database
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

        #Connection fails
        if (!$conn) {
            session_start();
            $_SESSION["error"] = [
                "title" => "Database connection rejected",
                "msg" => "database timeout",
                "content" => "The server is inaccessible at the moment. Please try again at a different time",
                "retry" => "manage.php"
            ];
            header("location: notification.php");
            exit("Database connection failure.");
        #Connection succeeds
        } else {
            $sql_table1 = "students";
            $sql_table2 = "attempts";
            #Determine query
            switch ($_POST["request"]) {
                case "list_all":
                    $query = list_all($sql_table1, $sql_table2, $conn);
                    break;
                case "list_specific":
                    $query = list_specific($_POST, $sql_table1, $sql_table2, $conn);
                    break;
                case "list_full":
                    $query = list_full($sql_table1, $sql_table2, $conn);
                    break;
                case "list_half":
                    $query = list_half($sql_table1, $sql_table2, $conn);
                    break;
                case "delete_attempts":
                    $query = delete_attempts($_POST, $sql_table1, $conn);
                    break;
                case "update_score":
                    $query = update_score($_POST, $sql_table2, $conn);
                    break;
                default:
                    header("location: manage.php");
                    exit("Direct access through URL detected. Script execution aborted.");
            }

            #Queries to database server
            $result = mysqli_query($conn, $query);

            #Server responds
            if (!$result) {
                echo "<p>Something is wrong with $query.</p>";
            #For all list_* queries
            } else if (substr($_POST["request"], 0, 4) == "list") {
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
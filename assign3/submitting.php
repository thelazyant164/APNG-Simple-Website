<?php
    #Field validation
    function validate_data($data, $type) {
        switch($type) {
            case "name":
                return preg_match("/^[\w\s-]{1,30}$/", $data);
            case "id":
                return preg_match("/^[\d]{7,10}$/", $data);
            case "required":
                return !empty($data);
            default:
                return false;
        }
    }
    function validate_all($allVar) {
        #If access without going through quiz.php, redirects back
        if (!isset($allVar["first_name"])
         or !isset($allVar["last_name"])
         or !isset($allVar["student_id"])
         or !isset($allVar["support_for"])
         or !isset($allVar["year_developed"])
         or !isset($allVar["browser_support[]"])
         or !isset($allVar["developer"])
         or !isset($allVar["long_name"])) {
            header("location: quiz.php");
        }
        return validate_data($allVar["first_name"], "name")
           and validate_data($allVar["last_name"], "name")
           and validate_data($allVar["student_id"], "id")
           and validate_data($allVar["support_for"], "required")
           and validate_data($allVar["year_developed"], "required");
    }
    validate_all($_POST);

    #Import database information, password, username and other config
    require_once("settings.php");

    #Establish connection with database
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    #Connection fails
    if (!$conn) {
        echo "<p>Database connection failure</p>";

    #Connection succeeds
    } else {
        $sql_table = "quiz_answers";

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
            long_name VARCHAR(1000)
        )";
        $result_create = mysqli_query($conn, $query_create);

        #Escape all fields and trim all whitespaces
        $first_name = htmlspecialchars(trim($_POST["first_name"]));
        $last_name = htmlspecialchars(trim($_POST["last_name"]));
        $student_id = htmlspecialchars(trim($_POST["student_id"]));
        $support_for = htmlspecialchars(trim($_POST["support_for"]));
        $year_developed = htmlspecialchars(trim($_POST["year_developed"]));
        $browser_support = htmlspecialchars(trim($_POST["browser_support[]"]));
        $developer = htmlspecialchars(trim($_POST["developer"]));
        $long_name = htmlspecialchars(trim($_POST["long_name"]));

        #Define INSERT query
        $query_insert = "INSERT INTO $sql_table
                  (first_name, last_name, student_id, support_for, year_developed, browser_support, developer, long_name)
                  VALUES
                  ('$first_name', '$last_name', '$student_id', '$support_for', '$year_developed', '$browser_support', '$developer', '$long_name')";
        
        #Perform INSERT query
        $result_insert = mysqli_query($conn, $query_insert);

        #Server responds
        if (!$result_create) {
            echo "<p>Something is wrong with $query_create.</p>";
        }
        else if (!$result_insert) {
            echo "<p>Something is wrong with $query_insert.</p>";
        } else {
            #Right now, if successful submit, return what has just been submitted
            #TODO: change this into marking/grading
            echo "<table border=\"1\">\n";
            echo "<tr>\n"
                ."<th scope=\"col\">First name</th>\n"
                ."<th scope=\"col\">Last name</th>\n"
                ."<th scope=\"col\">Student ID</th>\n"
                ."<th scope=\"col\">Support for</th>\n"
                ."<th scope=\"col\">Year developed</th>\n"
                ."<th scope=\"col\">Browser support</th>\n"
                ."<th scope=\"col\">Developer</th>\n"
                ."<th scope=\"col\">Long name</th>\n"
                ."</tr>\n";
            while ($row = mysqli_fetch_assoc($result_insert)) {
                echo "<tr>\n";
                echo "<td>", $row['first_name'], "</th>\n";
                echo "<td>", $row['last_name'], "</th>\n";
                echo "<td>", $row['student_id'], "</th>\n";
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
?>
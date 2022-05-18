<?php
    require("sanitise.php");
    #Helper function authenticate to perform field validation on admin's credentials,
    #perform authentication queries on administrator database, and redirect to ../manage.php when authorized
    #redirects to error page with notice of incorrect credentials when unauthorized
    function authenticate() {
        #Field validation (for unsafe requests - update, delete)
        function validate_data($data, $type) {
            switch($type) {
                case "username":
                    return preg_match("/^[\w\d\-_]{10,30}$/", $data);
                case "password":
                    return preg_match("/^.{10,30}$/", $data);
                default:
                    return false;
            }
        }
        #Safeguard against direct php access through URL
        if (!isset($_POST["username"]) or !isset($_POST["password"])) {
            header("location: login.php");
            exit("Direct access through URL detected. Script execution aborted.");
        }

        #Validate username and password fields
        if (!validate_data($_POST["username"], "username")) {
            session_start();
            $_SESSION["error"] = [
                "title" => "Authentication failed",
                "msg" => "invalid fields detected. Login attempt unsuccessful",
                "content" => "Invalid field: Username (input: \"" . $_POST['username'] . "\").<br/>
                Username must only contains alphanumeric characters, dashes and/or underscores, and be between 10 and 30 characters long",
                "retry" => "login.php"
            ];
            header("location: ../notification.php");
            exit("Please go back and try again.");
        }
        if (!validate_data($_POST["password"], "password")) {
            session_start();
            $_SESSION["error"] = [
                "title" => "Authentication failed",
                "msg" => "invalid fields detected. Login attempt unsuccessful",
                "content" => "Invalid field: Password (input: \"" . $_POST['password'] . "\").<br/>
                Password must be between 10 and 30 characters long",
                "retry" => "login.php"
            ];
            header("location: ../notification.php");
            exit("Please go back and try again.");
        }

        #Import database information, password, username and other config
        require_once("../env/settings.php");
        #Establish connection with database
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
        
        #Connection fails
        if (!$conn) {
            session_start();
            $_SESSION["error"] = [
                "title" => "Database connection rejected",
                "msg" => "database timeout",
                "content" => "The server is inaccessible at the moment. Please try again at a different time",
                "retry" => "login.php"
            ];
            header("location: ../notification.php");
            exit("Database connection failure.");
            
            #Connection succeeds
        } else {
            $sql_table = "admin_credentials";
            
            #Escape all fields and trim all whitespaces
            $username = sanitise($_POST["username"]);
            $password = sanitise($_POST["password"]);
            
            #Determine query
            $query = "SELECT * FROM " . $sql_table . " WHERE username = '$username' AND password = '$password'";
            
            #Queries to database server
            $result = mysqli_query($conn, $query);
            
            #Server responds
            if (!$result) {
                echo "<p>Something is wrong with $query.</p>";
            } else if (!mysqli_fetch_array($result)) {
                session_start();
                $_SESSION["error"] = [
                    "title" => "Authentication failed",
                    "msg" => "credentials mismatched",
                    "content" => "Either your username or password is incorrect",
                    "retry" => "login.php"
                ];
                header("location: ../notification.php");
                exit("Authentication failure.");
            } else {
                session_start();
                $_SESSION["login"] = true;
                $_SESSION["username"] = $username;
                header("location: ../manage.php");
            }
            mysqli_free_result($result);
            mysqli_close($conn);
        }
    }
    authenticate();
?>
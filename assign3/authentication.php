<?php
    #Helper function authenticate to perform field validation on admin's credentials,
    #perform authentication queries on administrator database, and redirect to manage.php when authorized
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
        }

        #Validate username and password fields
        if (!validate_data($_POST["username"], "username") or !validate_data($_POST["password"], "password")) {
            echo "<p>Invalid fields detected. Login attempt failed.</p>";
            exit();
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
            $sql_table = "admin_credentials";
            
            #Escape all fields and trim all whitespaces
            $username = htmlspecialchars(trim($_POST["username"]));
            $password = htmlspecialchars(trim($_POST["password"]));
            
            #Determine query
            $query = "SELECT * FROM " . $sql_table . " WHERE username = '$username' AND password = '$password'";
            
            #Queries to database server
            $result = mysqli_query($conn, $query);
            
            #Server responds
            if (!$result) {
                echo "<p>Something is wrong with $query.</p>";
            } else if (!mysqli_fetch_array($result)) {
                echo "<p>Wrong credentials. Access denied.</p>";
            } else {
                session_start();
                $_SESSION["login"] = true;
                $_SESSION["username"] = $username;
                header("location: manage.php");
            }
            mysqli_free_result($result);
            mysqli_close($conn);
        }
    }
    authenticate();
?>
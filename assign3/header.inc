<?php
    function createHeader() {
        session_start();
        echo "
            <header>\n
                <nav>\n
                    <ul>\n
                        <li id=\"toggler\">\n
                            <!-- Dark mode toggler -->\n
                            <label for=\"toggleMode\" id=\"toggleDark\"><span class=\"material-icons md-32\">toggle_off</span><span class=\"material-icons md-32\">dark_mode</span></label>\n
                            <label for=\"toggleMode\" id=\"toggleLight\"><span class=\"material-icons md-32\">toggle_on</span><span class=\"material-icons md-32\">light_mode</span></label>\n
                        </li>\n";
        if (isset($_SESSION["login"])) {
            echo "<li><a href=\"lib/logout.php\">Log out</a></li>\n";
            echo "<li><a href=\"manage.php\">Manage</a></li>\n";
        } else {
            echo "<li><a href=\"login.php\">Manage</a></li>\n";
        }
        echo "
                        <li><a href=\"enhancements.php\">Enhancements</a></li>\n
                        <li><a href=\"quiz.php\">Quiz</a></li>\n
                        <li><a href=\"topic.php\">Topic</a></li>\n
                        <li><a href=\"index.php\">Home</a></li>\n
                        <li><a href=\"https://youtu.be/1NSN55hGJ10\" rel=\"noreferrer noopener\"><img alt=\"youtube button\" class=\"youtube\" src=\"images/youtube.png\"/></a></li>\n
                    </ul>\n
                </nav>\n
            </header>
        ";
    }
?>
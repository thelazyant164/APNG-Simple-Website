<?php
    function createHeader() {
        echo "
            <header>\n
                <nav>\n
                    <ul>\n
                        <li id=\"toggler\">\n
                            <!-- Dark mode toggler -->\n
                            <label for=\"toggleMode\" id=\"toggleDark\"><span class=\"material-icons md-32\">toggle_off</span><span class=\"material-icons md-32\">dark_mode</span></label>\n
                            <label for=\"toggleMode\" id=\"toggleLight\"><span class=\"material-icons md-32\">toggle_on</span><span class=\"material-icons md-32\">light_mode</span></label>\n
                        </li>\n
                        <li><a href=\"enhancements.php\" target=\"_blank\">Enhancements</a></li>\n
                        <li><a href=\"quiz.php\" target=\"_blank\">Quiz</a></li>\n
                        <li><a href=\"topic.php\" target=\"_blank\">Topic</a></li>\n
                        <li><a href=\"index.php\" target=\"_blank\">Home</a></li>\n
                        <li><a href=\"https://youtu.be/1NSN55hGJ10\" target=\"_blank\" rel=\"noreferrer noopener\"><img alt=\"youtube button\" class=\"youtube\" src=\"images/youtube.png\"/></a></li>\n
                    </ul>\n
                </nav>\n
            </header>
        ";
    }
?>
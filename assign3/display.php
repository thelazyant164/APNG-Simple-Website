<?php
    #Helper functions to display total grades, individual component grades as well as
    #correct answers when a user has exceeded their maximum attempt count
    function display_total_grade($submission) {
        echo "
            <h3>Your grades:</h3>\n
            <p>\n
                ", $submission['score'], "/100 - ", $submission['score']/100, "%\n
            </p>\n
            <p>\n
                Pie chart representing score components for each question - JPgraph\n
            </p>\n
        ";
    }
    function display_grades($submission) {
        echo "<h3>How did you do?</h3>\n";
        if ($submission['score'] == 100) {
            echo "<p>You were excellent!</p>\n";
        } else if ($submission['score'] >= 70) {
            echo "<p>You did fine!</p>\n";
        } else if ($submission['score'] >= 50) {
            echo "<p>You passed.</p>\n";
        } else if ($submission['score'] >= 30) {
            echo "<p>You could have done better.</p>\n";
        } else {
            echo "<p>You failed!</p>\n";
        }
        echo "<h3>Overview:</h3>\n
            <ul>\n
                <li>Total: ", $submission['score'], "%</li>\n
                <li>For Question 1: ", $submission['scores']['score_answer1'], "/10</li>\n
                <li>For Question 2: ", $submission['scores']['score_answer2'], "/20</li>\n
                <li>For Question 3: ", $submission['scores']['score_answer3'], "/15</li>\n
                <li>For Question 4: ", $submission['scores']['score_answer4'], "/5</li>\n
                <li>For Question 5: ", $submission['scores']['score_answer5'], "/50</li>\n
            </ul>\n
        ";
    }
    function display_answers($submission) {
        if ($submission['attempt_no'] == 2) {
            echo "
                <section class=\"parallax parallax-bg\">\n
                    <h2>Answers</h2>\n
                </section>\n
                <section class=\"no-parallax\">\n
                    <p>Question 1: <span class=\"bold\">Transparency</span>
                    - Your answer was: <span class=\"bold\">", $submission['support_for'], "</span></p>\n
                    <p>Question 2: <span class=\"bold\">2004</span>
                    - Your answer was: <span class=\"bold\">", $submission['year_developed'], "</span></p>\n
                    <p>Question 3: <span class=\"bold\">Mozilla</span>
                    - Your answer was: <span class=\"bold\">", $submission['developer'], "</span></p>\n
                    <p>Question 4: <span class=\"bold\">Chrome, Edge, Opera</span>
                    - Your answer was: <span class=\"bold\">", $submission['browser_support'], "</span></p>\n
                    <p>Question 5: <span class=\"bold\">Animated Portable Network Graphics</span>
                    - Your answer was: <span class=\"bold\">", $submission['long_name'], "</span></p>\n
                </section>\n
            ";
        }
    }
?>
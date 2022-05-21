<?php
    #Helper functions to display total grades, individual component grades as well as
    #correct answers when a user has exceeded their maximum attempt count
    function display_total_grade($submission) {
        echo "
            <h3>Your grades:</h3>\n
            <p>\n
                ", $submission['score'], "/100 - ", $submission['score'], "%\n
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
            <table>\n
                <tr>
                    <th>Total:</th>
                    <td>" , $submission['score'], "%</td>
                </tr>
                <tr>
                    <th>Question 1:</th>
                    <td>" , $submission['scores']['score_answer1'], "/10</td>
                </tr>
                <tr>
                    <th>Question 2:</th>
                    <td>" , $submission['scores']['score_answer2'], "/20</td>
                </tr>
                <tr>
                    <th>Question 3:</th>
                    <td>" ,$submission['scores']['score_answer3'], "/15</td>
                </tr>
                <tr>
                    <th>Question 4:</th>
                    <td>",$submission['scores']['score_answer4'], "/5 </td>
                </tr>
                <tr>
                    <th>Question 5:</th>
                    <td>", $submission['scores']['score_answer5'], "/50</td>
                </tr>
            </table>\n
        ";
    }
    function display_answers($submission) {
        if ($submission['attempt_no'] == 2) {
            echo "
                <section class=\"parallax parallax-bg\">\n
                    <h2>Answers</h2>\n
                </section>\n
                <section class=\"no-parallax\">\n
                    <h3>Below are side-by-side comparisons of correct answers and what you inputted on your second attempt:</h3>\n
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
    function display_retry_prompt($submission) {
        if ($submission['attempt_no'] == 1) {
            echo "
                <h3>Would you like to <a href=\"quiz.php\">try again?</a></h3>
            ";
        }
    }
?>
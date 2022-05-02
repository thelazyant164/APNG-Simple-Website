<?php
    #Helper functions to display total grades, individual component grades as well as
    #correct answers when a user has exceeded their maximum attempt count
    function display_total_grade() {
        echo "
            <h3>Your grades:</h3>\n
            <p>\n
                100/100 - 100%\n
            </p>\n
            <p>\n
                Pie chart representing score components for each question\n
            </p>\n
        ";
    }
    function display_grades() {
        echo "
            <h3>How did you do?</h3>\n
            <p>\n
                You performed poorly...\n
            </p>\n
            <h3>Overview:</h3>\n
            <ol>\n
                <li>Total: 2/5</li>\n
                <li>For Question 1: 3/5</li>\n
                <li>For Question 2: 1/5</li>\n
                <li>For Question 3: 2/5</li>\n
                <li>For Question 4: 5/5</li>\n
                <li>For Question 5: 0/5</li>\n
            </ol>\n
        ";
    }
    function display_answers($attempt_no) {
        if ($attempt_no == 2) {
            echo "
                <section class=\"parallax parallax-bg\">\n
                    <h2>Answers</h2>\n
                </section>\n
                <section class=\"no-parallax\">\n
                    <p>Question 1: Transparency</p>\n
                    <p>Question 2: 2004</p>\n
                    <p>Question 3: Mozilla</p>\n
                    <p>Question 4: Chrome, Edge, Opera</p>\n
                    <p>Question 5: Animated Portable Network Graphics</p>\n
                </section>\n
            ";
        }
    }
?>
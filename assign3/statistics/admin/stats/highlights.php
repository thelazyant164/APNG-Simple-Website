<?php
    #Highlights table for queryresults.php
    require('statistics/admin/adminprestatistics.php');
    $retrieved_data = retrieve_data("env/settings.php");

    function average($arr) {
        if (count($arr) == 0) {
            return 0;
        }
        return array_sum($arr)/count($arr);
    }
    echo "<table>\n
        <tr>\n
            <th>Highlights</th>\n
            <th>Values</th>\n
        </tr>\n
        <tr>\n
            <td>Average score for all attempts</td>\n
            <td>" . round(average($retrieved_data["all_scores"], 2)) . "</td>\n
        </tr>\n
        <tr>\n
            <td>Average score for first attempts</td>\n
            <td>" . round(average($retrieved_data["all_attempt1_scores"], 2)) . "</td>\n
        </tr>\n
        <tr>\n
            <td>Number of students who attempted quiz</td>\n
            <td>" . count($retrieved_data["all_attempt1_scores"], 2) . "</td>\n
        </tr>\n
        <tr>\n
            <td>Average score for second attempts</td>\n
            <td>" . round(average($retrieved_data["all_attempt2_scores"], 2)) . "</td>\n
        </tr>\n
        <tr>\n
            <td>Number of students who attempted quiz a second time</td>\n
            <td>" . count($retrieved_data["all_attempt2_scores"]) . "</td>\n
        </tr>\n
    </table>\n";
?>
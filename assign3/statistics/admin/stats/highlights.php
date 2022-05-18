<?php
    #Highlights table for queryresults.php
    require_once('statistics/admin/adminprestatistics.php');
    function average($arr) {
        return array_sum($arr)/count($arr);
    }
    function hardest($arr) {
        return array_search(min($arr), $arr) + 1;
    }
    function easiest($arr) {
        return array_search(max($arr), $arr) + 1;
    }
    $easiest_question = easiest([
        average(array_merge($all_attempt1_question1_scores, $all_attempt2_question1_scores)),
        average(array_merge($all_attempt1_question2_scores, $all_attempt2_question2_scores)),
        average(array_merge($all_attempt1_question3_scores, $all_attempt2_question3_scores)),
        average(array_merge($all_attempt1_question4_scores, $all_attempt2_question4_scores)),
        average(array_merge($all_attempt1_question5_scores, $all_attempt2_question5_scores)),
    ]);
    $hardest_question = hardest([
        average(array_merge($all_attempt1_question1_scores, $all_attempt2_question1_scores)),
        average(array_merge($all_attempt1_question2_scores, $all_attempt2_question2_scores)),
        average(array_merge($all_attempt1_question3_scores, $all_attempt2_question3_scores)),
        average(array_merge($all_attempt1_question4_scores, $all_attempt2_question4_scores)),
        average(array_merge($all_attempt1_question5_scores, $all_attempt2_question5_scores)),
    ]);
    echo "<table>\n
        <tr>\n
            <th>Highlights</th>\n
            <th>Values</th>\n
        </tr>\n
        <tr>\n
            <td>Average score for first attempts</td>\n
            <td>" . average($all_attempt1_scores) . "</td>\n
        </tr>\n
        <tr>\n
            <td>Average score for second attempts</td>\n
            <td>" . average($all_attempt2_scores) . "</td>\n
        </tr>\n
        <tr>\n
            <td>Average score for all attempts</td>\n
            <td>" . average($all_scores) . "</td>\n
        </tr>\n
        <tr>\n
            <td>Hardest question</td>\n
            <td>Question" . $easiest_question . "</td>\n
        </tr>\n
        <tr>\n
            <td>Easiest question</td>\n
            <td>Question" . $hardest_question . "</td>\n
        </tr>\n
    </table>\n";
?>
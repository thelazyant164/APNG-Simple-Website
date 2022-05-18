<?php
    #Plot linegraph for each question, for adminstatistics.php
    require_once('../../../jpgraph/jpgraph.php');
    require_once('../../../jpgraph/jpgraph_line.php');
    require_once('../adminprestatistics.php');
    
    $mergedarray1 = [];
    $mergedarray2 = [];
    // attempt 1
    $q1_avg1 = array_sum($all_attempt1_question1_scores)/count($all_attempt1_question1_scores);
    $q2_avg1 = array_sum($all_attempt1_question2_scores)/count($all_attempt1_question2_scores);
    $q3_avg1 = array_sum($all_attempt1_question3_scores)/count($all_attempt1_question3_scores);
    $q4_avg1 = array_sum($all_attempt1_question4_scores)/count($all_attempt1_question4_scores);
    $q5_avg1 = array_sum($all_attempt1_question5_scores)/count($all_attempt1_question5_scores);
    array_push($mergedarray1, $q1_avg1, $q2_avg1, $q3_avg1, $q4_avg1, $q5_avg1);
    
    // attempt 2
    $q1_avg2 = array_sum($all_attempt2_question1_scores)/count($all_attempt2_question1_scores);
    $q2_avg2 = array_sum($all_attempt2_question2_scores)/count($all_attempt2_question2_scores);
    $q3_avg2 = array_sum($all_attempt2_question3_scores)/count($all_attempt2_question3_scores);
    $q4_avg2 = array_sum($all_attempt2_question4_scores)/count($all_attempt2_question4_scores);
    $q5_avg2 = array_sum($all_attempt2_question5_scores)/count($all_attempt2_question5_scores);
    array_push($mergedarray2, $q1_avg2, $q2_avg2, $q3_avg2, $q4_avg2, $q5_avg2);

    $ydata = $mergedarray1;
    $y2data = $mergedarray2;
    
    // Create the graph and specify the scale for both Y-axis
    $graph = new Graph(600,300);
    $graph->SetScale('textlin');
    $graph->SetY2Scale('lin');
    $graph->SetShadow();
    $graph->yaxis->scale->SetAutoMax(100);
    
    // Adjust the margin
    $graph->img->SetMargin(40,40,20,40);
    
    // Create the two linear plot
    $lineplot=new LinePlot($ydata);
    $lineplot2=new LinePlot($y2data);
    
    // Add the plot to the graph
    $graph->Add($lineplot);
    $graph->AddY2($lineplot2);
    $lineplot2->SetColor('orange');
    $lineplot2->SetWeight(2);
    
    // Adjust the axis color
    $graph->y2axis->SetColor('orange');
    $graph->yaxis->SetColor('blue');
    
    $graph->title->Set('Average Score for Each Question Per Attempt');
    $graph->xaxis->title->Set('Question Number');
    $graph->yaxis->title->Set('Average Score');
    
    $graph->title->SetFont(FF_FONT1,FS_BOLD);
    $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
    $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
        
    // Set the colors for the plots
    $lineplot->SetColor('blue');
    $lineplot->SetWeight(2);
    $lineplot2->SetColor('orange');
    $lineplot2->SetWeight(2);
    $lineplot->SetLegend('Attempt 1');
    $lineplot2->SetLegend('Attempt 2');
    // $lineplot->SetCenter();
    $lineplot2->SetCenter();
    
    // Set the legends for the plots
    
    // Adjust the legend position
    $graph->legend->Pos(0.0,0.5,'right','bottom');
    
    // Display the graph
    $graph->Stroke();
?>
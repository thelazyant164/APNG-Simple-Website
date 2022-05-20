<?php
    #Plot linegraph for overall score, for adminstatistics.php
    require('../../../jpgraph/jpgraph.php');
    require('../../../jpgraph/jpgraph_line.php');
    require('../adminprestatistics.php');
    $retrieved_data = retrieve_data("../../../env/settings.php");

    $ydata = $retrieved_data["all_attempt1_scores"];
    $y2data = $retrieved_data["all_attempt2_scores"];
    if (count($ydata) == 0) {
        $ydata = [0];
    }
    if (count($y2data) == 0) {
        $y2data = [0];
    }
    
    // Create the graph. These two calls are always required
    $graph = new Graph(400,300);    
    $graph->img->SetMargin(40,40,20,40);
    $graph->SetScale("textlin");
    $graph->SetY2Scale("lin",0,100);
    $graph->SetShadow();
    // $graph->xaxis->scale->SetAutoMin(0);
    // $graph->yaxis->scale->SetAutoMax(100);
    
    // Create the linear plot
    $lineplot=new LinePlot($ydata);
    $lineplot2=new LinePlot($y2data);
    
    // Add the plot to the graph
    $graph->Add($lineplot);
    $graph->AddY2($lineplot2);
    $graph->y2axis->SetColor("orange");
    
    $graph->title->Set("All Scores, Attempt 1 & 2");
    $graph->xaxis->title->Set("Submission #");
    $graph->yaxis->title->Set("Score");
    
    $graph->title->SetFont(FF_FONT1,FS_BOLD);
    $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
    $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
    
    $lineplot->SetColor("blue");
    $lineplot->SetWeight(2);
    
    $lineplot2->SetColor("orange");
    $lineplot2->SetWeight(2);
    
    $graph->yaxis->SetColor("blue");
    
    $lineplot->SetLegend('Attempt 1');
    $lineplot2->SetLegend('Attempt 2');
    $graph->legend->Pos(0.0,0.5,'right','bottom');

    // Display the graph
    $graph->Stroke();
?>
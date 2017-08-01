<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CISC 662 Course Project - Nathan Rague</title>

    <!-- Declare CSS -->
    <link rel="stylesheet" href="/css/api/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/api/docs/docs.css">
</head>
<body data-spy="scroll" data-target="#myScrollspy" data-offset="200">

<div class="container">
    <div class="row">
        <nav class="col-sm-3" style="position:relative;">
            <div  id="myScrollspy">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="#introduction">Introduction</a></li>
                    <li><a href="#project_info">Project Info</a></li>
                    <li><a href="#datasets">Data Sets</a></li>
                </ul>
            </div>
        </nav>
        <div class="col-sm-9">
            <div id="introduction" class="function">
                <h1 class="page-header">Introduction</h1>

                <div class="row">
                    <div class="col-xs-12">
                        <p class="double-text">
                        This page outlines the resources used in a project created for CISC 662, Data Mining and KDD at NOVA
                        Southeastern University in the 2017 Summer I term.
                        The purpose of this project was to use the K-Nearest Neighbor classify to accurately detect
                        the presence of malicious web traffic using bigram frequencies of HTTP GET URLs in web logs. This project
                        is the culmination of 87 programming hours by Nathan Rague for the classes's term project.
                        </p>
                    </div>
                </div>
            </div>

            <div id="project_info" class="function">
                <h1 class="page-header">Project Info & Execution</h1>

                <div class="row" style="margin-top: 2em;">
                    <div class="col-xs-4">
                        <h4>Source Code</h4>
                        <p>The view the source code please click "Source Code" below. Relevant function are in
                         the application/controllers directory.</p>

                        <p>
                            <a target="_blank" href="https://github.com/sharktek-nathan/CISC-662-Term-Project">View Source Code</a>
                        </p>
                    </div>
                    <div class="col-xs-4">
                        <h4>Run Classifier</h4>
                        <p>To run the classifier yourself and view of a summary of its performance,
                            please click "Run KNN Classifier".</p>
                    </div>
                    <div class="col-xs-4">
                        <h4>Server Configuration:</h4>
                        <p>To view the server's architecture and config, please click "Server Info" below:</p>

                        <p>
                            <a target="_blank" href="/resources/serverInfo/">Server Info</a>
                        </p>

                    </div>
                </div>

                <div class="row" style="margin: 2em 1em; border: 2px dashed #b9b9d4; padding: 2em;">
                    <div class="col-xs-12 text-center" >
                        <a target="_blank" href="/performance/" style="font-size: 2em; font-weight: 200;">Run KNN Classifier</a><br>
                        <small><strong>Please allow 3-5 minutes of execution time</strong></small>
                    </div>
                </div>

            </div>

            <div id="datasets" class="function">
                <h1 class="page-header">Data Sets</h1>

                <div class="row">
                    <div class="col-xs-12">
                        <p class="double-text">The following section includes the original apache web log files, parsed HTTP files and the
                            resulting generated training and testing data sets. The training data set is comprised of
                            2000 labeled lines of which the first 1000 are labeled malicious and the remaining 1000 are labeled normal.
                            The testing data set contains 1000 lines of testing bigrams of which the first 500 are unlabeled normal
                            records and the second 500 lines are unlabeled malicious records.
                        </p>
                        <div class="row file-row">
                            <div class="col-xs-6">
                                <h4>HTTP Dataset CSIC 2010 - Normal Traffic</h4>
                                <a target="_blank" href="/resources/downloadFile/normalTrafficTest.txt">normalTrafficTest.txt (19.6MB)</a>
                            </div>
                            <div class="col-xs-6">
                                <h4>HTTP Dataset CSIC 2010 - Malicious Traffic</h4>
                                <a target="_blank" href="/resources/downloadFile/anomalousTrafficTest.txt">anomalousTrafficTest.txt (15.3MB)</a>
                            </div>
                        </div>

                        <div class="row file-row">
                            <div class="col-xs-6">
                                <h4>Parsed Log Files for Normal HTTP GETs:</h4>
                                <a target="_blank" href="/resources/downloadFile/parsed_normal1.txt">parsed_normal1.txt (1.1MB)</a>
                            </div>
                            <div class="col-xs-6">
                                <h4>Parsed Log Files for Malicious HTTP GETs:</h4>
                                <a target="_blank" href="/resources/downloadFile/parsed_malicious1.txt">parsed_malicious1.txt (1.4MB)</a>
                            </div>
                        </div>

                        <div class="row file-row">
                            <div class="col-xs-6">
                                <h4>Training Data (2000 Lines):</h4>
                                <a target="_blank" href="/resources/downloadFile/TrainingSet_Final5000.csv">TrainingSet_Final5000.csv (3.8MB)</a>
                            </div>
                            <div class="col-xs-6">
                                <h4>Testing Data (1000 Lines):</h4>
                                <a target="_blank" href="/resources/downloadFile/TestSet_both500.txt">TestSet_both500.txt (2.0MB)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/api/jquery-2.1.3.js"></script>
<script src="/js/api/bootstrap/bootstrap.min.js"></script>
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?skin=desert"></script>

<script>
    $( document ).ready(function() {

    });
</script>

</body>

</html>

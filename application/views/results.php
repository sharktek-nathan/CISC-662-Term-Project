<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CISC 662 Course Project - Nathan Rague</title>

    <!-- Declare CSS -->
    <link rel="stylesheet" href="/css/api/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/api/docs/docs.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="page-header">
            <h2>KNN Classifier
                <small>Performance Summary over <?php echo $time; ?> seconds</small>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3>Confusion Matrix</h3>
        </div>
        <div class="col-xs-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Classes</th>
                        <th>is_normal = yes <br> (Predicted)</th>
                        <th>is_normal = no <br> (Predicted)</th>
                        <th>Total</th>
                        <th>Recognition Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>is_normal = yes <br> (Actual)</td>
                        <td><?php echo $tp; ?></td>
                        <td><?php echo $fn; ?></td>
                        <td><?php echo $p; ?></td>
                        <td><?php echo $sensitivity; ?></td>
                    </tr>
                    <tr>
                        <td>is_normal = no <br> (Actual)</td>
                        <td><?php echo $fp; ?></td>
                        <td><?php echo $tn; ?></td>
                        <td><?php echo $n ?></td>
                        <td><?php echo $specificity; ?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><?php echo $tp + $fp; ?></td>
                        <td><?php echo $fn + $tn;?></td>
                        <td><?php echo $p + $n;?></td>
                        <td><?php echo $accuracy; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row" style="margin-top: 2em;">
        <div class="col-xs-12">
            <h3>Other Performance Factors</h3>
        </div>
        <div class="col-xs-12">
            <p>Error Rate   : <?php echo $error_rate; ?></p>
            <p>Precision    : <?php echo $precision; ?></p>
            <p>F1 Score     : <?php echo $f1_score; ?></p>
        </div>
    </div>
</div>

<script src="/js/api/jquery-2.1.3.js"></script>
<script src="/js/api/bootstrap/bootstrap.min.js"></script>
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?skin=desert"></script>

</body>

</html>

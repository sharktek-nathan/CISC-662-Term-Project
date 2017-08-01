<?php
defined('BASEPATH') OR exit('No direct script access allowed');

# Import ML Lib
require_once('/www/identitack/php-ml/vendor/autoload.php');
use Phpml\Dataset\CsvDataset;
use Phpml\Classification\KNearestNeighbors;

class Performance extends CI_Controller {

    public function index() {

        # Allow PHP to execute for up to 5 minutes
        set_time_limit(300);
        $time_start = time();

        #################################################
        #      Get Training & Testing Data Sets         #
        #################################################

        $data_set = new CsvDataset('/www/identitack/samples/TrainingSet_Final5000.csv', 1000, true);

        # Invoke the classifier and provide training data set
        $classifier = new KNearestNeighbors(2);
        $classifier->train($data_set->getSamples(), $data_set->getTargets());

        # Open the testing data set
        $file = new SplFileObject("/www/identitack/samples/TestSet_both500.txt");

        $TP = 0;
        $TN = 0;
        $FP = 0;
        $FN = 0;

        # Loop until we reach the end of the file.
        $i = 0;
        while (!$file->eof()) {
            $result = $classifier->predict(explode(',', $file->fgets())) . "<br>";

            if($i < 499) {
                if(strpos((String)$result, 'norm') !== false) {
                    $TP++;
                } else {
                    $FN++;
                }
            } else {
                if(strpos((String)$result, 'norm') !== false) {
                    $FP++;
                } else {
                    $TN++;
                }
            }

            $i++;
            if($i > 999) { break; }

        }

        #################################################
        #      Calculate Performance & Benchmarks       #
        #################################################

        # Get benchmarks & performance
        $total_time     = time() - $time_start;
        $P = 500;
        $N = 500;

        # Accuracy & Error Rate
        $accuracy       = ($TP + $TN) / ($P + $N);
        $error_rate     = ($FN + $FP) / ($P + $N);

        # Sensitivity & Specificity & Precision
        $sensitivity    = $TP / $P;
        $specificity    = $TN / $N;
        $precision      = $TP / ($TP + $FP);

        # F1 SCore
        $F1             = 2 * $precision * $sensitivity / ($precision + $sensitivity);

        $summary = array(
            'p'             => $P,
            'n'             => $N,
            'tp'            => $TP,
            'tn'            => $TN,
            'fp'            => $FP,
            'fn'            => $FN,
            'accuracy'      => $accuracy,
            'error_rate'    => $error_rate,
            'sensitivity'   => $sensitivity,
            'specificity'   => $specificity,
            'precision'     => $precision,
            'f1_score'      => $F1,
            'time'          => $total_time
        );

        $this->load->view('results',$summary);

    }

}

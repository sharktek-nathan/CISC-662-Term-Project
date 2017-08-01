<?php
defined('BASEPATH') OR exit('No direct script access allowed');

# Import ML Lib
require_once('/www/identitack/php-ml/vendor/autoload.php');
use Phpml\Dataset\CsvDataset;

class Reduction extends CI_Controller {


    public function reduceMalicious() {

        $data_set = new CsvDataset('/www/identitack/samples/TrainingSet2.csv', 2704, true);
        $samples = $data_set->getSamples();


        $highest_features = array();

        foreach($samples as $record) {

            foreach($record as $key => $frequency) {

                if($frequency > 1) { continue;}

                if(array_key_exists($key, $highest_features)) {
                    $highest_features[$key] = $highest_features[$key] + $frequency;
                } else {
                    $highest_features[$key] = $frequency;
                }

            }
        }

        foreach($highest_features as $k => $v) {
            $highest_features[$k] = $v / count($samples);
        }

        echo count($samples);


        # Open File
        $training_file = fopen("/www/identitack/samples/Compares.csv", "w+") or die("Unable to open file!");
        fputcsv($training_file, $highest_features);


        echo "<pre>" . print_r($highest_features, TRUE) . "</pre>"; die;



    }

    public function reduceNormal() {

        $data_set = new CsvDataset('/www/identitack/samples/NormalSetDelete.csv', 2704, true);
        $samples = $data_set->getSamples();


        $highest_features = array();

        foreach($samples as $record) {

            foreach($record as $key => $frequency) {

                if($frequency > 1) { continue;}

                if(array_key_exists($key, $highest_features)) {
                    $highest_features[$key] = $highest_features[$key] + $frequency;
                } else {
                    $highest_features[$key] = $frequency;
                }

            }
        }

        foreach($highest_features as $k => $v) {
            $highest_features[$k] = $v / count($samples);
        }

        echo count($samples);

        # Open File
        $training_file = fopen("/www/identitack/samples/Compares.csv", "a") or die("Unable to open file!");
        fputcsv($training_file, $highest_features);


        echo "<pre>" . print_r($highest_features, TRUE) . "</pre>"; die;

    }


    function compare() {


        ini_set('auto_detect_line_endings',TRUE);
        $handle = fopen('/www/identitack/samples/Compares.csv','r');
        $line = 1;
        while ( ($data = fgetcsv($handle) ) !== FALSE ) {
            if($line === 1) {
                $malicious = $data;
            } else {
                $normal = $data;
                break;
            }
            $line++;
        }
        ini_set('auto_detect_line_endings',FALSE);

        $compares = array();
        foreach($malicious as $k => $v) {
            $compares[$k] = $v - $normal[$k];
        }

        arsort($compares);
        echo "<pre>" . print_r($compares, TRUE) . "</pre>"; die;


        $training_file = fopen("/www/identitack/samples/TopKeys1000.csv", "a") or die("Unable to open file!");


        $top_keys = array();

        $count = 1;
        foreach($compares as $k => $v) {
            $top_keys[] = $k;
            $count++;
            if($count > 1000) { break;}
        }

        fputcsv($training_file, $top_keys);


    }





}

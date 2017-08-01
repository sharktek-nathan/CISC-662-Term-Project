<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Test extends CI_Controller
{


    public function index()
    {

    }

    public function parseNormalData()
    {

        #################################################
        #                Read Normal Log            #
        #################################################

        $get_captures = array();
        $file = new SplFileObject("/www/identitack/samples/normalTrafficTest.txt");

        # Loop until we reach the end of the file.
        while (!$file->eof()) {
            // Parse line by line for
            if (preg_match("/GET\s*https?:\/\/.*\/(.*?)\s*HTTP/", $file->fgets(), $output_array)) {
                if (isset($output_array[1]) && !empty($output_array[1])) # Do not get blanks
                    $get_captures[] = $output_array[1];
            }
        }

        # Verify at least one sample was found
        if (count($get_captures) < 1) {
            exit('failed to parse');
        }

        #################################################
        #           Write Normal Data to File        #
        #################################################

        # Open file in overwrite, create mode
        $parsed_file = fopen("/www/identitack/samples/parsed_normal1.txt", "w+") or die("Unable to open file!");

        # Write each line to the file
        foreach ($get_captures as $get) {
            fwrite($parsed_file, $get . "\n");
        }

        # Close the file
        fclose($parsed_file);

    }

    public function parseMaliciousData()
    {

        #################################################
        #                Read Malicious Log            #
        #################################################

        $get_captures = array();
        $file = new SplFileObject("/www/identitack/samples/anomalousTrafficTest.txt");

        # Loop until we reach the end of the file.
        while (!$file->eof()) {
            // Parse line by line for
            if (preg_match("/GET\s*https?:\/\/.*\/(.*?)\s*HTTP/", $file->fgets(), $output_array)) {
                if (isset($output_array[1]) && !empty($output_array[1])) # Do not get blanks
                    $get_captures[] = $output_array[1];
            }
        }

        # Verify at least one sample was found
        if (count($get_captures) < 1) {
            exit('failed to parse');
        }

        #################################################
        #           Write Malicious Data to File        #
        #################################################

        # Open file in overwrite, create mode
        $parsed_file = fopen("/www/identitack/samples/parsed_malicious1.txt", "w+") or die("Unable to open file!");

        # Write each line to the file
        foreach ($get_captures as $get) {
            fwrite($parsed_file, $get . "\n");
        }

        # Close the file
        fclose($parsed_file);

    }


    private function genCharCount($string)
    {
        if (strlen($string) < 1) {
            return FALSE;
        }

        $char_frequency = $this->genCharMap();

        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 2);
            if (!array_key_exists($char, $char_frequency)) {
                continue;
            }
            $char_frequency[$char] = $char_frequency[$char] + 1;
        }

        $ret_array = array();
        foreach ($char_frequency as $char_count) {
            $ret_array[] = $char_count;
        }

        return $ret_array;
    }

    private function genCharMap()
    {

        $char_frequency = array();
        for ($i = 33; $i <= 126; $i++) {
            $char1 = chr($i);

            if (preg_match("/[^a-z0-9-._?@!$\"'()*+,;=]/", $char1)) {
                continue;
            }

            for ($j = 33; $j <= 126; $j++) {
                $char2 = chr($j);

                if (preg_match("/[^a-z0-9-._?@!$\"'()*+,;=]/", $char2)) {
                    continue;
                }

                $char_frequency[$char1 . $char2] = 0;
            }


        }

        return $char_frequency;
    }

    public function writeTrainingData()
    {

        set_time_limit(300);

        #################################################
        #                Get Top  500 Keys              #
        #################################################
        $handle = fopen('/www/identitack/samples/TopKeys1000.csv', 'r');
        while (($data = fgetcsv($handle)) !== FALSE) {
            $top500 = $data;
        }

        fclose($handle);

        #################################################
        #               Read Malicious Data            #
        #################################################
        $malicious_results = array();
        $file1 = new SplFileObject("/www/identitack/samples/parsed_malicious1.txt");

        // Loop until we reach the end of the file.
        $i = 0;
        while (!$file1->eof()) {
            $malicious_results[$i] = $this->genCharCount($file1->fgets());
            $i++;
            if (count($malicious_results) >= 1000) {
                break;
            }
        }


        #################################################
        #               Read Normal Data            #
        #################################################
        $normal_results = array();
        $file2 = new SplFileObject("/www/identitack/samples/parsed_normal1.txt");

        // Loop until we reach the end of the file.
        $i = 0;
        while (!$file2->eof()) {
            $normal_results[$i] = $this->genCharCount($file2->fgets());
            $i++;
            if (count($normal_results) >= 1000) {
                break;
            }
        }


        #################################################
        #                 Drop Crap Keys                #
        #################################################

        $j = 0;
        foreach ($malicious_results as $mal_record) {
            foreach ($mal_record as $k => $v) {
                if (!in_array($k, $top500)) {
                    unset($malicious_results[$j][$k]);
                }
            }
            $malicious_results[$j][] = 'malicious';
            $j++;
        }


        $j = 0;
        foreach ($normal_results as $norm_record) {
            foreach ($norm_record as $k => $v) {
                if (!in_array($k, $top500)) {
                    unset($normal_results[$j][$k]);
                }
            }
            $normal_results[$j][] = 'normal';
            $j++;
        }


        #################################################
        #         Write Both Data Sets to File          #
        #################################################

        # Open File
        $training_file = fopen("/www/identitack/samples/TrainingSet_Final5000.csv", "w+") or die("Unable to open file!");

        # Generate Headers && Write Headers
        $header = array_keys($this->genCharMap());
        foreach ($header as $k => $v) {
            if (!in_array($k, $top500)) {
                unset($header[$k]);
            }
        }

        $header[] = 'class_label';
        fputcsv($training_file, $header);

        # Write Malicious Data Set
        foreach ($malicious_results as $data) {
            fputcsv($training_file, $data);
        }

        # Write Normal Data Set
        foreach ($normal_results as $data) {
            fputcsv($training_file, $data);
        }

        fclose($training_file);

    }


    public function writeTestData()
    {

        set_time_limit(300);

        #################################################
        #                Get Top  500 Keys              #
        #################################################
        $handle = fopen('/www/identitack/samples/TopKeys1000.csv', 'r');
        while (($data = fgetcsv($handle)) !== FALSE) {
            $top500 = $data;
        }

        fclose($handle);


        #################################################
        #               Read Malicious Data             #
        #################################################
        $malicious_results = array();
        $file2 = new SplFileObject("/www/identitack/samples/parsed_malicious2.txt");

        // Loop until we reach the end of the file.
        $i = 0;
        while (!$file2->eof()) {
            $malicious_results[$i] = $this->genCharCount($file2->fgets());
            $i++;
            if (count($malicious_results) >= 500) {
                break;
            }
        }


        #################################################
        #               Read Normal Data               #
        #################################################
        $normal_results = array();
        $file2 = new SplFileObject("/www/identitack/samples/parsed_normal2.txt");

        // Loop until we reach the end of the file.
        $i = 0;
        while (!$file2->eof()) {
            $normal_results[$i] = $this->genCharCount($file2->fgets());
            $i++;
            if (count($normal_results) >= 500) {
                break;
            }
        }

        #################################################
        #                 Drop Crap Keys                #
        #################################################
        $j = 0;
        foreach ($normal_results as $norm_record) {
            foreach ($norm_record as $k => $v) {
                if (!in_array($k, $top500)) {
                    unset($normal_results[$j][$k]);
                }
            }
            $j++;
        }

        $j = 0;
        foreach ($malicious_results as $mal_record) {
            foreach ($mal_record as $k => $v) {
                if (!in_array($k, $top500)) {
                    unset($malicious_results[$j][$k]);
                }
            }
            $j++;
        }


        #################################################
        #              Write Normal Data Set            #
        #################################################


        # Open File
        $training_file = fopen("/www/identitack/samples/TestSet_both500.txt", "w+") or die("Unable to open file!");

        # Write Normal Data Set
        foreach ($normal_results as $data) {
            fwrite($training_file, implode(',', $data) . "\n");

        }

        # Write Normal Data Set
        foreach ($malicious_results as $data) {
            fwrite($training_file, implode(',', $data) . "\n");

        }

        fclose($training_file);
    }


}
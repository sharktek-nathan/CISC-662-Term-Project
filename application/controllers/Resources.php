<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resources extends CI_Controller {


    public function __construct()
    {
        // On controller load, call  model
        parent::__construct();
        $this->load->helper('download');
    }


    public function downloadFile($filename) {

        $file_location = "/www/identitack/samples/" . $filename;
        force_download($file_location, NULL);

    }

    public function serverInfo() {
        phpinfo();
    }
}

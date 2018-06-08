<?php

class Fileuploader {
    public $errors = array();
    public $model = array();
    function __construct(){
        load_m_model($file = "Filesmod");
        $this->model = new Filesmod;
    }
    public function make($file = 'file', $author, $concern_place_id = "0", $concern_place = "express", $caption = ""){
        $config['upload_path'] = 'assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|gif|png';
        $config['max_size'] = '10098888787039';
        $config['max_width'] = '768888';
        $config['max_height'] = '768888';
        $config['encrypt_name'] = true;
        $config['remove_spaces'] = true;

        load_class($class="Upload", $directory = 'libraries', $param = NULL);
        $upload = new CI_Upload($config);
       if (!$upload->do_upload($file)) {
            $this->errors = array('error' => $upload->display_errors());

           //get the errors.....
            //print_r($this->errors);//looking how to get this bug fixed....need to ascribe to the property, $this->errors, to be returned
            return $this->errors;
       } else {
            $up_data = array('upload_data' => $upload->data());
            $store_id = $this->model->make(
                $file_name = $up_data['upload_data']['file_name'],
                $creator = $author,
                $size = $up_data['upload_data']['file_size'],
                $type = $up_data['upload_data']['image_type'],
                $concern_place_id,
                $concern_place,
                $caption
            );
           //check for ID presence and return it if present....
            if($store_id) {
                return $store_id;
            }else{
                return false;
            }
       }
    }
    public function make_and_return_file_name_without_file_id($file = 'file'){
        $config['upload_path'] = 'assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|gif|png';
        $config['max_size'] = '10098888787039';
        $config['max_width'] = '768888';
        $config['max_height'] = '768888';
        $config['encrypt_name'] = true;
        $config['remove_spaces'] = true;
        load_class($class="Upload", $directory = 'libraries', $param = NULL);
        $upload = new CI_Upload($config);
       if (!$upload->do_upload($file)) {
            $this->errors = array('error' => $upload->display_errors());
            return $this->errors;
       } else {
            $up_data = array('upload_data' => $upload->data());
            if($up_data) {
                return $up_data['upload_data']['file_name'];
            }
       }
    }
}
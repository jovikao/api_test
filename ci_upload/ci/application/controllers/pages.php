<?php

class Pages extends CI_Controller {

    public function view($page = 'home')
    {
        //$upload_dir = 'uploads/';
        $upload_dir = '/tmp/';
        $allowed_ext = array('jpg','jpeg','png','gif');

        $config['upload_path'] = '/tmp/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '512';
        $config['max_width']  = '1024';
        $config['max_height']  = '1024';

        $this->load->library('upload',$config);
        if ( ! $this->upload->do_upload('pic'))
        {
            $result = array('result' => $this->upload->display_errors());
        }
        else
        {
            error_log(print_r($this->upload->data(), true));
            $result = array('result' => $this->upload->data());
        }
        $this->load->view('upload_result', $result);
    }
}

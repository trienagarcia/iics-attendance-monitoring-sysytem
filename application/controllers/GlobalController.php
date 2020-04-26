<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GlobalController extends CI_Controller
{
    public function validateLogin()
    {
        // print("<pre>".print_r($this->input->post(),true)."</pre>");
        $email = (isset($_POST['email'])) ? $_POST['email'] : '';
        $password = (isset($_POST['password'])) ? $_POST['password'] : '';
        $login = $this->Global_model->get_data_with_query('person', '*', 'email ="' .$email. '" AND password="'.sha1($password).'"');

        // print("<pre>".print_r($login,true)."</pre>");

        if (count($login) > 0) {
            $user_info = $this->Global_model->get_data_with_query('person', '*', 'person_id ="' . $login[0]->person_id . '"');
            $this->session->set_userdata((array) ($login[0]));
            
            if($this->session->position_Id == 1 || $this->session->position_Id == 2) {
                echo json_encode(array('success' => true, 'message' => base_url().'time-logs'));
            }else{
                echo json_encode(array('success' => true, 'message' => base_url().'time-logs-user'));
            }

            // redirect(base_url().'home');
        } else {
            echo json_encode(array('success' => false, 'message' => 'Invalid username or password'));
        }
    }

}

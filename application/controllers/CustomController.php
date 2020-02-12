<?php
class CustomController extends CI_Controller
{

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function validatePassword()
    {
        $password = $_POST['password'];
        $isExist = $this->Global_model->get_data_with_query('users', 'id', 'password ="' . sha1($password) . '" AND username = "' . $this->session->userdata('username') . '"');
        if (count($isExist) > 0) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        echo json_encode(array('status' => $status));
    }

    public function getNewPassword()
    {
        $length = 6;
        $data['password'] = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);

        print_r(json_encode($data));
    }

    public function savePageContent()
    {
        $table = 'content_pages';
        $data = array(
            'short_description' => $this->input->post('short_description'),
            'content' => $this->input->post('content'),
            'status' => $this->input->post('status'),
        );
        $field = 'content_id';
        $where = $this->input->post('content_id');
        $response = $this->Global_model->update_data($table, $data, $field, $where);
    }

    public function addAccount()
    {
        $table = 'person';
        $courses = array($this->input->post('courses'));
        $courses_str = implode(",", $courses);
        $data = array(
            'email' => $this->input->post('email'),
            'password' => sha1($this->input->post('password')),
            'name' => $this->input->post('name'),
            'position_Id' => '2',
            'rfid_id' => $this->input->post('rfid'),
            'person_number' => $this->input->post('faculty_number')
        );

        $response = $this->Global_model->insert_data($table, $data);
        print_r(json_encode($response));
    }

    public function updatePassword()
    {
        $person_id = $this->session->userdata('person_id');
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $confirm_new_password = $this->input->post('confirm_new_password');
        $user = $this->Global_model->get_data_with_query('person', 'password', 'person_id =' . $person_id);
        if ($new_password == $confirm_new_password) {
            if (sha1($current_password) == $user[0]->password) {
                $table = 'person';
                $data = array('password' => sha1($confirm_new_password));
                $field = 'person_id';
                $where = $person_id;
                $response = $this->Global_model->update_data($table, $data, $field, $where);
                $result['message'] = "Password Successfully Changed";
                $result['status'] = "success";
            } else {
                $result['message'] = "Invalid Password";
                $result['status'] = "error";
            }

        } else {
            $result['message'] = "New password and confirm password does not match";
            $result['status'] = "error";
        }

        print_r(json_encode($result));
    }

    public function getAllAccounts()
    {
        $result = $this->Custom_model->get_all_users();
        print_r(json_encode($result));
    }

    public function addNewRequest()
    {
        $table = 'requests';
        $person_id = $this->session->userdata('person_id');
        $data = array(
            'request_date' => $this->input->post('date'),
            'person_id' => $person_id,
            'time_from' => $this->input->post('time_from'),
            'time_to' => $this->input->post('time_to'),
            'room_id' => $this->input->post('room'),
            'section_id' => $this->input->post('section'),
            'course_id' => $this->input->post('course'),
            'status_id' => 1
        );

        $response = $this->Global_model->insert_data($table, $data);
        print_r(json_encode($response));
    }

    public function checkIncomingRfid() {
        $this->load->helper("url");
        
        // you can change the location of your file wherever you want
        $json_obj = file_get_contents(base_url()."rfid_data.json");

        $rfid_data = json_decode($json_obj);
        $rfid_id = $rfid_data->id;
        $rfid_timestamp = $rfid_data->timestamp;



        if($this->session->userdata('rfid_data') && $this->session->userdata('rfid_time')) {
            // Compare RFID wth session

            if($this->session->userdata('rfid_data') == $rfid_id && $this->session->userdata('rfid_time') == $rfid_timestamp) {
                echo json_encode(array('success' => true, 'message' => 'existing', 'data' => $rfid_id));
                return;
            }

        }else{
             $this->session->set_userdata('rfid_data', $rfid_id);
             $this->session->set_userdata('rfid_time', $rfid_timestamp);
            return;
        } 
        

        $this->session->set_userdata('rfid_data', $rfid_id);
        $this->session->set_userdata('rfid_time', $rfid_timestamp);
        $rfid = $this->Custom_model->get_existing_rfids($rfid_id);

        if ($rfid) {
            $person_id = $rfid->person_id;
            $current_date = date('Y-m-d');
            $current_datetime = date('Y-m-d h:i:s');

            //Check logs if it's existing
            $rfid_logs = $this->Custom_model->get_logs($rfid->rfid_id, $person_id, $current_date);
            $table = 'logs';
            $errors = '';
            if($rfid_logs) {
                // Add time out
                $data = array('time_out' => $current_datetime);
                $field = 'logs_id';
                $where = $rfid_logs->logs_id;
                $response = $this->Global_model->update_data($table, $data, $field, $where);

                if($response === "failed") {
                    $errors = "Update logs Failed";
                }
            }else{
                $data = array(
                    'person_id' => $person_id,
                    'rfid_id' => $rfid->rfid_id,
                    'date' => $current_date,
                );
                $logs_insert = $this->Global_model->insert_data('logs', $data);

                if($logs_insert === "failed") {
                    $errors = "Insert logs Failed";
                }

            }

            echo json_encode(array('success' => true, 'message' => 'RFID Recognized.', 'name' => $rfid->name, 'number' => $rfid->person_number, 
                                    'time' => $current_datetime, 'errors' => $errors));
        }else{
            echo json_encode(array('success' => false, 'message' => 'RFID Not Recognized. Please Sign up for an account.'));
        }
        // print("<pre>".print_r($rfid,true)."</pre>");

        // print_r(json_encode($rfid_data));
    }

    public function deleteAccount() {
        $table = "person";
        $field = "person_id";
        $where = $this->input->post("id");
        $result = $this->Global_model->delete_data($table, $field, $where);
        print_r(json_encode($result));
    }


    public function getCourses() {
        $courses = $this->Global_model->get_all_data("course", "*");

        print_r(json_encode($courses));
    }

    public function getRooms() {
        $rooms = $this->Global_model->get_all_data("rooms", "*");

        print_r(json_encode($rooms));
    }

    public function getSections() {
        $sections = $this->Global_model->get_all_data_with_order("sections", "*", "sections.year_level", "ASC");

        print_r(json_encode($sections));
    }

    public function getRfid() {
        $rfids = $this->Global_model->get_all_data("rfid", "rfid_id, rfid_data");

        // $rfids = $this->Custom_model->get_all_available_rfids();

        print_r(json_encode($rfids));
    }


    public function getTimeLogs() {
        $result = $this->Custom_model->get_all_time_logs();

        // print("<pre>".print_r($result,true)."</pre>");
        print_r(json_encode($result));
    }

    public function getUserTimeLogs() {
        $result = $this->Custom_model->get_all_user_time_logs();
        print_r(json_encode($result));
    }

    public function getUserSubmittedRequests() {
        $person_id = $this->session->userdata('person_id');
        $result = $this->Custom_model->get_user_submitted_requests($person_id);
        print_r(json_encode($result));
    }

    // annthonite
    public function getFilteredTimeLogs() {
        $aResult = $this->Custom_model->get_filtered_time_logs();
        print_r(json_encode($aResult));
    }
}

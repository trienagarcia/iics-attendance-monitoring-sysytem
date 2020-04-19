<?php
require('Time.php');
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

    public function checkRFIDTableDifference() {
        $result = $this->Custom_model->get_rfid_comparison();

        // print("<pre>".print_r($result,true)."</pre>");

        if(!empty($result)) {
            // echo '$result[0]->rfid_result: ' . $result[0]->rfid_result . '<br>';
            // echo '$result[0]->datetime_result: ' . $result[0]->datetime_result . '<br>';
            if( $result[0]->rfid_result == 0 || $result[0]->datetime_result == 0 ) {
                
                // echo 'response: ' . $response . '<br>';
                $rfid_name_1 = trim($result[0]->rfid_name_1);
                $rfid = $this->Custom_model->get_existing_rfids($rfid_name_1);
                if ($rfid) {
                    $person_id = $rfid->person_id;
                    $current_date = date('Y-m-d');
                    $current_datetime = date('Y-m-d h:i:s');
                    $current_time = date('h:i:s');

                    $welcome_title = "Signing";

                    //Check rfid if it's existing
                    // start change - 4/19/2020
                    // $rfid_logs = $this->Custom_model->get_logs($rfid->rfid_id, $person_id, $current_date);

                    // check LOGS if it's existing
                    $rfid_logs = $this->Custom_model->check_logs_for_time_out($rfid->rfid_id, $person_id, $current_date);


                    // echo 'last query: ' . $this->db->last_query() . '<br>rfid_logs: ' . $rfid_logs . '<br>';

                    $table = 'logs';
                    $errors = '';
                    if($rfid_logs) {
                        // Add time out
                        $data = array('time_out' => $current_datetime);
                        $field = 'logs_id';
                        $where = $rfid_logs->logs_id;
                        $response = $this->Global_model->update_data($table, $data, $field, $where);
                        $welcome_title = "Signing Off";

                        if($response === "failed") {
                            $errors = "Update logs Failed";
                        }                               
                    }else{

                        $rfid_logs_new = $this->Custom_model->check_logs_for_insert($current_date);

                        if($rfid_logs_new) {
                            $data = array(
                                'rfid_id' => $rfid->rfid_id,
                                'attendance_id' => 1,
                                'time_in' => $current_datetime
                            );
                            $field = 'logs_id';
                            $where = $rfid_logs_new->logs_id;
                            $logs_update = $this->Global_model->update_data($table, $data, $field, $where);
                            $welcome_title = "Signing On";

                            if($logs_update === "failed") {
                                $errors = "Update Insert logs Failed";
                            }
                        }

                    }

                    // echo 'last query: ' . $this->db->last_query() . '<br>rfid_logs: ' . $rfid_logs . '<br>';

                    echo json_encode(array('success' => true, 
                                            'message' => $welcome_title, 
                                            'rfid_data' => $rfid->rfid_data, 
                                            'number' => $rfid->person_number, 
                                            'first_name' => $rfid->first_name, 
                                            'last_name' => $rfid->last_name,
                                            'time' => $current_datetime, 
                                            'errors' => $errors));
                }else{
                    echo json_encode(array('success' => false, 'message' => 'RFID Not Recognized. Please Sign up for an account.'));
                }

                $response = $this->Custom_model->update_rfid_counter();
            }
            else{
                echo json_encode(array('success' => true, 'message' => 'existing'));
            }
        }



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
        // print("<pre>".print_r($aResult,true)."</pre>");
        print_r(json_encode($aResult));
    }

    // annthonite
    public function updateLogs() { 
        $table = 'logs';
        $data = array(
            'attendance_id' => $this->input->post("attendance_id"),
            'remarks'       => $this->input->post('remarks')
        );
        $field = 'logs_id';
        $where = $this->input->post('logs_id');
        return $this->Global_model->update_data($table, $data, $field, $where);
    }

    // annthonite
    public function updateLogsRemarks() {
        $table = 'logs';
        $data = array(
            'remarks' => $this->input->post('remarks')
        );
        $field = 'logs_id';
        $where = $this->input->post('logs_id');
        return $this->Global_model->update_data($table, $data, $field, $where);
    }

    private function getAllApprovedSchedules() {
        $result = $this->Custom_model->get_all_approved_schedules();
        print_r(json_encode($result));
    }

    // 03-21-2020 - S
    private function removeDuplicates( $rooms ) {
        $final_rooms = array();
        foreach($rooms as $room) {
            $isAlreadyExistingFlag = FALSE;
            foreach($final_rooms as $final_room) {
                if($final_room["room_id"] == $room["room_id"]){
                    $isAlreadyExistingFlag = TRUE;
                    break;
                }
            }

            if($isAlreadyExistingFlag) {
                continue;
            }

            array_push($final_rooms, $room);
        }

        return $final_rooms;
    } 
    // 03-21-2020 - E

    private function getUniqueRooms( $result ) {
        $rooms = array();
        foreach( $result as $room ) {
            array_push($rooms, ["room_id" => $room->room_id, "room_number" => $room->room_number]);
        }

        return $this->removeDuplicates( $rooms );
    }

    // JANG - 02/19/2020
    public function getOpenSchedules() {

        if (!empty($this->input->get('sch_date'))) {
            $date = $this->input->get('sch_date');
            $timestamp = strtotime($date);
            $day = intval(date('w', $timestamp)) + 1;
        }else{
            $timestamp = strtotime(date("Y-m-d", strtotime('tomorrow')));
            $day = intval(date('w', $timestamp)) + 1;
        }

        $interval = $this->input->get('interval');

        if(empty($interval)) {
            $interval = 1;
        }

        $result = $this->Custom_model->get_schedules( $day );
        $rooms = $this->getUniqueRooms($result);

        // print("<pre>".print_r($rooms,true)."</pre>");
        $final_schedule = array();
        
        $i = 0;
        foreach( $rooms as $room ) {
            $schedules = array();
            for($idx = 0; $idx < count($result)  ; $idx++) {
                // echo 'room number: ' . $room["room_number"] . '<br>';
                // echo '$result[$idx]->room_number: ' . $result[$idx]->room_number . "<br>";
                // echo '$room["room_number"] == $result[$idx]->room_number? ' . ($room["room_number"] == $result[$idx]->room_number) . '<br>';
                if( $room["room_number"] == $result[$idx]->room_number ) {
                    $start_time = substr($result[$idx]->start_time, 0, -3);
                    $end_time = substr($result[$idx]->end_time, 0, -3);

                    if($start_time[0] == '0') {
                        $start_time = substr( $start_time, 1 );
                    }

                    if($end_time[0] == '0') {
                        $end_time = substr( $end_time, 1 );
                    }

                    $time = $start_time . '-' . $end_time;
                    array_push($schedules, $time);
                }

            }
            // echo 'schedules<br>';
            // print("<pre>".print_r($schedules,true)."</pre>");

            $open_schedules = $this->computeOpenSchedules( $schedules, $room );
            $final_schedule = array_merge($final_schedule, $open_schedules);
            // $final_schedule[$i]['date'] = date("Y-m-d", $timestamp);
        }
        $final_schedule =  (array)$this->convertToObject($final_schedule);
        $super_final_schedule = array_values($this->incorporateIntervals($final_schedule, $rooms, $interval));

        $ctr = 1;
        // annthonite
        foreach ($super_final_schedule as $row) {
            $row->date = date("Y-m-d", $timestamp);
            $row->schedule_id = $ctr++;
        }

        // echo 'interval: ' . $interval . '<br>';
        // print("super_final: <br><pre>".print_r($super_final_schedule,true)."</pre>");

        print_r(json_encode($super_final_schedule));
    }


    // 3-15-2020
    private function incorporateIntervals( $semi_final_schedule, $rooms, $interval ) {
        $final_room_schedules = [];
        $room_schedule = [];

        foreach($rooms as $room) {
            foreach($semi_final_schedule as $sched) {
                if($room["room_number"] == $sched->room_number) {
                    array_push($room_schedule, $sched);
                }
            }

            $final_room_schedules = array_merge($final_room_schedules, $this->orderByInterval( $room_schedule, $interval, $room ));
            $room_schedule = [];
        }

        return (array)$this->convertToObject($final_room_schedules);
    }
    // 3-15-2020

   function convertToObject($array) {
        $object = new stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = $this->convertToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }

    // 3-12-2020
    private function orderByInterval( $sched, $interval, $room ) {
       // ['7:00-8:00']
        $all_schedules = array();
        $number_of_times = 2 * $interval + 1;
        foreach( $sched as $value ) {
            $start_time = $value->start_time;
            $end_time = $value->end_time;

            // echo 'start time: ' . $start_time . '<br>';
            // echo 'end time: ' . $end_time . '<br>';

            $flag = FALSE;
            for( $ctr = 0; $ctr < count($all_schedules); $ctr++ ) {
                $array = $all_schedules[$ctr];
                // echo 'end(array): ' . end($array) . '<br>';
                // echo 'equal? ' . ($start_time == end($array) ) . '<br>';
                if( $start_time == end($array) ) {
                    array_push($array, $end_time);
                    $flag = TRUE;
                    // print("<pre>".print_r($array,true)."</pre>");
                    unset($all_schedules[$ctr]);
                    array_splice( $all_schedules, $ctr, 0, array( $array ) );
                    break;
                }


            }

            // echo 'flag: ' . $flag . '<br>';
            if($flag == FALSE) {
                $arr = array();
                array_push($arr, $start_time);
                array_push($arr, $end_time);
                array_push($all_schedules, $arr);
            }

            // print("<pre>".print_r($all_schedules,true)."</pre>");

        }

        // [[]]
        // print("all_schedule:<br><pre>".print_r($all_schedules,true)."</pre>");

        $final_schedule = [];
        foreach($all_schedules as $arr){
            $ctr = 0;
            for($current_index = 0; $current_index < count($arr); $current_index++) {
                $ctr++;
                if( $ctr == $number_of_times ) {
                    // echo 'start_time: ' . $arr[$current_index - $ctr + 1] . '<br>';
                    // echo 'end_time: ' . $arr[$current_index] . '<br><br>';
                    array_push($final_schedule, ['start_time' => $arr[$current_index - $ctr + 1], 
                                                 'end_time' => $arr[$current_index], 
                                                 'room_id' => $room["room_id"],
                                                 'room_number' => $room["room_number"]]);
                    $ctr = 0;
                    $current_index--;
                }
            }
        }

        // print("final_schedule:<br><pre>".print_r($final_schedule,true)."</pre>");

        return $final_schedule;
    }
    // 3-12-2020

    // $list = ['8:30-9:30', '10:00-13:00', '14:30-16:00', '16:30-21:00'];
    private function computeOpenSchedules($list, $room) {

        // print_array($list, 'input');
        // echo '<br>';

        $st = array();
        $et = array();
        $final = array();
        $start = 7;
        $end = 21;
        $temp  = $start;

        $st = ['7:00', '7:30', '8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', 
                '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30'];
        $et = ['7:30', '8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', 
                '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00'];
        // while($temp < $end) {
        //     array_push( $st, number_format((float)$temp, 2, ':', '') );
        //     $temp++;
        // }

        // $temp = $start++;
        // while( $start <= $end ) {
        //     array_push( $et, number_format((float)$start, 2, ':', '') );
        //     $start++;
        // }

        // $this->print_array($st, 'start_time');
        // $this->print_array($et, 'end_time');
        // echo '<br>';

        foreach( $list as $val ) {
            $times = explode("-", $val);
            $start_time = trim($times[0]);
            $end_time = trim($times[1]);

            // echo 'start time: ' . $start_time . '<br>';
            // echo 'end_time: ' . $end_time . '<br>';
            $range = $this->find_range($start_time, $end_time);
            
            if (($key = array_search($start_time, $st)) !== false) {
                unset($st[$key]);
            }

            if (($key = array_search($end_time, $et)) !== false) {
                unset($et[$key]);
            }

            foreach($range as $time) {
                if (($key = array_search($time, $st)) !== false) {
                    unset($st[$key]);
                }

                if (($key = array_search($time, $et)) !== false) {
                    unset($et[$key]);
                }
            }
        }

        $st = array_values($st);
        $et = array_values($et);

        // $this->print_array($st, 'start_time');
        // $this->print_array($et, 'end_time');
        // echo '<br>';

        if(count($st) >= count($et)) {
            for($idx = 0; $idx < count($st); $idx++){
                array_push($final, array('start_time' => $st[$idx], 'end_time' => $et[$idx], 
                    'room_id' => $room["room_id"], 'room_number' => $room["room_number"]));
            }
        }        
        return $final;
    }

    private function add_time($time) {
        $last = substr($time, -1);
        if( $last == 6 ) {
            $time = ($time+1) - 0.6;
        }else {
            $time += 0.3;
        }

        return $time;
    }

    private function find_range($time1, $time2) {
        $time1 = floatval(str_replace(':', '.', $time1));
        $time2 = floatval(str_replace(':', '.', $time2));
        $range = array();
        
        $time1 = $this->add_time($time1);

        while($time1 < $time2){
            if( substr($time1, -1) != 6 ) {
                array_push($range, number_format((float)$time1, 2, ':', ''));
            }

            $time1 = $this->add_time($time1);
        }

        return $range;
    }

    private function print_array($arrray, $msg) {
        echo $msg . "<br>";
        foreach( $arrray as $val ) {
            echo $val . ',&nbsp;';
        }
        echo '<br>';
    }

    // annthonite
    public function getRequests() {
        $result = $this->Custom_model->getRequests();
        // print("result: <br><pre>".print_r($result,true)."</pre>");
        print_r(json_encode($result));
    }

    // annthonite
    public function updateRequestStatus() {
        $table = 'make_up_requests';
        $data = array(
            'status_id' => $this->input->post('status_id')
        );
        $field = 'request_id';
        $where = $this->input->post('request_id');
        return $this->Global_model->update_data($table, $data, $field, $where);
    }

    // annthonite
    public function deleteRequests() {
        $table = 'make_up_requests';
        $field = 'request_id';
        $where = $this->input->post('request_id');
        return $this->Global_model->delete_data($table, $field, $where);
    }

    // annthonite
    public function updateScheduleSubstitute() {
        $table = 'schedule';
        $data = array(
            'person_id' => $this->input->post('person_id')
        );
        $field = 'schedule_id';
        $where = $this->input->post('schedule_id');

        
        return $this->Global_model->update_data($table, $data, $field, $where);

    }

    // 04-09-2020
    public function getRfidFromHttpPost() {
        $results = $this->input->post();

        print("<pre>".print_r($results,true)."</pre>");

        if(!empty($results)) {
            // echo '&nbsp;&nbsp;&nbsp;&nbsp;RECEIVED&nbsp; <br>';
            $table = 'rfid_counter';
            $data = array(
                'rfid_name_1' => trim($results["rfid_name"]),
                'datetime_1' => trim($results["datetime"])
            );
            $field = 'counter_id';
            $where = 1;

            $response = $this->Global_model->update_data($table, $data, $field, $where);

            return $response;
        }

        // echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NONE&nbsp;&nbsp;&nbsp;<br>';
        return 300;
    }

    public function checkRequestDate() {
        $current_date = date('Y-m-d');
        $current_time = date('h:i:s');
        $current_datetime = new DateTime();

        $result = $this->Custom_model->get_schedule_request_ids_with_overdates($current_date);

        // print("&nbsp;&nbsp;result: <br><pre>".print_r($result,true)."</pre>");

        // echo '&nbsp;&nbsp;last query: ' . $this->db->last_query();
        if(!empty($result)) {
            $table = 'make_up_requests';
            $field = 'request_id';

            foreach($result as $value) {

                $datetime = new DateTime($value->request_date . ' ' . $value->start_time);

                // echo 'current time: ' . $current_datetime->format('Y-m-d h:i:s') . "<br>";
                // echo 'start_time: ' . $datetime->format('Y-m-d h:i:s') . "<br>";

                if($current_datetime > $datetime) {
                    $where = $value->request_id;

                    // echo "  where " . $where . "<br>";
                    $response = $this->Global_model->delete_data($table, $field, $where);
                }

                
            }
            
            print_r(json_encode("success"));
        }


        print_r(json_encode("none"));
    }



}

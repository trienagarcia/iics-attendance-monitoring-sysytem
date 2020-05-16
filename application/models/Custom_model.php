<?php 
date_default_timezone_set('Asia/Taipei');

	class Custom_model extends CI_Model{

		public function get_all_users() { 
					$this->db->select("*");
					$this->db->from("person");
					$this->db->join("rfid", "person.rfid_id = rfid.rfid_id");
					$this->db->join("person_position", "person.position_Id = person_position.position_id AND person.position_Id = 3");
					$q = $this->db->get();
					return $q->result();
		}

		public function get_existing_rfids($rfid_id) {
			$this->db->select("*");
			$this->db->from("person");
			$this->db->join("rfid", "person.rfid_id = rfid.rfid_id");
			$this->db->where("rfid.rfid_data = ", $rfid_id);
			$q = $this->db->get();

			if ($q->num_rows() > 0)
			{
				$row = $q->row(); 
				return $row;
			}

			return null;
		}

		public function get_latest_rfid() {
			$this->db->select("*");
			$this->db->from("rfid_pings");
			$this->db->order_by("ping_date", "desc");
			$q = $this->db->get();

			if ($q->num_rows() > 0)
			{
				$row = $q->row(); 
				return $row;
			}

			return null;
		}

		// select * from logs where time_out IS NULL;
		public function get_logs($rfid_id, $person_id, $date) {
			$this->db->select("*");
			$this->db->from("logs");
			$this->db->where("rfid_id = ", $rfid_id);
			$this->db->where("person_id = ", $person_id);
			$this->db->where("log_date = ", $date);
			$this->db->where("time_out IS NULL");
			$this->db->order_by("time_in", "desc");
			$q = $this->db->get();

			if ($q->num_rows() > 0)
			{
				$row = $q->row(); 
				return $row;
			}

			return null;
		}

		/*
		 for insert 

		 Select * from `logs` log INNER JOIN `schedule` s ON log.schedule_id = s.schedule_id where log.attendance_id = 0 and log.log_date = CURRENT_DATE ORDER BY s.start_time;

		/*
		-- TODO ADD DATES to CI sql statement
		-- TODO ADD REMARKS
		Select * from `schedule` s INNER JOIN `person` p on s.person_id = p.person_id 
		INNER JOIN `logs` log On s.schedule_id = log.schedule_id
		INNER JOIN `rooms` room ON room.room_id = s.room_id
		INNER JOIN `course` course ON course.course_id = s.course_id
		INNER JOIN `sections` section on section.section_id = s.section_id
		INNER JOIN `attendance` attend ON attend.attendance_id = log.attendance_id;
		*/
		public function get_all_time_logs( $date ) {
			$this->db->select("logs.logs_id, person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, logs.time_in, logs.time_out, attendance.attendance_name, logs.log_date, logs.remarks, logs.attendance_id, schedule.schedule_id, schedule.person_id, schedule.start_time, schedule.end_time, 
				make_up_requests.request_date");
			$this->db->from("schedule");
			$this->db->join("person", "schedule.person_id = person.person_id");
			$this->db->join("logs", "logs.schedule_id = schedule.schedule_id");
			$this->db->join("rooms", "rooms.room_id = schedule.room_id");
			$this->db->join("course", "course.course_id = schedule.course_id");
			$this->db->join("sections", "sections.section_id = schedule.section_id");
			$this->db->join("attendance", "attendance.attendance_id = logs.attendance_id");			
			// add - 04/14 - add make up requests date
			$this->db->join("make_up_requests", "schedule.schedule_id = make_up_requests.schedule_id", "left");
			$this->db->where("logs.log_date <= ", $date);
			$this->db->group_by("schedule.schedule_id");
			// ADD and date
			$q = $this->db->get();
			return $q->result();
		}

		// added 04/23/2020
		public function get_all_schedule() {
			$this->db->select("person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, schedule.schedule_id, schedule.person_id, schedule.start_time, schedule.end_time, make_up_requests.request_date, rooms.room_id, schedule.type_id, make_up_requests.status_id, schedule.day");
			$this->db->from("schedule");
			$this->db->join("person", "schedule.person_id = person.person_id");
			$this->db->join("rooms", "rooms.room_id = schedule.room_id");
			$this->db->join("course", "course.course_id = schedule.course_id");
			$this->db->join("sections", "sections.section_id = schedule.section_id");			
			// add - 04/14 - add make up requests date
			$this->db->join("make_up_requests", 
				"schedule.schedule_id = make_up_requests.schedule_id", "left");
			// ADD and date
			$q = $this->db->get();
			return $q->result();
		}

		public function get_filtered_schedule() {
			$this->db->select("person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, schedule.schedule_id, schedule.person_id, schedule.start_time, schedule.end_time, make_up_requests.request_date, rooms.room_id, schedule.type_id, make_up_requests.status_id, schedule.day");
			$this->db->from("schedule");
			$this->db->join("person", "schedule.person_id = person.person_id");
			$this->db->join("rooms", "rooms.room_id = schedule.room_id");
			$this->db->join("course", "course.course_id = schedule.course_id");
			$this->db->join("sections", "sections.section_id = schedule.section_id");			
			// add - 04/14 - add make up requests date
			$this->db->join("make_up_requests", 
				"schedule.schedule_id = make_up_requests.schedule_id", "left");

			if (!empty($this->input->get('person_id'))) {
				$this->db->where("person.person_id = ", $this->input->get('person_id'));
			}

			$q = $this->db->get();
			return $q->result();
		}

		// INSERT INTO `logs` (person_id, log_date) Select person_id, now() from `schedule` s where s.day = DAYOFWEEK(now())
		// Select * from `logs` log INNER JOIN `schedule` s ON log.schedule_id = s.schedule_id where log.attendance_id = 0 and log.log_date = CURRENT_DATE ORDER BY s.start_time
		/*
			SELECT * FROM `schedule` s 
			INNER JOIN person p ON s.person_id = p.person_id 
			INNER JOIN `logs` log ON log.person_id = p.person_id 
			INNER JOIN rooms room ON room.room_id = s.room_id 
			INNER JOIN course c ON c.course_id = s.course_id 
			INNER JOIN sections sec ON sec.section_id = s.section_id 
			INNER JOIN attendance a ON a.attendance_id = log.attendance_id AND p.person_id = 8
		*/
		public function get_all_user_time_logs() {
			$current_date = date('Y-m-d');
			$this->db->select("logs.logs_id, person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, logs.time_in, logs.time_out, attendance.attendance_name, logs.log_date, logs.remarks, logs.attendance_id, schedule.schedule_id, schedule.person_id, schedule.start_time, schedule.end_time, 
				make_up_requests.request_date");
			$this->db->from("schedule");
			$this->db->join("person", "schedule.person_id = person.person_id");
			$this->db->join("logs", "logs.schedule_id = schedule.schedule_id");
			$this->db->join("rooms", "rooms.room_id = schedule.room_id");
			$this->db->join("course", "course.course_id = schedule.course_id");
			$this->db->join("sections", "sections.section_id = schedule.section_id");
			$this->db->join("attendance", "attendance.attendance_id = logs.attendance_id");			
			// add - 04/14 - add make up requests date
			$this->db->join("make_up_requests", "schedule.schedule_id = make_up_requests.schedule_id", "left");
			$this->db->where("logs.person_id = ", $this->session->userdata('person_id'));

			// annthonite
			if (!empty($this->input->get('date'))) {
				$this->db->where("logs.log_date = ", $this->input->get('date'));
			}else{
				$this->db->where("logs.log_date <= ", $current_date);
			}

			
			$q = $this->db->get();
			return $q->result();
		}


		// annthonite
		public function get_filtered_time_logs($date) {
			$this->db->select("logs.logs_id, person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, logs.time_in, logs.time_out, attendance.attendance_name, logs.remarks, logs.attendance_id, schedule.schedule_id, schedule.person_id, schedule.start_time, schedule.end_time, 
				make_up_requests.request_date, logs.log_date");
			$this->db->from("schedule");
			$this->db->join("person", "schedule.person_id = person.person_id");
			$this->db->join("logs", "logs.schedule_id = schedule.schedule_id");
			$this->db->join("rooms", "rooms.room_id = schedule.room_id");
			$this->db->join("course", "course.course_id = schedule.course_id");
			$this->db->join("sections", "sections.section_id = schedule.section_id");
			$this->db->join("attendance", "attendance.attendance_id = logs.attendance_id");			
			// add - 04/14 - add make up requests date
			$this->db->join("make_up_requests", "schedule.schedule_id = make_up_requests.schedule_id", "left");
			$this->db->where("logs.log_date <= ", $date);

			if (!empty($this->input->get('person_id'))) {
				$this->db->where("person.person_id = ", $this->input->get('person_id'));
			}
			if (!empty($this->input->get('log_date'))) {
				$this->db->where("logs.log_date = ", $this->input->get('log_date'));
			}

			$q = $this->db->get();
			return $q->result();
		}

		/*
			SELECT * FROM `make_up_requests` 
			JOIN `schedule` ON `schedule`.`schedule_id` = `make_up_requests`.`schedule_id` 
			JOIN `rooms` ON `schedule`.`room_id` = `rooms`.`room_id` 
			JOIN `sections` ON `schedule`.`section_id` = `sections`.`section_id` 
			JOIN `course` ON `schedule`.`course_id` = `course`.`course_id` 
			JOIN `status` ON `make_up_requests`.`status_id` = `status`.`status_id` 
			JOIN `person` ON `schedule`.`person_id` = `person`.`person_id` 
			WHERE `schedule`.`person_id` = '8';
		*/
		public function get_user_submitted_requests($person_id) {
			$this->db->select("schedule.schedule_id, schedule.room_id, rooms.room_number, schedule.section_id, sections.section_name, 
								make_up_requests.request_date, schedule.start_time, schedule.end_time, schedule.course_id, course.course_code, 
								make_up_requests.status_id, status.status_name, make_up_requests.request_id");
			$this->db->from("make_up_requests");
			$this->db->join("schedule", "schedule.schedule_id = make_up_requests.schedule_id");
			$this->db->join("rooms", "schedule.room_id = rooms.room_id");
			$this->db->join("sections", "schedule.section_id = sections.section_id");
			$this->db->join("course", "schedule.course_id = course.course_id");
			$this->db->join("status", "make_up_requests.status_id = status.status_id");
			$this->db->join("person", "schedule.person_id = person.person_id");
			$this->db->where("schedule.person_id = ", $person_id);
			$q = $this->db->get();
			return $q->result();
		}

		// public function get_all_available_rfids() {
		// 	$this->db->select("*");
		// 	$this->db->from("person");
		// 	$this->db->join("rfid", "person.rfid_id <> rfid.rfid_id");
		// 	$q = $this->db->get();
		// 	return $q->result();
		// }

		public function get_schedules($day) {
			$this->db->select("*");
			$this->db->from("schedule");
			$this->db->join("rooms", "rooms.room_id = schedule.room_id");
			$this->db->join("make_up_requests", "make_up_requests.schedule_id = schedule.schedule_id AND make_up_requests.status_id = 2", "left");
			$this->db->where("schedule.day = ", $day);
			$q = $this->db->get();
			return $q->result();
		}

		// annthonite
		// changed - 3-22-2020 - JANG - changed from requests table to make_up_requests
		public function getRequests() {
			$this->db->select("schedule.schedule_id, schedule.room_id, rooms.room_number, schedule.section_id, sections.section_name, 
								make_up_requests.request_date, person.first_name, person.last_name, schedule.start_time, schedule.end_time, schedule.course_id, course.course_code, make_up_requests.status_id, status.status_name, make_up_requests.request_id");
			$this->db->from("make_up_requests");
			$this->db->join("schedule", "schedule.schedule_id = make_up_requests.schedule_id");
			$this->db->join("rooms", "schedule.room_id = rooms.room_id");
			$this->db->join("sections", "schedule.section_id = sections.section_id");
			$this->db->join("course", "schedule.course_id = course.course_id");
			$this->db->join("status", "make_up_requests.status_id = status.status_id");
			$this->db->join("person", "schedule.person_id = person.person_id");
			$q = $this->db->get();
			return $q->result();
		}
		// changed - 3-22-2020 - JANG

		public function get_all_approved_schedules() {
			$this->db->select("logs.logs_id, person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number");
			$this->db->from("schedule");
			$this->db->join("person", "schedule.person_id = person.person_id", "left");
			$this->db->join("rooms", "rooms.room_id = schedule.room_id", "left");
			$this->db->join("course", "course.course_id = schedule.course_id", "left");
			$this->db->join("sections", "sections.section_id = schedule.section_id", "left");
			// ADD and date
			$q = $this->db->get();
			return $q->result();
		}

		public function get_rfid_comparison() {
			$this->db->select("(rfid_name_1 = rfid_name_2) as rfid_result, (datetime_1 = datetime_2) as datetime_result, rfid_name_1, datetime_1");
			$this->db->from("rfid_counter");
			$q = $this->db->get();
			return $q->result();
		}

		public function get_rfid_counter() {
			$this->db->select("*");
			$this->db->from("rfid_counter");
			$q = $this->db->get();
			return $q->result();
		}

		public function update_rfid_counter() {
			$this->db->set('rfid_name_2', 'rfid_name_1', false);
			$this->db->set('datetime_2', 'datetime_1', false);
			$this->db->update('rfid_counter');
			$updated_status = $this->db->affected_rows();
			if($updated_status):
			    return "success";
			else:
			    return "failed";
			endif;
		}

		public function get_schedule_request_ids_with_overdates($current_date){
			$this->db->select("make_up_requests.request_id, schedule.start_time, make_up_requests.request_date, make_up_requests.status_id");
			$this->db->from("schedule");
			$this->db->join("make_up_requests", "schedule.schedule_id = make_up_requests.schedule_id");
			$this->db->where("make_up_requests.request_date <= ", $current_date);
			$q = $this->db->get();
			return $q->result();
		}

		// 04/19/2020
		public function check_logs_for_insert($current_date){
			$this->db->select("*");
			$this->db->from("logs");
			$this->db->join("schedule", "logs.schedule_id = schedule.schedule_id");
			$this->db->where("logs.log_date = ", $current_date);
			$this->db->where("logs.attendance_id = 0");
			$this->db->where("logs.time_in IS NULL");
			$this->db->order_by("schedule.start_time");

			$q = $this->db->get();

			if ($q->num_rows() > 0)
			{
				$row = $q->row(); 
				return $row;
			}

			return null;
		}

		// 04/19/2020
		public function check_logs_for_time_out($rfid_id, $person_id, $date){
			$this->db->select("*");
			$this->db->from("logs");
			$this->db->where("rfid_id = ", $rfid_id);
			$this->db->where("person_id = ", $person_id);
			$this->db->where("log_date = ", $date);
			$this->db->where("time_in IS NOT NULL");
			$this->db->where("time_out IS NULL");
			$this->db->order_by("time_in", "desc");
			$q = $this->db->get();

			if ($q->num_rows() > 0)
			{
				$row = $q->row(); 
				return $row;
			}

			return null;
		}

		public function get_schedule_by_date($day) {
			$this->db->select("schedule.person_id, schedule.schedule_id, make_up_requests.status_id, schedule.type_id, make_up_requests.request_date");

			$this->db->from("schedule");
			$this->db->join("make_up_requests", 
				"schedule.schedule_id = make_up_requests.schedule_id", "left");
			$this->db->where("schedule.day", $day);
			$q = $this->db->get();
			return $q->result();
		}

		public function get_all_schedule_by_day($day) {
			$this->db->select("person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, schedule.schedule_id, schedule.person_id, schedule.start_time, schedule.end_time, make_up_requests.request_date, rooms.room_id, schedule.type_id, make_up_requests.status_id");
			$this->db->from("schedule");
			$this->db->join("person", "schedule.person_id = person.person_id");
			$this->db->join("rooms", "rooms.room_id = schedule.room_id");
			$this->db->join("course", "course.course_id = schedule.course_id");
			$this->db->join("sections", "sections.section_id = schedule.section_id");			
			// add - 04/14 - add make up requests date
			$this->db->join("make_up_requests", 
				"schedule.schedule_id = make_up_requests.schedule_id", "left");
			$this->db->where("schedule.day", $day);
			// ADD and date
			$q = $this->db->get();
			return $q->result();
		}


	}
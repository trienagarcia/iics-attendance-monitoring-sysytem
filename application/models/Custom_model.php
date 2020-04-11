<?php 
date_default_timezone_set('Asia/Taipei');

	class Custom_model extends CI_Model{

		public function get_all_users() { 
					$this->db->select("*");
					$this->db->from("person");
					$this->db->join("rfid", "person.rfid_id = rfid.rfid_id");
					$this->db->join("person_position", "person.position_Id = person_position.position_id AND person.position_Id = 2");
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
		-- TODO ADD DATES to CI sql statement
		-- TODO ADD REMARKS
		SELECT * FROM `schedule` s 
		LEFT JOIN person p ON s.person_id = p.person_id 
		LEFT JOIN `logs` log ON log.person_id = p.person_id 
		LEFT JOIN rooms room ON room.room_id = s.room_id 
		LEFT JOIN course c ON c.course_id = s.course_id 
		LEFT JOIN sections sec ON sec.section_id = s.section_id 
		LEFT JOIN attendance a ON a.attendance_id = log.attendance_id
		 AND log.log_date < CURRENT_DATE
		*/
		public function get_all_time_logs() {
			$this->db->select("logs.logs_id, person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, logs.time_in, logs.time_out, attendance.attendance_name, logs.remarks, logs.attendance_id");
			$this->db->from("schedule");
			$this->db->join("person", "schedule.person_id = person.person_id", "left");
			$this->db->join("logs", "logs.person_id = person.person_id", "left");
			$this->db->join("rooms", "rooms.room_id = schedule.room_id", "left");
			$this->db->join("course", "course.course_id = schedule.course_id", "left");
			$this->db->join("sections", "sections.section_id = schedule.section_id", "left");
			$this->db->join("attendance", "attendance.attendance_id = logs.attendance_id", "left");
			// ADD and date
			$q = $this->db->get();
			return $q->result();
		}

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
			$this->db->select("person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, logs.time_in, logs.time_out, attendance.attendance_name, logs.remarks");
			$this->db->from("schedule");
			$this->db->join("person", "schedule.person_id = person.person_id");
			$this->db->join("logs", "logs.person_id = person.person_id");
			$this->db->join("rooms", "rooms.room_id = schedule.room_id");
			$this->db->join("course", "course.course_id = schedule.course_id");
			$this->db->join("sections", "sections.section_id = schedule.section_id");
			$this->db->join("attendance", "attendance.attendance_id = logs.attendance_id");
			$this->db->where("person.person_id = ", $this->session->userdata('person_id'));
			$q = $this->db->get();
			return $q->result();
		}

		// annthonite
		public function get_filtered_time_logs() {
			$this->db->select("logs.logs_id, person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, logs.time_in, logs.time_out, attendance.attendance_name, logs.remarks, logs.attendance_id");
			$this->db->from("schedule");
			$this->db->join("person", "schedule.person_id = person.person_id");
			$this->db->join("logs", "logs.person_id = person.person_id");
			$this->db->join("rooms", "rooms.room_id = schedule.room_id");
			$this->db->join("course", "course.course_id = schedule.course_id");
			$this->db->join("sections", "sections.section_id = schedule.section_id");
			$this->db->join("attendance", "attendance.attendance_id = logs.attendance_id");

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
			SELECT * FROM `requests` 
			INNER JOIN `rooms`
			ON requests.room_id = rooms.room_id
			INNER JOIN `sections`
			ON requests.section_id = sections.section_id
			INNER JOIN `course`
			ON requests.course_id = course.course_id
			INNER JOIN `status`
			ON requests.status_id = `status`.status_id
			WHERE requests.person_id = ;
		*/
		public function get_user_submitted_requests($person_id) {
			$this->db->select("schedule.schedule_id, schedule.room_id, rooms.room_number, schedule.section_id, sections.section_name, 
								make_up_requests.request_date, schedule.start_time, schedule.end_time, schedule.course_id, course.course_code, 
								make_up_requests.status_id, status.status_name");
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
			$this->db->where("schedule.day = ", $day);
			$q = $this->db->get();
			return $q->result();
		}

		// annthonite
		// changed - 3-22-2020 - JANG - changed from requests table to make_up_requests
		public function getRequests() {
			$this->db->select("schedule.schedule_id, schedule.room_id, rooms.room_number, schedule.section_id, sections.section_name, 
								make_up_requests.request_date, person.first_name, person.last_name, schedule.start_time, schedule.end_time, schedule.course_id, course.course_code, make_up_requests.status_id, status.status_name");
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
	}
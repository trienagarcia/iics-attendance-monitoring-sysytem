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

		public function get_logs($rfid_id, $person_id, $date) {
			$this->db->select("*");
			$this->db->from("logs");
			$this->db->where("rfid_id = ", $rfid_id);
			$this->db->where("person_id = ", $person_id);
			$this->db->where("date = ", $date);
			$q = $this->db->get();

			if ($q->num_rows() > 0)
			{
				$row = $q->row(); 
				return $row;
			}

			return null;
		}

		public function get_all_time_logs() {
			$this->db->select("*");
			$this->db->from("person");
			$this->db->join("logs", "person.person_id = logs.person_id");
			$q = $this->db->get();
			return $q->result();
		}

		public function get_all_user_time_logs() {
			$this->db->select("*");
			$this->db->from("person");
			$this->db->join("logs", "person.person_id = logs.person_id");
			$this->db->where("person.person_id = ", $this->session->userdata('person_id'));
			$q = $this->db->get();
			return $q->result();
		}

		// annthonite
		public function get_filtered_time_logs() {
			var_dump($this->input->post('sProfessor')); die();
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
			$this->db->select("*");
			$this->db->from("requests");
			$this->db->join("rooms", "requests.room_id = rooms.room_id");
			$this->db->join("sections", "requests.section_id = sections.section_id");
			$this->db->join("course", "requests.course_id = course.course_id");
			$this->db->join("status", "requests.status_id = status.status_id");
			$this->db->where("requests.person_id = ", $person_id);
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

		

	}
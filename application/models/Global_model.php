<?php 
date_default_timezone_set('Asia/Taipei');

	class Global_model extends CI_Model{

		function check_session() {
			if($this->session->userdata('sess_user')!='') { 
				return true;
			} else {
				return false;
			}
		}
		
	    function get_all_data($table, $select)
		{
			$this->db->select($select);
			$this->db->from($table);
			$q = $this->db->get();
			return $q->result();
		}

		function get_all_data_with_order($table, $select, $order_field, $order_orient)
		{
			$this->db->select($select);
			$this->db->from($table);
			$this->db->order_by($order_field, $order_orient);
			$q = $this->db->get();
			return $q->result();
		}

		function get_data_with_query($table, $select, $query)
		{
			$this->db->select($select);
			$this->db->from($table);
			$this->db->where($query);
			$q = $this->db->get();
			return $q->result();
		}

		function get_data_with_query_and_single_order($table, $select, $query, $order_field, $order_orient)
		{
			$this->db->select($select);
			$this->db->from($table);
			$this->db->where($query);
			$this->db->order_by($order_field, $order_orient);
			$q = $this->db->get();
			return $q->result();
		}

		function get_data_with_join($table, $select, $query, $join)
		{
			$this->db->select($select);
			$this->db->from($table);
			$this->db->where($query);
			foreach ($join as $key => $vl) {
					$this->db->join($vl['table'],$vl['query'],$vl['type']);
			}
			$q = $this->db->get();
			return $q->result();
		}

		function insert_data($table, $data){

			$this->db->insert($table, $data);
			$insertId = $this->db->insert_id();

   			if($insertId):
   				return $insertId;
			else:
			    return "failed";
			endif;
		}

		function insert_batch_data($table, $data){

			$this->db->insert_batch($table, $data);
			$insertId = $this->db->insert_id();

   			if($insertId):
   				return $insertId;
			else:
			    return "failed";
			endif;
		}

		function update_data($table,$data,$field,$where){
			$this->db->where($field, $where);
			$this->db->update($table, $data);
			$updated_status = $this->db->affected_rows();
			if($updated_status):
			    return "success";
			else:
			    return "failed";
			endif;
		}

		function delete_data($table, $field, $where){
			$this->db->where($field, $where);
			$this->db->delete($table);
   			$updated_status = $this->db->affected_rows();
			if($updated_status):
			    return "success";
			else:
			    return "failed";
			endif;
		}
	}
?>
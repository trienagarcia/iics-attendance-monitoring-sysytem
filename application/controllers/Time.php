<?php 

class Time {
 
	private $timeIn;
	private $timeOut;
	private $room;
 
	function __construct( $timeIn, $timeOut, $room ) {
		$this->timeIn = $timeIn;
		$this->timeOut = $timeOut;
		$this->room = $room;
	}
 
	public function getTimeIn() {
		return $this->$timeIn;
	}
 
	public function getTimeOut() {
		return $this->$timeOut;
	}

	public function getRoom() {
		return $this->$room;
	}
 
}




?>
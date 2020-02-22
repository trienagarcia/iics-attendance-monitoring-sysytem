<?php 

class Time {
 
	private $timeIn;
	private $timeOut;
 
	function __construct( $timeIn, $timeOut ) {
		$this->timeIn = $timeIn;
		$this->timeOut = $timeOut;
	}
 
	function getTimeIn() {
		return $this->timeIn;
	}
 
	function getTimeOut() {
		return $this->$timeOut;
	}
 
}




?>
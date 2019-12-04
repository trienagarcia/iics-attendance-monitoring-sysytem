<?php 
$this->load->view('layouts/header', $head);
$this->load->view('layouts/menu');
$this->load->view('pages/'.$view);
$this->load->view('layouts/footer');
 ?>
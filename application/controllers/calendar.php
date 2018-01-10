<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class calendar extends CI_Controller {

	public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('calendar_model', 'calendar');
		//$this->load->model('akademik/berita_model','berita');
		$this->load->library(array('template'));
    }


	/*Home page Calendar view  */
	public function index()
	{
		$this->template->display('calendar');
	}

	/*Get all Events */

	public function getEvents()
	{
		$result=$this->calendar->getEvents();
		echo json_encode($result);
	}
	/*Add new event */
	public function addEvent()
	{
		$result=$this->calendar->addEvent();
		echo $result;
	}
	/*Update Event */
	public function updateEvent()
	{
		$result=$this->calendar->updateEvent();
		echo $result;
	}
	/*Delete Event*/
	public function deleteEvent()
	{
		$result=$this->calendar->deleteEvent();
		echo $result;
	}
	
	public function dragUpdateEvent()
	{	

		$result=$this->calendar->dragUpdateEvent();
		echo $result;
	}
}

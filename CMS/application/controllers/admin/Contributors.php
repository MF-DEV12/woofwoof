<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contributors extends CI_Controller {

 private $param;
 	function __construct(){
 		parent::__construct();
 		$this->param = $this->param = $this->query_model->param; 
 		$this->param["table"] = "tblcontributors";
 	}

	public function index()
	{
		$data["index"] = 2;
		$data["data"] = $this->getList();
		$controller["currentController"] = "admin/contributors/"; 
		$data["jsvar"] = json_encode($controller);
		$this->load->view('admin/contributors',$data);
		 
	}

	function getList(){
		
		$this->param["fields"] = "ID, FIRSTNAME, LASTNAME, MIDNAME, DATE_FORMAT(CREATEDDATE,'%M %d, %Y') CREATEDDATE";
		$this->param["conditions"] = "STATUS = 1";
		$this->param["order"] = "LASTNAME, FIRSTNAME";
		$result = $this->query_model->getData($this->param);
		return $result;
	}

	function insert(){
		
		$insert["FIRSTNAME"] = $this->input->post("FIRSTNAME");
		$insert["LASTNAME"] = $this->input->post("LASTNAME");
		$insert["MIDNAME"] = $this->input->post("MIDNAME");
	  
		 
	 
		$insert["STATUS"] = 1;
		$insert["CREATEDDATE"] = date("Y-m-d h:i s");

		$this->param["dataToInsert"] = $insert;
		 
		$result = $this->query_model->insertData($this->param);

		echo ($result == true || $result == false) ? $result : 1062;
	}

	function update(){
		
		$update["FIRSTNAME"] = $this->input->post("FIRSTNAME");
		$update["LASTNAME"] = $this->input->post("LASTNAME");
		$update["MIDNAME"] = $this->input->post("MIDNAME");
		 
		 
		$update["STATUS"] = 1;
		$this->param["conditions"] = array("ID"=>$this->input->post("ID"));
		//$update["MAINTAINEDDATE"] = date("Y-m-d h:i s");

		$this->param["dataToUpdate"] = $update;
		 
		$result = $this->query_model->updateData($this->param);

		echo ($result == true || $result == false) ? $result : 1062;
	}


	function remove(){
		$id = $this->input->post("ID");
		$qry = "UPDATE " . $this->param["table"]  . " SET STATUS = 0 WHERE ID IN($id)";
		$query = $this->db->query($qry);
		$this->session->set_flashdata('result', $this->db->affected_rows() . " row(s) deleted.");
		echo true;
	}
}

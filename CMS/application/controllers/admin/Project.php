<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {

 	private $param;
 	function __construct(){
 		parent::__construct();
 		$this->param = $this->param = $this->query_model->param; 
 		$this->param["table"] = "tblprojects";
 	}

	public function index()
	{
		$data["index"] = 1;
		$data["data"] = $this->getList();
		$controller["currentController"] = "admin/project/"; 
		$data["jsvar"] = json_encode($controller);
		$this->load->view('admin/project',$data);
		 
	} 


	function getList(){
		
		$this->param["fields"] = "ID, PROJECT, `DESC`, DATE_FORMAT(STARTDATE,'%M %d, %Y') STARTDATE, DATE_FORMAT(ENDDATE,'%M %d, %Y') ENDDATE, EVERY, 0 ASSETS, 0 EXPENSES, 0 TOTALCONTRIBUTION, 0 CALCULATEDTOTAL";
		$this->param["conditions"] = "STATUS = 1";
		$this->param["order"] = "PROJECT";
		$result = $this->query_model->getData($this->param);
		$result = $this->setResultProject($result);
		return $result;
	}

	function setResultProject($result){
		foreach ($result as $key) {
			$assets = $this->getTotalAssetsExpenses(1,$key->ID);
			$expenses = $this->getTotalAssetsExpenses(2,$key->ID);
			$total = $this->getTotalContributions($key->ID);
			$key->ASSETS = $assets;
			$key->EXPENSES = $expenses;
			$key->TOTALCONTRIBUTION = $total;
			$key->CALCULATEDTOTAL = ((float)$total + (float)$assets) - (float)$expenses;
		}
		 
		return $result;
	}

	function getTotalAssetsExpenses($type,$projectid){
		$this->param = $this->param = $this->query_model->param; 
		$this->param["table"] = "tblassetsexpenses";
		$this->param["fields"] = "SUM(CONTRIBUTIONS) TOTAL";
		$this->param["conditions"] = "PROJECTID = $projectid AND TYPE = $type";
		$result = $this->query_model->getData($this->param);
		return $result[0]->TOTAL;
	}

	function getTotalContributions($projectid){
		$this->param = $this->param = $this->query_model->param; 
		$this->param["table"] = "tblcontributorspayment cp";
		$this->param["fields"] = "SUM(cp.AMOUNTPAY) TOTAL";
		$this->param["joins"] = "INNER JOIN tblprojectcontributors pc ON cp.PROJECTCONTRIBID = pc. ID";
		$this->param["conditions"] = "pc.PROJECTID = $projectid AND cp.STATUS = 1";
		$result = $this->query_model->getData($this->param);
		return $result[0]->TOTAL;
	}

	function insert(){
		
		$insert["PROJECT"] = $this->input->post("PROJECT");
		$insert["DESC"] = $this->input->post("DESC");
		 
		$startdate = new DateTime($this->input->post("STARTDATE")); 
		$enddate = new DateTime($this->input->post("ENDDATE"));  

		$insert["STARTDATE"] = $startdate->format("Y-m-d");
		$insert["ENDDATE"] = $enddate->format("Y-m-d");  
		$insert["EVERY"] = $this->input->post("EVERY");
		$insert["STATUS"] = 1;
		$insert["CREATEDDATE"] = date("Y-m-d h:i s");

		$this->param["dataToInsert"] = $insert;
		 
		$result = $this->query_model->insertData($this->param);

		echo ($result == true || $result == false) ? $result : 1062;
	}


	function update(){
		
		$update["PROJECT"] = $this->input->post("PROJECT");
		$update["DESC"] = $this->input->post("DESC");
		 
		$startdate = new DateTime($this->input->post("STARTDATE")); 
		$enddate = new DateTime($this->input->post("ENDDATE"));  

		$update["STARTDATE"] = $startdate->format("Y-m-d");;  
		$update["ENDDATE"] = $enddate->format("Y-m-d");;  
		$update["EVERY"] = $this->input->post("EVERY");
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

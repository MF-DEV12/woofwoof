<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets extends CI_Controller {

 private $param;
 	function __construct(){
 		parent::__construct();
 		$this->param = $this->param = $this->query_model->param; 
 		$this->param["table"] = "tblcontributors";
 	}

	public function index()
	{
		$listassets = array();
		$data["index"] = 4;
		$data["projects"] = $this->getProjects();

		foreach ($data["projects"] as $key) {
			$listassets[$key->ID] = $this->getAssetsByProject($key->ID);
		}
	 
		$data["listassets"] = $listassets;
		$controller["currentController"] = "admin/assets/"; 
		$data["jsvar"] = json_encode($controller);
		$this->load->view('admin/assets',$data);
		 
	}

	function getProjects(){
		$this->param["table"] = "tblprojects p";
		$this->param["fields"] = "p.ID, PROJECT, SUM((CASE WHEN ae.STATUS = 1 AND ae.TYPE = 1 THEN ae.CONTRIBUTIONS ELSE 0 END)) TOTAL ";
		$this->param["joins"] = "LEFT JOIN tblassetsexpenses ae ON p.ID = ae.PROJECTID";
		$this->param["conditions"] = "ae.TYPE = 1";
		$this->param["order"] = "PROJECT";
		$result = $this->query_model->getData($this->param);
		return $result;
	} 

	function getAssetsByProject($project){
		$this->param = $this->param = $this->query_model->param; 
		$this->param["table"] = "tblassetsexpenses";
		$this->param["fields"] = "ID, REMARKS, CONTRIBUTIONS,  DATE_FORMAT(TRANSDATE,'%M %d, %Y') TRANSDATE ";
		$this->param["conditions"] = "STATUS = 1 and PROJECTID = $project AND TYPE = 1";
		$this->param["order"] = "TRANSDATE";
		$result = $this->query_model->getData($this->param);
		return $result; 
	}
  
	function insertAssetToProject(){
		$insert["PROJECTID"] = $this->input->post("PROJECTID"); 
		$insert["REMARKS"] = $this->input->post("REMARKS"); 
		$insert["TYPE"] = 1;
		$insert["CONTRIBUTIONS"] = $this->input->post("CONTRIBUTIONS"); 
		$transdate = new DateTime($this->input->post("TRANSDATE")); 
		$transdate = $transdate->format("Y-m-d");
		$insert["TRANSDATE"] = $transdate;  

		$this->param["table"] = "tblassetsexpenses";
		$this->param["dataToInsert"] = $insert;
		$this->query_model->insertData($this->param);

		echo json_encode(array("result"=>"ok"));

		 
	}

	function insertContributorsPayment(){
		$this->param["table"] = "tblcontributorspayment";
		$insert["PROJECTCONTRIBID"] = $this->input->post("PROJECTCONTRIBID");
		$insert["AMOUNTPAY"] = $this->input->post("AMOUNTPAY");
		$startdate = new DateTime($this->input->post("DATEPAYMENT"));  
		$insert["DATEPAYMENT"] = $startdate->format("Y-m-d");; 

		$this->param["dataToInsert"] = $insert;

		$result = $this->query_model->insertData($this->param); 
		echo ($result == true || $result == false) ? json_encode(array("result"=>"ok")) : json_encode(array("result"=>"1062"));
	}


	function removePayment(){
		$id = $this->input->post("ID");
		$update["STATUS"] = 0;
		$update["MAINTAINEDDATE"] = date("Y-m-d h:i s");

		$this->param["table"] = "tblcontributorspayment";
		$this->param["conditions"] = "ID = $id";
		$this->param["dataToUpdate"] = $update;

		$result = $this->query_model->updateData($this->param);
		echo ($result == true || $result == false) ? json_encode(array("result"=>"ok")) : json_encode(array("result"=>"1062"));

	}

	
	 
}

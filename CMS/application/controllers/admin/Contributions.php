<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contributions extends CI_Controller {

 private $param;
 	function __construct(){
 		parent::__construct();
 		$this->param = $this->param = $this->query_model->param; 
 		$this->param["table"] = "tblcontributors";
 	}

	public function index()
	{
		$listcotributors = array();
		$data["index"] = 3;
		$data["projects"] = $this->getProjects();

		foreach ($data["projects"] as $key) {
			$listcotributors[$key->ID] = $this->getContributorsByProject($key->ID);
		}
		$data["listcotributors"] = $listcotributors;
		$controller["currentController"] = "admin/contributions/"; 
		$data["jsvar"] = json_encode($controller);
		$this->load->view('admin/contributions',$data);
		 
	}

	function viewcontributions(){
		$id = $this->input->get("id");
		$data["project"] = $this->getProjectItem($id);
		$data["listdate"] = $this->getProjectRange($data["project"]); 
		$data["index"] = 3;
		 
		$this->load->view('admin/viewcontributions',$data);
	}

	function getProjects(){
		$this->param["table"] = "tblprojects p";
		$this->param["fields"] = "p.ID, PROJECT, SUM((CASE WHEN cp.STATUS = 1 THEN AMOUNTPAY ELSE 0 END)) TOTAL ";
		$this->param["joins"] = "INNER JOIN tblprojectcontributors pc ON p.ID = pc.PROJECTID ";
		$this->param["joins"] .= "LEFT JOIN tblcontributorspayment cp ON pc.ID = cp.PROJECTCONTRIBID "; 
		$this->param["order"] = "PROJECT";
		$result = $this->query_model->getData($this->param);
		return $result;
	}

	function getContributors(){
		$this->param["table"] = "tblcontributors";
		$this->param["fields"] = "ID value, CONCAT(FIRSTNAME, ' ', LASTNAME) label";
		$this->param["conditions"] = "STATUS = 1";
		$this->param["order"] = "FIRSTNAME, LASTNAME";
		$result = $this->query_model->getData($this->param);
		echo json_encode($result);
	}

	function getContributorsByProject($project){
		$this->param["queryFile"] = "reccontribution";
		$replace = array();
		$replace[] = array("KEY"=>"#project#","VALUE"=>$project);
		$this->param["queryReplace"] = $replace;
		$result = $this->query_model->getData($this->param); 
		return $result;
	}

	function getProjectItem($id){
		$this->param["table"] = "tblprojects";
		$this->param["fields"] = "*";
		$this->param["conditions"] = "ID = $id";
		$result = $this->query_model->getData($this->param);
		return $result[0];
	}

	function getProjectRange($item){
		$list =  array();
		$curDate = new DateTime();
		$curMonth = date_format($curDate, 'F');
		$curYEar = date_format($curDate, 'Y');

		$startDate = date_create($item->STARTDATE);

		$startMonth = date_format($startDate, 'F');
		$startYear = date_format($startDate, 'Y');
		$intMonth = date_format($startDate, 'm');


		while($curMonth != $startMonth || $curYEar != $startYear){
			$listObj = new StdClass();
			$listObj->MONTH = $startMonth;
			$listObj->YEAR = $startYear;
			$listObj->WEEKS = $this->weeks_in_month($startYear,$intMonth);
			$list[] = $listObj;

			$startDate->add(new DateInterval('P1M'));
			$startMonth = date_format($startDate, 'F');
			$startYear = date_format($startDate, 'Y'); 
			$intMonth = date_format($startDate, 'm');

		}
		$listObj = new StdClass();
		$listObj->MONTH = $startMonth;
		$listObj->YEAR = $startYear;
		$listObj->WEEKS = $this->weeks_in_month($startYear,$intMonth);
		$list[] = $listObj;
	 
		return (object)($list);

	}

	function weeks_in_month($year, $month){
		date_default_timezone_set('Asia/Manila');
		$list = array();
		$year = intval($year);
		$month = intval($month); 

	    $num_of_days = date("t", mktime(0,0,0,$month,1,$year));
	  
	    $num_of_weeks = 0; 
	    for($i=1; $i<=$num_of_days; $i++)
	    { 
	      $currentDate = new DateTime($year . "-" . $month . '-' . $i);	 
	      $day_of_week = date('N', strtotime($year . "-" . $month . '-' . $i));
	      if($day_of_week == 7){ 
	      	$list[] = $i;
	      	$num_of_weeks++;
	      }
	        
	    } 
	    $obj = new StdClass();
	    $obj->NUMWEEKS = $num_of_weeks;
	    $obj->LISTDAYS = implode(",", $list);
	    return $obj;
	  }

	function getPaymentHistory(){
		$pcID = $this->input->post("PROJECTCONTRIBID");
		$cond = "PROJECTCONTRIBID = $pcID AND STATUS = 1";

		$this->param["table"] = "tblcontributorspayment";
		$this->param["fields"] = "ID, AMOUNTPAY, DATE_FORMAT(DATEPAYMENT,'%M %d, %Y') DATEPAYMENT"; 
		$this->param["conditions"] = $cond;
		$this->param["order"] = "DATEPAYMENT DESC";

		$result = $this->query_model->getData($this->param);

		echo json_encode($result);
	}
	 
	function insertContributorsToProject(){
		$projectid = $this->input->post("PROJECTID");
		$listContrib = $this->input->post("CONTRIBUTORS");
		$contributions = $this->input->post("CONTRIBUTION");
		$startdate = new DateTime($this->input->post("STARTDATE")); 
		$startdate = $startdate->format("Y-m-d");

		$qry = " INSERT INTO tblprojectcontributors(PROJECTID, CONTRIBUTORSID, CONTRIBUTIONS, STARTDATE, STATUS) ";
		$qry .= "SELECT '$projectid', ID, $contributions, '$startdate', 1 FROM tblcontributors WHERE ID IN($listContrib) AND ID NOT IN(SELECT CONTRIBUTORSID FROM tblprojectcontributors WHERE PROJECTID = '$projectid');";
		
		$this->db->query($qry);
		$affected_rows =  $this->db->affected_rows();
		if($affected_rows > 0)
			$this->session->set_flashdata('result', $affected_rows . " row inserted.");
		echo json_encode(array("result"=>(($affected_rows > 0) ? "ok" : "not")));
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

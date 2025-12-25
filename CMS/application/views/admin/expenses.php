<!DOCTYPE html>
<html>
<head>
	<!-- Include meta tag to ensure proper rendering and touch zooming -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	  
	<title>Project Expenses</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/jquery-ui.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/bootstrap/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/bootstrap-tokenfield/tokenfield-typeahead.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/bootstrap-tokenfield/bootstrap-tokenfield.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/nav-slide.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/style.css');?>">
	<link href="<?=base_url('js/bootstrap-datepicker/css/bootstrap-datetimepicker.css');?>" rel="stylesheet" type="text/css" />
</head>
<body>
	
	<?php $this->load->view("header");?>
	<input type="hidden" id="js-vars" data-var='<?=$jsvar;?>'/>
	<div class="container" id="content"> 
		<div class="panel panel-primary">
	      <div class="panel-heading">Project Expenses</div>
	      <div class="panel-body">
	      		<div class="row">
					<?php if($projects) { ?>
					 	  	<div id="custom-search-input">
		                        <div class="input-group col-md-12">
		                            <input type="text" class="search-query form-control" placeholder="Search" />
		                            <span class="input-group-btn">
		                                <button class="btn btn-danger" type="button">
		                                    <span class=" glyphicon glyphicon-search"></span>
		                                </button>
		                            </span>
		                        </div>
		                    </div>
		            <?php } ?>
		            <!-- RESULT AFFECTED ROWS -->
						<?php if($this->session->flashdata('result')) {?>
							<p class="label label-info result"><?=$this->session->flashdata('result');?></p> 
						<?php }?>
						<!--  -->
					<div id="list-wrap" class="col-lg-12">	 
					 	<div class="panel-group" id="group">
					 	  <?php if($projects) { ?> 
					 	  	 <?php foreach ($projects as $row) { ?>
					 	  	 <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							      		<div class="btn-group pull-right" data-item='<?=json_encode($row);?>'>
							      			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" title="View"><span class="glyphicon glyphicon-search"></span> <span class="caret"></span></button>
							      			<ul class="dropdown-menu" role="menu"> 
									      		<li><a class="btn-view" data-toggle="collapse" data-parent="#group" href="#collapse<?=$row->ID;?>"><span class="glyphicon glyphicon-usd"></span> Expenses</a></li>
							      			</ul> 
							      		</div>
							        	
							      		<h4 class="list-group-item-heading"><?=$row->PROJECT?></h4>
							        	<p class="list-group-item-text">Total Expenses: <b>&#x20B1 <?=$row->TOTAL?></b></p>
							      </h4>
							    </div>
							    <div id="collapse<?=$row->ID?>" class="panel-collapse collapse">
							      <div class="panel-body">
							      		<a class="btn btn2 btn-link btn-assets" data-toggle="modal" data-target="#assets-form" data-backdrop="static"  data-keyboard="false" data-item='<?=json_encode($row);?>'><span class="glyphicon glyphicon-plus"></span> Add Expenses(s)</a>

							      		<div class="list-group" id="list-assets">
							      		  <?php if($listassets[$row->ID]) { 
							      		  	foreach($listassets[$row->ID] as $rowcontrib) { ?>
											  <a href="#" class="list-group-item"> 
											   
											    <h4 class="list-group-item-heading"><?=$rowcontrib->REMARKS;?></h4>
											    <p class="list-group-item-text border-bottom">Transaction Date: <?=$rowcontrib->TRANSDATE;?></p>
											    <p class="list-group-item-text border-bottom">Amount: <b class="label label-info pull-right">&#x20B1 <?=number_format($rowcontrib->CONTRIBUTIONS,2);?></b></p>
											   

											  </a>
										  <?php } 
										  	} ?> 
										</div>

							      </div>
							    </div>
							     
							  </div> 
					 	  
					 	  <?php  } ?>
					 	  <?php } else{ ?>
					 	  		<!-- NO RECORDS FOUND  -->
					 	  		<label class="label label-default pull-right">No record(s) found.</label> 
					 	  <?php } ?> 
						</div>
					</div> 
			 
				</div>

	      </div>
	    </div>
		 
		
			
				 
			

		

	</div>

 	<div id="assets-form" class="modal fade" role="dialog">
	  <div class="modal-dialog"> 
	    <!-- Modal content-->
	    <div class="modal-content" >
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>

	        <h4 class="modal-title">Add Expenses - <project></project></h4>

	      </div>
	      <div class="modal-body">
	         <div class="row" style="padding: 0 36px;"> 
	         		<form id='form-main'> 
		         		
			         	<div class='form-group'>
			         		<label for='CONTRIBUTIONS'>Amount:</label>
			         		<input class='form-control' id='CONTRIBUTIONS' type='text' data-type="unique"/> 
			         	</div>
			         	<div class='form-group'>
		         			<label for='REMARKS'>Remarks:</label>
							<input type="text" class="form-control" id="REMARKS" data-type="unique" />  
		         		</div>
			         	<div class='form-group'>
			     			<label for='TRANSDATE'>Transaction Date:</label>
			     			<div class='input-group date '>
			         			<input class='form-control' id='TRANSDATE' type='text' data-type="required"/> 
			         			<span class="input-group-addon material-dropdown" id="TRANSDATEs"><span class="glyphicon glyphicon-calendar"></span><span class="mdi mdi-menu-down"></span></span>
			         		</div>
			     		</div>
		         	</form>
	         </div>
	      </div>
	      <div class="modal-footer">
		      <div class='btn-group pull-right'>
				      	<button type="button" class="btn btn-primary btn-addassets">Add</button>
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		       </div>
	      	
	      </div>
	    </div>

	  </div>
	</div>

	 
 

 
	 
 
	<script type="text/javascript" src='<?=base_url("js/jquery/jquery-1.11.3.js")?>'></script>
	<script type="text/javascript" src='<?=base_url("js/jquery/jquery-ui.js")?>'></script>
	<script type="text/javascript" src='<?=base_url("js/bootstrap/bootstrap.min.js")?>'></script>
	<script type="text/javascript" src='<?=base_url("js/bootstrap-tokenfield/bootstrap-tokenfield.min.js")?>'></script>
	<script type="text/javascript" src='<?=base_url("js/bootstrap-tokenfield/affix.js")?>'></script>
	<script type="text/javascript" src='<?=base_url("js/bootstrap-tokenfield/docs.js")?>'></script>
	<script type="text/javascript" src='<?=base_url("js/bootstrap-tokenfield/scrollspy.js")?>'></script>
	<script type="text/javascript" src='<?=base_url("js/bootstrap-tokenfield/typehead.bundle.min.js")?>'></script>
	<script type="text/javascript" src='<?=base_url("js/nav-slide.js")?>'></script>

	<script type="text/javascript" src="<?=base_url('js/bootstrap-datepicker/js/moment.min.js');?>"></script> 
    <script type="text/javascript" src="<?=base_url('js/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js');?>"></script> 
    <script type="text/javascript" src="<?=base_url('js/bootbox.min.js');?>"></script> 
    <script type="text/javascript" src='<?=base_url('js/maskMoney.js');?>'></script> 
	<script type="text/javascript" src='<?=base_url("js/utility/ajaxCall.js")?>'></script>
	<script type="text/javascript" src='<?=base_url("js/admin/maintenance.js")?>'></script>
	<script type="text/javascript" src='<?=base_url("js/admin/expenses.js")?>'></script>
	 
</body>
	
</html>
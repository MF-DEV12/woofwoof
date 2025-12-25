<!DOCTYPE html>
<html>
<head>
	<!-- Include meta tag to ensure proper rendering and touch zooming -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	  
	<title>Record of Contributions</title>
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
	      <div class="panel-heading">Record of Contributions</div>
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
						      				<li><a class="btn-viewcontributions" data-param="<?=$row->ID;?>" href="<?=base_url('admin/contributions/viewcontributions?id='. $row->ID);?>"><span class="glyphicon glyphicon-calendar" ></span> Contributions</a></li>
								      		<li><a class="btn-view" data-toggle="collapse" data-parent="#group" href="#collapse<?=$row->ID;?>"><span class="glyphicon glyphicon-user"></span> Contributors</a></li>
						      			</ul> 
						      		</div>
						        	
						      		<h4 class="list-group-item-heading"><?=$row->PROJECT?></h4>
						        	<p class="list-group-item-text">Total Contributions: <b>&#x20B1 <?=$row->TOTAL?></b></p>
						      </h4>
						    </div>
						    <div id="collapse<?=$row->ID?>" class="panel-collapse collapse">
						      <div class="panel-body">
						      		<a class="btn btn2 btn-link btn-addcontributors" data-toggle="modal" data-target="#contributors-form" data-backdrop="static"  data-keyboard="false"><span class="glyphicon glyphicon-plus"></span> Add Contributor(s)</a>

						      		<div class="list-group" id="list-contributors">
						      		  <?php if($listcotributors[$row->ID]) { 
						      		  	foreach($listcotributors[$row->ID] as $rowcontrib) { ?>
										  <a href="#" class="list-group-item"> 
										    <button class="btn btn2 btn-link pull-right btn-payment" data-item='<?=json_encode($rowcontrib);?>' data-toggle="modal" data-target="#payment-form" data-backdrop="static"  data-keyboard="false" title="Set Payment"> <span class="glyphicon glyphicon-edit"></span></button>
										    <button class="btn btn2 btn-link pull-right btn-history" data-item='<?=json_encode($rowcontrib);?>' data-toggle="modal" data-target="#history-form" data-backdrop="static"  data-keyboard="false" title=" Payment History"><span class="glyphicon glyphicon-search"></span></button>
										    <h4 class="list-group-item-heading"><?=$rowcontrib->NAME;?></h4>
										    <p class="list-group-item-text border-bottom">Contributions: <b class="pull-right">&#x20B1 <?=number_format($rowcontrib->CONTRIBUTIONS,2);?></b></p>
										    <p class="list-group-item-text border-bottom">Remaining: <b class="label label-danger pull-right"> &#x20B1 <?=number_format($rowcontrib->REM_CONTRIB,2);?></b></p>
										    <p class="list-group-item-text border-bottom">Total Paid: <b class="label label-primary pull-right"> &#x20B1 <?=number_format($rowcontrib->TOTALPAYMENT,2);?></b></p>

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

 	<div id="contributors-form" class="modal fade" role="dialog">
	  <div class="modal-dialog"> 
	    <!-- Modal content-->
	    <div class="modal-content" >
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>

	        <h4 class="modal-title">Add Contributors</h4>

	      </div>
	      <div class="modal-body">
	         <div class="row" style="padding: 0 36px;"> 
	         		<form id='form-main'> 
		         		<div class='form-group'>
		         			<label for='CONTRIBUTORS'>Specify the Contributors:</label>
							<input type="text" class="form-control" id="CONTRIBUTORS" data-type="unique" /> 

		         		</div>
			         	<div class='form-group'>
			         		<label for='CONTRIBUTION'>Contributions:</label>
			         		<input class='form-control' id='CONTRIBUTION' type='text' data-type="unique"/> 
			         	</div>
			         	<div class='form-group'>
			     			<label for='STARTDATE'>Start Date:</label>
			     			<div class='input-group date '>
			         			<input class='form-control' id='STARTDATE' type='text' data-type="required"/> 
			         			<span class="input-group-addon material-dropdown" id="STARTDATEs"><span class="glyphicon glyphicon-calendar"></span><span class="mdi mdi-menu-down"></span></span>
			         		</div>
			     		</div>
		         	</form>
	         </div>
	      </div>
	      <div class="modal-footer">
		      <div class='btn-group pull-right'>
				      	<button type="button" class="btn btn-primary btn-addcontrib">Add</button>
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		       </div>
	      	
	      </div>
	    </div>

	  </div>
	</div>

	<div id="payment-form" class="modal fade" role="dialog">
	  <div class="modal-dialog"> 
	    <!-- Modal content-->
	    <div class="modal-content" >
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>

	        <h4 class="modal-title">Set Payment</h4>

	      </div>
	      <div class="modal-body">
	         <div class="row" style="padding: 0 36px;"> 
	         		<form id='form-main'> 
		         		 
			         	<div class='form-group'>
			         		<label for='AMOUNTPAY'>Amount:</label>
			         		<input class='form-control' id='AMOUNTPAY' type='text' data-type="unique"/> 
			         	</div>
			          	<div class='form-group'>
			     			<label for='DATEPAYMENT'>Date of payment:</label>
			     			<div class='input-group date '>
			         			<input class='form-control' id='DATEPAYMENT' type='text' data-type="required"/> 
			         			<span class="input-group-addon material-dropdown" id="STARTDATEs"><span class="glyphicon glyphicon-calendar"></span><span class="mdi mdi-menu-down"></span></span>
			         		</div>
			     		</div>
		         	</form>
	         </div>
	      </div>
	      <div class="modal-footer">
		      <div class='btn-group pull-right'>
				      	<button type="button" class="btn btn-primary btn-addpayment">Submit</button>
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		       </div>
	      	
	      </div>
	    </div>

	  </div>
	</div>

	<div id="history-form" class="modal fade" role="dialog">
	  <div class="modal-dialog"> 
	    <!-- Modal content-->
	    <div class="modal-content" >
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>

	        <h4 class="modal-title">Payment History - <contributors></contributors></h4>
	      </div>
	      <div class="modal-body">
	         <p class="label label-info" id="result-history">1 payment has been removed.</p>

	         <div class="row" style="padding: 0 36px;"> 
	         		<form id='form-main'> 
		         		 <div class="list-group" id="list-history">
			         		 
						</div> 
		         	</form>
	         </div>
	      </div>
	      <div class="modal-footer"> 
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
	<script type="text/javascript" src='<?=base_url("js/admin/contributions.js")?>'></script>
	 
</body>
	
</html>
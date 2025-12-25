<!DOCTYPE html>
<html>
<head>
	<!-- Include meta tag to ensure proper rendering and touch zooming -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	  
	<title>Contributions</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/jquery-ui.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/bootstrap/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/datatables/jquery.dataTables.css')?>">
	 
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/style.css');?>">
	<link href="<?=base_url('js/bootstrap-datepicker/css/bootstrap-datetimepicker.css');?>" rel="stylesheet" type="text/css" />
</head>
<body>
	
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="slide-nav">
	  <div class="container">
	   <div class="navbar-header">
	   
	    <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-calendar" ></span> Contributions of <?=$project->PROJECT;?></a>
	   </div>
	   <!--   <ul class="nav navbar-nav pull-right" >
	     	<li><a href="<?=base_url('admin/contributions');?>"> <span class="glyphicon glyphicon-menu-left"></span> Back</a></li> 
	    </ul> -->
	          
	  </div>
	</div>	

	<div class="container" id="content">
	<div class="panel panel-primary">
      <div class="panel-heading">List of the Contributions</div>
      <div class="panel-body"> 
      		 
      		<img id="loading-contribution" src="<?=base_url('images/viewcontribution.gif')?>" alt="">
      		<table id="list-contributions" class="display" cellspacing="0" width="100%"> 
				<thead>
					<tr>
						<th rowspan="2" class="contrib-th">Contributor's Name</th>  
						<?php foreach($listdate as $key) { ?>
							<th colspan="<?=$key->WEEKS->NUMWEEKS;?>" class="text-center border-th border-th-top"><?=$key->MONTH . " " . $key->YEAR;?></th>
						<?php } ?> 
					</tr>
					<tr> 
						<?php foreach($listdate as $key) { $listweeks = explode(",",$key->WEEKS->LISTDAYS);?> 
							<?php foreach($listweeks as $day) { ?>
								<td class="text-center border-th"><?=$day . "-" . substr($key->MONTH, 0, 3);?> </td>
							<?php } ?> 
						<?php } ?> 
					</tr>
				</thead>
				<tbody>
					<?php for($i=1;$i<=10;$i++) {?> 
						<tr>
							<td>#<?=$i;?></td>
							<?php foreach($listdate as $key) { $listweeks = explode(",",$key->WEEKS->LISTDAYS);?> 
								<?php foreach($listweeks as $day) { ?>
									<td>--</td>
								<?php } ?> 
								
						 
							<?php } ?> 
						</tr>
					<?php } ?>
					
				</tbody>
				
			</table>
      </div>
    </div>
	


	</div>
	  
 
	 
 
	<script type="text/javascript" src='//code.jquery.com/jquery-1.12.0.min.js'></script>
	<script type="text/javascript" src='<?=base_url("js/jquery/jquery-ui.js")?>'></script>
	<script type="text/javascript" src='<?=base_url("js/bootstrap/bootstrap.min.js")?>'></script>
	<script type="text/javascript" src='https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js'></script>
	<script type="text/javascript" src='https://cdn.datatables.net/fixedcolumns/3.2.1/js/dataTables.fixedColumns.min.js'></script>
	
    <script type="text/javascript" src="<?=base_url('js/bootbox.min.js');?>"></script> 
    <script type="text/javascript" src='<?=base_url('js/maskMoney.js');?>'></script> 
	<script type="text/javascript" src='<?=base_url("js/utility/ajaxCall.js")?>'></script> 
	<script type="text/javascript" src='<?=base_url("js/admin/viewcontributions.js")?>'></script>
	 
</body>
	
</html>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="slide-nav">
	  <div class="container">
	   <div class="navbar-header">
	    <a class="navbar-toggle"> 
	      <span class="sr-only">Toggle navigation</span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	     </a>
	    <a class="navbar-brand" href="#">Contributions Management System</a>
	   </div>
	   <div id="slidemenu">
	      
	    <ul class="nav navbar-nav pull-right">
	     <li <?=(($index == 1) ? "class='active'" : "");?>><a href="<?=base_url('admin/project');?>">Projects</a></li>
	     <li <?=(($index == 2) ? "class='active'" : "");?>><a href="<?=base_url('admin/contributors');?>">Contributors</a></li>
	     <li <?=(($index == 3) ? "class='active'" : "");?>><a href="<?=base_url('admin/contributions');?>">Contributions</a></li> 
	     <li <?=(($index == 4) ? "class='active'" : "");?>><a href="<?=base_url('admin/assets');?>">Assets</a></li>
	     <li <?=(($index == 5) ? "class='active'" : "");?>><a href="<?=base_url('admin/expenses');?>">Expenses</a></li> 
	    </ul>
	          
	   </div>
	  </div>
</div>	
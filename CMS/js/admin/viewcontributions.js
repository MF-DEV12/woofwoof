$(document).ready(function() {
	
 
	 

  $(window).load(function (){
    $("#loading-contribution").fadeOut("slow",function(){ 
          $('#list-contributions').DataTable( {
              scrollY:        400,
              scrollX:        true,
              scrollCollapse: true,
              paging:         false,
              fixedColumns:   true,
              aoColumnDefs: [
                 { aTargets: [ '_all' ], bSortable: false },
                 { aTargets: [ 0 ], bSortable: true }
              ]
          } );
          $("#list-contributions")
           .css("visibility","visible")
           .fadeIn() 

    }); 	 

  })

})
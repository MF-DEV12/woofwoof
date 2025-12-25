var jsvar = new Object();
var param = new Object();
var mode = "";
var curCtrl = "";
  

$(function(){

	$(window).load(function (){
		$(".result").fadeOut(8000)
		jsvar = $("#js-vars").data("var")
		curCtrl = jsvar.currentController

	})


	$('.date').datetimepicker({
        format: 'LL' 
    });


	$("#btn-add").click(function (e){
		$(".form-group").removeClass("required");
		$(".form-group").find("input").val("")
		mode = "new"
	})

	$("button.btn-save,a.btn-save").click(function (e){
		var elem = (mode == "new") ? $("#maintenance-form") : $(this).closest(".panel").find(".panel-body");
		var ctrl = (mode == "new") ? "insert" : "update";
		var conf = (mode == "new") ? "Do you want to save this data?" : "Do you want to update this data?"

		if(!isOkayToSave(elem)) return;
		 
		if(mode != "new"){
			var item = $(this).closest(".btn-group").data("item")
			param["ID"] = item.ID
		}

		bootbox.confirm(conf, function (result){
			if(result){
				callAjaxJson(curCtrl + ctrl,
								param,
								successData,
								ajaxError)
			}
		})
		 
	})
 
	$(".btn-edit").click(function (e){
		var elem = $(this)
		var data = elem.closest(".btn-group").data("item")
		mode = "edit" 
		for(x in data){
			elem.closest(".panel").find(".panel-body").find("#" + x.toUpperCase()).val(data[x])
		}
		$(".editmode").hide()
		$(".savemode").show()
		$(".selected").removeClass("selected");
		elem.closest(".panel-heading").addClass("selected")
		elem.closest(".panel").find(".savemode").hide()
		elem.closest(".panel").find(".editmode").show()
	})

	$(".btn-cancel").click(function (e){
	 	var elem = $(this)
	 	$(".selected").removeClass("selected");
		elem.closest(".panel").find(".savemode").show()
		elem.closest(".panel").find(".editmode").hide()
	})

	$("#btn-remove").click(function (e){
		var paramID = new Array()
		var elem = $(this)
		$(".chkElem:checked").each(function(i){
			var curItem = $(this)
			paramID.push(curItem.attr("id").replace("chk-",""))
		})

		if(!paramID.length){return;}

		bootbox.confirm("Delete all marked item? ", function (result){
			if(result){
					param = new Object()
					param.ID = paramID.join(",");

					callAjaxJson(curCtrl + "remove",
								param,
								function (response){
									location.href = baseUrl + curCtrl
								},
								ajaxError())
			}
		}) 

	})

	$("#btn-check").click(function (e){
		var elem = $(this)
		var check = elem.attr("data-value")

		if(check !== "true"){
			elem.find("span.glyphicon").removeClass("glyphicon-unchecked")
			elem.find("span.glyphicon").addClass("glyphicon-check")
			check = true
		}
		else{
			elem.find("span.glyphicon").removeClass("glyphicon-check")
			elem.find("span.glyphicon").addClass("glyphicon-unchecked")
			check = false

		}
 		$("div.panel:not(.not-search) .chkElem").prop("checked",check)

 		$("div.panel:not(.not-search) .chkElem").change()
 		
		elem.attr("data-value", check.toString())
		elem.find("text").text(((check.toString() === "true") ? "Unmark all" : "Mark all"))


	})

	$(".chkElem").change(function (e){
		var elem = $(this)
		if(elem.prop("checked"))
			elem.closest(".panel-heading").addClass("checked")
		else
			elem.closest(".panel-heading").removeClass("checked")
	})

	$('.search-query').keyup(function (e){
		var src = $(this).val()
		$(".not-search").removeClass("not-search")
		$(".list-group-item-heading:not(:Contains('"+ src +"'))").closest(".panel").addClass("not-search")

		 
		$("#btn-check")
			.attr("data-value","false") 
			.find("text").text("Mark all")
		
	})
 	
 	jQuery.expr[':'].Contains = function(a, i, m) { 
	  return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0; 
	};

})

function isOkayToSave(elem){
	var isOkay = true;
	param = new Object();
	$(".form-group").removeClass("required");
	elem.find("#form-main").find("input.form-control,select.form-control").each(function (e){
		var cur = $(this) 

		if(cur.val() == ""){
			if(hastAttr(cur,"data-type"))
				cur.closest(".form-group").addClass("required"); 
			isOkay = false;
		}
		else{
			if(hastAttr(cur,"data-type")){
				cur.closest(".form-group").removeClass("required"); 
			}
			param[cur.attr("id")] = cur.val();
		}
	})
	return isOkay;
}


 function successData(response){
	location.href = baseUrl + curCtrl 
 }

function hastAttr(elem,attr){
	var attr = elem.attr(attr); 
	 
	if (typeof attr !== typeof undefined && attr !== false) 
	   	return true
	else
		return false
	
}
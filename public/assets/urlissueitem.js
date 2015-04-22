$(document).ready(function(){
	/*点击添加弹框内容变化为当前内容*/
	$("button#add").bind("click",function(){
		$("#myModal").find("button#add_btn").show();
		$("#myModal").find("button#update_btn").hide();
		$("#myModal").find("#idInput").val("");
		$("#myModal").find("#parentsSelect").val("");
		$("#myModal").find("#itemInput").val("");
		$("#myModal").find("#linkInput").val("");
		$("#myModal").find("#describeInput").val("");
	});
	/*添加框点击保存按钮*/		
	$("button#add_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var cate_key = $("#myModal").find("#parentsSelect").val();
		var item_key = $("#myModal").find("#itemInput").val();
		var link = $("#myModal").find("#linkInput").val();
		var describe = $("#myModal").find("#describeInput").val();
		$(".span12").load("addUrlissueItem",{'cate_key':cate_key,'item_key':item_key,'link':link,'describe':describe,'page':page},
				function(msg){
				});
	});
	/*点击修改后修改弹框内容变化为当前内容*/
	$("button#update").bind("click",function(){
		$("#myModal").find("button#add_btn").hide();
		$("#myModal").find("button#update_btn").show();
		var id = $(this).parents("tr").find("td").eq(0).text();
		var cate_key = $(this).parents("tr").find("#cate_keyInput").val();
		var item_key = $(this).parents("tr").find("td").eq(2).text();
		var link = $(this).parents("tr").find("td").eq(3).text();
		var describe = $(this).parents("tr").find("td").eq(4).text();
		$("#myModal").find("#idInput").val(id);
		$("#myModal").find("#parentsSelect option").removeAttr("selected");
		$("#myModal").find("#parentsSelect").find("option[value="+cate_key+"]").attr('selected',true);	
		$("#myModal").find("#itemInput").val(item_key);
		$("#myModal").find("#linkInput").val(link);
		$("#myModal").find("#describeInput").val(describe);
		/*修改弹框点击保存按钮*/						
	});
	$("button#update_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $("#myModal").find("#idInput").val();
		var cate_key = $("#myModal").find("#parentsSelect").val();
		var item_key = $("#myModal").find("#itemInput").val();
		var link = $("#myModal").find("#linkInput").val();
		var describe = $("#myModal").find("#describeInput").val();
		$(".span12").load("updateUrlissueItem",{'id':id,'cate_key':cate_key,'item_key':item_key,'link':link,'describe':describe,'page':page},
				function(msg){
				});
	});
	/*点击删除按钮*/
	$("button#del").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $(this).parents("tr").find("td").eq(0).text();
		window.location="delUrlissueItem?id="+id+"&page="+page;
	});	
});
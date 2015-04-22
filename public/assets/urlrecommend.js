$(document).ready(function(){
	/*点击添加弹框内容变化为当前内容*/
	$("button#add").bind("click",function(){
		$("#myModal").find("button#add_btn").show();
		$("#myModal").find("button#update_btn").hide();
		$("#myModal").find("#idInput").val("");
		$("#myModal").find("#nameInput").val("");
		$("#myModal").find("#linkInput").val("");
		$("#myModal").find("#newPoInput").val("");	
	});
	/*添加框点击保存按钮*/		
	$("button#add_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var name = $("#myModal").find("#nameInput").val();
		var link = $("#myModal").find("#linkInput").val();
		var position = $("#myModal").find("#newPoInput").val();
		$(".span12").load("addUrlReCommend",{'name':name,'link':link,'position':position,'page':page},
				function(msg){
					alert(msg);
				});
	});
	/*点击修改后修改弹框内容变化为当前内容*/
	$("button#update").bind("click",function(){
		$("#myModal").find("button#add_btn").hide();
		$("#myModal").find("button#update_btn").show();
		var id = $(this).parents("tr").find("td p").eq(0).text();
		var name = $(this).parents("tr").find("td").eq(1).text();
		var link = $(this).parents("tr").find("td").eq(2).text();
		var oldPo = $(this).parents("tr").find("td").eq(3).text();
		$("#myModal").find("#idInput").val(id);
		$("#myModal").find("#nameInput").val(name);
		$("#myModal").find("#linkInput").val(link);
		$("#myModal").find("#oldPoInput").val(oldPo);
		$("#myModal").find("#newPoInput").val(oldPo);								
	});
	/*修改弹框点击保存按钮*/
	$("button#update_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $("#myModal").find("#idInput").val();
		var name = $("#myModal").find("#nameInput").val();
		var link = $("#myModal").find("#linkInput").val();
		var oldPo = $("#myModal").find("#oldPoInput").val();
		var newPo = $("#myModal").find("#newPoInput").val();
		$(".span12").load("updateUrlReCommend",{'id':id,'name':name,'link':link,
			'oldPo':oldPo,'newPo':newPo,'page':page},
				function(msg){
				});
	});
	/*点击删除按钮*/
	$("button#del").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $(this).parents("tr").find("td p").eq(0).text();
		window.location="delUrlReCommend?id="+id+"&page="+page;
	});	
	/*保存位置*/
	$("tbody.drag_tr.ui-sortable tr").bind("mouseup",function(){		
		if($("span.label.label-default.drag_holder").css("display")!="none"){
			var ThisId = $(this).find("td p").eq(0).text();
			setTimeout(function(){
				$("tbody.drag_tr.ui-sortable tr").each(function(){
					if($(this).find("td p").eq(0).text() == ThisId){
						var PrevId = $(this).prev("tr").find("td p").eq(0).text();
						var NextId = $(this).next("tr").find("td p").eq(0).text();
						$.post("savePostionUrlRecommend",{'ThisId':ThisId,"PrevId":PrevId,"NextId":NextId},
								function(msg){
								});
					}
				});
				
			},1000);
		}	
	});
});
$(document).ready(function(){
	/*点击添加弹框内容变化为当前内容*/
	$("button#add").bind("click",function(){
		$("#myModal").find("button#add_btn").show();
		$("#myModal").find("button#update_btn").hide();
		$("#myModal").find("#titleInput").val("");	
		$("#myModal").find("#newPoInput").val("");
	});
	/*添加框点击保存按钮*/		
	$("button#add_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var title = $("#myModal").find("#titleInput").val();
		$(".span12").load("addNavicate",{'title':title,'position':position,'page':page},
				function(msg){
				});
	});
	/*点击修改后修改弹框内容变化为当前内容*/
	$("button#update").bind("click",function(){
		$("#myModal").find("button#add_btn").hide();
		$("#myModal").find("button#update_btn").show();
		var id = $(this).parents("tr").find("td p").eq(0).text();
		var title = $(this).parents("tr").find("td").eq(1).text();
		var oldPo = $(this).parents("tr").find("td").eq(2).text();
		$("#myModal").find("#idInput").val(id);
		$("#myModal").find("#titleInput").val(title);
		$("#myModal").find("#oldPoInput").val(oldPo);
		$("#myModal").find("#newPoInput").val(oldPo);
		/*修改弹框点击保存按钮*/						
	});
	$("button#update_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $("#myModal").find("#idInput").val();
		var title = $("#myModal").find("#titleInput").val();
		var oldPo = $("#myModal").find("#oldPoInput").val();
		var newPo = $("#myModal").find("#newPoInput").val();
		$(".span12").load("updateNavicate",{'id':id,'title':title,'oldPo':oldPo,'newPo':newPo
			,'page':page},
				function(msg){
				});
	});
	/*点击删除按钮*/
	$("button#del").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $(this).parents("tr").find("td p").eq(0).text();
		$.post("delNaviCate",
				{'id':id},
				function(msg){
					if(msg == 'sucess'){
						window.location="navicate?page="+page;
					}
					else{
						alert("删除错误，请先删除关联子类");
					}
				});
	});	
	/*保存位置*/
	$("tbody.drag_tr.ui-sortable tr").bind("mouseup",function(){		
		if($("span.label.label-default.drag_holder").css("display")!="none"){
			var ThisId = $(this).find("td p").eq(0).text();
			setTimeout(function(){
				$("tbody.drag_tr.ui-sortable tr").each(function(){
					if($(this).find("td p").eq(0).text() == ThisId){
						var PrevId = $(this).prev("tr").find("td p").eq(0).text()
						var NextId = $(this).next("tr").find("td p").eq(0).text()
						$.post("savePostionNaviCate",{'ThisId':ThisId,"PrevId":PrevId,"NextId":NextId},
								function(msg){
								});
					}
				});
				
			},1000);
		}	
	});
});
$(document).ready(function(){
	/*点击添加弹框内容变化为当前内容*/
	$("button#add").bind("click",function(){
		$("#myModal").find("button#add_btn").show();
		$("#myModal").find("button#update_btn").hide();
		$("#myModal").find("#idInput").val("");
		$("#myModal").find("#titleInput").val("");
		$("#myModal").find("#dcrpInput").val("");
	});
	/*添加框点击保存按钮*/		
	$("button#add_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var title = $("#myModal").find("#titleInput").val();
		var dcrp = $("#myModal").find("#dcrpInput").val();
		$.ajaxFileUpload
		(
			{
				url:'addLitecategory',
				secureuri:false,
				fileElementId:'iconInput',
				dataType: 'json',
				data:{'title':title,'dcrp':dcrp,'page':page},
				success: function (content)
				{
					$(".span12").empty();
					$(".span12").append(content);
				},
				error: function (msg)
				{
					alert(msg);
				}
			}
		);
	});
	/*点击修改后修改弹框内容变化为当前内容*/
	$("button#update").bind("click",function(){
		$("#myModal").find("button#add_btn").hide();
		$("#myModal").find("button#update_btn").show();
		var id = $(this).parents("tr").find("td p").eq(0).text();
		var title = $(this).parents("tr").find("td").eq(1).text();
		var img = $(this).parents("tr").find("td").eq(2).text();
		var dcrp = $(this).parents("tr").find("td").eq(3).text();		
		$("#myModal").find("#idInput").val(id);
		$("#myModal").find("#titleInput").val(title);
		$("#myModal").find("#iconInput").attr("value",img);
		$("#myModal").find("#dcrpInput").val(dcrp);
	});
	/*修改弹框点击保存按钮*/
	$("button#update_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $("#myModal").find("#idInput").val();
		var title = $("#myModal").find("#titleInput").val();
		var dcrp = $("#myModal").find("#dcrpInput").val();
		$.ajaxFileUpload
		(
			{
				url:'updateLitecategory',
				secureuri:false,
				fileElementId:'iconInput',
				dataType: 'json',
				data:{'id':id,'title':title,'dcrp':dcrp,'page':page},
				success: function (content)
				{
					$(".span12").empty();
					$(".span12").append(content);
				},
				error: function (msg)
				{
					alert(msg);
				}
			}
		);
	});
	/*修改弹框点击保存按钮*/
	$("button#del").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $(this).parents("tr").find("td p").eq(0).text();
		$.post("delLitecategory",
				{'id':id},
				function(msg){
					if(msg == 'sucess'){
						window.location="litecategory?page="+page;
					}
					else{
						alert("删除错误，请先删除关联轻应用");
					}
		});
	});
	/*上线下线按钮*/
	$("button#offline").bind("click",function(){
		var name = $(this).text();
		if (name == "暂时下线") {
			$(this).text("上线");
			$(this).parents("tr").removeClass("success");
			$(this).parents("tr").addClass("error");	
		}
		else {
			$(this).text("暂时下线");
			$(this).parents("tr").removeClass("error");
			$(this).parents("tr").addClass("success");
		}
		var id = $(this).parents("tr").find("td p").eq(0).text();
		$.post("changeLiteCategoryOpens",{'id':id},function(){
			
		});
	});
	$("#iconInput").change(function(){
		//判断图片是否符合标准
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
						//选择改变位置的方法
						$.post("savepostionlitecategory",{'ThisId':ThisId,"PrevId":PrevId,"NextId":NextId},
								function(msg){
								});
					}
				});
				
			},1000);
		}	
	});
});
$(document).ready(function(){
	/*点击添加弹框内容变化为当前内容*/
	$("button#add").bind("click",function(){
		$("#myModal").find("button#add_btn").show();
		$("#myModal").find("button#update_btn").hide();
		$("#myModal").find("#idInput").val("");
		$("#myModal").find("#keyInput").val("");
		$("#myModal").find("#versionInput").val("");
		$("#myModal").find("#desInput").val("");
	});
	/*添加框点击保存按钮*/		
	$("button#add_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var key = $("#myModal").find("#keyInput").val();
		var version = $("#myModal").find("#versionInput").val();
		var description = $("#myModal").find("#desInput").val();
		$(".span12").load("addVersion",{'key':key,'version':version,
			'description':description,'page':page},
				function(msg){
				});
	});
	/*点击修改后修改弹框内容变化为当前内容*/
	$("button#update").bind("click",function(){
		$("#myModal").find("button#add_btn").hide();
		$("#myModal").find("button#update_btn").show();
		var id = $(this).parents("tr").find("td").eq(0).text();
		var key = $(this).parents("tr").find("td").eq(1).text();
		var version = $(this).parents("tr").find("td").eq(2).text();
		var description = $(this).parents("tr").find("td").eq(3).text();
		var issue_time = $(this).parents("tr").find("td").eq(4).text();
		$("#myModal").find("#idInput").val(id);
		$("#myModal").find("#keyInput").val(key);
		$("#myModal").find("#versionInput").val(version);
		$("#myModal").find("#desInput").val(description);
		/*修改弹框点击保存按钮*/						
	});
	$("button#update_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $("#myModal").find("#idInput").val();
		var key = $("#myModal").find("#keyInput").val();
		var version = $("#myModal").find("#versionInput").val();
		var description = $("#myModal").find("#desInput").val();
		$(".span12").load("updateVersion",{'id':id,'key':key,'version':version,
			'description':description,'page':page},
				function(msg){
				});
	});
	/*点击删除按钮*/
	$("button#del").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $(this).parents("tr").find("td").eq(0).text();
		window.location="delVersion?id="+id+"&page="+page;
	});	
});
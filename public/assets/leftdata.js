$(document).ready(function(){
	/*点击添加弹框内容变化为当前内容*/
	$("button#add").bind("click",function(){
		$("#myModal").find("button#add_btn").show();
		$("#myModal").find("button#update_btn").hide();
		$("#myModal").find("#titleInput").val("");
		$("#myModal").find("#urlInput").val("");
		$("#myModal").find("#iconInput").val("");
	});
	/*添加框点击保存按钮*/		
	$("button#add_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var title = $("#myModal").find("#titleInput").val();
		var url = $("#myModal").find("#urlInput").val();
		var iconUrl = $("#myModal").find("#iconInput").val();
		$(".span12").load("addLeftdata",{'title':title,'url':url,'iconUrl':iconUrl,'page':page},
				function(msg){
				});
	});
	/*点击修改后修改弹框内容变化为当前内容*/
	$("button#update").bind("click",function(){
		$("#myModal").find("button#add_btn").hide();
		$("#myModal").find("button#update_btn").show();
		var id = $(this).parents("tr").find("td").eq(0).text();
		var title = $(this).parents("tr").find("td").eq(1).text();
		var url = $(this).parents("tr").find("td").eq(2).text();
		var iconUrl = $(this).parents("tr").find("td").eq(3).text();
		$("#myModal").find("#idInput").val(id);
		$("#myModal").find("#titleInput").val(title);
		$("#myModal").find("#urlInput").val(url);
		$("#myModal").find("#iconInput").val(iconUrl);
		
	});	
	/*修改弹框点击保存按钮*/
	$("button#update_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $("#myModal").find("#idInput").val();
		var title = $("#myModal").find("#titleInput").val();
		var url = $("#myModal").find("#urlInput").val();
		var iconUrl = $("#myModal").find("#iconInput").val();
		$(".span12").load("updateLeftdata",{'id':id,'title':title,'url':url,'iconUrl':iconUrl,'page':page},
				function(msg){
				});
	});
	/*点击删除按钮*/
	$("button#del").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $(this).parents("tr").find("td").eq(0).text();
		window.location="delLeftdata?id="+id+"&page="+page;
	});
});
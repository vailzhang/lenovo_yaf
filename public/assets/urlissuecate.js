$(document).ready(function(){
	/*点击添加弹框内容变化为当前内容*/
	$("button#add").bind("click",function(){
		$("#myModal").find("button#add_btn").show();
		$("#myModal").find("button#update_btn").hide();
		$("#myModal").find("#idInput").val("");
		$("#myModal").find("#keyInput").val("");
		$("#myModal").find("#describeInput").val("");
	});
	/*添加框点击保存按钮*/		
	$("button#add_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var key = $("#myModal").find("#keyInput").val();
		var describe = $("#myModal").find("#describeInput").val();
		$(".span12").load("addUrlissueCate",{'key':key,'describe':describe,'page':page},
				function(msg){
				});
	});
	/*点击修改后修改弹框内容变化为当前内容*/
	$("button#update").bind("click",function(){
		$("#myModal").find("button#add_btn").hide();
		$("#myModal").find("button#update_btn").show();
		var id = $(this).parents("tr").find("td").eq(0).text();
		var key = $(this).parents("tr").find("td").eq(1).text();
		var describe = $(this).parents("tr").find("td").eq(2).text();
		$("#myModal").find("#idInput").val(id);
		$("#myModal").find("#keyInput").val(key);
		$("#myModal").find("#describeInput").val(describe);
		/*修改弹框点击保存按钮*/						
	});
	$("button#update_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $("#myModal").find("#idInput").val();
		var key = $("#myModal").find("#keyInput").val();
		var describe = $("#myModal").find("#describeInput").val();
		$(".span12").load("updateUrlissueCate",{'id':id,'key':key,'describe':describe,'page':page},
				function(msg){
				});
	});
	/*点击删除按钮*/
	$("button#del").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $(this).parents("tr").find("td").eq(0).text();
		$.post("delUrlissueCate",
				{'id':id},
				function(msg){
					if(msg == 'sucess'){
						window.location="UrlissueCate?page="+page;
					}
					else{
						alert("删除错误，请先删除关联网址");
					}
		});
	});	
});
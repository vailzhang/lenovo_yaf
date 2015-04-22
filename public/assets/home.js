$(document).ready(function(){
	/*点击添加弹框内容变化为当前内容*/
	$("button#add").bind("click",function(){
		$("#myModal").find("button#add_btn").show();
		$("#myModal").find("button#update_btn").hide();
		$("#myModal").find("#idInput").val("");
		$("#myModal").find("#versionInput").val("");
		$("#myModal").find("#version_minInput").val("");
		$("#myModal").find("#version_maxInput").val("");
		$("#myModal").find("#commandInput").val("");
		$("#myModal").find("#old_urlInput").val("");
		$("#myModal").find("#urlInput").val("");
		$("#myModal").find("#srcInput").val("");
		$("#myModal").find("#colorInput").val("");	
	});
	/*添加框点击保存按钮*/		
	$("button#add_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var version = $("#myModal").find("#versionInput").val();
		var version_min = $("#myModal").find("#version_minInput").val();
		var version_max = $("#myModal").find("#version_maxInput").val();
		var command = $("#myModal").find("#commandInput").val();
		var old_url = $("#myModal").find("#old_urlInput").val();
		var url = $("#myModal").find("#urlInput").val();
		var src = $("#myModal").find("#srcInput").val();
		var color =$("#myModal").find("#colorInput").val();
		$(".span12").load("addHome",{'version':version,'version_min':version_min,'version_max':version_max,
			'command':command,'old_url':old_url,'url':url,'src':src,'color':color,'page':page},
			function(msg){
			});
	});
	/*点击修改后修改弹框内容变化为当前内容*/
	$("button#update").bind("click",function(){
		$("#myModal").find("button#add_btn").hide();
		$("#myModal").find("button#update_btn").show();
		var id = $(this).parents("tr").find("td").eq(0).text();
		var version = $(this).parents("tr").find("td").eq(1).text();
		var version_min = $(this).parents("tr").find("td").eq(2).text();
		var version_max = $(this).parents("tr").find("td").eq(3).text();
		var command = $(this).parents("tr").find("td").eq(4).text();
		var old_url = $(this).parents("tr").find("td").eq(5).text();
		var url = $(this).parents("tr").find("td").eq(6).text();
		var src = $(this).parents("tr").find("td").eq(7).text();
		var color = $(this).parents("tr").find("td").eq(8).text();
		$("#myModal").find("#idInput").val(id);
		$("#myModal").find("#versionInput").val(version);
		$("#myModal").find("#version_minInput").val(version_min);
		$("#myModal").find("#version_maxInput").val(version_max);
		$("#myModal").find("#commandInput").val(command);
		$("#myModal").find("#old_urlInput").val(old_url);
		$("#myModal").find("#urlInput").val(url);
		$("#myModal").find("#srcInput").val(src);
		$("#myModal").find("#colorInput").val(color);		
	});
	
	/*修改弹框点击保存按钮*/
	$("button#update_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $("#myModal").find("#idInput").val();
		var version = $("#myModal").find("#versionInput").val();
		var version_min = $("#myModal").find("#version_minInput").val();
		var version_max = $("#myModal").find("#version_maxInput").val();
		var command = $("#myModal").find("#commandInput").val();
		var old_url = $("#myModal").find("#old_urlInput").val();
		var url = $("#myModal").find("#urlInput").val();
		var src = $("#myModal").find("#srcInput").val();
		var color =$("#myModal").find("#colorInput").val();	
		$(".span12").load("updateHome",{'version':version,'version_min':version_min,'version_max':version_max,
			'command':command,'old_url':old_url,'url':url,'src':src,'color':color,'id':id,'page':page},
		function(msg){
		});
	});
	/*点击删除按钮*/
	$("button#del").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $(this).parents("tr").find("td").eq(0).text();
		window.location="delHome?id="+id+"&page="+page;
	});
});
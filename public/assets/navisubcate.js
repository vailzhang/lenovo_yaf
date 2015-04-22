$(document).ready(function(){
	/*点击添加弹框内容变化*/
	$("button#add").bind("click",function(){
		$("#myModal").find("button#add_btn").show();
		$("#myModal").find("button#update_btn").hide();
		$("#myModal").find("#idInput").val('');
		$("#myModal").find("#a_colorInput").val('');
		$("#myModal").find("#b_colorInput").val('');
		$("#myModal").find("#titleInput").val('');
		$("#myModal").find("#urlInput").val('');	
	});
	/*添加弹框点击保存按钮*/
	$("button#add_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var title = $("#myModal").find("#titleInput").val();
		var url = $("#myModal").find("#urlInput").val();
		var cate_id = $("#myModal").find("#parentsSelect").val();
		var a_color = $("#myModal").find("#a_colorInput").val();
		var b_color = $("#myModal").find("#b_colorInput").val();
		$(".span12").load("addNavisubcate",{'title':title,'url':url,'cate_id':cate_id,'a_color':a_color,'b_color':b_color,'page':page},
				function(msg){
				});
	});
	/*点击修改后修改弹框内容变化为当前内容*/
	$("button#update").bind("click",function(){
		$("#myModal").find("button#add_btn").hide();
		$("#myModal").find("button#update_btn").show();
		var id = $(this).parents("tr").find("td p").eq(0).text();
		var title = $(this).parents("tr").find("td").eq(1).text();
		var cate_id= $.trim($(this).parents("tr").find("#cate_id").val());
		var a_color= $.trim($(this).parents("tr").find("#a_color").val());
		var b_color= $.trim($(this).parents("tr").find("#b_color").val());
		var url = $(this).parents("tr").find("td").eq(3).text();
		$("#myModal").find("#idInput").val(id);
		$("#myModal").find("#a_colorInput").val(a_color);
		$("#myModal").find("#b_colorInput").val(b_color);
		$("#myModal").find("#titleInput").val(title);
		$("#myModal").find("#urlInput").val(url);
		$("#myModal").find("#parentsSelect option").removeAttr("selected");
		$("#myModal").find("#parentsSelect").find("option[value="+cate_id+"]").attr('selected',true);		
	});
	/*修改弹框点击保存按钮*/
	$("button#update_btn").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $("#myModal").find("#idInput").val();
		var title = $("#myModal").find("#titleInput").val();
		var url = $("#myModal").find("#urlInput").val();
		var cate_id = $("#myModal").find("#parentsSelect").val();
		var a_color = $("#myModal").find("#a_colorInput").val();
		var b_color = $("#myModal").find("#b_colorInput").val();
		$(".span12").load("updateNavisubcate",{'id':id,'title':title,'url':url,'cate_id':cate_id,'a_color':a_color,'b_color':b_color,'page':page},
				function(msg){
				});
	});
	/*点击按钮*/
	$("button#del").bind("click",function(){
		var page = $.trim($('li.page_btn.active').text());
		var id = $(this).parents("tr").find("td p").eq(0).text();
		$.post("delNaviSubcate",
				{'id':id},
				function(msg){
					if(msg == 'sucess'){
						window.location="navisubcate?page="+page;
					}
					else{
						alert("删除错误，请先删除关联菜单");
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
						var PrevId = $(this).prev("tr").find("td p").eq(0).text();
						var NextId = $(this).next("tr").find("td p").eq(0).text();
						$.post("savePostionNaviSubCate",{'ThisId':ThisId,"PrevId":PrevId,"NextId":NextId},
								function(msg){
								});
					}
				});
				
			},1000);
		}	
	});
});
$(function() {
    // Side Bar Toggle
    $('.hide-sidebar').click(function() {
        $('#sidebar').hide('fast', function() {
            $('#content').removeClass('span9');
            $('#content').addClass('span12');
            $('.hide-sidebar').hide();
            $('.show-sidebar').show();
        });
    });

    $('.show-sidebar').click(function() {
        $('#content').removeClass('span12');
        $('#content').addClass('span9');
        $('.show-sidebar').hide();
        $('.hide-sidebar').show();
        $('#sidebar').show('fast');
    });
});
$(function() {
    $('.drag_tr').sortable();
    $('.drag_tr').sortable('disable');
    $('.drag_holder').hide();
    $('#add_btn').click(function() {
        var alertnode=$('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4>提醒</h4>数据添加成功</div>');
        var par=$("#first-row");
        par.append(alertnode);
    });
    $('#sort_btn').click(function(){
        if( $('#sort_btn').text()=="排序"){       
            $('.drag_tr').sortable('enable');
            $('#sort_btn').text('停止排序');
            $('.drag_holder').show();
        }else{

            $('.drag_holder').hide();
            $('#sort_btn').text('排序');
            $('.drag_tr').sortable('disable');
        }
    });
    $('.page_btn').click(function(e){
        var eve=e;
        btns = $('.page_btn'); 
        btns.removeClass('active');
        btns[eve.toElement.innerHTML-1].classList.add('active');
    });
});
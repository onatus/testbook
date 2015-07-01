$(document).ready(function(){
    $('#genre').click(function(){
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {"search":$('[type=search]').val(),"find":"genre"},
            success: function(html){
                $("#content").html(html);
            }
        });
        return false;
    });
    $('#author').click(function(){
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {"search":$('[type=search]').val(),"find":"author"},
            success: function(html){
                $("#content").html(html);
            }
        });
        return false;
    });
    $('#mainLink').click(function(){
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {"show":"all"},
            success: function(html){
                $("#content").html(html);
                $('body').delegate('.addComment', 'click', function(){
                    var id = $(this).data('id');
                    alert(id);
                    var a = '#text';
                    var b = '#commentBox';
                    a += id;
                    b += id;
                    alert(a);
                    $.ajax({
                        type: "POST",
                        url: "index.php",
                        data: {"comment":$(a).val(),"id":id},
                        success: function(html){
                            $(b).html(html);
                        }
                    });
                    return false;
                });
            }
        });
        return false;
    });
});
/**
 * Created by Dima on 29.06.2015.
 */

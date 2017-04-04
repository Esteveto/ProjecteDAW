
$(document).ready(function(){
	console.log("OK");
    $("img").load(function(){
        $(this).addClass("bounce");
    });
    $(".likeimgs").click(function(){
        var id = $(this).attr("id");
        console.log("id: "+id);
        $.ajax({
            url:"setLike.php", //the page containing php script
            type: "post", //request type,
            data: {id: id},
            success:function(result){
                console.log(result);
                if(result == "true"){
                    $("#"+id+"").removeClass("imgLike");
                    $("#"+id+"").addClass("imgLiked");
                    console.log("cookieSet: "+result);
                }else if(result == "false"){
                    $("#"+id+"").removeClass("imgLiked");
                    $("#"+id+"").addClass("imgLike");

                }
           }
        });
    });
});
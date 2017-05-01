
$(document).ready(function(){
	//console.log("OK");
    $("img").on('load',function(){
        $(this).addClass("bounce");
    });
    $(".likeimgs").click(function(){
        var id = $(this).attr("id");
        //console.log("id: "+id);
        $.ajax({
            url:"setLike.php", //the page containing php script
            type: "post", //request type,
            data: {id: id},
            success:function(result){
                console.log(id);
                var idImg = id.split('cookie')[1];
                var idNumLikes = "numLikes"+idImg;
                var numLikes = parseInt($("#"+idNumLikes).text());
                console.log(numLikes);
                if(result == "true"){
                    $("#"+id+"").removeClass("imgLike");
                    $("#"+id+"").addClass("imgLiked");
                    $("#"+id+"").attr("src","images/corazon4.png");
                    numLikes++;
                    $("#"+idNumLikes).text(numLikes);
                    //console.log("cookieSet: "+result);
                }else if(result == "false"){
                    $("#"+id+"").removeClass("imgLiked");
                    $("#"+id+"").addClass("imgLike");
                    $("#"+id+"").attr("src","images/corazon3.png");
                    numLikes--;
                    $("#"+idNumLikes).text(numLikes);
                }
           }
        });
    });

    $('.dropdown').hover(function() {
        console.log("hover");
      $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(500);
    }, function() {
      $(this).find('.dropdown-menu').stop(true, true).delay(75).fadeOut(500);
    });
});
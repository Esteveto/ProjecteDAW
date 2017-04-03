/*function albumSelected(item){
	document.getElementById("albumSelected").innerHTML = item.text;
}

function categoriaActual(categoria){
	var categoria1 = document.getElementById(categoria);
	var categories = document.getElementsByClassName("dropdown-toggle");
	for (i in categories){
		categories[i].style = "";
	}
	categoria1.style = " color:white; font-weight: bold;";
}*/

function borrar(id){
	console.log(id);
}

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
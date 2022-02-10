jQuery(document).ready(function($) {
    //console.log("loaded");
    $(".snillrik-settings-switch").on("click", function() {
        var inputten = $(this).find("input[type=checkbox]");
        if (inputten.is(':checked'))
            inputten.prop('checked', false)
        else {
            inputten.prop('checked', true)
        }

        //console.log("clikk "+inputten.attr("type"));
    });
    /* 	$(".snillrik-settings-item-inner").on("click",function(){
    		var inputten = $(this).find("input[type=checkbox]");
    		if(inputten.is(':checked'))
    			inputten.prop('checked',false)
    		else{
    			inputten.prop('checked',true)
    		}

    		//console.log("clikk "+inputten.attr("type"));
        }); */
});
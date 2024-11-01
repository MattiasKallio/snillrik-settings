jQuery(document).ready(function ($) {
    //console.log("loaded");
    $(".snillrik-settings-switch").on("click", function () {
        var inputten = $(this).find("input[type=checkbox]");
        if (inputten.is(':checked'))
            inputten.prop('checked', false)
        else {
            inputten.prop('checked', true)
        }
    });

    $('.snset-color-field').wpColorPicker();

    $(".snillrik-force-plugins").on("click", function () {
        //do ajax snillrik_force_plugins
        var data = {
            'action': 'snillrik_force_plugins'
        };
        $.post(ajaxurl, data, function (response) {
            //alert('Got this from the server: ' + response);
            $(".snillrik-force-plugins").html("Done");
            //disable button
            $(".snillrik-force-plugins").prop('disabled', true);
        });

    });

    $(".snillrik-delete-transients").on("click", function () {
        //do ajax snillrik_force_plugins
        var data = {
            'action': 'snillrik_delete_transients'
        };
        $.post(ajaxurl, data, function (response) {
            //alert('Got this from the server: ' + response);
            $(".snillrik-delete-transients").html("Done");
            //disable button
            $(".snillrik-delete-transients").prop('disabled', true);
        });

    });

});
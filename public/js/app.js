$(document).ready(function() {
    $('.nav-link.active .sub-menu').slideDown();
    // $("p").slideUp();

    $('#sidebar-menu .arrow').click(function() {
        $(this).parents('li').children('.sub-menu').slideToggle();
        $(this).toggleClass('fa-angle-right fa-angle-down');
    });

    $("input[name='checkall']").click(function() {
        var checked = $(this).is(':checked');
        $('.table-checkall tbody tr td input:checkbox').prop('checked', checked);
    });
});



$(document).ready(function() {
    show_upload_image = function() {
        var upload_image = document.getElementById("upload-thumb")
        if (upload_image.files && upload_image.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#upload-image').attr('src', e.target.result)
            };
            reader.readAsDataURL(upload_image.files[0]);
            // let url = URL.createObjectURL(input.files[0]);
            // upload-image.setAttribute('src', url);
        }
    }
    show_upload_multi_image = function () {
        var upload_image = document.getElementById("upload-thumb");
        if(upload_image.files){
            let str_class_img = "";
            for(var i = 0 ; i < upload_image.files.length ; i++){
                str_class_img += "<img class='fl-left' id='upload-image-" + i + "'>";
                $('div#slider-thumb').html(str_class_img);
                let selector_img = "#upload-image-" + i;
                
                var reader = new FileReader();
                reader.onload = function(e){
                    $(selector_img).attr('src', e.target.result);
                    console.log(selector_img);
                };
                reader.readAsDataURL(upload_image.files[i]);
            }
            
        }
    }
});
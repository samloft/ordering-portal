// require('./modules/basket');
// require('./modules/categories');
// require('./modules/products');
// require('./modules/inputs');
// require('./modules/checkout');

// $('input[type="file"]').change(function (file) {
//     $('.custom-file-label').html(file.target.files[0].name);
// });

$('button[id="upload-order"]').on('click', function () {
    $('#loader .loader-txt').html('Uploading your order, please wait');
    $('#loader').modal('show');
});

$(".sidebar-dropdown > a").click(function () {
    $(".sidebar-submenu").slideUp(200);
    if (
        $(this)
            .parent()
            .hasClass("active")
    ) {
        $(".sidebar-dropdown").removeClass("active");
        $(this)
            .parent()
            .removeClass("active");
    } else {
        $(".sidebar-dropdown").removeClass("active");
        $(this)
            .next(".sidebar-submenu")
            .slideDown(200);
        $(this)
            .parent()
            .addClass("active");
    }
});

$("#close-sidebar").click(function () {
    $(".page-wrapper").removeClass("toggled");
});
$("#show-sidebar").click(function () {
    $(".page-wrapper").addClass("toggled");
});

// Get the modal
// var modal = document.getElementById('img-modal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
// var img = document.getElementById('enlarge-image');
// var modalImg = document.getElementById("product-image");
// var captionText = document.getElementById("caption");
//
// $('img[id="enlarge-image"]').on('click', function () {
//     $('#img-modal').show();
//     modalImg.src = $(this).attr('src');
//     captionText.innerHTML = $(this).closest('.product-list').find('#product-code').text();
//
//     console.log($(this).closest('#product-code').text());
// });
//
// $('#img-modal').on('click', function () {
//     $(this).hide();
// });

// Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
// if (span) {
//     span.onclick = function () {
//         modal.style.display = "none";
//     };
// }

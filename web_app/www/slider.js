let new_block = document.getElementById("new-scroll-block");
let for_you_block = document.getElementById("for-you-scroll-block");
let popular_block = document.getElementById("popular-scroll-block");

$('#new-next-button-container').click(function (e) {
    $('#new-scroll-block').animate({
        scrollLeft: new_block.scrollLeft + 300 + 'px',
    }, 'slow', function () {

    });
})
$('#new-prev-button-container').click(function (e) {
    $('#new-scroll-block').animate({
        scrollLeft: new_block.scrollLeft + -300 + 'px',
    }, 'slow', function () {

    });
})


$('#for-you-next-button-container').click(function (e) {
    $('#for-you-scroll-block').animate({
        scrollLeft: for_you_block.scrollLeft + 300 + 'px',
    }, 'slow', function () {

    });
})
$('#for-you-prev-button-container').click(function (e) {
    $('#for-you-scroll-block').animate({
        scrollLeft: for_you_block.scrollLeft + -300 + 'px',
    }, 'slow', function () {

    });
})


$('#popular-next-button-container').click(function (e) {
    $('#popular-scroll-block').animate({
        scrollLeft: popular_block.scrollLeft + 300 + 'px',
    }, 'slow', function () {

    });
})
$('#popular-prev-button-container').click(function (e) {
    $('#popular-scroll-block').animate({
        scrollLeft: popular_block.scrollLeft + -300 + 'px',
    }, 'slow', function () {

    });
})
let block = document.getElementById("scroll-block");

$('.next-button-container').click(function (e) {
    $('.new-docs').animate({
        scrollLeft: block.scrollLeft + 300 + 'px',
    }, 'slow', function () {

    });
})
$('.prev-button-container').click(function (e) {
    $('.new-docs').animate({
        scrollLeft: block.scrollLeft + -300 + 'px',
    }, 'slow', function () {

    });
})
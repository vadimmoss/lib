$('.rate-button').click(function (e) {

    let userRate = $(this).val()
    let xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href + '/rate')
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status !== 200) {
                object.error(xhr.responseText);
            } else {
                var dom = $.parseHTML(xhr.responseText);
                var elem = $(dom).find(".doc-rating");
                $(".doc-rating").replaceWith(elem);
            }
        }

    }
    xhr.send('rate=' + userRate);
    e.preventDefault();
});




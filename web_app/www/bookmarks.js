$('.like-image').click(function (e) {

    // alert('/documents/'+$(this).attr('value')+'/bookmark');
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/books/' + $(this).attr('value') + '/bookmark')
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status !== 200) {
                console.log(xhr.responseText);
            } else {
                location.reload()
            }
        }

    }
    xhr.send();
    e.preventDefault();
})
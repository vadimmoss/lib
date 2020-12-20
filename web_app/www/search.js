let classes = document.getElementById('classes');


var servResponse = document.sqlQuerySelector('#result_docs');

document.getElementById('submit1').addEventListener("click", function (e) {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/search/search')
    let myForm = document.forms.searchForm;
    let formData = new FormData(myForm);
    xhr.send(formData);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.response);
            servResponse.innerHTML = xhr.response;
        } else {
            if (xhr.status === 404) {
                servResponse.textContent = 'Не найдено ни одного документа!';
            }
        }
    }

});
document.sqlQuerySelectorAll('.order_by').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        let myForm = document.forms.searchForm;
        let formData = new FormData(myForm);
        formData.append('order_by', item.value)
        // alert(item.value);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/search/search')
        xhr.send(formData);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                servResponse.innerHTML = xhr.response;
            }
        }

    })
})

var servResponse = document.sqlQuerySelector('#contests');

document.getElementById('submit-upload').addEventListener("click", function (e) {
    e.preventDefault();
    let imageUpload = document.getElementById('image');
    let userInput = imageUpload.value;
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/documents/upload')
    let formData = new FormData(document.forms.uploadImageForm);
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            console.log(xhr.responseText)
            servResponse.textContent = xhr.responseText;
        }
    }
    xhr.send(formData);
});




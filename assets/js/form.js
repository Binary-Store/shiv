

function sendData(event){
    console.log('sendData');
    event.preventDefault();
    document.getElementById('subBtn').innerText = 'Sending...';

    var formData = {
        name: document.forms["myForm"]["name"].value,
        number: document.forms["myForm"]["number"].value,
        email : document.forms["myForm"]["email"].value,
        message: document.forms["myForm"]["message"].value
    };
    console.log(formData);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "send.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {

            document.forms["myForm"].reset();
            document.getElementById('notification').style.display = 'block';
            setTimeout(function() {
                document.getElementById('notification').style.display = 'none';
            }, 3000);
            document.getElementById('subBtn').innerText = 'Submit';
        }
    };
    xhr.send(JSON.stringify(formData));
}

function sendEmail(event){
    event.preventDefault();
    var formData = {
        Email : document.forms["subForm"]["email"].value,
    };
    var xhr = new XMLHttpRequest();
    document.getElementById('subBtn').innerText = 'Loding...';
    xhr.open("POST", "send.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {

            document.forms["subForm"].reset();
            document.getElementById('subBtn').innerText = 'Done';
            setTimeout(function() {
                document.getElementById('subBtn').innerText = 'Subscribe';
            }, 2000);
        }
    };
    xhr.send(JSON.stringify(formData));
}
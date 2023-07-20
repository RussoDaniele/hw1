function jsonCheckUsername(json) {
    if (formValidate.username = !json.exists) {
        document.querySelector('.username').classList.remove('errorp');
    } else {
        document.querySelector('.username span').textContent = "Username già in uso";
        document.querySelector('.username').classList.add('errorp');
    }
}

function jsonCheckEmail(json) {
    if (formValidate.email = !json.exists) {
        document.querySelector('.email').classList.remove('errorp');
    } else {
        document.querySelector('.email span').textContent = "Email già in uso";
        document.querySelector('.email').classList.add('errorp');
    }
}

function onResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function CheckUsername(event) {
    const username = document.querySelector('.username input');

    if(!/^[a-zA-Z0-9_]{1,15}$/.test(username.value)) {
        username.parentNode.querySelector('span').textContent = "Username non valido, sono ammessi: lettere, numeri e underscore. Max: 15";
        username.parentNode.classList.add('errorp');
        formValidate.username = false;

    } else {
        document.querySelector('.username').classList.remove('errorp');
        fetch("check_username.php?q="+encodeURIComponent(username.value)).then(onResponse).then(jsonCheckUsername);
    }    
}

function CheckEmail(event) {
    const email = document.querySelector('.email input');
    const mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(!(String(email.value).toLowerCase()).match(mailformat)){
        document.querySelector('.email span').textContent = "Email non valida";
        document.querySelector('.email').classList.add('errorp');
        formValidate.email = false;

    } else {
        document.querySelector('.email').classList.remove('errorp');
        fetch("check_email.php?q="+encodeURIComponent(String(email.value).toLowerCase())).then(onResponse).then(jsonCheckEmail);
    }
}

function CheckPassword(event) {
    const password = document.querySelector('.password input');
    if (formValidate.password = (password.value.length >= 8)) {
        document.querySelector('.password').classList.remove('errorp');
    } else {
        document.querySelector('.password').classList.add('errorp');
    }
}

function CheckConfirmPassword(event) {
    const confirm_password = document.querySelector('.confirm_password input');
    const password = document.querySelector('.password input')
    if (formValidate.confirm_password = (confirm_password.value === password.value)) {
        document.querySelector('.confirm_password').classList.remove('errorp');
    } else {
        document.querySelector('.confirm_password').classList.add('errorp');
    }
}

function Signup(event) {
    if (Object.keys(formValidate).length !== 4 || Object.values(formValidate).includes(false)) {
        event.preventDefault();
    }
}

const formValidate = {'upload': true};
document.querySelector('.username input').addEventListener('blur', CheckUsername);
document.querySelector('.email input').addEventListener('blur', CheckEmail);
document.querySelector('.password input').addEventListener('blur', CheckPassword);
document.querySelector('.confirm_password input').addEventListener('blur', CheckConfirmPassword);
document.querySelector('form').addEventListener('submit', Signup);
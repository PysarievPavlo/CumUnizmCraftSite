document.getElementById('login-button').addEventListener('click', function() {
    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;

    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password),
    })
    .then(response => response.text())
    .then(data => {
        if (data === "") { // Если ответ пустой (успешная авторизация)
            location.reload(); // Перезагружаем страницу
        } else {
            alert(data); // Выводим ошибку, если есть
        }
    });
});
<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<header>
    <nav>
        <a href="index.php">cumunizmcraft.pp.ua</a>
        <div> <a href="index.php">Главная</a>
            <a href="#">Новости</a>
            <a href="#">Правила</a>
            <a href="#">Контакты</a>
        </div>
    </nav>
</header>
    <main>
        <section class="login-section">
            <div class="container login-form">
                <h2 class="text-center">Авторизация</h2>
                <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                <input type="text" id="username" placeholder="Имя пользователя" class="form-control">
                <input type="password" id="password" placeholder="Пароль" class="form-control">
                <a href="forgot_password.php" class="btn btn-link btn-block">Забыли пароль?</a>
                <button id="login-button" class="btn btn-primary btn-block w-auto">Войти</button>
                <a href="register.php" class="btn btn-secondary btn-block">Регистрация</a>
            </div>

            <script>
                document.getElementById('login-button').addEventListener('click', function() {
                    let username = document.getElementById('username').value;
                    let password = document.getElementById('password').value;
                    let errorMessage = document.getElementById('error-message');

                    fetch('login.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.href = 'cabinet.php'; // Перенаправляем на cabinet.php после успешной авторизации
                        } else {
                            errorMessage.textContent = data.message;
                            errorMessage.style.display = 'block';
                        }
                    });
                });

                document.getElementById('password').addEventListener('keyup', function(event) {
                    if (event.key === 'Enter') {
                        document.getElementById('login-button').click();
                    }
                });
            </script>
        </section>
    </main>
    <footer>
        <p>© 2025 cumunizmcraft.pp.ua Все права защищены</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
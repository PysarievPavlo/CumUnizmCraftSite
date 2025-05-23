<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>CumUnzimCraft</title>
    <link rel="icon" href="favicon.png" type="image/png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav>
            <a href="index.php">cumunizmcraft.pp.ua</a>
            <div>
                <a href="index.php">Главная</a>
                <a href="#">Новости</a>
                <a href="#">Правила</a>
                <a href="#">Контакты</a>
                <?php if (isset($_SESSION["username"])) { ?>
                    <a href="cabinet.php">Личный кабинет</a>
                <?php } else { ?>
                    <a href="login_page.php">Авторизация</a>
                <?php } ?>
            </div>
        </nav>
    </header>

    <main>
    <div class="banner">
    <div class="slider">
        <img src="/image1.png" alt="Image 1" class="slide active">
        <img src="/image2.png" alt="Image 2" class="slide">
        <img src="/image3.png" alt="Image 3" class="slide">
    </div>
    <div class="overlay">
        <h1>Ласкаво просимо на cumunizmcraft.pp.ua</h1>
        <button class="join-button-banner">Розпочати гру</button>
    </div>
</div>

    <section class="section">
        <h2>Что такое cumunizmcraft.pp.ua</h2>
        <p>"Cumunizm Craft" — сервер, где ваша кирка — это народное достояние! Все, что вы накопали, автоматически переходит в руки администрации (Сергей Радик и Назар Мойщный — наши главные трутни). Батюшка Серафим следит за тем, чтобы никто не уклонялся от труда. Присоединяйтесь, и мы вместе построим светлое коммунистическое будущее (для администрации, конечно же)!</p>
    </section>
</main>
    <footer>
        <p>© 2025 cumunizmcraft.pp.ua Все права защищены</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (i === index) {
                slide.classList.add('active');
            }
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    setInterval(nextSlide, 5000); // Змінюйте зображення кожні 5 секунд
</script>
</body>
</html>
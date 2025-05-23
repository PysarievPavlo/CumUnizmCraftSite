<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'db_connect.php';

// Код личного кабинета
if (isset($_SESSION["username"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["skin"])) {
        $target_dir = "skins/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $imageFileType = strtolower(pathinfo($_FILES["skin"]["name"], PATHINFO_EXTENSION));
        if ($imageFileType != "png") {
            echo "File is not a valid PNG image.";
        } else {
            $username = $_SESSION["username"];
            $target_file = $target_dir . $username . "." . $imageFileType;

            if (move_uploaded_file($_FILES["skin"]["tmp_name"], $target_file)) {
                $skin_url = $target_file;

                $sql = "UPDATE users SET skin = ? WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $skin_url, $username);

                if ($stmt->execute()) {
                    echo "Skin updated successfully!";
                } else {
                    echo "Error updating skin: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    $sql = "SELECT skin FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION["username"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $skin = "";
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $skin = $row["skin"];
    }

    $stmt->close();
} else {
    header("Location: login_page.php"); // Перенаправляем на страницу авторизации, если пользователь не авторизован
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Личный кабинет</title>
    <link rel="icon" href="favicon.png" type="image/png">
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
            <?php if (isset($_SESSION["username"])) { ?>
                <a href="cabinet.php">Личный кабинет</a>
            <?php } else { ?>
                <a href="login_page.php">Авторизация</a>
            <?php } ?>
        </div>
    </nav>
</header>

    <main>
        <section class="login-section has-border">
            <div class="inner-container">
                <h1>Добро пожаловать, <?php echo $_SESSION["username"]; ?>!</h1>
                <form method="post" enctype="multipart/form-data">
                    <label for="skin">Загрузить скин (PNG):</label>
                    <input type="file" name="skin" id="skin" accept=".png">
                    <button type="submit" class="btn btn-primary">Загрузить</button>
                </form>

                <?php
                $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
                $skin_path = "skins/" . $username . ".png";
                $default_skin_path = "skins/default.png";

                if ($username && (file_exists($skin_path) || file_exists($default_skin_path))) {
                    ?>
                   <div class="skin-container">
    <div class="skin-viewer__view skin-viewer__back text-center" style="transform: translateX(-5px);">
        <img src="skin.php?user=<?= $username ?>&mode=1&size=140&t=<?= time() ?>" alt="Скин спереди" class="skin-viewer__view__img">
    </div>
    <div class="skin-viewer__view skin-viewer__front text-center" style="transform: translateX(5px);">
        <img src="skin.php?user=<?= $username ?>&mode=2&size=140&t=<?= time() ?>" alt="Скин сзади" class="skin-viewer__view__img">
    </div>
</div>
                    <?php
                } else {
                    echo "<p>Скин не найден.</p>";
                }
                ?>

                <div class="cabinet-buttons">
                    <a href="logout.php" class="btn btn-danger">Выйти</a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>cumunizmcraft.pp.ua</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
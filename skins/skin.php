<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Перевірка наявності бібліотеки GD
if (!function_exists('imagecreatefrompng')) {
    die('Бібліотека GD не встановлена.');
}

// Налаштування
$skin_dir = 'skins/';
$default_skin = 'default.png';

// Отримання параметрів
$user = isset($_GET['user']) ? $_GET['user'] : null;
$mode = isset($_GET['mode']) ? $_GET['mode'] : 1;
$size = isset($_GET['size']) ? $_GET['size'] : 140;

// Перевірка імені користувача
if (empty($user)) {
    $user = 'default';
}

// Шлях до файлу скина
$skin_path = $skin_dir . $user . '.png';

// Перевірка наявності файлу скина
if (!file_exists($skin_path)) {
    $skin_path = $skin_dir . $default_skin;
}

// Перевірка наявності файлу default.png
if (!file_exists($skin_dir . $default_skin)) {
    die('Файл default.png не знайдено.');
}

// Завантаження зображення скина
$skin = @imagecreatefrompng($skin_path);
if (!$skin) {
    echo 'Помилка завантаження зображення скина: ' . $skin_path;
    error_log('Помилка завантаження зображення скина: ' . $skin_path);
    die();
}

// Розміри скина
$skin_width = imagesx($skin);
$skin_height = imagesy($skin);
// Створення зображення персонажа
if ($mode == 1) {
    // Вид спереду
    $output = imagecreatetruecolor(16 * ($skin_width / 64), 32 * ($skin_width / 64));

    // Прозорий фон
    imagealphablending($output, false);
    imagesavealpha($output, true);
    $transparent = imagecolorallocatealpha($output, 255, 255, 255, 127);
    imagefill($output, 0, 0, $transparent);

    // Копіювання частин скина (з перевірками)
    if (!imagecopy($output, $skin, 4 * ($skin_width / 64), 0, 8 * ($skin_width / 64), 8 * ($skin_width / 64), 8 * ($skin_width / 64), 8 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (голова).');
    }
    if (!imagecopy($output, $skin, 4 * ($skin_width / 64), 8 * ($skin_width / 64), 20 * ($skin_width / 64), 20 * ($skin_width / 64), 8 * ($skin_width / 64), 12 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (тіло).');
    }
    if (!imagecopy($output, $skin, 0, 8 * ($skin_width / 64), 44 * ($skin_width / 64), 20 * ($skin_width / 64), 4 * ($skin_width / 64), 12 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (права рука).');
    }
    if (!imagecopy($output, $skin, 12 * ($skin_width / 64), 8 * ($skin_width / 64), 44 * ($skin_width / 64), 20 * ($skin_width / 64), 4 * ($skin_width / 64), 12 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (ліва рука).');
    }
    if (!imagecopy($output, $skin, 4 * ($skin_width / 64), 20 * ($skin_width / 64), 4 * ($skin_width / 64), 20 * ($skin_width / 64), 4 * ($skin_width / 64), 12 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (права нога).');
    }
    if (!imagecopy($output, $skin, 8 * ($skin_width / 64), 20 * ($skin_width / 64), 4 * ($skin_width / 64), 20 * ($skin_width / 64), 4 * ($skin_width / 64), 12 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (ліва нога).');
    }
    if (!imagecopy($output, $skin, 4 * ($skin_width / 64), 0, 40 * ($skin_width / 64), 8 * ($skin_width / 64), 8 * ($skin_width / 64), 8 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (шапка).');
    }
}
elseif ($mode == 2) {
    // Вид ззаду
    $output = imagecreatetruecolor(16 * ($skin_width / 64), 32 * ($skin_width / 64));

    // Прозорий фон
    imagealphablending($output, false);
    imagesavealpha($output, true);
    $transparent = imagecolorallocatealpha($output, 255, 255, 255, 127);
    imagefill($output, 0, 0, $transparent);

    // Копіювання частин скина (з перевірками)
    if (!imagecopy($output, $skin, 4 * ($skin_width / 64), 8 * ($skin_width / 64), 32 * ($skin_width / 64), 20 * ($skin_width / 64), 8 * ($skin_width / 64), 12 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (тіло ззаду).');
    }
    if (!imagecopy($output, $skin, 4 * ($skin_width / 64), 0, 24 * ($skin_width / 64), 8 * ($skin_width / 64), 8 * ($skin_width / 64), 8 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (голова ззаду).');
    }
    if (!imagecopy($output, $skin, 0, 8 * ($skin_width / 64), 52 * ($skin_width / 64), 20 * ($skin_width / 64), 4 * ($skin_width / 64), 12 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (права рука ззаду).');
    }
    if (!imagecopy($output, $skin, 12 * ($skin_width / 64), 8 * ($skin_width / 64), 52 * ($skin_width / 64), 20 * ($skin_width / 64), 4 * ($skin_width / 64), 12 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (ліва рука ззаду).');
    }
    if (!imagecopy($output, $skin, 4 * ($skin_width / 64), 20 * ($skin_width / 64), 12 * ($skin_64), 12 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (ліва нога ззаду).');
    }
    if (!imagecopy($output, $skin, 4 * ($skin_width / 64), 0, 56 * ($skin_width / 64), 8 * ($skin_width / 64), 8 * ($skin_width / 64), 8 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (шапка ззаду).');
    }
} else {
    // Голова
    $output = imagecreatetruecolor(8 * ($skin_width / 64), 8 * ($skin_width / 64));

    // Прозорий фон
    imagealphablending($output, false);
    imagesavealpha($output, true);
    $transparent = imagecolorallocatealpha($output, 255, 255, 255, 127);
    imagefill($output, 0, 0, $transparent);

    // Копіювання частин скина (з перевірками)
    if (!imagecopy($output, $skin, 0, 0, 8 * ($skin_width / 64), 8 * ($skin_width / 64), 8 * ($skin_width / 64), 8 * ($skin_width / 64))) {
        die('Помилка копіювання частини скина (голова).');
    }
}

// Зміна розміру зображення
$resized = imagecreatetruecolor($size, $size * 2);
if (!imagecopyresampled($resized, $output, 0, 0, 0, 0, $size, $size * 2, 16 * ($skin_width / 64), 32 * ($skin_width / 64))) {
    die('Помилка зміни розміру зображення.');
}
// Виведення зображення
header('Content-type: image/png');
imagepng($resized);

// Знищення зображень
imagedestroy($skin);
imagedestroy($output);
imagedestroy($resized);
?>
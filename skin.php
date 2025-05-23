<?php
// Функції з плащами поки вирезані
$skin = array(
    'dir_skins' => __DIR__ . '/skins/', // Шлях до папки скинів від поточного каталогу
    'default' => 'default', // Дефолтний скін
    'user' => filter_input(INPUT_GET, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    'size' => filter_input(INPUT_GET, 'size', FILTER_SANITIZE_NUMBER_FLOAT),
    'mode' => filter_input(INPUT_GET, 'mode', FILTER_SANITIZE_NUMBER_FLOAT),
);

if (!is_dir($skin['dir_skins'])) {
    exit('Шлях до скинів не є папкою! Вкажіть правильний шлях.');
}

if (file_exists($skin['dir_skins'] . $skin['user'] . '.png')) {
    $skin['skin'] = $skin['dir_skins'] . $skin['user'] . '.png';
} else {
    $skin['skin'] = $skin['dir_skins'] . $skin['default'] . '.png';
}

if (empty($skin['size'])) {
    $skin['size'] = '128';
}

if (empty($skin['mode'])) {
    $skin['mode'] = '1';
}

function imageturn($result, $img, $rx = 0, $ry = 0, $x = 0, $y = 0, $size_x = null, $size_y = null) {
    if ($size_x < 1) {
        $size_x = imagesx($img);
    }
    if ($size_y < 1) {
        $size_y = imagesy($img);
    }
    imagecopyresampled($result, $img, $rx, $ry, ($x + $size_x - 1), $y, $size_x, $size_y, 0 - $size_x, $size_y);
}

$skin['skif'] = getimagesize($skin['skin']);
$skin['h'] = $skin['skif']['0'];
$skin['w'] = $skin['skif']['1'];
$skin['r'] = $skin['h'] / 64;

header("Content-type: image/png");

$skin['s'] = imagecreatefrompng($skin['skin']);

$skin['p'] = imagecreatetruecolor(16 * $skin['r'], 32 * $skin['r']);
$skin['t'] = imagecolorallocatealpha($skin['p'], 255, 255, 255, 127);
imagefill($skin['p'], 0, 0, $skin['t']);

if ($skin['mode'] == '1') {
    // Face
    imagecopy($skin['p'], $skin['s'], 4 * $skin['r'], 0 * $skin['r'], 8 * $skin['r'], 8 * $skin['r'], 8 * $skin['r'], 8 * $skin['r']);
    // Arms
    imagecopy($skin['p'], $skin['s'], 0 * $skin['r'], 8 * $skin['r'], 44 * $skin['r'], 20 * $skin['r'], 4 * $skin['r'], 12 * $skin['r']);
    imageturn($skin['p'], $skin['s'], 12 * $skin['r'], 8 * $skin['r'], 44 * $skin['r'], 20 * $skin['r'], 4 * $skin['r'], 12 * $skin['r']);
    // Chest
    imagecopy($skin['p'], $skin['s'], 4 * $skin['r'], 8 * $skin['r'], 20 * $skin['r'], 20 * $skin['r'], 8 * $skin['r'], 12 * $skin['r']);
    // Legs
    imagecopy($skin['p'], $skin['s'], 4 * $skin['r'], 20 * $skin['r'], 4 * $skin['r'], 20 * $skin['r'], 4 * $skin['r'], 12 * $skin['r']);
    imageturn($skin['p'], $skin['s'], 8 * $skin['r'], 20 * $skin['r'], 4 * $skin['r'], 20 * $skin['r'], 4 * $skin['r'], 12 * $skin['r']);
    // Hat
    imagecopy($skin['p'], $skin['s'], 4 * $skin['r'], 0 * $skin['r'], 40 * $skin['r'], 8 * $skin['r'], 8 * $skin['r'], 8 * $skin['r']);
} elseif ($skin['mode'] == '2') {
    // Back body
    imagecopy($skin['p'], $skin['s'], 4 * $skin['r'], 8 * $skin['r'], 32 * $skin['r'], 20 * $skin['r'], 8 * $skin['r'], 12 * $skin['r']);
    // Head back
    imagecopy($skin['p'], $skin['s'], 4 * $skin['r'], 0 * $skin['r'], 24 * $skin['r'], 8 * $skin['r'], 8 * $skin['r'], 8 * $skin['r']);
    // Back arms
    imageturn($skin['p'], $skin['s'], 0 * $skin['r'], 8 * $skin['r'], 52 * $skin['r'], 20 * $skin['r'], 4 * $skin['r'], 12 * $skin['r']);
    imagecopy($skin['p'], $skin['s'], 12 * $skin['r'], 8 * $skin['r'], 52 * $skin['r'], 20 * $skin['r'], 4 * $skin['r'], 12 * $skin['r']);
    // Back legs
    imageturn($skin['p'], $skin['s'], 4 * $skin['r'], 20 * $skin['r'], 12 * $skin['r'], 20 * $skin['r'], 4 * $skin['r'], 12 * $skin['r']);
    imagecopy($skin['p'], $skin['s'], 8 * $skin['r'], 20 * $skin['r'], 12 * $skin['r'], 20 * $skin['r'], 4 * $skin['r'], 12 * $skin['r']);
    // Hat back
    imagecopy($skin['p'], $skin['s'], 4 * $skin['r'], 0 * $skin['r'], 56 * $skin['r'], 8 * $skin['r'], 8 * $skin['r'], 8 * $skin['r']);
} elseif ($skin['mode'] == '3') {
    $skin['p'] = imagecreatetruecolor(8 * $skin['r'], 8 * $skin['r']);
    imagecopy($skin['p'], $skin['s'], 0, 0, 8 * $skin['r'], 8 * $skin['r'], 8 * $skin['r'], 8 * $skin['r']);
    imagecopy($skin['p'], $skin['s'], 0, 0, 40 * $skin['r'], 8 * $skin['r'], 8 * $skin['r'], 8 * $skin['r']);
}

if ($skin['mode'] == '3') {
    $skin['fs'] = imagecreatetruecolor($skin['size'], $skin['size']);
} else {
    $skin['fs'] = imagecreatetruecolor($skin['size'], $skin['size'] * 2);
}

imagesavealpha($skin['fs'], true);
$skin['t'] = imagecolorallocatealpha($skin['fs'], 255, 255, 255, 127);
imagefill($skin['fs'], 0, 0, $skin['t']);
imagecopyresized($skin['fs'], $skin['p'], 0, 0, 0, 0, imagesx($skin['fs']), imagesy($skin['fs']), imagesx($skin['p']), imagesy($skin['p']));
imagepng($skin['fs']);

imagedestroy($skin['fs']);
imagedestroy($skin['p']);
imagedestroy($skin['s']);
?>
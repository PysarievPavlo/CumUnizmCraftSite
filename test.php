<?php
$file = "skins/test.txt";
$content = "Test content";
if (file_put_contents($file, $content)) {
    echo "File created successfully!";
} else {
    echo "Error creating file.";
}
?>
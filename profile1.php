<?php
require_once 'db_connect.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['userUUID'])) {
    $userUUID = $data['userUUID'];

    // Пошук користувача в базі даних
    $sql = "SELECT * FROM users WHERE uuid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userUUID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $response = [
            "success" => true,
            "result" => [
                "username" => $user['username'],
                "isAlex" => $user['isAlex'],
                "skinUrl" => $user['skin'],
                "capeUrl" => $user['capeURL']
            ]
        ];
    } else {
        $response = [
            "success" => false,
            "error" => "Користувач не знайдений"
        ];
    }
} else {
    $response = [
        "success" => false,
        "error" => "Недостатньо даних"
    ];
}

echo json_encode($response);
?>
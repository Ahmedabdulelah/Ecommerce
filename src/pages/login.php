<?php
include '../../config/database.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['user_name'];
    $password = $_POST['password'];

    $sql = 'SELECT * FROM users WHERE username = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['userid'] = $row['id'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION["username"]= $row['username'];
            $_SESSION["log_in"]= true;
            header("Location: ../index.php");
            exit(); 
        } else {
            $error_message = "خطأ في بيانات تسجيل الدخول";  
        }
    } else {
        $error_message = "خطأ في بيانات تسجيل الدخول"; 
    }

    $stmt->close();
    $conn->close();
}
if (!empty($error_message)) {
    echo "<script>
        alert('$error_message');
        window.location.href = 'login.html';
    </script>";
    exit();
}

?>

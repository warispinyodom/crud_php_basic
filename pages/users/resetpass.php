<?php
require_once 'header.php';
session_start();

if (empty($_SESSION['email'])) {
    header('Location: ../../auth/login.php');
    exit;
}

$email = $_SESSION['email'];

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldpass = $_POST['old_password'];
    $newpass = $_POST['new_password'];
    $confirmpass = $_POST['confirm_password'];

    if ($newpass !== $confirmpass) {
        $error = "❌ รหัสผ่านใหม่ไม่ตรงกัน";
    } else {
        // ดึงรหัสผ่านเดิมจากฐานข้อมูล
        $sql = "SELECT m_pass FROM members WHERE m_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($current_password);
        $stmt->fetch();
        $stmt->close();

        // ตรวจสอบรหัสผ่านเดิมแบบ plain text
        if ($oldpass === $current_password) {
            // ไม่เข้ารหัสรหัสผ่านใหม่ (plain text)
            $update_sql = "UPDATE members SET m_pass = ? WHERE m_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $newpass, $email);
            if ($update_stmt->execute()) {
                $success = "✅ เปลี่ยนรหัสผ่านสำเร็จแล้ว";
            } else {
                $error = "เกิดข้อผิดพลาดในการอัปเดตรหัสผ่าน";
            }
            $update_stmt->close();
        } else {
            $error = "❌ รหัสผ่านเดิมไม่ถูกต้อง";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รีเซ็ตรหัสผ่าน</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f2f2f2;
            padding: 40px;
        }

        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .formgroup {
            margin-bottom: 15px;
        }

        .formgroup label {
            display: block;
            margin-bottom: 5px;
        }

        .formgroup input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        .button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .message {
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
            color: red;
        }

        .success {
            color: green;
        }

        .nav-back {
            text-align: center;
            margin-top: 20px;
        }

        .nav-back a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🔐 รีเซ็ตรหัสผ่าน</h2>

    <?php if ($error): ?>
        <div class="message"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="message success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="formgroup">
            <label for="old_password">รหัสผ่านเดิม</label>
            <input type="password" name="old_password" id="old_password" required>
        </div>

        <div class="formgroup">
            <label for="new_password">รหัสผ่านใหม่</label>
            <input type="password" name="new_password" id="new_password" required>
        </div>

        <div class="formgroup">
            <label for="confirm_password">ยืนยันรหัสผ่านใหม่</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
        </div>

        <button type="submit" class="button">รีเซ็ตรหัสผ่าน</button>
    </form>

    <div class="nav-back">
        <a href="mainpage.php">← กลับหน้าหลัก</a>
    </div>
</div>

</body>
</html>

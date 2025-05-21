<?php
require_once 'header.php';
session_start();

$showemail = $_SESSION['email'];
$showuser = $_SESSION['username'];
$showtell = $_SESSION['tell'];

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $tell = $_POST['tell'];

    // ใช้ prepared statement ป้องกัน SQL Injection
    $stmt = $conn->prepare("UPDATE members SET m_id = ?, m_user = ?, m_tell = ? WHERE m_id = ?");
    $stmt->bind_param("ssss", $email, $username, $tell, $showemail);

    if ($stmt->execute()) {
        $success = "✅ อัปเดตข้อมูลสำเร็จแล้ว";

        // อัปเดต session
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['tell'] = $tell;

        $showemail = $email;
        $showuser = $username;
        $showtell = $tell;
    } else {
        $error = "❌ เกิดข้อผิดพลาดในการอัปเดต: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการโปรไฟล์</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .formgroup {
            margin-bottom: 20px;
        }

        .formgroup label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .formgroup input {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
        }

        .button-full {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        .button-full:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }

        .back-button {
            margin-top: 20px;
            text-align: center;
        }

        .back-button a {
            text-decoration: none;
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .back-button a:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>⚙️ จัดการโปรไฟล์</h2>

        <?php if ($success): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="formgroup">
         
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($showemail); ?>" required>
                <label for="email">อีเมล</label>
            </div>

            <div class="formgroup">
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($showuser); ?>" required>
                <label for="username">ชื่อ - นามสกุล</label>
            </div>

            <div class="formgroup">
                <input type="text" name="tell" id="tell" value="<?php echo htmlspecialchars($showtell); ?>" required>
                <label for="tell">เบอร์โทรศัพท์</label>
            </div>

            <button class="button-full" type="submit">💾 แก้ไขข้อมูล</button>
        </form>

        <div class="back-button">
            <a href="mainpage.php">← กลับหน้าหลัก</a>
        </div>
    </div>

</body>
</html>

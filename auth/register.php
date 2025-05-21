<?php
    require_once 'header.php';
    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = trim($_POST['email']);
        $usernameform = trim($_POST['username']);
        $password = trim($_POST['password']);
        $tell = trim($_POST['tell']);

        // ตรวจสอบว่าทุกฟิลด์ถูกกรอกหรือไม่
        if (empty($email) || empty($usernameform) || empty($password) || empty($tell)) {
            $error = "❌ กรุณากรอกข้อมูลให้ครบถ้วน";
        } else {
            // ใช้ prepared statement ป้องกัน SQL Injection
            $stmt = $conn->prepare("INSERT INTO `members`(`m_id`, `m_user`, `m_pass`, `m_tell`) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $email, $usernameform, $password, $tell);
            if ($stmt->execute()) {
                $success = "✅ สมัครสมาชิกสำเร็จ!";
                echo "<script>window.location = 'login.php';</script>";
            } else {
                $error = "❌ เกิดข้อผิดพลาดในการสมัครสมาชิก";
            }
            $stmt->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิก</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .formgroup {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .formgroup label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        .formgroup input {
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
            box-sizing: border-box;
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
        }

        .button-full:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        .link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #007BFF;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>📝 สมัครสมาชิก</h2>

        <?php if ($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="formgroup">
                <input type="email" name="email" id="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
                <label for="email">อีเมล</label>

            </div>

            <div class="formgroup">
                <input type="text" name="username" id="username" value="<?php echo isset($usernameform) ? $usernameform : ''; ?>" required>
                <label for="username">ชื่อ - นามสกุล</label>

            </div>

            <div class="formgroup">
                <input type="password" name="password" id="password" required>
                <label for="password">รหัสผ่าน</label>

            </div>

            <div class="formgroup">
                <input type="text" name="tell" id="tell" value="<?php echo isset($tell) ? $tell : ''; ?>" required>
                <label for="tell">เบอร์โทรศัพท์</label>

            </div>

            <button class="button-full" type="submit">สมัครสมาชิก</button>

            <a class="link" href="login.php">หากท่านมีบัญชีอยู่แล้ว คลิกที่นี่!</a>
        </form>
    </div>

</body>
</html>

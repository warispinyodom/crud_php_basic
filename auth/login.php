<?php
session_start();
require_once 'header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === '' || $password === '') {
        $error = "❌ กรุณากรอกข้อมูลให้ครบถ้วน";
    } else {
        // ใช้ prepared statement เพื่อความปลอดภัย
        $stmt = $conn->prepare("SELECT m_id, m_user, m_pass, m_tell FROM members WHERE m_id = ? AND m_pass = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // ตั้งค่า session
            $_SESSION['email'] = $row['m_id'];
            $_SESSION['username'] = $row['m_user'];
            $_SESSION['password'] = $row['m_pass'];
            $_SESSION['tell'] = $row['m_tell'];

            // redirect ไปหน้า main
            echo "<script>alert('เข้าสู่ระบบสำเร็จแล้ว')</script>";
            echo "<script>window.location = '../pages/users/mainpage.php'</script>";
            exit;
        } else {
            $error = "❌ อีเมลหรือรหัสผ่านไม่ถูกต้อง หรือไม่มีบัญชีผู้ใช้นี้";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
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

        .error-message {
            text-align: center;
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
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
        <h2>🔐 เข้าสู่ระบบ</h2>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="formgroup">
                <input type="email" name="email" id="email" required>
                <label for="email">อีเมล</label>
            </div>
            <div class="formgroup">
                <input type="password" name="password" id="password" required>
                <label for="password">รหัสผ่าน</label>
            </div>
            <button class="button-full" type="submit">เข้าสู่ระบบ</button>
            <a class="link" href="register.php">ยังไม่มีบัญชี? สมัครสมาชิกที่นี่</a>
        </form>
    </div>

</body>
</html>

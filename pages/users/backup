<?php
require_once 'header.php';
session_start();

// ตรวจสอบว่ามี session login หรือยัง
if (empty($_SESSION['email'])) {
    header('Location: ../../auth/login.php');
    exit;
}

// ดึงข้อมูลจาก session
$email = $_SESSION['email'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการบัญชีผู้ใช้</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
        }

        .navbar {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar .logo h3 {
            margin: 0;
        }

        .navbar .user-info {
            font-size: 14px;
        }

        ul.menu {
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: center;
        }

        ul.menu li {
            margin: 0;
        }

        ul.menu li a {
            display: block;
            padding: 15px 25px;
            text-decoration: none;
            color: #333;
            transition: background 0.3s;
        }

        ul.menu li a:hover {
            background-color: #f0f0f0;
        }

        .container {
            padding: 30px;
            text-align: center;
        }

        .container h2 {
            margin-bottom: 20px;
        }

        @media (max-width: 600px) {
            ul.menu {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">
            <h3>MyWebsite</h3>
        </div>
        <div class="user-info">
            👤 <?php echo htmlspecialchars($username); ?> | 
            📧 <?php echo htmlspecialchars($email); ?>
        </div>
    </div>

    <ul class="menu">
        <li><a href="mangename.php">📝 จัดการชื่อ</a></li>
        <li><a href="resetpass.php">🔐 จัดการรหัสผ่าน</a></li>
        <li><a href="profile.php">👤 โปรไฟล์</a></li>
        <li><a href="mainpage.php">🏠 หน้าหลัก</a></li>
        <li><a href="logout.php" onclick="return confirm('คุณต้องการออกจากระบบหรือไม่?')">🚪 ออกจากระบบ</a></li>
    </ul>

    <div class="container">
        <h2>👋 ยินดีต้อนรับสู่หน้าจัดการบัญชี</h2>
        <p>เลือกเมนูด้านบนเพื่อจัดการข้อมูลบัญชีของคุณ</p>
    </div>

</body>
</html>

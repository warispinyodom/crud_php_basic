<?php
require_once 'header.php';
session_start();

// ✅ เชื่อมต่อฐานข้อมูล (ถ้ายังไม่เชื่อมใน header.php ให้ใส่ไว้ตรงนี้)
// require_once 'db_connect.php';

if (empty($_SESSION['email'])) {
    header('Location: ../../auth/login.php');
    exit;
}

$email = $_SESSION['email'];
$username = $_SESSION['username'];
$tell = $_SESSION['tell'];

// ✅ ลบสมาชิกหากมีการส่ง delete_id มา
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // ป้องกันไม่ให้ลบตัวเอง
    if ($delete_id !== $email) {
        $stmt = $conn->prepare("DELETE FROM members WHERE m_id = ?");
        $stmt->bind_param("s", $delete_id);
        $stmt->execute();
        $stmt->close();

        header("Location: mainpage.php"); // รีเฟรชหน้า
        exit;
    }
}

// ดึงข้อมูลสมาชิก
$sql = "SELECT * FROM members";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ข้อมูลสมาชิกทั้งหมด</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .userinfo {
            font-size: 16px;
        }

        .nav-links a {
            margin-left: 15px;
            text-decoration: none;
            color: #007BFF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px 16px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .delete-button {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="userinfo">
        👋 ยินดีต้อนรับ, <?php echo htmlspecialchars($username); ?> <br>
        📧 <?php echo htmlspecialchars($email); ?> | 📞 <?php echo htmlspecialchars($tell); ?>
    </div>
    <div class="nav-links">
        <a href="profile.php">⚙️ จัดการโปรไฟล์</a>
        <a href="logout.php" onclick="return confirm('คุณแน่ใจหรือไม่ว่าจะออกจากระบบ?');">🚪 ออกจากระบบ</a>
    </div>
</div>

<h1>📋 รายชื่อสมาชิกทั้งหมด</h1>

<table>
    <tr>
        <th>ลำดับ</th>
        <th>อีเมล</th>
        <th>ชื่อผู้ใช้</th>
        <th>เบอร์โทรศัพท์</th>
        <th>จัดการ</th>
    </tr>
    <?php
    $i = 1;
    if ($result && mysqli_num_rows($result) > 0):
        while ($row = mysqli_fetch_assoc($result)):
    ?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo htmlspecialchars($row['m_id']); ?></td>
        <td><?php echo htmlspecialchars($row['m_user']); ?></td>
        <td><?php echo htmlspecialchars($row['m_tell']); ?></td>
        <td>
            <?php if ($row['m_id'] !== $email): ?>
                <a class="delete-button" href="?delete_id=<?php echo urlencode($row['m_id']); ?>" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสมาชิกนี้?');">ลบ</a>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>
    <?php
        endwhile;
    else:
    ?>
    <tr>
        <td colspan="5">ไม่มีข้อมูลสมาชิก</td>
    </tr>
    <?php endif; ?>
</table>

</body>
</html>

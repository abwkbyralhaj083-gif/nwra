<?php
$host = "localhost";
$dbname = "WaterResources";
$username = "your_username";
$password = "your_password";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "فشل الاتصال: " . $e->getMessage();
}
?>
<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM Users WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['username'] = $user['Username'];
        header("Location: dashboard.php");
    } else {
        $error = "خطأ في البريد الإلكتروني أو كلمة المرور";
    }
}
?>
<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $stmt = $conn->prepare("INSERT INTO DrillingPermits 
            (UserID, RequestDate, RequestType, Purpose, DrillingType, 
            WellStatus, District, Zone, Area, Location) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $_SESSION['user_id'],
            date('Y-m-d'),
            $_POST['request_type'],
            $_POST['purpose'],
            $_POST['drilling_type'],
            $_POST['well_status'],
            $_POST['district'],
            $_POST['zone'],
            $_POST['area'],
            $_POST['location']
        ]);
        
        echo "تم إرسال الطلب بنجاح";
    } catch(PDOException $e) {
        echo "حدث خطأ: " . $e->getMessage();
    }
}
?>
<?php
session_start();
require_once 'config.php';

$stmt = $conn->prepare("SELECT * FROM DrillingPermits WHERE UserID = ?");
$stmt->execute([$_SESSION['user_id']]);
$permits = $stmt->fetchAll();
?>

<table>
    <thead>
        <tr>
            <th>رقم الطلب</th>
            <th>تاريخ الطلب</th>
            <th>نوع الطلب</th>
            <th>الحالة</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($permits as $permit): ?>
        <tr>
            <td><?php echo $permit['PermitID']; ?></td>
            <td><?php echo $permit['RequestDate']; ?></td>
            <td><?php echo $permit['RequestType']; ?></td>
            <td><?php echo $permit['Status']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $stmt = $conn->prepare("INSERT INTO Complaints 
            (UserID, SubmissionDate, DefendantName, DefendantPhone, 
            DefendantCapacity, ComplaintReason, Status) 
            VALUES (?, ?, ?, ?, ?, ?, 'pending')");
        
        $stmt->execute([
            $_SESSION['user_id'],
            date('Y-m-d'),
            $_POST['defendant_name'],
            $_POST['defendant_phone'],
            $_POST['defendant_capacity'],
            $_POST['complaint_reason']
        ]);
        
        echo "تم تسجيل الشكوى بنجاح";
    } catch(PDOException $e) {
        echo "حدث خطأ: " . $e->getMessage();
    }
}
?>
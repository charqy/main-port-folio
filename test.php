
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // تحميل مكتبة PHPMailer

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');



    // تحقق من البيانات الأساسية
    if (empty($firstName) || empty($lastName) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "الرجاء تعبئة جميع الحقول بشكل صحيح.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // إعدادات SMTP - غيرها حسب مزود الإيميل عندك
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';       // مثال: خادم Gmail SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'achrafchari40@gmail.com';  // غيره لإيميلك
        $mail->Password = 'achrafchari2004';   // كلمة المرور أو كلمة مرور التطبيق (app password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // المرسل والمستقبل
        $mail->setFrom('achrafchari40@gmail.com', 'achraf');
        $mail->addAddress("achrafchari40@gmail.com"); // نفس إيميلك أو إيميل آخر تستقبل عليه

        // محتوى الرسالة
        $mail->isHTML(true);
        $mail->Subject = 'رسالة جديدة من نموذج الاتصال';
        $mail->Body = "
            <h2>رسالة من $firstName $lastName</h2>
            <p><b>البريد الإلكتروني:</b> $email</p>
            <p><b>الرسالة:</b><br>" . nl2br(htmlspecialchars($message)) . "</p>
        ";

        $mail->send();
        echo "تم إرسال الرسالة بنجاح. شكراً لتواصلك.";
    } catch (Exception $e) {
        echo "لم يتم إرسال الرسالة. حدث خطأ: " . $mail->ErrorInfo;
    }
} else {
    echo "طلب غير صحيح.";
}
?>
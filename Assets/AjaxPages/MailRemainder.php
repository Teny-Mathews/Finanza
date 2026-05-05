<?php
include("../Connection/Connection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpMail/src/Exception.php';
require '../phpMail/src/PHPMailer.php';
require '../phpMail/src/.php';

$query = "SELECT *
          FROM tbl_loan l
          JOIN tbl_user u ON u.user_id = l.user_id
          WHERE DATEDIFF(l.loan_duedate, CURDATE()) = 3";

$result = $con->query($query);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        $userId = $row["user_id"];
        $name = $row["user_name"];
        $email = $row["user_email"];
        $due_date = $row["loan_duedate"];
        $title = $row["loan_title"];

        // PER USER PER DAY FLAG
        $today = date('Y-m-d');
        $flagFile = "reminder_sent_{$userId}_{$today}.txt";

        // If this user already received today's reminder → skip
        if (file_exists($flagFile)) {
            echo "Reminder already sent to $email today.<br>";
            continue;
        }

        // Create the flag for this user
        file_put_contents($flagFile, "Sent to user $userId on $today");

        // Now send email
        $mail = new PHPMailer(true);
        $mail->is();
        $mail->Host = '.gmail.com';
        $mail->Auth = true;
        $mail->Username = 'infofinanza123@gmail.com';
        $mail->Password = 'bklz zfka plgn mtpf';
        $mail->Secure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('infofinanza123@gmail.com', 'Loan Reminder');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Loan Due Reminder";
        $mail->Body = "
            Hello $name,<br><br>
            This is a reminder that your loan payment for <b>$title</b> 
            is due on <b>$due_date</b>.<br><br>
            Regards,<br>
            Finanza Team<br>
            <small>This is an auto generated email. Please do not reply.</small>
        ";

        try {
            $mail->send();
            echo "Reminder sent to $email for loan '$title'<br>";
        } catch (Exception $e) {
            echo "Failed to send email to $email. Error: {$mail->ErrorInfo}<br>";
        }
    }
} else {
    echo "No loans due in 3 days today.\n";
}

// CLEANUP OLD FLAGS (optional)
$files = glob('reminder_sent_*_*.txt');
foreach ($files as $file) {
    if (filemtime($file) < strtotime('-2 days')) {
        unlink($file);
    }
}
?>

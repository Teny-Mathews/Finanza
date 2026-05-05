
<?php
include("../Connection/Connection.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpMail/src/Exception.php';
require '../phpMail/src/PHPMailer.php';
require '../phpMail/src/.php';

// Today's date
$today = date('Y-m-d');

// Get all users with an expense limit > 0
$userQuery = "SELECT user_id, user_name, user_email, user_expenselimit 
              FROM tbl_user 
              WHERE user_id='" . $_SESSION['uid'] . "' AND user_expenselimit > 0";

$userResult = $con->query($userQuery);

if ($userResult->num_rows > 0) {

    while ($user = $userResult->fetch_assoc()) {

        $userId = $user['user_id'];
        $userName = $user['user_name'];
        $userEmail = $user['user_email'];
        $expenseLimit = $user['user_expenselimit'];

        // ----------------------------
        // PER-USER PER-DAY FLAG FILE
        // ----------------------------
        $flagFile = "expense_alert_user_{$userId}_{$today}.txt";

        if (file_exists($flagFile)) {
            // Skip sending for this user today
            echo "Alert already sent today to $userEmail<br>";
            continue;
        }

        // ----------------------------
        // CALCULATE USER'S MONTHLY EXPENSE
        // ----------------------------
        $expenseQuery = "SELECT SUM(expense_price) AS total 
                         FROM tbl_expense 
                         WHERE user_id = $userId
                           AND MONTH(expense_date) = MONTH(CURDATE())
                           AND YEAR(expense_date) = YEAR(CURDATE())";

        $expenseResult = $con->query($expenseQuery);
        $expenseRow = $expenseResult->fetch_assoc();

        $totalExpense = $expenseRow['total'] ?? 0;

        // ----------------------------
        // CHECK IF USER EXCEEDED LIMIT
        // ----------------------------
        if ($totalExpense <= $expenseLimit) {
            echo "$userEmail is within limit.<br>";
            continue;
        }

        // ----------------------------
        // SEND EMAIL
        // ----------------------------
        $mail = new PHPMailer(true);

        try {

            $mail->is();
            $mail->Host = '.gmail.com';
            $mail->Auth = true;
            $mail->Username = 'infofinanza123@gmail.com';
            $mail->Password = 'ginu ynbj ngfa glyy';
            $mail->Secure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('infofinanza123@gmail.com', 'Finanza - Expense Alert');
            $mail->addAddress($userEmail);

            $mail->isHTML(true);
            $mail->Subject = "Expense Limit Exceeded";

            $mail->Body = "
                Hello $userName,<br><br>
                You have exceeded your monthly expense limit of <b>₹$expenseLimit</b>.<br>
                Your total recorded expenses this month: <b>₹$totalExpense</b>.<br><br>
                Please review your expenses and control your spending.<br><br>
                Regards,<br>
                Finanza Team
            ";

            $mail->send();

            echo "Expense alert sent to $userEmail<br>";

            // Create user-specific flag file
            file_put_contents($flagFile, "Sent on $today");

        } catch (Exception $e) {
            echo "Failed to send email to $userEmail. Error: {$mail->ErrorInfo}<br>";
        }
    }
} else {
    echo "No users with expense limits found.<br>";
}


// Clean old flag files (older than 3 days)
$files = glob('expense_alert_user_*.txt');

foreach ($files as $file) {
    if (filemtime($file) < strtotime('-3 days')) {
        unlink($file);
    }
}
?>

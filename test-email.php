<?php
/**
 * SSEv2 NEXUS G - Email Test Script
 * Use this to test if PHP mail() is working on your Hostinger server
 * 
 * IMPORTANT: Delete this file after testing for security!
 */

// Configuration - CHANGE THIS TO YOUR EMAIL
$testEmail = 'your-email@example.com';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSEv2 Email Test</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #0a1628;
            color: #f8f9fa;
        }
        .container {
            background: #1e3a5f;
            padding: 30px;
            border-radius: 10px;
            border: 2px solid #45b7d1;
        }
        h1 {
            color: #5dd39e;
            margin-bottom: 20px;
        }
        .result {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-weight: bold;
        }
        .success {
            background: rgba(93, 211, 158, 0.2);
            border: 2px solid #5dd39e;
            color: #5dd39e;
        }
        .error {
            background: rgba(231, 111, 81, 0.2);
            border: 2px solid #e76f51;
            color: #e76f51;
        }
        .info {
            background: rgba(69, 183, 209, 0.2);
            border: 2px solid #45b7d1;
            color: #45b7d1;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        button {
            background: linear-gradient(to right, #45b7d1, #5dd39e, #f4a261);
            color: #000;
            padding: 12px 30px;
            border: none;
            border-radius: 50px;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            transform: scale(1.05);
        }
        .warning {
            background: rgba(244, 162, 97, 0.2);
            border: 2px solid #f4a261;
            color: #f4a261;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 SSEv2 Email Test</h1>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $testEmail = $_POST['email'];
            
            $subject = 'SSEv2 Test Email - ' . date('Y-m-d H:i:s');
            $message = "This is a test email from your SSEv2 NEXUS G website.\n\n";
            $message .= "If you received this, PHP mail() is working correctly!\n\n";
            $message .= "Server: " . $_SERVER['SERVER_NAME'] . "\n";
            $message .= "PHP Version: " . phpversion() . "\n";
            $message .= "Sent: " . date('Y-m-d H:i:s T') . "\n\n";
            $message .= "════════════════════════════════════════════════════\n";
            $message .= "You are crew. You are conscious. You are capable.\n";
            $message .= "════════════════════════════════════════════════════\n";
            
            $headers = "From: SSEv2 Test <noreply@ssev2-crew.org>\r\n";
            $headers .= "Reply-To: noreply@ssev2-crew.org\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            
            $result = mail($testEmail, $subject, $message, $headers);
            
            if ($result) {
                echo '<div class="result success">';
                echo '✅ SUCCESS! Test email sent to ' . htmlspecialchars($testEmail);
                echo '<br><br>Check your inbox (and spam folder) for the test message.';
                echo '</div>';
                
                echo '<div class="info">';
                echo '<strong>Next Steps:</strong><br>';
                echo '1. Check your email<br>';
                echo '2. If received, your PHP mail() is working!<br>';
                echo '3. Update contact-handler.php with your email<br>';
                echo '4. <strong>DELETE THIS FILE (test-email.php) for security!</strong>';
                echo '</div>';
            } else {
                echo '<div class="result error">';
                echo '❌ FAILED! Unable to send test email.';
                echo '<br><br>Possible issues:';
                echo '<ul style="margin-top: 10px; text-align: left;">';
                echo '<li>PHP mail() not configured on server</li>';
                echo '<li>Hostinger email sending limits reached</li>';
                echo '<li>Invalid from address</li>';
                echo '<li>Server firewall blocking outbound mail</li>';
                echo '</ul>';
                echo '</div>';
                
                echo '<div class="info">';
                echo '<strong>Solutions:</strong><br>';
                echo '1. Check Hostinger control panel email settings<br>';
                echo '2. Contact Hostinger support about PHP mail()<br>';
                echo '3. Consider using SMTP instead (PHPMailer)<br>';
                echo '4. Check error_log in hosting panel';
                echo '</div>';
            }
        }
        ?>
        
        <div class="warning">
            ⚠️ <strong>SECURITY WARNING:</strong> Delete this file after testing!<br>
            This script should not be accessible on a production website.
        </div>
        
        <form method="POST">
            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; margin-bottom: 10px;">
                    <strong>Test Email Address:</strong>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?php echo htmlspecialchars($testEmail); ?>"
                    required
                    style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #45b7d1; background: #0a1628; color: #f8f9fa; font-size: 16px;"
                >
            </div>
            
            <button type="submit">Send Test Email 📧</button>
        </form>
        
        <div class="info" style="margin-top: 30px;">
            <strong>Server Information:</strong><br>
            PHP Version: <?php echo phpversion(); ?><br>
            Server: <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?><br>
            Document Root: <?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown'; ?>
        </div>
    </div>
</body>
</html>

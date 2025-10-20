<?php
/**
 * SSEv2 NEXUS G - Contact Form Handler
 * Processes crew member contact form submissions
 * 
 * Security features:
 * - Honeypot spam protection
 * - Email validation
 * - Rate limiting
 * - Input sanitization
 */

// Configuration
define('CREW_EMAIL', 'noah.o.bodhi@ssev2-crew.org'); // Your email address
define('MAX_SUBMISSIONS_PER_HOUR', 5); // Rate limit
define('LOG_FILE', __DIR__ . '/logs/contact-submissions.log');

// Start session for rate limiting
session_start();

// Headers
header('Content-Type: application/json');

/**
 * Main processing function
 */
function processContactForm() {
    // Only accept POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return sendResponse(false, 'Invalid request method');
    }
    
    // Check honeypot (spam protection)
    if (!empty($_POST['bot-field'])) {
        logSubmission('SPAM_HONEYPOT', $_POST);
        // Pretend success to confuse bots
        return sendResponse(true, 'Message received');
    }
    
    // Rate limiting check
    if (!checkRateLimit()) {
        return sendResponse(false, 'Too many submissions. Please try again later.');
    }
    
    // Validate and sanitize inputs
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $role = sanitizeInput($_POST['role'] ?? 'general');
    $message = sanitizeInput($_POST['message'] ?? '');
    
    // Validation
    $errors = [];
    
    if (empty($name) || strlen($name) < 2) {
        $errors[] = 'Please provide a valid name';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please provide a valid email address';
    }
    
    if (empty($message) || strlen($message) < 10) {
        $errors[] = 'Please provide a message (at least 10 characters)';
    }
    
    if (!empty($errors)) {
        return sendResponse(false, implode('. ', $errors));
    }
    
    // Prepare email
    $emailSent = sendCrewEmail($name, $email, $role, $message);
    
    if ($emailSent) {
        // Log successful submission
        logSubmission('SUCCESS', [
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'message_length' => strlen($message)
        ]);
        
        // Update rate limit counter
        incrementSubmissionCount();
        
        return sendResponse(true, 'Transmission received! Welcome aboard, crew member.');
    } else {
        logSubmission('EMAIL_FAILED', ['email' => $email]);
        return sendResponse(false, 'Unable to send message. Please try again or contact us directly.');
    }
}

/**
 * Send email to crew
 */
function sendCrewEmail($name, $email, $role, $message) {
    $roleNames = [
        'strategist' => 'Strategist - Vision & Planning',
        'builder' => 'Builder - Development & Creation',
        'connector' => 'Connector - Community & Outreach',
        'catalyst' => 'Catalyst - Ideas & Innovation',
        'general' => 'General Inquiry'
    ];
    
    $roleName = $roleNames[$role] ?? 'General Inquiry';
    
    $subject = "[SSEv2 NEXUS] New Crew Transmission from {$name}";
    
    $emailBody = "";
    $emailBody .= "═══════════════════════════════════════════════════\n";
    $emailBody .= "    SPACESHIP EARTH v2.0 - NEW TRANSMISSION\n";
    $emailBody .= "═══════════════════════════════════════════════════\n\n";
    $emailBody .= "CREW MEMBER: {$name}\n";
    $emailBody .= "CHANNEL: {$email}\n";
    $emailBody .= "ROLE INTEREST: {$roleName}\n\n";
    $emailBody .= "───────────────────────────────────────────────────\n";
    $emailBody .= "MESSAGE:\n";
    $emailBody .= "───────────────────────────────────────────────────\n\n";
    $emailBody .= wordwrap($message, 70) . "\n\n";
    $emailBody .= "───────────────────────────────────────────────────\n\n";
    $emailBody .= "Transmitted: " . date('Y-m-d H:i:s T') . "\n";
    $emailBody .= "From: ssev2-crew.org\n";
    $emailBody .= "\n═══════════════════════════════════════════════════\n";
    $emailBody .= "You are crew. You are conscious. You are capable.\n";
    $emailBody .= "═══════════════════════════════════════════════════\n";
    
    $headers = [];
    $headers[] = "From: SSEv2 NEXUS <noreply@ssev2-crew.org>";
    $headers[] = "Reply-To: {$name} <{$email}>";
    $headers[] = "X-Mailer: PHP/" . phpversion();
    $headers[] = "X-Priority: 1";
    $headers[] = "Content-Type: text/plain; charset=UTF-8";
    
    return mail(CREW_EMAIL, $subject, $emailBody, implode("\r\n", $headers));
}

/**
 * Check rate limiting
 */
function checkRateLimit() {
    $currentHour = date('YmdH');
    
    if (!isset($_SESSION['submission_hour'])) {
        $_SESSION['submission_hour'] = $currentHour;
        $_SESSION['submission_count'] = 0;
    }
    
    // Reset counter if hour changed
    if ($_SESSION['submission_hour'] !== $currentHour) {
        $_SESSION['submission_hour'] = $currentHour;
        $_SESSION['submission_count'] = 0;
    }
    
    return $_SESSION['submission_count'] < MAX_SUBMISSIONS_PER_HOUR;
}

/**
 * Increment submission counter
 */
function incrementSubmissionCount() {
    if (!isset($_SESSION['submission_count'])) {
        $_SESSION['submission_count'] = 0;
    }
    $_SESSION['submission_count']++;
}

/**
 * Sanitize user input
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Log submission for monitoring
 */
function logSubmission($status, $data) {
    $logDir = dirname(LOG_FILE);
    if (!file_exists($logDir)) {
        @mkdir($logDir, 0755, true);
    }
    
    $logEntry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'status' => $status,
        'data' => $data
    ];
    
    @file_put_contents(
        LOG_FILE,
        json_encode($logEntry) . "\n",
        FILE_APPEND | LOCK_EX
    );
}

/**
 * Send JSON response
 */
function sendResponse($success, $message) {
    http_response_code($success ? 200 : 400);
    echo json_encode([
        'success' => $success,
        'message' => $message
    ]);
    exit;
}

// Process the form
processContactForm();
?>
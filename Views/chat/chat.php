<?php
require_once '../../Controllers/DBController.php';
require_once '../../Controllers/AuthController.php';
require_once '../../Controllers/StaffController.php';
require_once '../../Controllers/CustomerController.php';
require_once '../../Controllers/BugController.php';
require_once '../../Models/Message.php';
require_once '../../Controllers/MessageController.php';

$user_id = $_SESSION['userId'] ?? null;
$user_role = $_SESSION['userRole'] ?? null;
$errMsg = $_SESSION['errMsg'] ?? '';
$successMsg = $_SESSION['successMsg'] ?? '';
unset($_SESSION['errMsg'], $_SESSION['successMsg']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user_id && $user_role) {
    $bug_id = $_POST['bug_id'] ?? null;
    $recipient_id = $_POST['recipient_id'] ?? null;
    $message_text = $_POST['message'] ?? null;

    if ($bug_id && $recipient_id && $message_text) {
        $message = new Message(0, $bug_id, $user_id, $message_text);
        $message->setRecipientId($recipient_id);
        $messageController = new MessageController();
        if ($messageController->sendMessage($message, $user_role)) {
            $_SESSION['successMsg'] = "Message sent successfully.";
            echo "<script>window.location.href = 'index.php?page=chat';</script>";
            exit();
        } else {
            $errMsg = $_SESSION['errMsg'] ?? "Failed to send message.";
        }
    } else {
        $errMsg = "Please select a bug, recipient, and enter a message.";
    }
}

// Load bugs for the select dropdown
$bugs = [];
$authController = new AuthController();
$bugController = new BugController();
if ($user_id && $user_role) {
    if ($user_role == 'admin') {
        $result = $bugController->getAllBugs();
        if (!$result) {
            $errMsg = "Error in fetching bugs.";
        } else {
            $bugs = $result;
        }
    } elseif ($user_role == 'staff') {
        $user = $authController->getUserById($user_id);
        if ($user) {
            $staffController = new StaffController();
            $staff = $staffController->getStaffByEmail($user[0]["email"]);
            if ($staff) {
                $result = $bugController->getBugsForStaff($staff[0]["staff_id"]);
                if (!$result) {
                    $errMsg = "Error in fetching bugs.";
                } else {
                    $bugs = $result;
                }
            } else {
                $errMsg = "Staff not found.";
            }
        } else {
            $errMsg = "User not found.";
        }
    } elseif ($user_role == 'customer') {
        $user = $authController->getUserById($user_id);
        if ($user) {
            $customerController = new CustomerController();
            $customer = $customerController->getCustomerByEmail($user[0]["email"]);
            if ($customer) {
                $result = $bugController->getAllBugsForCustomer($customer[0]["customer_id"]);
                if (!$result) {
                    $errMsg = "Error in fetching bugs.";
                } else {
                    $bugs = $result;
                }
            } else {
                $errMsg = "Customer not found.";
            }
        } else {
            $errMsg = "User not found.";
        }
    }
}

// Load received messages
$received_messages = [];
if ($user_id && $user_role) {
    $messageController = new MessageController();
    $received_messages = $messageController->getUserMessages($user_id, $user_role);
} else {
    $errMsg = $errMsg ?: "Please log in to view messages.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .messages-list {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="chat-container">
        <h2 class="mb-4">Chat</h2>

        <?php if ($errMsg): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($errMsg); ?></div>
        <?php endif; ?>
        <?php if ($successMsg): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($successMsg); ?></div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">Send Message</div>
            <div class="card-body">
                <?php if ($user_id && $user_role): ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="bug_id" class="form-label">Select Bug</label>
                            <select name="bug_id" id="bug_id" class="form-select" required>
                                <option value="">Select a bug</option>
                                <?php
                                foreach ($bugs as $bug) {
                                    echo "<option value='{$bug['id']}'>" . htmlspecialchars($bug['bug_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="recipient_id" class="form-label">Select Recipient</label>
                            <select name="recipient_id" id="recipient_id" class="form-select" required>
                                <option value="">Select a recipient</option>
                                <?php
                                $db = new DBController();
                                if ($db->openConnection()) {
                                    $query = "SELECT id, name FROM users WHERE id != ? AND role IN ('admin', 'staff', 'customer')";
                                    $stmt = $db->connection->prepare($query);
                                    $stmt->bind_param("i", $user_id);
                                    $stmt->execute();
                                    $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                    foreach ($users as $user) {
                                        echo "<option value='{$user['id']}'>" . htmlspecialchars($user['name']) . "</option>";
                                    }
                                    $stmt->close();
                                    $db->closeConnection();
                                } else {
                                    $errMsg = "Error connecting to database.";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                <?php else: ?>
                    <p class="text-muted">Please log in to send messages.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Received Messages</div>
            <div class="card-body messages-list">
                <?php if (empty($received_messages)): ?>
                    <p class="text-muted text-center">No messages received.</p>
                <?php else: ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>From</th>
                                <th>Bug</th>
                                <th>Message</th>
                                <th>Sent At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($received_messages as $msg): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($msg['sender_name'] ?? 'Unknown'); ?></td>
                                    <td><?php echo htmlspecialchars($msg['bug_name'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($msg['message'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($msg['sent_at'] ?? ''); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
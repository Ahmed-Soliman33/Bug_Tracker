<i class="bi bi-pencil-square text-info" style="cursor: pointer; margin-right: 2px;  font-size: 18px; "></i>
<i class="bi bi-archive-fill  " style="cursor: pointer; font-size: 18px; color: #e01123; "></i>
<?php
include '';

if (isset($_GET['id'])) {
    $bug_id = intval($_GET['id']); 

    $stmt = $conn->prepare("DELETE FROM bugs WHERE id = ?");
    $stmt->bind_param("i", $bug_id);

    if ($stmt->execute()) {
        echo "Bug deleted successfully.";
    } else {
        echo "Error deleting bug: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No bug ID provided.";
}
?>

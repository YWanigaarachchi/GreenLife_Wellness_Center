<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['query'])) {
    $query = "%" . $_GET['query'] . "%";
    $sql = "SELECT * FROM services WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $query);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>" . htmlspecialchars($row['name']) . "</strong>: " . htmlspecialchars($row['description']) . "</p>";
    }
}
?>

<!-- search form -->
<form method="GET">
    <input type="text" name="query" placeholder="Search services...">
    <button type="submit">Search</button>
</form>
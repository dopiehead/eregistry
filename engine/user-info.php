<?php
require("auth.php");
$auth = new Auth(new Database());

$conn = $auth->getConnection();
$user_id = $auth->getUserId();

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $search = $conn->real_escape_string($_GET['q']);
    $searchTerms = explode(" ", $search);

    $query = "SELECT id, name, state FROM user_profile WHERE verified = 1 AND (";
    $conditions = [];
    $params = [];
    $paramTypes = "";

    foreach ($searchTerms as $text) {
        $conditions[] = "(name LIKE ?)";
        $paramTypes .= "s";
        $params[] = "%$text%";
    }

    $query .= implode(" AND ", $conditions) . ") ORDER BY id DESC LIMIT 5";

    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param($paramTypes, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<div class='w-100'>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $name = $row['name'];
            $state = $row['state'];
            ?>
            <div class='result-item d-flex justify-content-between align-items-center'>
                <span class='text-sm text-decoration-none text-capitalize fw-bold text-secondary'>
                    <?= htmlspecialchars($name); ?>
                </span>

                <span class='text-sm text-decoration-none text-capitalize fw-bold text-secondary'>
                    <?= htmlspecialchars($state); ?>
                </span>

                <a class='btn btn-sm btn-outline-primary' href="userProfile?id=<?= base64_encode($id); ?>">Check details</a>
            </div>
            <?php
        }
        ?>
        <div class='text-end px-2 py-2'>
            <a class='text-decoration-none text-secondary px-2 rounded-2 py-1 btn-dark text-white text-sm' href="userProfile?search=<?= urlencode($_GET['q']); ?>">See more <i class='fa fa-arrow-right'></i></a>
        </div>
        <?php
    } else {
        echo "<p class='text-muted'>No result found.</p>";
    }

    echo "</div>";
    $stmt->close();
}
?>

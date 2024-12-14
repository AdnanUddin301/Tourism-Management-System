<?php include('includes/header.php'); 

require_once 'db/db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$plan_id = $_GET['plan_id'] ?? null;

// Fetch tour plan details using the corrected table name 'tour_plan'
$query = "SELECT tp.spot_id, ts.spot_name 
          FROM tour_plan tp
          JOIN tourist_spots ts ON tp.spot_id = ts.spot_id
          WHERE tp.plan_id = :plan_id AND tp.user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['plan_id' => $plan_id, 'user_id' => $user_id]);
$plan = $stmt->fetch();

if (!$plan) {
    echo "Invalid tour plan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_text = $_POST['review_text'];

    // Insert review without rating (since rating is no longer part of the table)
    $insert_query = "INSERT INTO reviews (user_id, spot_id, review_text) 
                     VALUES (:user_id, :spot_id, :review_text)";
    $insert_stmt = $pdo->prepare($insert_query);
    $insert_stmt->execute([
        'user_id' => $user_id,
        'spot_id' => $plan['spot_id'],
        'review_text' => $review_text
    ]);

    echo "Review submitted successfully! <a href='dashboard.php'>Go back to Dashboard</a>";
    exit;
}
?>

<h1 style="text-align: center; color: #333; margin-bottom: 20px;">Leave a Review for <?= htmlspecialchars($plan['spot_name']) ?></h1>

<form method="POST" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
    <label for="review_text" style="display: block; font-size: 16px; color: #555; margin-bottom: 10px;">Your Review:</label>
    <textarea name="review_text" rows="5" cols="40" required style="width: 100%; padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 20px;"></textarea>
    <button type="submit" style="padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; border: none; border-radius: 5px; cursor: pointer;">Submit Review</button>
</form>

<a href="dashboard.php" style="display: block; text-align: center; margin-top: 20px; font-size: 16px; color: #007bff; text-decoration: none;">Back to Dashboard</a>

<?php include('includes/footer.php'); ?>

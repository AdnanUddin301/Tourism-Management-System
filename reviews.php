<?php
include('includes/header.php');
require_once 'db/db.php';

$spot_id = $_GET['spot_id'] ?? null;

// Fetch spot details
$query = "SELECT spot_name FROM tourist_spots WHERE spot_id = :spot_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['spot_id' => $spot_id]);
$spot = $stmt->fetch();

if (!$spot) {
    echo "Spot not found.";
    exit;
}

// Fetch reviews for the spot
$reviews_query = "SELECT r.review_text, u.username 
                  FROM reviews r
                  JOIN users u ON r.user_id = u.user_id
                  WHERE r.spot_id = :spot_id";
$reviews_stmt = $pdo->prepare($reviews_query);
$reviews_stmt->execute(['spot_id' => $spot_id]);
$reviews = $reviews_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews for <?= htmlspecialchars($spot['spot_name']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            text-align: center;
            font-size: 18px;
            color: #555;
        }

        .reviews-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .review-item {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-item strong {
            font-size: 18px;
            color: #007bff;
        }

        .review-item p {
            font-size: 16px;
            color: #555;
            margin-top: 5px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <h1>Reviews for <?= htmlspecialchars($spot['spot_name']) ?></h1>
    <p>Read what other tourists have to say about this spot!</p>

    <div class="reviews-container">
        <?php if ($reviews): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <strong><?= htmlspecialchars($review['username']) ?>:</strong>
                    <p><?= htmlspecialchars($review['review_text']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; font-size: 16px; color: #555;">No reviews yet. Be the first to leave a review!</p>
        <?php endif; ?>
    </div>

    <a href="catagories.php" class="back-link">Back to Spots</a>

<?php include('includes/footer.php'); ?>
</body>
</html>

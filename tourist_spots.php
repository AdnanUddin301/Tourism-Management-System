<?php
include('includes/header.php');
require_once 'db/db.php';

// Get the category_id from the URL
$category_id = $_GET['category_id'] ?? null;

        if (!$category_id) {
echo "<p class='text-red-500'>Invalid request. No category selected.</p>";
exit;
}

// Fetch all spots under the selected category
$query = "SELECT ts.spot_id, ts.spot_name, ts.description 
FROM tourist_spots ts
JOIN categories sc ON ts.category_id = sc.category_id
WHERE sc.category_id = :category_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['category_id' => $category_id]);
$spots = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tourist Spots</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6 bg-white shadow-lg rounded-md">
        <h1 class="text-3xl font-bold mb-4 text-gray-800">Tourist Spots</h1>
        <p class="mb-6 text-lg text-gray-600">Explore the tourist spots in this category!</p>

        <?php if ($spots && count($spots) > 0): ?>
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<?php foreach ($spots as $spot): ?>
                    <li class="bg-white shadow-md rounded-md p-4 hover:bg-blue-50 transition duration-300">
                        <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($spot['spot_name']) ?></h2>
                        <p class="text-gray-700 mb-4"><?= htmlspecialchars($spot['description']) ?></p>
                        <div class="flex space-x-2">
                            <a href="book_spot.php?spot_id=<?= htmlspecialchars($spot['spot_id']) ?>"
class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-300">
Book Now
                            </a>
                            <a href="reviews.php?spot_id=<?= htmlspecialchars($spot['spot_id']) ?>"
class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition duration-300">
View Reviews
                            </a>
                        </div>
                    </li>
<?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-red-500 font-semibold">No tourist spots found for this category.</p>
<?php endif; ?>

        <div class="text-center mt-6">
            <a href="categories.php" class="bg-blue-500 text-white py-3 px-6 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
Back to Categories
        </a>
        </div>
    </div>

<?php include('includes/footer.php'); ?>
</body>
</html>
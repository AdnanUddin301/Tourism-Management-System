<?php
include('includes/header.php');
require_once 'db/db.php';

// Fetch all categories
$query = "SELECT * FROM categories";
$stmt = $pdo->query($query);
$categories = $stmt->fetchAll();

// Fetch tourist spots based on selected categories or fetch all spots
$tourist_spots = [];

// Fetch all spots by default
$spots_query = "SELECT * FROM tourist_spots";
$spots_stmt = $pdo->query($spots_query);
$tourist_spots = $spots_stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['category_ids'])) {
        // Fetch spots for the selected categories
        $selected_category_ids = $_POST['category_ids'];

        // Generate placeholders for the query
        $placeholders = implode(',', array_fill(0, count($selected_category_ids), '?'));

        $spots_query = "SELECT * FROM tourist_spots WHERE category_id IN ($placeholders)";
        $spots_stmt = $pdo->prepare($spots_query);
        $spots_stmt->execute($selected_category_ids);
        $tourist_spots = $spots_stmt->fetchAll();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            font-family: 'Arial', sans-serif;
        }
        .category-card, .spot-card {
            border: 1px solid #ddd;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .category-card:hover, .spot-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .spot-actions {
            margin-top: 1rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        a {
            text-decoration: none;
        }
        .category-link, .spot-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem;
            font-size: 1.25rem;
            text-align: center;
            color: #007BFF;
            font-weight: 600;
        }
        .category-link:hover, .spot-link:hover {
            color: #a10099;
        }
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background-color: #5338ff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #a212c9;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container mx-auto p-6 bg-white shadow-lg rounded-md">
        <h1 class="text-4xl font-bold mb-6 text-gray-800 text-center">Explore Categories</h1>
        <p class="mb-8 text-lg text-gray-600 text-center">Select categories to filter the tourist spots!</p>

        <!-- New Category Selection Section -->
        <form method="POST" class="mb-6">
            <div class="flex flex-wrap justify-center gap-4">
                <?php foreach ($categories as $category): ?>
                    <label class="flex items-center space-x-2 bg-gray-100 px-4 py-2 rounded-lg shadow hover:bg-gray-200 transition cursor-pointer">
                        <input type="checkbox" name="category_ids[]" value="<?= htmlspecialchars($category['category_id']) ?>" class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="text-gray-700"><?= htmlspecialchars($category['category_name']) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-center mt-6">
                <button type="submit" class="bg-indigo-600 text-white py-3 px-6 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
                    Filter
                </button>
            </div>
        </form>

        <?php if (!empty($tourist_spots)): ?>
            <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Filtered Tourist Spots</h2>
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($tourist_spots as $spot): ?>
                    <li class="spot-card rounded-md p-4">
                        <div class="spot-content text-center">
                            <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($spot['spot_name']) ?></h3>
                            <p class="text-gray-600 mb-4"><?= htmlspecialchars($spot['description']) ?></p>
                        </div>
                        <div class="spot-actions">
                            <a href="book_spot.php?spot_id=<?= htmlspecialchars($spot['spot_id']) ?>" class="btn btn-primary">
                                Book the Spot
                            </a>
                            <a href="reviews.php?spot_id=<?= htmlspecialchars($spot['spot_id']) ?>" class="btn btn-secondary">
                                View Reviews
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p class="text-red-500 font-semibold text-center">No tourist spots found for the selected categories.</p>
        <?php endif; ?>

        <div class="text-center mt-8">
            <a href="index.php" class="inline-block bg-emerald-500 text-white py-3 px-8 rounded-lg shadow-md hover:bg-blue-600 hover:shadow-lg transition duration-300">
                Back to Home
            </a>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>

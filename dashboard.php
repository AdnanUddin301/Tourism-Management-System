<?php include('includes/header.php'); 
require_once 'db/db.php';

// for check
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}

$user_id = $_SESSION['user_id'];


$query = "SELECT tp.plan_id, ts.spot_name, tp.start_date, tp.end_date, tp.total_cost
          FROM tour_plan tp
          JOIN tourist_spots ts ON tp.spot_id = ts.spot_id
          WHERE tp.user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$plans = $stmt->fetchAll();
?>

<h1 style="font-family: 'Arial', sans-serif; font-size: 2.5em; color: #2c3e50; text-align: center; margin-top: 20px;">
    Your Dashboard
</h1>
<p style="text-align: center; font-size: 1.2em; color: #34495e; margin: 20px auto; max-width: 600px; background-color: #ecf0f1; padding: 15px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
    Welcome to your dashboard! Here you can view your tour plans and leave reviews for spots you've visited.
</p>

<h2 style="font-family: 'Arial', sans-serif; font-size: 2em; color: #2980b9; margin-left: 10%; margin-top: 30px;">
    Your Plans:
</h2>
<div style="max-width: 800px; margin: 0 auto; padding: 20px; background-color: #f4f6f7; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
    <?php if ($plans): ?>
        <ul style="list-style-type: none; padding: 0;">
            <?php foreach ($plans as $plan): ?>
                <li style="margin-bottom: 20px; padding: 15px; border: 1px solid #d5d8dc; border-radius: 5px; background-color: #ffffff; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);">
                    <p><strong style="color: #34495e;">Spot:</strong> <?= htmlspecialchars($plan['spot_name']) ?></p>
                    <p><strong style="color: #34495e;">Dates:</strong> <?= htmlspecialchars($plan['start_date']) ?> to <?= htmlspecialchars($plan['end_date']) ?></p>
                    <p><strong style="color: #34495e;">Total Cost:</strong> $<?= htmlspecialchars($plan['total_cost']) ?></p>
                    <a href="give_review.php?plan_id=<?= $plan['plan_id'] ?>" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #3498db; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 5px; transition: background-color 0.3s ease, transform 0.3s ease;" 
                    onmouseover="this.style.backgroundColor='#cc0088'; this.style.transform='scale(1.05)';" 
                    onmouseout="this.style.backgroundColor='#3498db'; this.style.transform='scale(1)';">
                        Give Review
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p style="font-size: 1.2em; color: #7f8c8d; text-align: center; margin-top: 20px;">
            You have no plans yet. Start by booking a spot!
        </p>
    <?php endif; ?>
</div>

<div style="text-align: center; margin-top: 30px;">
    <a href="catagories.php" style="display: inline-block; margin-top: 20px; padding: 15px 25px; background-color: #8e44ad; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 5px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease, transform 0.3s ease;" 
    onmouseover="this.style.backgroundColor='#732d91'; this.style.transform='scale(1.05)';" 
    onmouseout="this.style.backgroundColor='#8e44ad'; this.style.transform='scale(1)';">
        Browse Spots
    </a>
</div>


<?php include('includes/footer.php');  ?>

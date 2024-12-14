<?php include('includes/header.php'); 

require_once 'db/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$spot_id = $_GET['spot_id'] ?? null;

// Fetch spot details
$query = "SELECT * FROM tourist_spots WHERE spot_id = :spot_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['spot_id' => $spot_id]);
$spot = $stmt->fetch();

$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $accommodation = $_POST['accommodation'];
    $transportation = $_POST['transportation'];
    $meals = $_POST['meals'];
    $guide_id = $_POST['guide_id'];
    $total_cost = calculateCost($start_date, $end_date, $accommodation, $transportation, $meals);

    // Inserting your  tour plan
    $query = "INSERT INTO tour_plan (user_id, spot_id, start_date, end_date, accommodation, transportation, meals, guide_id, total_cost)
              VALUES (:user_id, :spot_id, :start_date, :end_date, :accommodation, :transportation, :meals, :guide_id, :total_cost)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'user_id' => $user_id,
        'spot_id' => $spot_id,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'accommodation' => $accommodation,
        'transportation' => $transportation,
        'meals' => $meals,
        'guide_id' => $guide_id,
        'total_cost' => $total_cost
    ]);

    $success_message = "Booking successful! <a href='dashboard.php'>Go to Dashboard</a>";
}

function calculateCost($start_date, $end_date, $accommodation, $transportation, $meals) {
    // Basic cost calculation logic
    $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);
    $cost = $days * 50; // Base cost per day
    $cost += $accommodation === 'resort' ? 200 : ($accommodation === 'hotel' ? 150 : 100);
    $cost += $transportation === 'airplane' ? 300 : ($transportation === 'private car' ? 200 : 100);
    $cost += $meals === 'breakfast+lunch+dinner' ? 50 : ($meals === 'breakfast+dinner' ? 30 : 0);
    return $cost;
}

// Fetch tour guides
$guides_query = "SELECT * FROM tour_guides";
$guides_stmt = $pdo->query($guides_query);
$guides = $guides_stmt->fetchAll();
?>

<h1 style="text-align: center; color: #333; margin-bottom: 20px;">Book Spot: <?= htmlspecialchars($spot['spot_name']) ?></h1>

<form method="POST" id="booking-form" style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <label for="start_date" style="display: block; margin-bottom: 8px; font-weight: bold;">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

    <label for="end_date" style="display: block; margin-bottom: 8px; font-weight: bold;">End Date:</label>
    <input type="date" id="end_date" name="end_date" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

    <label for="accommodation" style="display: block; margin-bottom: 8px; font-weight: bold;">Accommodation:</label>
    <select id="accommodation" name="accommodation" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">
        <option value="motel">Motel</option>
        <option value="resort">Resort</option>
        <option value="hotel">Hotel</option>
    </select>

    <label for="transportation" style="display: block; margin-bottom: 8px; font-weight: bold;">Transportation:</label>
    <select id="transportation" name="transportation" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">
        <option value="private car">Private Car</option>
        <option value="airplane">Airplane</option>
        <option value="train">Train</option>
        <option value="bus">Bus</option>
    </select>

    <label for="meals" style="display: block; margin-bottom: 8px; font-weight: bold;">Meals:</label>
    <select id="meals" name="meals" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">
        <option value="breakfast+lunch+dinner">Breakfast + Lunch + Dinner</option>
        <option value="breakfast+dinner">Breakfast + Dinner</option>
        <option value="none">None</option>
    </select>

    <label for="guide_id" style="display: block; margin-bottom: 8px; font-weight: bold;">Tour Guide:</label>
    <select id="guide_id" name="guide_id" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">
        <?php foreach ($guides as $guide): ?>
            <option value="<?= $guide['guide_id'] ?>"><?= htmlspecialchars($guide['guide_name']) ?></option>
        <?php endforeach; ?>
    </select>

    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Total Cost:</label>
    <p id="total-cost-display" style="font-size: 18px; font-weight: bold; color: #555; margin-bottom: 20px;">$0</p>

    <button type="submit" style="display: block; width: 100%; padding: 10px; background-color:#4ea2fc; color: #fff; font-weight: bold; border: none; border-radius: 5px; cursor: pointer;">Book Now</button>
</form>

<div style="max-width: 600px; margin: 20px auto; text-align: center; font-size: 16px; color: #28a745;">
    <?= $success_message ?>
</div>

<script>
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const accommodationSelect = document.getElementById('accommodation');
    const transportationSelect = document.getElementById('transportation');
    const mealsSelect = document.getElementById('meals');
    const totalCostDisplay = document.getElementById('total-cost-display');

    function calculateTotalCost() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const days = (endDate - startDate) / (1000 * 60 * 60 * 24);
        if (isNaN(days) || days < 1) return 0;

        let cost = days * 50;
        cost += accommodationSelect.value === 'resort' ? 200 : 
                (accommodationSelect.value === 'hotel' ? 150 : 100);
        cost += transportationSelect.value === 'airplane' ? 300 : 
                (transportationSelect.value === 'private car' ? 200 : 100);
        cost += mealsSelect.value === 'breakfast+lunch+dinner' ? 50 : 
                (mealsSelect.value === 'breakfast+dinner' ? 30 : 0);

        return cost;
    }

    function updateTotalCost() {
        const totalCost = calculateTotalCost();
        totalCostDisplay.textContent = `$${totalCost.toFixed(2)}`;
    }

    startDateInput.addEventListener('change', updateTotalCost);
    endDateInput.addEventListener('change', updateTotalCost);
    accommodationSelect.addEventListener('change', updateTotalCost);
    transportationSelect.addEventListener('change', updateTotalCost);
    mealsSelect.addEventListener('change', updateTotalCost);
</script>

<?php include('includes/footer.php'); ?>

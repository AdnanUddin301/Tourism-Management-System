<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'db/db.php';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($query);
    if ($stmt->execute(['username' => $username, 'email' => $email, 'password' => $password])) {
        echo "<div class='success-message'>Account created successfully! <a href='signin.php'>Login here</a></div>";
    } else {
        echo "<div class='error-message'>Error creating account. Please try again.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200 flex items-center justify-center min-h-screen">
    <div class="card w-96 bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold mb-6 text-center">Sign Up</h2>

            <?php if (!empty($success_message)): ?>
                <p class="text-green-500 text-center mb-4"><?= htmlspecialchars($success_message) ?></p>
            <?php elseif (!empty($error_message)): ?>
                <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 opacity-70" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm9-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <input type="text" name="username" placeholder="Enter your username" required class="grow" />
                    </label>
                </div>
                <div class="form-control mt-4">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 opacity-70" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm13.653-.347a1 1 0 0 0-1.256-.94l-5 1.2a1 1 0 0 0-.794 0l-5-1.2A1 1 0 0 0 .347 3.653l6 5a1 1 0 0 0 1.306 0l6-5ZM2 12.6a1 1 0 0 0 .1.45l5.9-4.9L8 8l.9.1 5.9 4.9a1 1 0 0 0 .1-.45v-.6l-5-4.167L2 12v.6Z" />
                        </svg>
                        <input type="email" name="email" placeholder="email@example.com" required class="grow" />
                    </label>
                </div>
                <div class="form-control mt-4">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 opacity-70" viewBox="0 0 16 16">
                            <path d="M7 4V2a4 4 0 0 1 8 0v2a4 4 0 1 1-8 0ZM4 6a2 2 0 1 1 0 4V6Zm6 5c-4 0-7-1.5-7-4V6a2 2 0 1 0-2 0v3c0 1.5 3 4 9 4s9-2.5 9-4V6a2 2 0 1 0-2 0v2c0 2.5-3 4-7 4Z"/>
                        </svg>
                        <input type="password" name="password" placeholder="Enter password" required class="grow" />
                    </label>
                </div>
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary w-full">Sign Up</button>
                </div>
            </form>

            <div class="divider">OR</div>
            <div class="text-center">
                <p>Already have an account?</p>
                <a href="signin.php" class="link link-primary">Sign in here</a>
            </div>
        </div>
    </div>
</body>
</html>

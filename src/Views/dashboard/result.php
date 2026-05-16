<?php

require_once '../../../config/Database.php';
require_once __DIR__ . '/../student/Quiz.php';

session_start();

$correct = $_SESSION['correct'];
$incorrect = $_SESSION['incorrect'];

$total = $correct + $incorrect;

$score = 0;

if($total > 0){
    $score = round(($correct / $total) * 100);
}

// reset
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-indigo-100 via-white to-blue-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-2xl rounded-3xl p-10 w-full max-w-md text-center">

        <h1 class="text-4xl font-extrabold text-indigo-600 mb-6">
            Quiz Finished
        </h1>

        <div class="mb-6">
            <div class="w-40 h-40 mx-auto rounded-full border-[12px] border-indigo-600 flex items-center justify-center">

                <span class="text-4xl font-bold text-indigo-600">
                    <?= $score ?>%
                </span>

            </div>
        </div>

        <div class="space-y-3 text-lg">

            <p class="text-green-600 font-bold">
                Correct Answers: <?= $correct ?>
            </p>

            <p class="text-red-500 font-bold">
                Incorrect Answers: <?= $incorrect ?>
            </p>

        </div>

    </div>

    <script>

        confetti({
            particleCount: 200,
            spread: 120,
            origin: { y: 0.6 }
        });

        setTimeout(() => {

            confetti({
                particleCount: 150,
                angle: 60,
                spread: 100,
                origin: { x: 0 }
            });

            confetti({
                particleCount: 150,
                angle: 120,
                spread: 100,
                origin: { x: 1 }
            });

        }, 700);

    </script>

</body>
</html>
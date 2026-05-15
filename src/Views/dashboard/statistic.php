<?php

require_once '../../../config/Database.php';
require_once __DIR__ . '/../student/Quiz.php';

$db = new Database();
$conn = $db->connect();

$quizObj = new Quiz($conn);

$results = $quizObj->getResults();

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 min-h-screen p-8">

<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-10">

        <div>
            <h1 class="text-4xl font-bold text-gray-800">
                Quiz Dashboard
            </h1>

            <p class="text-gray-500 mt-2">
                Students Results Overview
            </p>
        </div>

        <div class="bg-indigo-600 text-white px-6 py-4 rounded-2xl shadow-lg">

            Total Results:
            <span class="font-bold">
                <?php echo count($results); ?>
            </span>

        </div>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

        <table class="w-full">

            <thead class="bg-indigo-600 text-white">

                <tr>
                    <th class="px-6 py-5 text-left">Student</th>
                    <th class="px-6 py-5 text-left">Quiz ID</th>
                    <th class="px-6 py-5 text-left">Score</th>
                    <th class="px-6 py-5 text-left">Date</th>
                    
                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                <?php foreach($results as $result): ?>

                    <?php

                        $score = $result['score'] ?? 0;
                        $total = $result['total_questions'] ?? 0;

                        // SAFE calculation (no division by zero)
                        $percentage = 0;

                        if($total > 0){
                            $percentage = ($score / $total) * 100;
                        }

                        $passed = $percentage >= 50;

                    ?>

                    <tr class="hover:bg-gray-50 transition">

                        <!-- Student -->
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-700">

                                    <?php echo strtoupper(substr($result['student_name'], 0, 1)); ?>

                                </div>

                                <h3 class="font-semibold text-gray-800">
                                    <?php echo $result['student_name']; ?>
                                </h3>

                            </div>

                        </td>

                        <!-- Quiz ID -->
                        <td class="px-6 py-5 text-gray-600">
                            <?php echo $result['quiz_id']; ?>
                        </td>

                        <!-- Score -->
                        <td class="px-6 py-5">

                            <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-semibold">

                                <?php echo $score; ?>
                                /
                                <?php echo $total; ?>

                            </span>

                        </td>

                        <!-- Date -->
                        <td class="px-6 py-5 text-gray-500">

                            <?php echo date('d M Y', strtotime($result['created_at'])); ?>

                        </td>

                        <!-- Status -->
                       

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>
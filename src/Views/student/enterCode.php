<?php

session_start();

require_once '../../../config/database.php';

$db = new Database();
$conn = $db->connect();

if(isset($_POST["submit"])){

    $code = trim($_POST['code']);

    if(empty($code)){

        $_SESSION['error'] = "Please enter quiz code";

        header('Location: enterCode.php');
        exit();
    }

    // check database
    $sql = "SELECT * FROM quizzes WHERE code = :code LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':code', $code);
    $stmt->execute();

    $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

    if($quiz){

        // store quiz only
        $_SESSION['quiz'] = $quiz;

        header('Location: startQuiz.php');
        exit();

    } else {

        $_SESSION['error'] = "Code incorrect";

        header('Location: enterCode.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Quiz Code</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-gradient-to-br from-indigo-100 via-white to-blue-100 min-h-screen flex items-center justify-center font-sans">

    <div class="bg-white shadow-2xl rounded-3xl p-10 w-[90%] max-w-md border border-gray-100">

        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="bg-indigo-100 p-5 rounded-full">
                <i class="fa-solid fa-brain  text-indigo-600 text-4xl"></i>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-2">
            Join Quiz
        </h1>

        <p class="text-center text-gray-500 mb-8 font-medium">
            Enter your quiz code to start the evaluation
        </p>

        <!-- Form -->
        <form action="./enterCode.php" method="POST" class="space-y-6">

            <!-- Input -->
            <div>
                <label class="block text-gray-700 font-bold mb-2">
                    Quiz Code
                </label>

                   <?php if(isset($_SESSION['error'])): ?>
                    <div 
                        id="error-message"
                        class="mb-6 p-4 rounded-xl bg-red-100 border border-red-300 text-red-700 font-semibold text-center transition-all duration-300">
                        <i class="fa-solid fa-circle-exclamation mr-2"></i>
                        <?= $_SESSION['error'] ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                <div class="relative">

                    <span class="absolute left-4 top-3.5 text-gray-400">
                        <i class="fa-solid fa-key"></i>
                    </span>

                    <input 
                        id="quiz-code"
                        name="code"
                        type="text"
                        placeholder="Enter Quiz Code..."
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 font-semibold text-gray-700 shadow-sm"
                    >

                </div>
            </div>

            <!-- Button -->
            <button 
                name="submit"
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-indigo-300"
            >
                <i class="fa-solid fa-play mr-2"></i>
                Start Quiz
            </button>

        </form>

    </div>
    <script>

    const input = document.getElementById('quiz-code');
    const errorMessage = document.getElementById('error-message');

    if(input && errorMessage){

        input.addEventListener('input', () => {

            errorMessage.style.opacity = '0';
            errorMessage.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 300);

        });

    }

</script>
</body>
</html>
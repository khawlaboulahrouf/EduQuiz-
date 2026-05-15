<?php

session_start();

require_once '../../../config/Database.php';
require_once 'Quiz.php';

$db = new Database();
$conn = $db->connect();

$quizObj = new Quiz($conn);

if(isset($_POST["submit"])){

    $code = trim($_POST['code']);

    if(empty($code)){

        $_SESSION['error'] = "Please enter quiz code";

        header('Location: enterCode.php');
        exit();
    }

    $quiz = $quizObj->getQuizByCode($code);

    if($quiz){

        $_SESSION['quiz'] = $quiz;

        $_SESSION['correct'] = 0;
        $_SESSION['incorrect'] = 0;
        $_SESSION['current_index'] = 0;
        $_SESSION['answered'] = false;
        $_SESSION['selected_answer'] = null;

        header('Location: startQuiz.php');
        exit();

    }else{

        $_SESSION['error'] = "Invalid Quiz Code";

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

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-gradient-to-br from-indigo-100 via-white to-blue-100 min-h-screen flex items-center justify-center">

<div class="bg-white shadow-2xl rounded-3xl p-10 w-[90%] max-w-md">

<div class="flex justify-center mb-6">

<div class="bg-indigo-100 p-5 rounded-full">
<i class="fa-solid fa-brain text-indigo-600 text-4xl"></i>
</div>

</div>

<h1 class="text-3xl font-extrabold text-center text-gray-800 mb-2">
Join Quiz
</h1>

<p class="text-center text-gray-500 mb-8">
Enter your quiz code
</p>

<form action="" method="POST" class="space-y-6">

<?php if(isset($_SESSION['error'])): ?>

<div id="error-message"
class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl text-center">

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
type="text"
name="code"
placeholder="Enter Quiz Code..."
class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-4 focus:ring-indigo-200 focus:outline-none"
>

</div>

<button
name="submit"
type="submit"
class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-bold">

Start Quiz

</button>

</form>

</div>

<script>

const input = document.getElementById('quiz-code');
const error = document.getElementById('error-message');

if(input && error){

    input.addEventListener('input', () => {

        error.style.display = 'none';

    });
}

</script>

</body>
</html>
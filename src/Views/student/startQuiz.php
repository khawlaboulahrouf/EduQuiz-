<?php

session_start();

require_once '../../../config/Database.php';
require_once __DIR__ . '/Quiz.php';

$db = new Database();
$conn = $db->connect();

$quizObj = new Quiz($conn);

if(!isset($_SESSION['quiz'])){
    header("Location: enterCode.php");
    exit();
}

$quiz_id = $_SESSION['quiz']['id'];

$questions = $quizObj->getQuestions($quiz_id);

$index = $_SESSION['current_index'];

$currentQuestion = $questions[$index];

// answer logic
if(
    isset($_POST['answer']) &&
    $_SESSION['answered'] == false
){

    $selectedAnswer = $_POST['answer'];

    $_SESSION['selected_answer'] = $selectedAnswer;

    $_SESSION['answered'] = true;

    $answer = $quizObj->checkAnswer($selectedAnswer);

    if($answer){

        if($answer['is_correct'] == 1){

            $_SESSION['correct']++;

        }else{

            $_SESSION['incorrect']++;
        }
    }
}

// next
if(isset($_POST['next'])){

    $_SESSION['current_index']++;

    $_SESSION['answered'] = false;

    $_SESSION['selected_answer'] = null;

    if($_SESSION['current_index'] >= count($questions)){

        header("Location: result.php");
        exit();
    }

    header("Location: startQuiz.php");
    exit();
}

// back
if(isset($_POST['back'])){

    $_SESSION['current_index']--;

    if($_SESSION['current_index'] < 0){
        $_SESSION['current_index'] = 0;
    }

    $_SESSION['answered'] = false;

    $_SESSION['selected_answer'] = null;

    header("Location: startQuiz.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Quiz Application
            </h1>

            <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                Question <?php echo $index + 1; ?>
            </span>
        </div>

        <!-- Question -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 leading-relaxed">
                <?php echo $currentQuestion['question']; ?>
            </h2>
        </div>

        <!-- Answers -->
        <form method="POST" class="space-y-4">

            <?php foreach($currentQuestion['answers'] as $answer): ?>

                <button
                    type="submit"
                    name="answer"
                    value="<?php echo $answer['id']; ?>"
                    class="w-full text-left bg-gray-50 hover:bg-blue-50 border border-gray-200 hover:border-blue-400 transition duration-300 p-4 rounded-xl shadow-sm"
                >
                    <span class="text-gray-700 font-medium">
                        <?php echo $answer['answer']; ?>
                    </span>
                </button>

            <?php endforeach; ?>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center pt-6">

                <button
                    type="submit"
                    name="back"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-xl transition duration-300"
                >
                    ← Back
                </button>

                <button
                    type="submit"
                    name="next"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl shadow-md transition duration-300"
                >
                    Next →
                </button>

            </div>

        </form>

    </div>

</body>
</html>
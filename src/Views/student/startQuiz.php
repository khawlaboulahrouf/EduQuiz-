<?php

session_start();

require_once '../../../config/database.php';

$db = new Database();
$conn = $db->connect();

/* =========================
   INIT SESSION
========================= */

if(!isset($_SESSION['correct'])){
    $_SESSION['correct'] = 0;
}

if(!isset($_SESSION['incorrect'])){
    $_SESSION['incorrect'] = 0;
}

if(!isset($_SESSION['current_index'])){
    $_SESSION['current_index'] = 0;
}

if(!isset($_SESSION['answered'])){
    $_SESSION['answered'] = false;
}

if(!isset($_SESSION['selected_answer'])){
    $_SESSION['selected_answer'] = null;
}

/* =========================
   CHECK QUIZ SESSION
========================= */

if(!isset($_SESSION['quiz'])){
    header("Location: enterCode.php");
    exit();
}

$quiz_id = $_SESSION['quiz']['id'];

/* =========================
   GET QUESTIONS
========================= */

$sql = "SELECT * FROM questions WHERE quiz_id = :quiz_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':quiz_id', $quiz_id);
$stmt->execute();

$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   GET ANSWERS
========================= */

foreach($questions as &$question){

    $sql = "SELECT * FROM answers WHERE question_id = :question_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':question_id', $question['id']);
    $stmt->execute();

    $question['answers'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* =========================
   CURRENT QUESTION
========================= */

$index = $_SESSION['current_index'];

if($index < 0){
    $index = 0;
}

if($index >= count($questions)){
    $index = count($questions) - 1;
}

$currentQuestion = $questions[$index];

/* =========================
   ANSWER LOGIC
========================= */

if(
    isset($_POST['answer']) &&
    $_SESSION['answered'] == false
){

    $selectedAnswer = $_POST['answer'];

    $_SESSION['selected_answer'] = $selectedAnswer;
    $_SESSION['answered'] = true;

    $sql = "SELECT * FROM answers WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $selectedAnswer);
    $stmt->execute();

    $selected = $stmt->fetch(PDO::FETCH_ASSOC);

    if($selected){

        if($selected['is_correct'] == 1){

            $_SESSION['correct']++;

        }else{

            $_SESSION['incorrect']++;
        }
    }
}

/* =========================
   NEXT BUTTON
========================= */

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

/* =========================
   BACK BUTTON
========================= */

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

    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-indigo-100 via-white to-blue-100 min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-2xl bg-white shadow-2xl rounded-3xl p-8 border border-gray-100">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-8">

        <div>
            <p class="text-sm text-gray-500 font-medium">
                Question Progress
            </p>

            <h2 class="text-2xl font-bold text-indigo-600">
                <?= $index + 1 ?>

                <span class="text-gray-400 text-xl font-semibold">
                    / <?= count($questions) ?>
                </span>
            </h2>
        </div>

        <!-- PROGRESS -->
        <div class="w-44">

            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">

                <div 
                    class="bg-indigo-600 h-3 rounded-full transition-all duration-500"
                    style="width: <?= (($index + 1) / count($questions)) * 100 ?>%"
                ></div>

            </div>

            <p class="text-xs text-gray-500 mt-2 text-right font-semibold">
                <?= round((($index + 1) / count($questions)) * 100) ?>%
            </p>

        </div>

    </div>

    <!-- QUESTION -->
    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 mb-8 text-center leading-relaxed">
        <?= htmlspecialchars($currentQuestion['question']) ?>
    </h1>

    <!-- FORM -->
    <form method="POST" class="space-y-4">

        <?php foreach($currentQuestion['answers'] as $answer): ?>

            <?php

                $bgClass = "border-gray-200 hover:bg-indigo-50 hover:border-indigo-400";

                // correct answer => green
                if(
                    $_SESSION['answered'] &&
                    $answer['is_correct'] == 1
                ){
                    $bgClass = "bg-green-100 border-green-500";
                }

                // selected wrong answer => red
                if(
                    $_SESSION['answered'] &&
                    $_SESSION['selected_answer'] == $answer['id'] &&
                    $answer['is_correct'] == 0
                ){
                    $bgClass = "bg-red-100 border-red-500";
                }

            ?>

            <label class="flex items-center gap-4 p-5 border rounded-2xl cursor-pointer transition-all duration-300 shadow-sm hover:shadow-md <?= $bgClass ?>">

                <input 
                    type="radio" 
                    name="answer" 
                    value="<?= $answer['id'] ?>"
                    class="w-5 h-5 text-indigo-600"
                    onchange="this.form.submit()"
                    <?= $_SESSION['answered'] ? 'disabled' : '' ?>
                >

                <span class="text-gray-700 font-semibold text-lg">
                    <?= htmlspecialchars($answer['answer']) ?>
                </span>

            </label>

        <?php endforeach; ?>

        <!-- BUTTONS -->
        <div class="flex justify-between mt-10">

            <!-- BACK -->
            <button 
                type="submit"
                name="back"
                class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold transition-all duration-300"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </button>

            <?php if($_SESSION['answered']): ?>

                <!-- NEXT -->
                <button 
                    type="submit"
                    name="next"
                    class="flex items-center gap-2 px-7 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold shadow-lg hover:scale-105 transition-all duration-300"
                >
                    Next
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

            <?php endif; ?>

        </div>

    </form>

</div>

</body>
</html>
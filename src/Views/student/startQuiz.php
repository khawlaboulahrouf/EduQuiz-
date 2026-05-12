<?php

session_start();

require_once '../../../config/database.php';

$db = new Database();
$conn = $db->connect();

if(!isset($_SESSION['current_index'])){
    $_SESSION['current_index'] = 0;
}

 if(isset($_POST['next'])){
        $_SESSION['current_index']++;
    }

    if(isset($_POST['back'])){
        $_SESSION['current_index']--;
    }
// check session
if(!isset($_SESSION['quiz'])){
    header("Location: enterCode.php");
    exit();
}

$quiz_id = $_SESSION['quiz']['id'];

// get questions
$sql = "SELECT * FROM questions WHERE quiz_id = :quiz_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':quiz_id', $quiz_id);
$stmt->execute();

$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// add answers
foreach($questions as &$question){

    $sql = "SELECT * FROM answers WHERE question_id = :question_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':question_id', $question['id']);
    $stmt->execute();

    $question['answers'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// check if questions exist
$index = $_SESSION['current_index'];

if($index < 0){
    $index = 0;
}

if($index >= count($questions)){
    $index = count($questions) - 1;
}

$currentQuestion = $questions[$index];

?>

<!-- QUESTION -->
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
 </head>
 <body>
    <div class="min-h-screen bg-gradient-to-br from-indigo-100 via-white to-blue-100 flex items-center justify-center p-6">

    <div class="w-full max-w-2xl bg-white shadow-2xl rounded-3xl p-8 border border-gray-100">

        <!-- Question -->
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 mb-8 text-center">
            <?= htmlspecialchars($currentQuestion['question']) ?>
        </h1>

        <!-- Answers -->
        <form method="POST" class="space-y-4">

            <?php foreach($currentQuestion['answers'] as $answer): ?>

                <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition">

                    <input 
                        type="radio" 
                        name="answer" 
                        value="<?= $answer['id'] ?>"
                        class="w-5 h-5 text-indigo-600"
                    >

                    <span class="text-gray-700 font-medium">
                        <?= htmlspecialchars($answer['answer']) ?>
                    </span>

                </label>

            <?php endforeach; ?>

            <!-- Buttons -->
            <div class="flex justify-between mt-8">

                <!-- Back -->
                <button 
                    type="submit"
                    name="back"
                    class="flex items-center gap-2 px-6 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold transition"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                    Back
                </button>

                <!-- Next -->
                <button 
                    type="submit"
                    name="next"
                    class="flex items-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold shadow-lg transition"
                >
                    Next
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

            </div>

        </form>

    </div>

</div>
 </body>
 </html>

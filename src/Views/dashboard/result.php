<?php
require_once __DIR__ . '/../Repositories/resultRepo.php';

// ============================================================
//  VUE : Résultat de l'étudiant
//  Affiche : score final + correction question par question
//  Axe 4 — Variables disponibles :
//    $result       → objet Result
//    $corrections  → tableau des réponses (depuis ResultRepository)
//    $totalQuestions → int
// ============================================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats - <?= htmlspecialchars($result->getQuizTitle()) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animation d'apparition */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.5s ease forwards; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">

    <!-- ===== HEADER ===== -->
    <header class="bg-blue-700 text-white py-5 shadow-md">
        <div class="max-w-3xl mx-auto px-4">
            <h1 class="text-2xl font-bold">EduQuiz</h1>
            <p class="text-blue-200 text-sm mt-1">Résultats de l'évaluation</p>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 py-8 space-y-6">

        <!-- ===== CARTE SCORE ===== -->
        <div class="fade-up bg-white rounded-2xl shadow-lg p-8 text-center">

            <p class="text-gray-500 text-sm uppercase tracking-widest mb-2">
                <?= htmlspecialchars($result->getQuizTitle()) ?>
            </p>

            <!-- Score affiché en grand -->
            <?php
                $score = $result->getScore();
                // Couleur selon le score
                $scoreColor = match(true) {
                    $score >= 80 => 'text-green-600',
                    $score >= 50 => 'text-yellow-500',
                    default      => 'text-red-500',
                };
                $emoji = match(true) {
                    $score >= 80 => '🎉',
                    $score >= 50 => '👍',
                    default      => '😕',
                };
            ?>
            <div class="text-7xl font-extrabold <?= $scoreColor ?> my-4">
                <?= $score ?><span class="text-3xl">/100</span>
            </div>

            <p class="text-xl font-semibold text-gray-700"><?= $emoji ?>
                <?php
                    if ($score >= 80)      echo "Excellent ! Module validé.";
                    elseif ($score >= 50)  echo "Bien ! Quelques points à revoir.";
                    else                   echo "Module non validé. Revoyez le cours.";
                ?>
            </p>

            <p class="text-gray-400 text-sm mt-2">
                Soumis le <?= htmlspecialchars($result->getCreatedAt()) ?>
            </p>
        </div>

        <!-- ===== CORRECTION QUESTION PAR QUESTION ===== -->
        <div class="fade-up" style="animation-delay: 0.15s">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Correction détaillée</h2>

            <?php if (empty($corrections)): ?>
                <p class="text-gray-500 italic">La correction n'est pas disponible.</p>

            <?php else: ?>
                <?php foreach ($corrections as $index => $item): ?>

                    <?php
                        // true = bonne réponse, false = mauvaise
                        $isCorrect   = (bool)$item['is_correct'];
                        $borderColor = $isCorrect ? 'border-green-400' : 'border-red-400';
                        $bgColor     = $isCorrect ? 'bg-green-50'      : 'bg-red-50';
                        $icon        = $isCorrect ? '✅'               : '❌';
                    ?>

                    <div class="<?= $bgColor ?> border-l-4 <?= $borderColor ?> rounded-xl p-5 mb-4 shadow-sm">

                        <!-- Numéro + Texte de la question -->
                        <p class="font-semibold text-gray-800 mb-3">
                            <span class="text-gray-400 mr-1">Q<?= $index + 1 ?>.</span>
                            <?= htmlspecialchars($item['question_text']) ?>
                        </p>

                        <!-- Réponse choisie par l'étudiant -->
                        <p class="text-sm text-gray-600">
                            <?= $icon ?> <strong>Votre réponse :</strong>
                            <?= htmlspecialchars($item['chosen_answer_text']) ?>
                        </p>

                        <!-- Si mauvaise réponse → afficher la correction -->
                        <?php if (!$isCorrect): ?>
                            <p class="text-sm text-green-700 mt-1">
                                ✔️ <strong>Bonne réponse :</strong>
                                <?= htmlspecialchars($item['correct_answer_text']) ?>
                            </p>
                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- ===== BOUTON RETOUR ===== -->
        <div class="text-center fade-up" style="animation-delay: 0.3s">
            <a href="/index.php?page=dashboard"
               class="inline-block bg-blue-700 hover:bg-blue-800 text-white font-semibold
                      px-8 py-3 rounded-full transition-colors duration-200 shadow">
                ← Retour à l'accueil
            </a>
        </div>

    </main>

</body>
</html>

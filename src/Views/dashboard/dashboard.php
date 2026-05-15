<?php
require_once __DIR__ . '/../Repositories/resultRepo.php';

// ============================================================
//  VUE : Tableau de bord formateur
//  Affiche tous les scores d'un quiz + statistiques globales
//  Axe 4 — Variables disponibles :
//    $results   → tableau d'objets Result
//    $stats     → ['count', 'average', 'best', 'worst']
//    $quizTitle → string
// ============================================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - <?= htmlspecialchars($quizTitle) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans">

    <!-- ===== HEADER ===== -->
    <header class="bg-indigo-800 text-white py-5 shadow-md">
        <div class="max-w-5xl mx-auto px-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold"> Tableau de bord formateur</h1>
                <p class="text-indigo-300 text-sm mt-1">
                    Quiz : <?= htmlspecialchars($quizTitle) ?>
                </p>
            </div>
            <a href="/index.php?page=quizzes"
               class="text-sm bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-lg transition-colors">
                ← Mes quiz
            </a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8 space-y-8">

        <!-- ===== CARTES STATISTIQUES ===== -->
        <section>
            <h2 class="text-lg font-semibold text-gray-700 mb-4">📈 Statistiques globales</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <!-- Nombre de participants -->
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-3xl font-extrabold text-indigo-700">
                        <?= $stats['count'] ?>
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Participants</p>
                </div>

                <!-- Moyenne -->
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-3xl font-extrabold text-blue-600">
                        <?= $stats['average'] ?>
                        <span class="text-lg text-gray-400">/100</span>
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Moyenne</p>
                </div>

                <!-- Meilleur score -->
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-3xl font-extrabold text-green-600">
                        <?= $stats['best'] ?>
                        <span class="text-lg text-gray-400">/100</span>
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Meilleur score</p>
                </div>

                <!-- Moins bon score -->
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-3xl font-extrabold text-red-500">
                        <?= $stats['worst'] ?>
                        <span class="text-lg text-gray-400">/100</span>
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Score le plus bas</p>
                </div>

            </div>
        </section>

        <!-- ===== TABLEAU DES ÉTUDIANTS ===== -->
        <section>
            <h2 class="text-lg font-semibold text-gray-700 mb-4">🎓 Résultats par étudiant</h2>

            <?php if (empty($results)): ?>
                <div class="bg-white rounded-xl shadow p-8 text-center text-gray-500 italic">
                    Aucun étudiant n'a encore passé ce quiz.
                </div>

            <?php else: ?>
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-indigo-50 text-indigo-800 text-left">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Étudiant</th>
                                <th class="px-6 py-3 font-semibold">Score</th>
                                <th class="px-6 py-3 font-semibold">Résultat</th>
                                <th class="px-6 py-3 font-semibold">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">

                            <?php foreach ($results as $result): ?>
                                <?php
                                    $score = $result->getScore();
                                    // Badge couleur selon score
                                    [$badgeBg, $badgeText, $label] = match(true) {
                                        $score >= 80 => ['bg-green-100',  'text-green-700',  'Validé ✅'],
                                        $score >= 50 => ['bg-yellow-100', 'text-yellow-700', 'Passable 👍'],
                                        default      => ['bg-red-100',    'text-red-700',    'Échec ❌'],
                                    };
                                ?>
                                <tr class="hover:bg-gray-50 transition-colors">

                                    <!-- Nom de l'étudiant -->
                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        <?= htmlspecialchars($result->getStudentName()) ?>
                                    </td>

                                    <!-- Score numérique avec barre visuelle -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="font-bold text-gray-700 w-14">
                                                <?= $score ?>/100
                                            </span>
                                            <!-- Barre de progression -->
                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                <div class="h-2 rounded-full
                                                    <?= $score >= 80 ? 'bg-green-500' : ($score >= 50 ? 'bg-yellow-400' : 'bg-red-400') ?>"
                                                    style="width: <?= $score ?>%">
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Badge résultat -->
                                    <td class="px-6 py-4">
                                        <span class="<?= $badgeBg ?> <?= $badgeText ?>
                                                     text-xs font-semibold px-3 py-1 rounded-full">
                                            <?= $label ?>
                                        </span>
                                    </td>

                                    <!-- Date de passage -->
                                    <td class="px-6 py-4 text-gray-400 text-xs">
                                        <?= htmlspecialchars($result->getCreatedAt()) ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

    </main>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8fafc] min-h-screen font-sans antialiased">

<div class="max-w-7xl mx-auto px-4 py-10 sm:px-6 lg:px-8">


    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-slate-200 mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Teacher Dashboard
            </h1>
            <p class="text-slate-500 mt-1 text-sm">
                Manage your quizzes, questions, and student access.
            </p>
        </div>


        <a href="index.php?action=createQuiz" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm px-5 py-3 rounded-xl shadow-sm transition-all duration-200 hover:shadow">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Quiz
        </a>
    </div>


    <?php if (!empty($quizzes)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <?php foreach ($quizzes as $q): ?>
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between overflow-hidden group">
                    
                 
                    <div class="p-6">
                    
                        <div class="flex justify-between items-start gap-4 mb-3">
                            <h3 class="font-bold text-slate-800 text-lg group-hover:text-indigo-600 transition-colors">
                                <?= htmlspecialchars($q['title']) ?>
                            </h3>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-700 tracking-wider uppercase border border-slate-200">
                                <?= htmlspecialchars($q['code']) ?>
                            </span>
                        </div>

                 
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-3">
                            <?= htmlspecialchars($q['description'] ?? 'No description provided for this quiz.') ?>
                        </p>
                    </div>

                
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end items-center">
                        <a href="index.php?action=listQuestions&quiz_id=<?= $q['id'] ?>" class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                            View Details
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>
    <?php else: ?>
     
        <div class="text-center py-16 bg-white rounded-2xl border border-slate-200/80 shadow-sm max-w-md mx-auto">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-900">No quizzes yet</h3>
            <p class="text-slate-500 text-sm mt-1 px-6">Get started by creating your very first quiz for your students.</p>
            <a href="index.php?action=createQuiz" class="inline-flex items-center gap-2 mt-5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm px-4 py-2.5 rounded-xl shadow-sm transition-colors">
                Create First Quiz
            </a>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
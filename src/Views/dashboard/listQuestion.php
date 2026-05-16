<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8fafc] min-h-screen font-sans antialiased">

<div class="max-w-4xl mx-auto px-4 py-10 sm:px-6 lg:px-8">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-slate-200 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Questions List
            </h1>
            <p class="text-slate-500 mt-1 text-sm">
                Review, edit, and manage the questions for this quiz.
            </p>
        </div>

        <a href="index.php?action=addQuestion&quiz_id=<?= $quizId ?? $_GET['quiz_id'] ?? '' ?>" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm px-5 py-3 rounded-xl shadow-sm transition-all duration-200 hover:shadow">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Question
        </a>
    </div>

  
    <?php if (!empty($questions)): ?>
        <div class="space-y-6">
            
            <?php $index = 1; foreach ($questions as $q): ?>
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 relative group transition-all duration-200 hover:border-slate-300">
                    
                
                    <div class="flex justify-between items-start gap-6 mb-4">
                        <div class="flex gap-3">
                            <span class="font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 rounded-lg w-7 h-7 flex items-center justify-center text-sm shrink-0 mt-0.5">
                                <?= $index++ ?>
                            </span>
                            <h3 class="font-bold text-slate-800 text-lg leading-snug">
                                <?= htmlspecialchars($q['question']) ?>
                            </h3>
                        </div>

                  
                        <div class="flex items-center gap-1 shrink-0 opacity-80 group-hover:opacity-100 transition-opacity">
                            <!-- Edit -->
                            <a href="index.php?action=editQuestion&id=<?= $q['id'] ?>" class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors" title="Edit Question">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                       
                            <a href="index.php?action=deleteQuestion&id=<?= $q['id'] ?>&quiz_id=<?= $quizId ?? $_GET['quiz_id'] ?? '' ?>" onclick="return confirm('Are you sure?')" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Delete Question">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </a>
                        </div>
                    </div>

              
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 pl-10 mt-2">
                        <?php foreach ($q['answers'] as $a): ?>
                            <li class="flex items-start gap-2.5 p-3 rounded-xl border text-sm transition-colors <?= $a['is_correct'] ? 'bg-emerald-50/60 border-emerald-200/80 text-emerald-900 font-medium' : 'bg-slate-50/50 border-slate-100 text-slate-600' ?>">
                                <?php if ($a['is_correct']): ?>
                           
                                    <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                <?php else: ?>
                             
                                    <div class="w-1.5 h-1.5 bg-slate-400 rounded-full shrink-0 mt-2 mx-1.2"></div>
                                <?php endif; ?>
                                
                                <span><?= htmlspecialchars($a['answer']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                </div>
            <?php endforeach; ?>

        </div>
    <?php else: ?>

        <div class="text-center py-16 bg-white rounded-2xl border border-slate-200/80 shadow-sm max-w-md mx-auto">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-900">No questions found</h3>
            <p class="text-slate-500 text-sm mt-1 px-6">This quiz is currently empty. Start by creating the first question.</p>
            <a href="index.php?action=addQuestion&quiz_id=<?= $quizId ?? $_GET['quiz_id'] ?? '' ?>" class="inline-flex items-center gap-2 mt-5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm px-4 py-2.5 rounded-xl shadow-sm transition-colors">
                Add First Question
            </a>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
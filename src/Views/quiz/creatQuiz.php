<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8fafc] min-h-screen font-sans antialiased flex items-center justify-center p-4 sm:p-6">

<div class="w-full max-w-xl bg-white rounded-2xl border border-slate-200/80 shadow-xl p-6 sm:p-8">
    
   
    <div class="mb-8 text-center sm:text-left">
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
            Create New Quiz
        </h1>
        <p class="text-slate-500 mt-1 text-sm">
            Setup a new quiz by providing a title and a clear description for your students.
        </p>
    </div>


    <form method="POST" class="space-y-6">

        <div class="space-y-1.5">
            <label class="text-sm font-semibold text-slate-700">Quiz Title</label>
            <div class="relative">
                <input type="text" name="title" placeholder="e.g., Final Physics Exam - Term 1" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 placeholder-slate-400 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all outline-none text-sm">
            </div>
        </div>

        <div class="space-y-1.5">
            <label class="text-sm font-semibold text-slate-700">Description</label>
            <div class="relative">
                <textarea name="description" rows="4" placeholder="Briefly describe the topic, rules, or chapters covered in this quiz..." required
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 placeholder-slate-400 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all outline-none text-sm resize-none"></textarea>
            </div>
        </div>


        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 mt-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Create Quiz
        </button>

    </form>
</div>

</body>
</html>
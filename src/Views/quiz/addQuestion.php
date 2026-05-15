<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8fafc] min-h-screen font-sans antialiased flex items-center justify-center p-4 sm:p-6">

<div class="w-full max-w-xl bg-white rounded-2xl border border-slate-200/80 shadow-xl p-6 sm:p-8">
    

    <div class="mb-8 text-center sm:text-left">
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
            Add New Question
        </h1>
        <p class="text-slate-500 mt-1 text-sm">
            Fill in the question text, provide 4 options, and specify the correct answer.
        </p>
    </div>

    <form method="POST" class="space-y-6">
   
        <div class="space-y-1.5">
            <label class="text-sm font-semibold text-slate-700">Question Text</label>
            <input type="text" name="question" placeholder="e.g., What is the capital of Morocco?" required
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 placeholder-slate-400 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all outline-none text-sm">
        </div>

        <div class="space-y-3.5">
            <label class="text-sm font-semibold text-slate-700 block mb-1">Answer Options</label>
 
            <div class="relative">
                <span class="absolute left-4 top-3.5 text-xs font-bold text-slate-400 uppercase tracking-wider">A1</span>
                <input type="text" name="a1" placeholder="First option..." required
                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all outline-none text-sm">
            </div>

            <div class="relative">
                <span class="absolute left-4 top-3.5 text-xs font-bold text-slate-400 uppercase tracking-wider">A2</span>
                <input type="text" name="a2" placeholder="Second option..." required
                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all outline-none text-sm">
            </div>

            <div class="relative">
                <span class="absolute left-4 top-3.5 text-xs font-bold text-slate-400 uppercase tracking-wider">A3</span>
                <input type="text" name="a3" placeholder="Third option..." required
                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all outline-none text-sm">
            </div>

           
        </div>

        <div class="space-y-1.5">
            <label class="text-sm font-semibold text-slate-700">Correct Answer Index</label>
            <div class="relative">
                <select name="correct" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all outline-none appearance-none cursor-pointer">
                    <option value="" disabled selected>Select the correct option</option>
                    <option value="0">Answer 1 (A1)</option>
                    <option value="1">Answer 2 (A2)</option>
                    <option value="2">Answer 3 (A3)</option>
                </select>

                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>


        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 mt-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            Save Question
        </button>

    </form>
</div>

</body>
</html>
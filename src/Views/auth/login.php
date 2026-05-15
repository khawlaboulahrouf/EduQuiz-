<?php
require_once __DIR__ . '/../../../config/Database.php';
require_once __DIR__ . '/../../Repositories/userRepo.php';
require_once __DIR__ . '/../../Entities/User.php';
require_once __DIR__ . '/../../Services/authentification.php';
$repo = new UserRepository(Database::getConnection());   
$auth = new Auth($repo);

if($_SERVER['REQUEST_METHOD']==='POST'){
    if($auth->login($_POST['email'],$_POST['password'])){
        if($_SESSION['user']['role'] === 'prof'){
            header("Location: prof_dashboard.php");  
        }else{
            header("Location: /EduQuiz-/student/enterCode.php");
        exit;
        }  
        exit;
    }
    header('Location: register.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600">

  <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
      Login
    </h2>

    <form method="POST" class="space-y-4">

      <input 
        name="email"
        type="email"
        placeholder="Email"
        required
        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
      >

      <input 
        name="password"
        type="password"
        placeholder="Password"
        required
        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
      >

      <button 
        type="submit"
        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition transform hover:scale-[1.02]"
      >
        Login
      </button>

    </form>

  </div>

</body>
</html>
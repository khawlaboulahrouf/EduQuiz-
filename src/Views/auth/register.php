<?php

require_once __DIR__ . '/../../../config/Database.php';
require_once __DIR__ . '/../../Repositories/userRepo.php';
require_once __DIR__ . '/../../Entities/user.php';
$repo = new UserRepository(Database::getConnection());

if($_SERVER['REQUEST_METHOD']==='POST'){
    $user = new User(
        null,
        $_POST['name'],  
        $_POST['email'],
        $_POST['password'],
        $_POST['role']    
    );
    $repo->create($user);
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600">

  <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
      Register
    </h2>

    <form method="POST" class="space-y-4">

      <input 
        name="name"
        placeholder="Name"
        required
        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400"
      >

      <input 
        name="email"
        placeholder="Email"
        required
        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400"
      >

      <input 
        name="password"
        type="password"
        placeholder="Password"
        required
        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400"
      >

      <select 
        name="role"
        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400"
      >
        <option value="formateur">Formateur</option>
        <option value="etudiant">Étudiant</option>
      </select>

      <button 
        type="submit"
        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition"
      >
        S'inscrire
      </button>

    </form>
  </div>

</body>
</html>
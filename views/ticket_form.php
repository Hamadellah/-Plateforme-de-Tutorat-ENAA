<?php
session_start();

require_once __DIR__ . '/../src/Repositories/HelpRequestRepository.php';
require_once __DIR__ . '/../src/Services/formservices.php';

use App\Repositories\HelpRequestRepository;
use App\Services\TicketService;

$db = new PDO("mysql:host=localhost;dbname=ENAA;charset=utf8", "root", "123456");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$helpRepo = new HelpRequestRepository($db);
$ticketService = new TicketService($helpRepo);


$ticketService->checkAuth();

$error = $ticketService->handleSubmission($_POST);

$skills = $db->query("SELECT * FROM skills")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poser une question - ENAA</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-lg bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-xl">
        
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white tracking-tight">Poser une question</h2>
            <p class="text-slate-400 text-sm mt-1">Expliquez votre problème pour qu'un tuteur puisse vous venir en aide.</p>
            
            <!-- L'affichage des erreurs reste ici car c'est du visuel -->
            <?php if ($error): ?>
                <div class="mt-4 p-3 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-sm">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
        </div>

        <form action="" method="POST" class="space-y-5">
            
            <!-- Titre de la demande -->
            <div>
                <label for="title" class="block text-sm font-medium text-slate-300 mb-1.5">Titre de la question</label>
                <input type="text" id="title" name="title" required placeholder="Ex: Problème avec les jointures SQL"
                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 placeholder-slate-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition">
            </div>

            <!-- Choix de la compétence -->
            <div>
                <label for="skill_id" class="block text-sm font-medium text-slate-300 mb-1.5">Catégorie / Technologie</label>
                <select id="skill_id" name="skill_id" required
                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition">
                    <option value="" disabled selected hidden>Sélectionnez une compétence</option>
                    <?php foreach ($skills as $skill): ?>
                        <option value="<?= $skill['id'] ?>"><?= htmlspecialchars($skill['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Description du problème -->
            <div>
                <label for="description" class="block text-sm font-medium text-slate-300 mb-1.5">Description détaillée</label>
                <textarea id="description" name="description" rows="4" required placeholder="Décrivez précisément ce que vous ne comprenez pas ou l'erreur affichée..."
                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 placeholder-slate-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition resize-none"></textarea>
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="dashboard.php" class="px-5 py-2.5 rounded-xl border border-slate-800 text-slate-400 hover:bg-slate-800 hover:text-white text-sm font-medium transition">
                    Annuler
                </a>
                <button type="submit" name="submit_question" class="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium shadow-lg shadow-purple-600/20 transition">
                    Soumettre la question
                </button>
            </div>

        </form>
    </div>

</body>
</html>
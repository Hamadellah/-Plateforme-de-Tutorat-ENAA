<?php
require_once __DIR__ . '/../src/Services/connection.php';
require_once __DIR__ . '/../src/Repositories/HelpRequestRepository.php';
use App\Repositories\HelpRequestRepository;
use Services\Connection;
session_start();
$db = Connection::getConnection();
$helpRequestRepo = new HelpRequestRepository($db);    

$requests = $helpRequestRepo->getAllActiveRequests();
// var_dump($requests); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeerSync - Dashboard Tuteur/Étudiant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(147, 51, 234, 0.3); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(147, 51, 234, 0.5); }
    </style>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen flex font-sans">

    <!-- Sidebar -->
    <aside class="w-64 border-r border-white/10 bg-[#0f1422] flex flex-col justify-between hidden md:flex">
        <div class="p-6">
            <div class="text-2xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400 mb-8">
                PeerSync <span class="text-xs bg-purple-500/20 text-purple-400 px-2 py-0.5 rounded ml-1 border border-purple-500/30">Espace Tuteur</span>
            </div>

            <nav class="space-y-2">
                <a href="#" class="flex items-center space-x-3 bg-purple-600/10 text-purple-400 border-l-4 border-purple-500 px-4 py-3 rounded-r-xl transition-all font-medium">
                    <i class="fa-solid fa-house text-sm"></i>
                    <span>Fil d'actualité</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-white hover:bg-white/5 px-4 py-3 rounded-xl transition-all">
                    <i class="fa-solid fa-circle-question text-sm"></i>
                    <span>Mes Questions</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-white hover:bg-white/5 px-4 py-3 rounded-xl transition-all">
                    <i class="fa-solid fa-reply-all text-sm"></i>
                    <span>Mes Interventions</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-white hover:bg-white/5 px-4 py-3 rounded-xl transition-all">
                    <i class="fa-solid fa-graduation-cap text-sm"></i>
                    <span>Espace Étudiant</span>
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-white/10 bg-white/5 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-purple-500 to-indigo-500 flex items-center justify-center text-white font-bold border border-white/20">
                    <?= isset($_SESSION['user']['prenom']) ? strtoupper(substr($_SESSION['user']['prenom'], 0, 1)) : 'U' ?>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white">
                        <?= isset($_SESSION['user']['prenom']) ? htmlspecialchars($_SESSION['user']['prenom'] . ' ' . substr($_SESSION['user']['nom'], 0, 1) . '.') : 'Salma ...' ?>
                    </h4>
                    <p class="text-xs text-purple-400"><?= htmlspecialchars($_SESSION['user']['label_role'] ?? 'Tuteur') ?></p>
                </div>
            </div>
            <a href="logout.php" class="text-gray-400 hover:text-red-400 p-2 rounded-lg transition-colors">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <header class="h-16 border-b border-white/10 bg-[#0f1422]/50 backdrop-blur-md flex items-center justify-between px-6 sticky top-0 z-40">
            <div class="w-full max-w-xl relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input 
                    type="text" 
                    placeholder="Rechercher une question (ex: PHP OOP, Laravel)..." 
                    class="w-full pl-11 pr-4 py-2 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all text-sm"
                 Bled">
            </div>
            
            <a href="ticket_form.php" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-xl shadow-lg shadow-purple-600/20 transition-all transform active:scale-95 ml-4 flex items-center">
                Posez une question
            </a>
        </header>

        <div class="flex-1 flex overflow-hidden">
            
            <main class="flex-1 p-6 overflow-y-auto custom-scrollbar space-y-6">
                
                <div class="flex items-center justify-between border-b border-white/5 pb-4">
                    <h2 class="text-xl font-bold text-white">Toutes les questions</h2>
                    <div class="flex bg-white/5 p-1 rounded-lg border border-white/10 text-xs">
                        <button class="px-3 py-1.5 rounded-md bg-purple-600 text-white font-medium">Récentes</button>
                    </div>
                </div>

                <!-- ÉTAPE 2 : Boucle Foreach sur les requêtes d'aide -->
                <?php if (empty($requests)): ?>
                    <div class="text-center py-12 text-gray-500 border border-dashed border-white/10 rounded-2xl">
                        <i class="fa-solid fa-comments text-3xl mb-3 block text-gray-600"></i>
                        Aucune demande d'aide disponible pour le moment.
                    </div>
                <?php else: ?>
                    <?php foreach ($requests as $request): ?>
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-5 hover:border-purple-500/40 transition-all flex items-start space-x-4">
                            
                            <!-- Section Statut / Gauche -->
                            <div class="flex flex-col items-center space-y-3 text-center min-w-[85px]">
                                <?php if ($request['status'] === 'PENDING'): ?>
                                    <div class="border border-amber-500/30 bg-amber-500/10 text-amber-400 rounded-lg p-2 w-full text-xs font-semibold uppercase tracking-wider">
                                        En attente
                                    </div>
                                <?php elseif ($request['status'] === 'ASSIGNED'): ?>
                                    <div class="border border-indigo-500/30 bg-indigo-500/10 text-indigo-400 rounded-lg p-2 w-full text-xs font-semibold uppercase tracking-wider">
                                        Assigné
                                    </div>
                                <?php else: ?>
                                    <div class="border border-green-500/30 bg-green-500/10 text-green-400 rounded-lg p-2 w-full text-xs font-semibold uppercase tracking-wider">
                                        Résolu
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Section Infos / Droite -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-white hover:text-purple-400 transition-colors mb-2">
<a href="ticket_details.php?id=<?= $request['id'] ?>" class="text-purple-400 hover:text-purple-300 font-medium">
    <?= htmlspecialchars($request['title']) ?>
</a>                                </h3>
                                <p class="text-gray-400 text-sm line-clamp-2 mb-4">
                                    <?= htmlspecialchars($request['description']) ?>
                                </p>
                                
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <!-- Techno concernée -->
                                    <div class="flex space-x-2">
                                        <span class="bg-purple-500/10 border border-purple-500/20 text-purple-400 text-xs px-2.5 py-1 rounded-md font-mono">
                                            #<?= htmlspecialchars(strtolower($request['technology'] ?? 'code')) ?>
                                        </span>
                                    </div>
                                    <!-- Auteur et Date -->
                                    <div class="flex items-center space-x-2 text-xs text-gray-400">
                                        <span class="w-5 h-5 rounded-full bg-indigo-500 flex items-center justify-center text-[10px] text-white font-bold">
                                            <?= strtoupper(substr($request['student_prenom'], 0, 1)) ?>
                                        </span>
                                        <span class="text-gray-300 font-medium">
                                            <?= htmlspecialchars($request['student_prenom'] . ' ' . substr($request['student_nom'], 0, 1) . '.') ?>
                                        </span>
                                        <span>• Reçu le <?= date('d/m à H:i', strtotime($request['created_at'])) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </main>

            <!-- Sidebar Droite (Populaires) -->
            <aside class="w-80 border-l border-white/10 p-6 space-y-6 hidden lg:block bg-[#0f1422]/30">
                <div class="bg-gradient-to-br from-purple-900/30 to-indigo-900/30 border border-purple-500/20 rounded-2xl p-4">
                    <h4 class="font-bold text-white mb-3 text-sm uppercase tracking-wider text-purple-400">Mon Activité Tuteur</h4>
                    <div class="grid grid-cols-2 gap-3 text-center">
                        <div class="bg-white/5 p-3 rounded-xl border border-white/5">
                            <span class="block text-2xl font-extrabold text-white">0</span>
                            <span class="text-xs text-gray-400">Aides données</span>
                        </div>
                        <div class="bg-white/5 p-3 rounded-xl border border-white/5">
                            <span class="block text-2xl font-extrabold text-purple-400">100%</span>
                            <span class="text-xs text-gray-400">Score Fiabilité</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-3 text-sm">Tags populaires</h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs text-gray-400 bg-white/5 p-2 rounded-lg">
                            <span class="text-purple-400 font-mono">#php</span>
                            <span>Actif</span>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>

</body>
</html>
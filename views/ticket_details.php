<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../src/Repositories/HelpRequestRepository.php';
use App\Repositories\HelpRequestRepository;

$db = new PDO("mysql:host=localhost;dbname=ENAA;charset=utf8", "root", "123456");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$helpRepo = new HelpRequestRepository($db);

// 1. Kan-jibou l-ID men l-URL
$requestId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$requestId) {
    header("Location: dashboard.php");
    exit();
}

$request = $helpRepo->getRequestById($requestId);
if (!$request) {
    die("Had l-ticket ma kaynch.");
}

// 2. Mlli l-tuteur kay-cliqui 3la l-bouton "Aider"
if (isset($_POST['accept_help'])) {
    $currentUserId = $_SESSION['user_id'];
    
   
    if ($currentUserId == $request['student_id']) {
        $error = "Ma ymknch t-3awn rassk a sa7bi !";
    } if ($request['tutor_id']) {
        // Hna kan-génériw lien unique dynamic 3la hssab l-ticket
        $generatedLink = "https://meet.jit.si/ENAA-Tutorat-" . $requestId . "-" . uniqid();

        if ($helpRepo->acceptRequest($requestId, $currentUserId, $generatedLink)) {
            // Actualiser l-page bach n-choufou l-lien jdid
            header("Location: ticket_details.php?id=" . $requestId . "&success=1");
            exit();
        } else {
            $error = "Had l-ticket khdaw tuteur akhor sba9 mnnk.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la demande - ENAA</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-2xl bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-xl space-y-6">
        
        <!-- En-tête -->
        <div class="flex items-center justify-between border-b border-slate-800 pb-4">
            <div>
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-purple-500/10 text-purple-400 border border-purple-500/20">
                    <?= htmlspecialchars($request['technology_name']) ?>
                </span>
                <h1 class="text-2xl font-bold text-white mt-2"><?= htmlspecialchars($request['title']) ?></h1>
                <p class="text-sm text-slate-400 mt-1">
                    Posée par : <span class="text-slate-200"><?= htmlspecialchars($request['student_prenom'] . ' ' . $request['student_nom']) ?></span>
                </p>
            </div>
            
            <!-- Statut -->
            <div>
                <?php 
                $statusColors = [
                    'En attente' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                    'En cours' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                    'Résolu' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'
                ];
                $colorClass = $statusColors[$request['status']] ?? 'bg-slate-500/10 text-slate-400';
                ?>
                <span class="px-3 py-1.5 text-sm font-medium rounded-xl border <?= $colorClass ?>">
                    <?= htmlspecialchars($request['status']) ?>
                </span>
            </div>
        </div>

        <!-- Alerte Ila 3ndna error aw success -->
        <?php if (isset($error)): ?>
            <div class="p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-sm">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Description -->
        <div class="space-y-2">
            <h3 class="text-sm font-medium text-slate-400 uppercase tracking-wider">Description du problème</h3>
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 text-slate-300 whitespace-pre-line leading-relaxed">
                <?= htmlspecialchars($request['description']) ?>
            </div>
        </div>

        <!-- Blassa dyal l-Tuteur w l-Lien -->
        <div class="border-t border-slate-800 pt-6">
            <?php if ($request['tutor_id']): ?>
                <!-- Ila l-ticket deja m-accepti -->
                <div class="p-4 bg-slate-950 border border-slate-800 rounded-xl space-y-3">
                    <p class="text-sm text-slate-400">
                        Tuteur m-claf : <span class="text-white font-medium"><?= htmlspecialchars($request['tutor_prenom'] . ' ' . $request['tutor_nom']) ?></span>
                    </p>
                    <?php if ($request['run_link']): ?>
                        <div class="pt-2">
                            <a href="<?= htmlspecialchars($request['run_link']) ?>" target="_blank" 
                               class="inline-flex items-center px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition shadow-lg">
                                🌐 Dkhl l-espace dyal l-m3awna (Lien de Run)
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Ila l-ticket ba9i khawi, n-biyyn l-bouton "Aider" -->
                <form action="" method="POST" class="flex justify-between items-center">
                    <p class="text-sm text-slate-400">Had l-question ba9a kat-tsnna tuteur.</p>
                    <button type="submit" name="accept_help" 
                            class="px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium shadow-lg transition">
                        🤝 Aider cet étudiant
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <div class="flex justify-start pt-2">
            <a href="dashboard.php" class="text-sm text-slate-400 hover:text-white transition">
                ← Rj3 l-Dashboard
            </a>
        </div>
    </div>

</body>
</html>
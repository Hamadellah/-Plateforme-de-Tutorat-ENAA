
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeerSync - Plateforme de Tutorat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes graadientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animated-bg {
            background: linear-gradient(-45deg, #0f172a, #111827, #1e1b4b, #030712);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
    </style>
</head>
<body class="animated-bg min-h-screen text-white font-sans overflow-x-hidden">

    <!-- Navbar -->
    <nav class="w-full border-b border-white/10 bg-black/20 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="text-2xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400">
                PeerSync
            </div>
            <div class="flex items-center space-x-4">
                <a href="../views/login.php" class="px-5 py-2 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-300 text-sm font-medium">
                    Connexion
                </a>
                <a href="#" class="px-5 py-2 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 shadow-lg shadow-purple-600/20 transition-all duration-300 text-sm font-semibold">
                    S'inscrire
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="max-w-7xl mx-auto px-6 pt-24 pb-16 flex flex-col items-center text-center relative">
        <!-- Background Glowing Orbs -->
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-purple-600/10 rounded-full blur-[120px] -z-10"></div>

        <!-- Tagline -->
        <span class="px-4 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/30 text-purple-400 text-xs font-semibold tracking-wide uppercase mb-6 animate-bounce">
            Propulsé par les étudiants, pour les étudiants
        </span>

        <!-- Main Title -->
        <h1 class="text-5xl md:text-7xl font-black tracking-tight max-w-4xl leading-tight mb-8">
            Dominez le Code Ensemble Grâce au <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-400 to-indigo-400">Tutorat Peer-to-Peer</span>
        </h1>

        <!-- Subtitle -->
        <p class="text-lg md:text-xl text-gray-400 max-w-2xl font-normal mb-12 leading-relaxed">
            Trouvez de l'aide en temps réel ou partagez vos compétences avec vos pairs à l'ENAA. Ensemble, aucun bug ne résiste.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full max-w-md">
            <a href="index.php?action=login" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold shadow-xl shadow-purple-600/20 transition-all duration-300 transform hover:-translate-y-0.5 text-center">
                Lancer une demande d'aide
            </a>
            <a href="#" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-white font-medium transition-all duration-300 text-center">
                Devenir Tuteur
            </a>
        </div>

        <!-- Features Grid Stats preview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-4xl mt-32">
            <div class="p-6 rounded-2xl bg-white/5 border border-white/5 backdrop-blur-sm text-left hover:border-white/10 transition-all duration-300">
                <div class="text-purple-400 font-bold text-2xl mb-2">⚡ Entraide Rapide</div>
                <p class="text-sm text-gray-400">Créez un ticket pour votre bug, un tuteur disponible prendra le relais en quelques minutes.</p>
            </div>
            <div class="p-6 rounded-2xl bg-white/5 border border-white/5 backdrop-blur-sm text-left hover:border-white/10 transition-all duration-300">
                <div class="text-pink-400 font-bold text-2xl mb-2">🔄 Rôles Dynamiques</div>
                <p class="text-sm text-gray-400">Soyez apprenant sur un module difficile, et devenez tuteur sur les technos que vous maîtrisez.</p>
            </div>
            <div class="p-6 rounded-2xl bg-white/5 border border-white/5 backdrop-blur-sm text-left hover:border-white/10 transition-all duration-300">
                <div class="text-indigo-400 font-bold text-2xl mb-2">⭐ Revues & Partage</div>
                <p class="text-sm text-gray-400">Laissez des avis après chaque session pour valoriser l'engagement des tuteurs de l'école.</p>
            </div>
        </div>
    </main>

</body>
</html>
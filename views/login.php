
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeerSync - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animated-bg {
            background: linear-gradient(-45deg, #0f172a, #1e1b4b, #2e1065, #030712);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
    </style>
</head>
<body class="animated-bg min-h-screen flex items-center justify-center p-4 overflow-hidden font-sans">

    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl -z-10 animate-pulse"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl -z-10 animate-pulse" style="animation-delay: 2s;"></div>

    <div class="w-full max-w-md bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 shadow-2xl transition-all duration-500 hover:border-purple-500/30 hover:shadow-purple-500/10 flex flex-col transform opacity-0 translate-y-4 animate-[fadeIn_0.6s_ease-out_forwards]">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400">
                PeerSync
            </h1>
            <p class="text-sm text-gray-400 mt-2">Connectez-vous pour rejoindre vos pairs</p>
        </div>



        <form action="../public/process_login.php" method="POST" class="space-y-5">
            <input type="hidden" name="action" value="login">
            
            <div class="relative group">
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2 transition-colors group-focus-within:text-purple-400">
                    Adresse Email
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required
                    placeholder="nom@student.enaa.ma"
                    class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 outline-none transition-all duration-300 focus:border-purple-500 focus:bg-white/10 focus:ring-2 focus:ring-purple-500/20"
                >
            </div>

            <div class="relative group">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2 transition-colors group-focus-within:text-purple-400">
                    Mot de passe
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 outline-none transition-all duration-300 focus:border-purple-500 focus:bg-white/10 focus:ring-2 focus:ring-purple-500/20"
                >
            </div>

            <button 
                type="submit" 
                class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-semibold shadow-lg shadow-purple-600/20 transition-all duration-300 transform active:scale-[0.98] hover:shadow-purple-600/40"
            >
                Se connecter
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-gray-500">
            <span>Nouveau sur la plateforme ? </span>
            <a href="#" class="text-purple-400 hover:text-purple-300 font-medium transition-colors duration-200 underline underline-offset-4">
                Créer un compte
            </a>
        </div>
    </div>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(16px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>
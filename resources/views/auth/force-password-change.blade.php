<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="rgb(253, 240, 187) ">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changement de mot de passe obligatoire</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="shortcut icon" href="/wim.png" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
  
        body {
            background: linear-gradient(135deg,rgb(247, 237, 195) 0%, #fbc926 100%);
        }
        .btn-primary {
            background-color: #fbc926;
            color: #000000;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 222, 89, 0.3);
        }
        .input-field {
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }
        .input-field:focus {
            border-color: #fbc926;
            box-shadow: 0 0 0 3px rgba(255, 222, 89, 0.2);
        }
        .logo {
            height: 80px;
            width: auto;
        }
        .alert-warning {
            background-color: #fef3cd;
            border-color: #fde68a;
            color: #92400e;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-gray-50">
  @include('layouts.message')

  <div class="w-full max-w-md bg-white rounded-xl overflow-hidden shadow-lg" data-aos="fade-up">
    <div class="p-8">
      <!-- Alerte de sécurité -->
      <div class="alert-warning border rounded-md p-4 mb-6">
        <div class="flex">
          <div class="flex-shrink-0">
            <i data-feather="shield" class="h-5 w-5 text-yellow-600"></i>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-yellow-800">
              Sécurité requise
            </h3>
            <div class="mt-2 text-sm text-yellow-700">
              <p>Pour des raisons de sécurité, vous devez changer votre mot de passe par défaut avant de continuer.</p>
            </div>
          </div>
        </div>
      </div>

      <form class="space-y-6" method="POST" action="{{ route('password.update') }}">
        @csrf
        <div>
          <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label>
          <div class="mt-1 relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i data-feather="lock" class="h-5 w-5 text-gray-400"></i>
            </div>
            <input type="password" 
                   id="current_password" 
                   name="current_password" 
                   class="focus:ring-yellow-500 focus:border-yellow-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-3 @error('current_password') border-red-500 @enderror" 
                   placeholder="Mot de passe actuel"
                   required>
          </div>
          @error('current_password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
          <div class="mt-1 relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i data-feather="key" class="h-5 w-5 text-gray-400"></i>
            </div>
            <input type="password" 
                   id="password" 
                   name="password" 
                   class="focus:ring-yellow-500 focus:border-yellow-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-3 @error('password') border-red-500 @enderror" 
                   placeholder="Nouveau mot de passe (min. 8 caractères)"
                   required>
          </div>
          @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le nouveau mot de passe</label>
          <div class="mt-1 relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i data-feather="check-circle" class="h-5 w-5 text-gray-400"></i>
            </div>
            <input type="password" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   class="focus:ring-yellow-500 focus:border-yellow-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-3 @error('password_confirmation') border-red-500 @enderror" 
                   placeholder="Confirmer le nouveau mot de passe"
                   required>
          </div>
          @error('password_confirmation')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="relative">
                    <input class="form-check-input" type="checkbox" name="accept_politique" value="1" required>
                    <label class="form-check-label text-xs">
                        J’ai lu et j’accepte la <a href="{{ route('politique.confidentialite') }}" class="text-yellow-600 hover:text-yellow-700 font-semibold transition-colors" target="_blank">politique de confidentialité</a>.
                    </label>
                </div>

        <div>
          <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-black bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
            <i data-feather="save" class="mr-2"></i> Changer le mot de passe
          </button>
        </div>
      </form>

      <!-- Information de sécurité -->
      <div class="mt-6 text-center">
        <p class="text-xs text-gray-500">
          <i data-feather="info" class="inline h-4 w-4 mr-1"></i>
          Une fois votre mot de passe changé, vous serez redirigé vers votre tableau de bord.
        </p>
      </div>
    </div>
  </div>

  <script>
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true
    });
    
    feather.replace();
  </script>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/icon.ico') }}"><title>Login - Farmácia Pai e Filhos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-blue-50 h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
        
        <div class="bg-blue-700 p-8 text-center">
            <h1 class="text-white text-2xl font-bold flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus-circle"></i>
                FARMÁCIA PAI E FILHOS  
            </h1>
            <p class="text-blue-100 mt-2">Bem-vindo de volta!</p>
        </div>

        <div class="p-8">
            <form action="{{ route('login/auth') }}" method="POST"> @csrf

                <div class="mb-6">
                    <label for="email" class="block text-gray-600 text-sm font-medium mb-2">E-mail</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                               placeholder="seu@email.com" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-600 text-sm font-medium mb-2">Senha</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                               placeholder="********" required>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" class="form-checkbox text-blue-700 h-4 w-4 rounded focus:ring-blue-500 border-gray-300">
                        <span class="ml-2">Lembrar-me</span>
                    </label>
                    <a href="#" class="text-sm text-blue-700 hover:text-blue-900 font-semibold hover:underline">
                        Esqueceu a senha?
                    </a>
                </div>

                <button type="submit" 
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    ENTRAR
                </button>
            </form>

            <div class="my-6 flex items-center justify-between">
                <span class="w-1/5 border-b border-gray-300 lg:w-1/4"></span>
                <span class="text-xs text-center text-gray-400 uppercase">ou</span>
                <span class="w-1/5 border-b border-gray-300 lg:w-1/4"></span>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">Não tem uma conta?</p>
                <a href="{{ route('login/cadastro') }}" class="text-blue-700 font-bold hover:underline">
                    Crie sua conta agora
                </a>
            </div>
        </div>
    </div>

</body>
</html>
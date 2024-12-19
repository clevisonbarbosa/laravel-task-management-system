<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lista de Tarefas</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="icon" href="{{ asset('image/lista.png') }}" type="image/png">

        <style>
            body {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                margin: 0;
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #f6f8fd 0%, #f1f4f9 100%);
            }

            .container {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 2rem;
                padding: 2rem;
                max-width: 1200px;
                width: 100%;
            }

            .logo {
                width: 80px;
                height: 80px;
                object-fit: contain;
                animation: float 3s ease-in-out infinite;
            }

            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
                100% { transform: translateY(0px); }
            }

            .welcome-card {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 3rem 4rem;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                text-align: center;
                max-width: 500px;
                width: 100%;
                transition: transform 0.3s ease;
            }

            .welcome-card:hover {
                transform: translateY(-5px);
            }

            h1 {
                font-size: 2.5rem;
                color: #2d3748;
                margin: 1rem 0 2rem;
                font-weight: 600;
            }

            .buttons {
                display: flex;
                gap: 1rem;
                justify-content: center;
                margin-top: 2rem;
            }

            .btn {
                padding: 0.75rem 1.5rem;
                border-radius: 10px;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .btn-primary {
                background: #4f46e5;
                color: white;
                box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
            }

            .btn-secondary {
                background: #fff;
                color: #4f46e5;
                border: 2px solid #4f46e5;
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            }

            @media (max-width: 640px) {
                .welcome-card {
                    padding: 2rem;
                    margin: 1rem;
                }

                .buttons {
                    flex-direction: column;
                }

                h1 {
                    font-size: 2rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <img src="{{ asset('image/lista.png') }}" alt="Task Icon" class="logo">

            <div class="welcome-card">
                <h1>Lista de Tarefas</h1>
                <p>Organize suas tarefas de forma simples e eficiente</p>

                @if (Route::has('login'))
                    <div class="buttons">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-tasks"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Entrar
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-secondary">
                                    <i class="fas fa-user-plus"></i> Cadastrar
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>

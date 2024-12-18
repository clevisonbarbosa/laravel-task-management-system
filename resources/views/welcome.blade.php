<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lista de Tarefas</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

        <link rel="icon" href="{{ asset('image/lista.png') }}" type="image/png">

        <style>
            body {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
                font-family: 'Montserrat', sans-serif;
                background-color: #f9fafb;
            }

            img {
                width: 64px;
                height: 64px;
                object-fit: contain;
            }

            .todo-container {
                text-align: center;
                padding: 2rem;
                border-radius: 100px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                background-color: white;
                max-width: 500px;
                width: 100%;
            }

            h1 {
                font-size: 3rem;
                margin-bottom: 2rem;
                color: #333;
                display: flex;
                align-items: center;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            img + h1 {
                margin-top: 16px;
            }

            nav {
                display: flex;
                justify-content: flex-end;
                margin-top: 2rem;
            }

            a {
                padding: 0.75rem 1.25rem;
                border-radius: 4px;
                text-decoration: none;
                margin-left: 0.5rem;
                transition: all 0.3s ease;
            }

            .icon-container {
                margin-bottom: 2rem;
            }

            a:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            @media (prefers-color-scheme: dark) {
                body {
                    background-color: #ccc;
                }
                .todo-container {
                    background-color: #eee;
                }
                h1 {
                    color: #000000;
                }
                nav a {
                    color: #000000;
                }
            }
        </style>
    </head>
    <body>
        <div class="icon-container">
            <img src="{{ asset('image/lista.png') }}" alt="Task Icon">
        </div>
        <div class="todo-container">
            <h1>Lista de Tarefas</h1>
            @if (Route::has('login'))
                <nav>
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Entrar</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Cadastrar</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </body>
</html>

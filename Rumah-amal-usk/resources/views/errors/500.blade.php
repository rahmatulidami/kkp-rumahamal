@extends('layouts.layout-errors')

@section('title', 'Beranda | Rumah Amal USK')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(45deg, #000428, #004e92);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Arial', sans-serif;
            color: white;
            overflow: hidden;
        }

        .container {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .astronaut {
            width: 300px;
            animation: float 4s ease-in-out infinite;
        }

        h1 {
            font-size: 8em;
            margin: 20px 0;
            text-shadow: 0 0 10px rgba(255,255,255,0.5);
            animation: glow 2s ease-in-out infinite;
        }

        h2 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 30px;
            max-width: 600px;
        }

        .home-btn {
            padding: 15px 40px;
            background: #FF6B6B;
            border: none;
            border-radius: 30px;
            color: white;
            font-size: 1.1em;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .home-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255,107,107,0.4);
        }

        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes glow {
            0%, 100% { text-shadow: 0 0 10px rgba(255,255,255,0.5); }
            50% { text-shadow: 0 0 20px rgba(255,255,255,0.8); }
        }

        /* Add some star effects */
        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: twinkle var(--duration) ease-in-out infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }

        @media (max-width: 768px) {
            .astronaut {
                width: 200px;
            }
            h1 {
                font-size: 5em;
            }
            h2 {
                font-size: 1.5em;
            }
        }
    </style>

    <div class="stars"></div>
    <div class="container">
        <img src="https://cdn-icons-png.flaticon.com/512/1055/1055683.png" class="astronaut" alt="Astronaut">
        <h1 style="color: white;">500</h1>
        <h2 style="color: white;">Internal server Error</h2>
        <!-- <p>It seems you've drifted into unknown space territory. The page you're looking for is nowhere to be found in our galaxy.</p> -->
        <a href="/" class="home-btn">Return to Home Base</a>
    </div>

    <script>
        // Create animated stars
        function createStars() {
            const starsContainer = document.querySelector('.stars');
            for (let i = 0; i < 100; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                star.style.left = `${Math.random() * 100}%`;
                star.style.top = `${Math.random() * 100}%`;
                star.style.width = `${Math.random() * 3}px`;
                star.style.height = star.style.width;
                star.style.setProperty('--duration', `${Math.random() * 3 + 1}s`);
                starsContainer.appendChild(star);
            }
        }

        createStars();
    </script>

@endsection
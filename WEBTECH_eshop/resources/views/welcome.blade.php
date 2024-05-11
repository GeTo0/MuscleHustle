<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb; /* Light gray background */
        }

        /* Header styles */
        header {
            background-color: #ffffff; /* White background */
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Main styles */
        main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 80vh; /* Adjust as needed for vertical centering */
        }

        /* Footer styles */
        footer {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 20px;
            text-align: center;
            width: 100%;
            background-color: #ffffff; /* White background */
        }

        /* Additional styles for CATALOG link */
        .catalog-link {
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            color: #000000; /* Black color */
            margin-top: 20px; /* Add margin between title and CATALOG */
        }

        /* Box styles for CATALOG */
        .catalog-box {
            padding: 20px;
            background-color: #ffffff; /* White background */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        /* Styles for top right corner links */
        .top-right-links {
            display: flex;
        }

        .top-right-links a {
            margin-right: 30px; /* Add more space between links */
            text-decoration: none;
            color: #000000; /* Black color */
        }

        /* Title styles */
        .title {
            font-size: 6rem; /* Adjust the font size as needed */
            font-weight: bold;
            color: #000000; /* Black color */
            margin-bottom: 150px; /* Add margin below the title */
        }
    </style>
</head>
<body>
    <header>
        <div class="top-right-links">
            @guest
                <a href="{{ route('login') }}">Log in</a>
                <a href="{{ route('register') }}">Register</a>
            @else
                <a href="{{ route('dashboard') }}">PROFILE</a>
            @endguest
        </div>
    </header>
<main>
    <h1 class="title">MUSCLE HUSTLE</h1>
        <a href="{{ route('catalog') }}" class="catalog-link">
        <div class="catalog-box">
            <h2 class="text-xl font-semibold text-black">CATALOG</h2>
        </div>
    </a>
</main>
<footer>
    <p>Created by: Sebastián Lener, Dominik Zaťovič</p>
</footer>
</body>
</html>
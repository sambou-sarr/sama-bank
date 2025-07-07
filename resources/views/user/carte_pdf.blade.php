<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte Bancaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e3a34;
            color: white;
            margin: 0;
            padding: 40px;
        }

        .credit-card {
            width: 100%;
            max-width: 500px;
            height: 240px;
            border-radius: 16px;
            background: linear-gradient(135deg, #0e2d25, #1e3a34);
            box-shadow: 0 0 30px rgba(255, 193, 7, 0.3);
            border: 2px solid #ffc107;
            padding: 30px;
            position: relative;
        }

        .logo {
            position: absolute;
            top: 20px;
            right: 30px;
            font-weight: bold;
            color: #ffc107;
            font-size: 1.2rem;
        }

        .chip {
            width: 50px;
            height: 35px;
            background-color: #ffc107;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .number {
            font-size: 1.3rem;
            letter-spacing: 2px;
            margin-bottom: 25px;
        }

        .info {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
        }

        .owner {
            position: absolute;
            bottom: 20px;
            left: 30px;
            font-size: 0.95rem;
            font-weight: bold;
            letter-spacing: 1px;
            color: #fff;
        }

        .label {
            font-size: 0.7rem;
            color: #ccc;
        }
    </style>
</head>
<body>
    <div class="credit-card">
        <div class="logo">Sama Bank</div>
        <div class="chip"></div>

        <div class="number">{{ $carte->numero_carte }}</div>

        <div class="info">
            <div>
                <div class="label">EXP</div>
                <strong>{{ $carte->date_exp }}</strong>
            </div>
            <div>
                <div class="label">CVV</div>
                <strong>{{ $carte->CVV }}</strong>
            </div>
        </div>

        <div class="owner">
            Nom du Titulaire : {{ strtoupper($nomTitulaire) }}
        </div>
    </div>
</body>
</html>

@extends('user.base')

@section('content')
<style>
    body {
        background-color: #1e3a34;
    }

    .card-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 50px 0;
    }

    .credit-card {
        width: 420px;
        height: 240px;
        border-radius: 16px;
        background: linear-gradient(135deg, #0e2d25, #1e3a34);
        box-shadow: 0 0 30px rgba(255, 193, 7, 0.3);
        border: 2px solid #ffc107;
        color: white;
        padding: 30px;
        position: relative;
        text-align: left;
    }

    .credit-card .logo {
        position: absolute;
        top: 20px;
        right: 30px;
        font-weight: bold;
        color: #ffc107;
        font-size: 1.2rem;
    }

    .credit-card .chip {
        width: 50px;
        height: 35px;
        background-color: #ffc107;
        border-radius: 5px;
        margin-bottom: 30px;
    }

    .credit-card .number {
        font-size: 1.3rem;
        letter-spacing: 2px;
        margin-bottom: 25px;
    }

    .credit-card .info {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
    }

    .credit-card .info span {
        display: block;
    }

    .credit-card .owner {
        position: absolute;
        bottom: 20px;
        left: 30px;
        font-size: 0.95rem;
        font-weight: bold;
        letter-spacing: 1px;
        color: #fff;
    }

    .btn-pdf {
        display: block;
        margin: 30px auto;
        padding: 10px 20px;
        background-color: #ffc107;
        color: #1e3a34;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        text-decoration: none;
    }
</style>

<div class="card-wrapper">
    <div class="credit-card">
        <div class="logo">Sama Bank</div>
        <div class="chip"></div>

        <div class="number">{{ $carte->numero_carte }}</div>

        <div class="info">
            <div>
                <span>EXP</span>
                <strong>{{ $carte->date_exp }}</strong>
            </div>
            <div>
                <span>CVV</span>
                <strong>{{ $carte->CVV }}</strong>
            </div>
        </div>
        <br>
        <div class="owner">
            <span>Nom du Titulaire : </span>
            {{ strtoupper($nomTitulaire) }}
        </div>
    </div>
</div>

<a href="{{route('carte.pdf', $carte->id)}}" class="btn-pdf" target="_blank">Télécharger la carte en PDF</a>
@endsection

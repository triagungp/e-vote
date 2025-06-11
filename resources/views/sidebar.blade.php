<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $pageTitle ?? 'E Vote' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<!-- user/sidebar.php -->
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .sidebar {
        position: fixed;
        width: 200px;
        height: 100%;
        background: #2c3e50;
        padding-top: 20px;
    }

    .sidebar a {
        display: block;
        color: #ecf0f1;
        padding: 12px 20px;
        text-decoration: none;
    }

    .sidebar a:hover {
        background: #34495e;
    }

    .main-content {
        margin-left: 220px;
        padding: 30px;
        width: calc(100% - 220px);
    }

    @media (max-width: 768px) {
        .sidebar {
            position: relative;
            width: 100%;
            height: auto;
        }

        .main-content {
            margin-left: 0;
            width: 100%;
        }

    }
</style>
{{-- <div class="sidebar">
    <br>
    <br>
    <br>
    <a href="dashboard"> Dashboard</a>
    <a href="elections"> List Pemilihan</a>
    <a href="candidates"> Data Kandidat</a>
    <a href="tokens"> Token</a>
    <a href="logout"> Logout</a>
</div> --}}

<div class="sidebar bg-dark text-white p-3" style="min-height: 100vh;">
    <h4 class="text-center mb-4">
        <br>
        <i class="bi bi-check-circle-fill"> e-Vote</i> 
    </h4>
    <ul class="nav flex-column">
        <a href="dashboard"> Dashboard</a>
        <a href="elections"> List Pemilihan</a>
        <a href="candidates"> Data Kandidat</a>
        <a href="tokens"> Token</a>
        <a href="admin/logout"> Logout</a>
    </ul>
</div>

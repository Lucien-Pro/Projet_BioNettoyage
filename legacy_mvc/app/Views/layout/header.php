<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?> — Bâtiment A</title>
    <meta name="description" content="Application de traçabilité BioNettoyage pour la gestion des locaux et des équipes.">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="app">
    <div class="phone">
        
        <!-- Top Navigation Bar -->
        <header class="topbar">
            <div>
                <h1 class="topbar-title"><?php echo SITENAME; ?></h1>
                <div class="topbar-sub">Bâtiment A — Lundi 7 avril</div>
            </div>
            <a href="<?php echo URLROOT; ?>/admin" class="avatar" title="Accéder à la gestion">MD</a>
        </header>

        <!-- Tab Navigation -->
        <nav class="tab-bar">
            <div class="tab active" id="tab-btn-locaux" onclick="switchTab('mes-locaux', this)" role="button" tabindex="0">Mes locaux</div>
            <div class="tab" id="tab-btn-equipe" onclick="switchTab('equipe', this)" role="button" tabindex="0">Équipe</div>
            <div class="tab" id="tab-btn-alertes" onclick="switchTab('alertes', this)" role="button" tabindex="0">Alertes</div>
        </nav>

        <main class="content">

<?php
/**
 * Configuration de session sécurisée
 * 
 * Démarre la session avec des paramètres de sécurité optimisés.
 * À inclure UNIQUEMENT au début des scripts nécessitant une session.
 * 
 * @category Security
 * @package BoiteMail
 * @version 1.1
 */

// Vérifier si la session n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    
    // Options de session sécurisées
    $sessionOptions = [
        // Durée de vie du cookie (24 heures)
        'cookie_lifetime' => 86400,
        
        // Sécuriser le cookie (true en production avec HTTPS)
        'cookie_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        
        // Cookie accessible uniquement via HTTP (protection XSS)
        'cookie_httponly' => true,
        
        // Politique SameSite pour protection CSRF
        'cookie_samesite' => 'Strict',
        
        // Mode strict pour prévenir les attaques par fixation de session
        'use_strict_mode' => true,
        
        // Utiliser uniquement des cookies pour l'ID de session
        'use_only_cookies' => true,
        
        // Empêcher la mise en cache des pages avec session
        'cache_limiter' => 'nocache',
        
        // Nom personnalisé du cookie
        'name' => 'BOITEMAILE_SESSID',
    ];
    
    // Démarrer la session avec les options configurées
    session_start($sessionOptions);
    
    // Protection contre les attaques de fixation de session
    if (!isset($_SESSION['generated']) || $_SESSION['generated'] < (time() - 300)) {
        session_regenerate_id(true);
        $_SESSION['generated'] = time();
    }
}
?>
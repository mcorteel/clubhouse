<?php

return array(
    '' => 'home/index',
    'actualites' => 'home/index',
    'actualites\/page\/(\d+)' => 'home/index',
    
    'reservation' => 'reservation/index',
    'reservation\/(\d{4}-\d{2}-\d{2})' => 'reservation/index',
    'reservation\/create' => 'reservation/create',
    'reservation\/show\/(\d+)' => 'reservation/show',
    'reservation\/cancel\/(\d+)' => 'reservation/cancel',
    
    'login' => 'login/index',
    'logout' => 'login/logout',
    
    'admin' => 'admin/index',
    
    'utilisateur' => 'user/index',
    'utilisateur\/profil' => 'user/profile',
    'utilisateur\/reservations' => 'user/reservations',
    'utilisateur\/reservations\/page\/(\d+)' => 'user/reservations',
    
    'admin\/utilisateurs' => 'admin_users/all',
    'admin\/utilisateurs\/page\/(\d+)' => 'admin_users/all',
    'admin\/utilisateurs\/nouveau' => 'admin_users/edit',
    'admin\/utilisateurs\/(\d+)' => 'admin_users/edit',
    
    'admin\/partenaires' => 'admin_partners/all',
    'admin\/partenaires\/page\/(\d+)' => 'admin_partners/all',
    'admin\/partenaires\/nouveau' => 'admin_partners/edit',
    'admin\/partenaires\/(\d+)' => 'admin_partners/edit',
    'admin\/partenaires\/(\d+)\/supprimer' => 'admin_partners/remove',
    
    'admin\/images' => 'admin_pictures/all',
    'admin\/images\/page\/(\d+)' => 'admin_pictures/all',
    'admin\/images\/nouvelle' => 'admin_pictures/edit',
    'admin\/images\/(\d+)' => 'admin_pictures/edit',
    'admin\/images\/(\d+)\/supprimer' => 'admin_pictures/remove',
    'admin\/images\/scan' => 'admin_pictures/scan',
    
    'admin\/actualites' => 'admin_news/all',
    'admin\/actualites\/page\/(\d+)' => 'admin_news/all',
    'admin\/actualites\/nouvelle' => 'admin_news/edit',
    'admin\/actualites\/(\d+)' => 'admin_news/edit',
    'admin\/actualites\/(\d+)\/supprimer' => 'admin_news/remove',
    
    'admin\/ressources' => 'admin_resources/all',
    'admin\/ressources\/page\/(\d+)' => 'admin_resources/all',
    'admin\/ressources\/nouvelle' => 'admin_resources/edit',
    'admin\/ressources\/(\d+)' => 'admin_resources/edit',
    'admin\/ressources\/(\d+)\/supprimer' => 'admin_resources/remove',
    
    'admin\/config' => 'admin_config/index',
    
    ////////////////////////////////////
    // Custom routes should go here > //
    ////////////////////////////////////
    
    ////////////////////////////////////
    // < Custom routes should go here //
    ////////////////////////////////////
    
    
    '.*' => 'error/notfound',
);

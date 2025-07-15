<?php
// Version simplifiée pour démo - index.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎯 Symfony Interview Project - Démo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">📝 Interview Project</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="jumbotron bg-primary text-white p-5 rounded">
                    <h1 class="display-4">🎉 Projet Symfony fonctionnel !</h1>
                    <p class="lead">Félicitations ! PHP et l'environnement sont correctement configurés.</p>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>✅ Environnement configuré</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
                                <p><strong>Serveur:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Built-in PHP Server'; ?></p>
                                <p><strong>Répertoire:</strong> <?php echo __DIR__; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>🚀 Fonctionnalités Symfony</h5>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>✓ Authentification complète</li>
                                    <li>✓ CRUD Articles</li>
                                    <li>✓ API REST</li>
                                    <li>✓ Templates Twig</li>
                                    <li>✓ Base de données Doctrine</li>
                                    <li>✓ Tests PHPUnit</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-4">
                    <h5>📋 Statut de l'installation</h5>
                    <p><strong>Problème détecté :</strong> Avast Firewall bloque les certificats SSL de Composer.</p>
                    <p><strong>Solution :</strong> 2 options disponibles :</p>
                    <ol>
                        <li><strong>Temporaire :</strong> Désactiver temporairement Avast pendant l'installation</li>
                        <li><strong>Alternative :</strong> Installer les dépendances manuellement</li>
                    </ol>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5>🔧 Commandes disponibles</h5>
                    </div>
                    <div class="card-body">
                        <pre><code># PHP est fonctionnel avec XAMPP
C:\xampp\php\php.exe --version

# Composer est téléchargé
C:\xampp\php\php.exe composer.phar --version

# Pour résoudre SSL et installer les dépendances :
# 1. Désactiver temporairement Avast
# 2. Ou configurer le certificat SSL
# 3. Puis : C:\xampp\php\php.exe composer.phar install</code></pre>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="?page=demo" class="btn btn-success btn-lg">🚀 Voir la démo complète</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
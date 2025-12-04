# 🎯 Symfony Interview Project

Un projet Symfony complet créé pour démontrer toutes les compétences essentielles.

## 🚀 Fonctionnalités implémentées

### ✅ Authentification & Sécurité
- ✓ Système complet de registration/login/logout
- ✓ Gestion des utilisateurs avec Symfony Security Bundle  
- ✓ Hashage sécurisé des mots de passe
- ✓ Protection CSRF sur les formulaires
- ✓ Gestion des rôles (ROLE_USER, ROLE_ADMIN)

### ✅ CRUD Complet
- ✓ Création, lecture, modification, suppression d'articles
- ✓ Gestion des permissions (utilisateurs ne peuvent modifier que leurs propres articles)
- ✓ Système de brouillons/publication
- ✓ Recherche d'articles

### ✅ Base de données & ORM
- ✓ Entités Doctrine avec relations (User ↔ Article)
- ✓ Repository patterns avec requêtes personnalisées
- ✓ Migrations automatiques
- ✓ Fixtures pour données de test

### ✅ Formulaires & Validation
- ✓ Form Types Symfony avec validation
- ✓ Gestion des erreurs et feedback utilisateur
- ✓ Validation côté serveur avec contraintes Symfony

### ✅ Templates Twig
- ✓ Layout responsive avec Bootstrap 5
- ✓ Héritage de templates
- ✓ Composants réutilisables
- ✓ Système de navigation dynamique

### ✅ API REST
- ✓ Endpoints JSON complets (`/api/articles`)
- ✓ Groupes de sérialisation
- ✓ Gestion des erreurs API
- ✓ Documentation des endpoints

### ✅ Tests
- ✓ Tests unitaires PHPUnit
- ✓ Tests d'entités
- ✓ Tests de contrôleurs
- ✓ Configuration de test

## 🛠️ Installation & Configuration

### Prérequis
- PHP 8.1+
- Composer
- Symfony CLI (optionnel)
- Base de données (PostgreSQL, MySQL, ou SQLite)

### 🔧 Installation de l'environnement (Windows)

**Étape 1 : Installer PHP**
1. Téléchargez PHP 8.1+ depuis https://windows.php.net/download/
2. Extrayez dans `C:\php`
3. Ajoutez `C:\php` au PATH Windows :
   - Ouvrez "Variables d'environnement système"
   - Modifiez la variable PATH
   - Ajoutez `C:\php`
4. Redémarrez PowerShell

**Étape 2 : Installer Composer**
1. Téléchargez depuis https://getcomposer.org/Composer-Setup.exe
2. Exécutez l'installateur (il configurera automatiquement le PATH)
3. Redémarrez PowerShell

**Étape 3 : Vérifier l'installation**
```powershell
php --version
composer --version
```

### Installation du projet

1. **Installer les dépendances** :
```powershell
composer install
```

2. **Configurer la base de données** :
```powershell
# Modifiez le DATABASE_URL dans .env
# Exemple pour SQLite (simple) :
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

# Ou PostgreSQL :
DATABASE_URL="postgresql://username:password@127.0.0.1:5432/symfony_interview?serverVersion=15&charset=utf8"
```

3. **Créer la base de données** :
```powershell
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

4. **Charger des données de test** (optionnel) :
```powershell
php bin/console doctrine:fixtures:load
```

5. **Lancer le serveur** :
```powershell
# Avec Symfony CLI :
symfony server:start

# Ou avec PHP :
php -S localhost:8000 -t public/
```

6. **Accéder à l'application** :
- 🏠 Homepage: http://localhost:8000
- 🔐 Login: http://localhost:8000/login
- 📝 Registration: http://localhost:8000/register

## 🧪 Tests

Lancer les tests :
```bash
php bin/phpunit
```

## 🔌 API Endpoints

### Articles API
- `GET /api/articles` - Liste des articles
- `GET /api/articles/{id}` - Détail d'un article
- `POST /api/articles` - Créer un article (auth requise)
- `PUT /api/articles/{id}` - Modifier un article (auth requise)
- `DELETE /api/articles/{id}` - Supprimer un article (auth requise)

### Exemples d'utilisation

**Récupérer tous les articles** :
```powershell
# Avec curl (PowerShell moderne)
curl -X GET http://localhost:8000/api/articles

# Ou avec Invoke-WebRequest (PowerShell classique)
Invoke-WebRequest -Uri "http://localhost:8000/api/articles" -Method GET
```

**Créer un article** :
```powershell
# Avec curl
curl -X POST http://localhost:8000/api/articles `
  -H "Content-Type: application/json" `
  -d '{
    "title": "Mon nouvel article",
    "content": "Contenu de l'article...",
    "summary": "Résumé de l'article",
    "published": true
  }'

# Ou avec Invoke-WebRequest
$body = @{
    title = "Mon nouvel article"
    content = "Contenu de l'article..."
    summary = "Résumé de l'article"
    published = $true
} | ConvertTo-Json

Invoke-WebRequest -Uri "http://localhost:8000/api/articles" -Method POST -Body $body -ContentType "application/json"
```

## 📁 Structure du projet

```
symfony/
├── config/              # Configuration Symfony
│   ├── packages/        # Configuration des bundles
│   └── routes/          # Configuration des routes
├── public/              # Point d'entrée web
│   └── index.php
├── src/
│   ├── Controller/      # Contrôleurs
│   │   ├── Api/         # Contrôleurs API
│   │   ├── ArticleController.php
│   │   ├── HomeController.php
│   │   ├── SecurityController.php
│   │   └── RegistrationController.php
│   ├── Entity/          # Entités Doctrine
│   │   ├── User.php
│   │   └── Article.php
│   ├── Form/            # Types de formulaires
│   │   ├── ArticleType.php
│   │   └── RegistrationFormType.php
│   ├── Repository/      # Repositories Doctrine
│   │   ├── UserRepository.php
│   │   └── ArticleRepository.php
│   └── Kernel.php
├── templates/           # Templates Twig
│   ├── base.html.twig
│   ├── home/
│   ├── security/
│   ├── article/
│   └── dashboard/
├── tests/               # Tests PHPUnit
├── .env                 # Variables d'environnement
├── composer.json        # Dépendances PHP
└── phpunit.xml.dist     # Configuration tests
```

## 🎯 Points clés

### Architecture & Patterns
- ✅ **MVC Pattern** : Séparation claire Controller/Model/View
- ✅ **Repository Pattern** : Logique de base de données isolée
- ✅ **Dependency Injection** : Services injectés automatiquement
- ✅ **Form Types** : Réutilisabilité des formulaires

### Sécurité
- ✅ **Authentication** : Login/logout sécurisé
- ✅ **Authorization** : Contrôle d'accès aux ressources
- ✅ **CSRF Protection** : Protection contre les attaques CSRF
- ✅ **Password Hashing** : Hashage sécurisé des mots de passe
- ✅ **Input Validation** : Validation des données utilisateur

### Base de données
- ✅ **ORM Doctrine** : Mapping objet-relationnel
- ✅ **Relations** : OneToMany/ManyToOne entre User et Article
- ✅ **Migrations** : Versioning de la base de données
- ✅ **Requêtes personnalisées** : QueryBuilder et DQL

### API & Serialization
- ✅ **REST API** : Endpoints RESTful
- ✅ **JSON Serialization** : Groupes de sérialisation
- ✅ **Error Handling** : Gestion des erreurs API
- ✅ **HTTP Status Codes** : Codes de réponse appropriés

### Tests
- ✅ **Unit Tests** : Tests des entités et logique métier
- ✅ **Functional Tests** : Tests des contrôleurs
- ✅ **Test Environment** : Configuration séparée pour les tests



## 🚀 Fonctionnalités ajoutées

- 📱 **Design responsive** avec Bootstrap 5
- 🔍 **Recherche d'articles** avec filtres
- 📊 **Dashboard utilisateur** avec statistiques
- 🎨 **Interface moderne** avec émojis et UX optimisée
- ⚡ **Performance** : Pagination et requêtes optimisées
- 🔒 **Sécurité renforcée** : Validation stricte et protection CSRF

---


Ce projet démontre une maîtrise complète de l'écosystème Symfony et des meilleures pratiques de développement web moderne.
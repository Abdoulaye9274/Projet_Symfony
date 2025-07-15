# 🚀 Installation Rapide (Windows)

## Installation automatique avec PowerShell

Copiez-collez ces commandes dans PowerShell **en tant qu'administrateur** :

### 1. Installer Chocolatey (gestionnaire de paquets Windows)
```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))
```

### 2. Installer PHP et Composer
```powershell
choco install php composer -y
```

### 3. Redémarrer PowerShell et vérifier
```powershell
# Fermer et rouvrir PowerShell
php --version
composer --version
```

## Installation manuelle (alternative)

### Option A : PHP
1. **Télécharger PHP** : https://windows.php.net/download/
   - Choisir "Thread Safe" version 8.1+
   - Extraire dans `C:\php`

2. **Ajouter au PATH** :
   - Touche Windows + R → `sysdm.cpl`
   - Onglet "Avancé" → "Variables d'environnement"
   - Modifier la variable "Path"
   - Ajouter `C:\php`

### Option B : Composer  
1. **Télécharger** : https://getcomposer.org/Composer-Setup.exe
2. **Installer** avec les paramètres par défaut

## Démarrage du projet

Une fois PHP et Composer installés :

```powershell
# 1. Installer les dépendances
composer install

# 2. Créer la base de données SQLite (simple)
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# 3. Lancer le serveur
php -S localhost:8000 -t public/
```

## Accès à l'application

- **Site web** : http://localhost:8000
- **API** : http://localhost:8000/api/articles

## En cas de problème

### Erreur "php n'est pas reconnu"
- Vérifier que PHP est dans le PATH
- Redémarrer PowerShell après installation

### Erreur "composer n'est pas reconnu"
- Redémarrer PowerShell après installation
- Vérifier dans `C:\ProgramData\ComposerSetup\bin`

### Port 8000 déjà utilisé
```powershell
# Utiliser un autre port
php -S localhost:8080 -t public/
```

## Tests rapides

```powershell
# Tester que tout fonctionne
curl http://localhost:8000
curl http://localhost:8000/api/articles

# Ou avec PowerShell natif
Invoke-WebRequest -Uri "http://localhost:8000"
```
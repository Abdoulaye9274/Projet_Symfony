# 🔧 Guide d'installation Windows - Solutions

## 📌 Problème rencontré
L'installation de Chocolatey nécessite des droits administrateur. Voici **3 solutions alternatives** :

## ✅ Solution 1 : Installation manuelle PHP + Composer (Recommandée)

### 📥 Téléchargements directs
1. **PHP** : https://windows.php.net/download/
   - Choisir "Thread Safe" version 8.1+ (.zip)
   - Extraire dans `C:\php`

2. **Composer** : https://getcomposer.org/Composer-Setup.exe
   - Télécharger et exécuter l'installateur

### ⚙️ Configuration PATH Windows
1. Touche `Windows + R` → taper `sysdm.cpl` → Entrée
2. Onglet "Avancé" → "Variables d'environnement"
3. Dans "Variables système", sélectionner "Path" → "Modifier"
4. "Nouveau" → ajouter `C:\php`
5. OK → OK → Redémarrer PowerShell

## ✅ Solution 2 : XAMPP (Tout-en-un)

### 📦 Installation XAMPP
1. **Télécharger** : https://www.apachefriends.org/download.html
2. **Installer** XAMPP (inclut PHP, Apache, MySQL)
3. **Ajouter au PATH** : `C:\xampp\php`
4. **Installer Composer** séparément

## ✅ Solution 3 : PHP portable (Sans installation)

### 🔄 Utilisation temporaire
Si vous voulez juste tester le projet :
1. Téléchargez PHP portable
2. Extrayez dans le dossier du projet
3. Utilisez `.\php\php.exe` au lieu de `php`

## 🚀 Après installation - Tester

```powershell
# Redémarrer PowerShell puis tester :
php --version
composer --version

# Si ça fonctionne, installer le projet :
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php -S localhost:8000 -t public/
```

## 🎯 Configuration SQLite (Simplifiée)

Le projet est **déjà configuré** pour utiliser SQLite (pas besoin de serveur MySQL/PostgreSQL) !
La base de données sera créée automatiquement dans `var/data.db`.

## 🆘 En cas de problème

### Erreur "php n'est pas reconnu"
- Vérifier que `C:\php` est dans le PATH
- Redémarrer PowerShell après modification du PATH

### Erreur "composer n'est pas reconnu" 
- Composer s'installe généralement dans `%APPDATA%\Composer\vendor\bin`
- L'installateur devrait ajouter automatiquement au PATH

### Test sans PATH
```powershell
# Si le PATH ne fonctionne pas, utiliser le chemin complet :
C:\php\php.exe --version
C:\ProgramData\ComposerSetup\bin\composer.bat --version
```

Quelle solution préférez-vous essayer en premier ?
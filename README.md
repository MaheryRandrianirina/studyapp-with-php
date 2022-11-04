# study-app-with-php

Application pour aider dans les études. Que vous soyez élèves, étudiants, autodidactes,etc... vous pouvez utiliser cette application. 
L'application a été conçue suivant les méthodes d'apprentissage mises au point par la neuroscience.

1 - Fonctionnalités :
    -> inscription / connexion / déconnexion
    -> créer un emploi du temps
    -> générer automatiquement les répétitions en suivant la méthode de répétitions éspacées
    -> afficher automatiquement les emploi du temps de la journée
    -> remettre à plutard la revision s'il y a des imprévus
    -> play/pause suivant la technique Pomodoro
    -> système de notification
    -> responsive
 
 
 2 - A faire pour lancer l'application :
    -> lancer : npm install
    -> composer install
    -> certaines vues possèdent une variable $js. Ecrire dedans le chemin vers le fichier .js qui se trouve dans le dossier assets. exemple : $js = "./assets/exemple.js"
    -> Lors de la production, écrire le chemin vers le le fichier CSS dans la balise link
    -> mettre l'application dans wamp, xamp, lamp,... ou utiliser cette commande : php -S localhost:8000 -t public
    -> lancer la commande suivante dans la racine : mysql -u root -p nom-de-votre-base-de-données < studyapp.sql
    -> lancer : npm run dev (pour le développement), npm run prod (pour la production)
    -> aller sur localhost:8000 dans votre navigateur
   
   
 3 - NB:
    L'application n'est pas encore mise totalement finie donc vous rencontrerez peut-être quelques problèmes mineures mais ne vous inquiétez pas, la 
    version complète arrivera la semaine prochaine. 
    Toutefois, vous pouvez travailler ou l'utiliser avec toutes ses fonctionnalités.

mon_projet
==========

A Symfony project created on May 30, 2016, 9:28 pm.
![Capture 1](cap.png)</br>
![Capture 2](cap2.png)</br>


Projet Synfony3
Mohamed Diallo et Patrick Chen

Le theme du projet est un site d'entreprise de voitures.
On ne peux pas s'inscrire directement sur le site car il faut etre un salarie
pour pouvoir acceder a la plateforme mis en place.

Les moderateurs tests sont : 
pseudo :Lessard_2003
mdp :Lessard_Arienne
pseudo        mdp
Labrie_2007 :Labrie_Arienne
Lamoureux_2008 : Lamoureux_Somerville

(php bin/console server:start)
(php bin/console doctrine:schema:update --force) eventuellement


Comment faire marcher le site
creer un nouveau projet :
symfony new mon_projet

-puis remplacer le fichier mon_projet/app/Ressources/      par celui dans l'archive (Ressources/)

-remplacer  mon_projet/src/AppBundle/  par celui dans l'archive(AppBundle/)

-remplacer mon_projet/web par le dossier web de l'archive.

-Utiliser votre propre Base De Donnée et charger pachen56.sql.(modifier en fonction de votre base de donnees)

-ensuite avec un navigateur faire : localhost:8000





les modules 
-Gestion des formations:l'utilisateur choisi la formation ,tant que le superieur n'as pas valide ,il peut changer d'avis.

-statistiques sur les salaries:quelques stattistiques -> nombres d'hommes et de femmes.taux de CDD CDI (..)

-generateur de fiche de paie : l'utilisateur peux charger sa fiche de paie qui contient les informations nescessaires.(les calculs sont simplifiers).

-moteur de recherche:Ce moteur cherche dans les salaries ,les formations et les themes et sujets du forum et les affichent.

-tableur:Tableur a l'image de exel ,marche avec les formules de exel.

-forum de discussion:Le forum est regroupé par themes ,dans chaque themes on peut soit participer a une discussion ,soit en creer une nouvelle.

-mini chat:On peut creer une conversation et ajouter autant de personnes voulus.On peut supprimer une conversation a laquel on participe.



# equipe etrange
***

### Cordier Maxime / Waroquet Quentin

## contexte
Les utilisateurs choisisse 1 classe sur les 2 proposée, chacune offrant des missions quotidiennes uniques en lien avec sa classe. La réussite des missions est cruciale, car les utilisateurs disposent d'un nombre de vies limitée.

- Missions Quotidiennes en focntion de la classe
- Validation des Missions
- Historique des Missions
- gestion de points de vie avec suppression du compte si pv = 0;
- Administration des Missions / user / classe + Historique
- Historique personel lorque connectés
- modification de ces identifiants
- (BONUS) Leaderboard -> affichage du nombre de mission réussi par classe (si l'utilisateur est connécté) sur la page affichant les 2 classe (en recupérant le total de missions réussi en fonction de la classe de la mission réussi)



## installation :
```
composer i
```
Création d'un fichier .env.local à partir du fichier .env :
```
cp .env .env.local
```
Puis modifiez les variables d'environnement du fichier .env.local selon votre environnement local.

installer la bdd / mettre a jour la bdd
```
composer recreate-db
```
Lancer le serveur
```
symfony serve
```



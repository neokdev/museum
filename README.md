# Build CI
[![build status](https://gitlab.com/morvan.aurelien/museum/badges/_dev/build.svg)](https://gitlab.com/morvan.aurelien/museum/commits/_dev)

# Enoncé

### Contexte
Le musée du Louvre vous a missionné pour un projet ambitieux : créer un nouveau système de réservation et de gestion des tickets en ligne pour diminuer les longues files d’attente et tirer parti de l’usage croissant des smartphones.

### Cahier des charges
L’interface doit être accessible aussi bien sur ordinateur de bureau que tablettes et smartphones, et utiliser pour cela un design responsive.

L’interface doit être fonctionnelle, claire et rapide avant tout. Le client ne souhaite pas surcharger le site d’informations peu utiles : l’objectif est de permettre aux visiteurs d’acheter un billet rapidement.

Il existe 2 types de billets : le billet « Journée » et le billet « Demi-journée » (il ne permet de rentrer qu’à partir de 14h00). Le musée est ouvert tous les jours sauf le mardi (et fermé les 1er mai, 1er novembre et 25 décembre).

Le musée propose plusieurs types de tarifs :

- Un tarif « normal » à partir de 12 ans à 16 €
- Un tarif « enfant » à partir de 4 ans et jusqu’à 12 ans, à 8 € (l’entrée est gratuite pour les enfants de moins de 4 ans)
- Un tarif « senior » à partir de 60 ans pour 12  €
- Un tarif « réduit » de 10 € accordé dans certaines conditions (étudiant, employé du musée, d’un service du Ministère de la Culture, militaire…)

Pour commander, on doit sélectionner :
- Le jour de la visite
- Le type de billet (Journée, Demi-journée…). On peut commander un billet pour le jour même mais on ne peut plus commander de billet « Journée » une fois 14h00 passées.
- Le nombre de billets souhaités

Le client précise qu’il n’est pas possible de réserver pour les jours passés (!), les dimanches, les jours fériés et les jours où plus de 1000 billets ont été vendus en tout pour ne pas dépasser la capacité du musée.
Pour chaque billet, l’utilisateur doit indiquer son nom, son prénom, son pays et sa date de naissance. Elle déterminera le tarif du billet.

Si la personne dispose du tarif réduit, elle doit simplement cocher la case « Tarif réduit ». Le site doit indiquer qu’il sera nécessaire de présenter sa carte d’étudiant, militaire ou équivalent lors de l’entrée pour prouver qu’on bénéficie bien du tarif réduit.

Le site récupèrera par ailleurs l’e-mail du visiteur afin de lui envoyer les billets. Il ne nécessitera pas de créer un compte pour commander.

Le visiteur doit pouvoir payer avec la solution Stripe par carte bancaire.

Le site doit permettre de sélectionner son mode de paiement et gérer le retour du paiement. En cas d’erreur, il invite à recommencer l’opération. Si tout s’est bien passé, la commande est enregistrée et les billets sont envoyés au visiteur.

Vous utiliserez les environnements de test fournis par Stripe pour simuler la transaction, afin de ne pas avoir besoin de rentrer votre propre carte bleue.

# Le billet
Un email de confirmation sera envoyé à l’utilisateur et fera foi de billet.

Le mail doit indiquer:
- Le nom et le logo du musée
- La date de la réservation
- Le tarif
- Le nom de chaque visiteur
- Le code de la réservation (un ensemble de lettres et de chiffres)

### Livrables attendus
- Document de présentation de la solution pour le client, incluant la note de cadrage (PDF)
- Cahier des charges fonctionnel
- Cahier des charges technique
- Code source complet du projet versionné avec Git, développé avec le framework PHP Symfony
- Quelques (4-5) tests unitaires et fonctionnels que l’on peut exécuter

# Présentation technique du projet
## Modèles de données
![Modèle de données](/docs/museum_model.png)
## Architecture projet
- Back:
    - PHP
    - Symfony 3.2
- Front:
    - Moteur template twig
    - Bootstrap
- Architecture serveur:
    - Debian 8
    - Apache 2.4
    - Postgres 9.5
    
## Installation du projet

**1. Clone du projet**  
`git clone git@gitlab.com:morvan.aurelien/museum.git`  

**2. Dossier du projet**    
`cd museum`  

**3. Installation des dépendances**  
`composer install`  

**4. Renseigner les informations du parameters file**  
- **database_driver:** Driver base de donnée
- **database_host:** Host de la base de donnée
- **database_port:** Port de la base de donnée
- **database_name:** Nom souhaité pour la base de donnée
- **database_user:** Utilisateur avec des droits d'accès pour la base de donnée
- **database_password:** Mot de passe de l'utilisateur
- **mailer_transport:** Par défaut *smtp*
- **mailer_host:** Host du mailer, laisser par défaut si utilisation de postfix
- **mailer_user:** User du mailer, laisser par défaut si utilisation de postfix
- **mailer_password:** Password de l'utilisateur du mailer, laisser par défaut si utilisation de postfix
- **adress_contact:** Adresse du musée pour les mails, par défaut *musee@aurelien-morvan.fr*
- **name_contact:** Nom de contact du musée pour les mails, par défaut *Musée du Louvre*
- **stripe.token:** Clé API privée du compte Stripe.
- **stripe.pub_key:** Clé API public du compte Stripe.

**5. Chargement des fixtures de déploiement pour la démonstration**  
`php bin/console d:f:l -n`  

## Cas d'erreur pour la démonstration
**1. Affichage du message d'alert pour le jour courant si billets restants inférieur à 100 billets**
- Paramétrer lors du chargement des fixtures.

**2. Affichage d'un message d'erreur sur un jour fermé**  
- Choisir Mardi, Dimanche, 1er Mai, 1 novembre ou 25 Décembre

**3. Affichage d'un message de nombres de billets restants insuffisants** 
- Choisir la date du 14 juillet 2017 en choisissant un nombre de billets supérieur à 4**
## Exemple de billet reçu par mail
**1. Effectuer un parcours de réservation**

**2. Sur la page "/order", indiquer l'adresse mail "aurelien.morvan@dartybox.com", "john@doe.com", "jane@doe.com"**

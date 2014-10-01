# Documentation française de Witzing

## Sommaire

1. **Introduction**
    - Organisation générale du projet
    - Guide de développement
    - Participer
2. **Développement**
    - A.P.I.
        - Fonctions
        - Données
    - Interne
        - Fonctions
        - Stockage des données
    - Concepts
        - Entités
        - Sécurité

## Introduction

### Organisation du projet

Le projet Witzing est organisé selon un mode de développement collaboratif : chacun peut prendre place dans l'aventure et contribuer à son rythme, à sa manière sans aucune contrainte.

### Guide de développement

Avant de rejoindre l'équipe nous vous conseillons vivement la lecture du [GuWide][], l'unique document directeur qui vous permettra de contribuer dans les meilleures conditions possibles.

### Participer

Pour participer, rien de plus simple, tout est expliqué à l'intérieur de l'unique document directeur, le [GuWide][].

## Développement

### A.P.I.

Witzing est construit autour d'une A.P.I. (acronyme de *__A__pplication __P__rogramming __I__nterface*, qui en fraçais est une *__I__nterface __A__pplicative de __P__rogrammation*) que documente cette section.

#### Fonctions

Les fonctions de l'A.P.I. sont disponibles sur [APIFunctions][].

#### Données

L'A.P.I. fonctionne en utilisant des données textuelles hiérarchisées comme décrit sur [APIDatas][].

### Interne

Est documenté ici le fonctionnement interne de Witzing.

#### Fonctions

Les fonctions internes sont documentées sur [COREFunctions][].

#### Stockage des données

Witzing utilise une base de donnée relationnelle telle que décrite sur [COREDatas][]

### Concepts

#### Entités

Le vocabulaire utilisé par l'équipe est défini par la liste ci-dessous :

- **Compte**  
    C'est l'ensemble des informations saisies lors de l'étape d'inscription.

- **Profil**  
    Est l'ensemble des informations publiées sous l'identité d'un *__Compte__*.

- **Membre**  
    Désigne l'entité rendu titulaire d'un *__Profil__* lors de sa création par l'intermédiaire de l'étape d'inscription.

#### Sécurité

Les concepts de sécurité actuellement implémentés sont la vérification d'activité et l'authentification basique.

- **Authentification**  
    Basique, combinaison d'un identifiant et d'un mot de passe.

- **Vérifications**  
    Par activité, le *__Membre__* possède la liste des 20 dernières activités de son *__Profil__*.

[GNU General Public License version 3]: http://www.gnu.org/licenses/gpl.txt "GNU General Public License Version 3"
[GNU Lesser General Public License version 3]: http://www.gnu.org/licenses/lgpl.txt "GNU Lesser General Public License Version 3"
[Creative Commons Attribution Share-Alike 3.0]: http://creativecommons.org/licenses/by-sa/3.0/ "Creative Commons Attribution Share-Alike 3.0"
[SIL Open Font License Version 1.1]: http://scripts.sil.org/cms/scripts/page.php?item_id=OFL_web "SIL Open Font License Version 1.1"
[Apache License Version 2.0]: http://www.apache.org/licenses/LICENSE-2.0.txt "Apache License Version 2.0"
[GNOME]: http://www.gnome.org/ "Gnome"
[KDE]: http://www.kde.org/ "KDE"
[OpenSans]: http://www.google.com/fonts/specimen/Open+Sans "Open Sans"
[Modern Pictograms]: http://johncaserta.com/modern-pictograms/ "Modern Pictograms"
[http://www.witzing.fr/]: http://www.witzing.fr/ "Witzing"
[doc]: doc
[AUTHORS.txt]: AUTHORS.txt
[GuWide]: GuWide.md
[APIFunctions]: APIFunctions.md
[APIDatas]: APIDatas.md
[COREFunctions]: COREFunctions.md
[COREDatas]: COREDatas.md

# csv-merge

## Prérequis

- PHP 7

## Description
Fusionner deux fichiers CSV en migrant une ou des données d'un fichier dans l'autre en se basant sur une clé présente dans les deux fichiers

## Usage
- Installer toutes les dépendances via Composer :
`composer install` ou `php composer.php install`

- Copier-coller le fichier `config.yaml.example` en le renommant `config.yaml` et en l'adaptant à votre cas.

Explications :
```yaml
filePath:
    receiver: "le fichier qui qui va contenir la donnée migrée.Ne pas oublier d'ajouter la colonne (si elle n'existe pas) qui va contenir la donnée."
    host: "le fichier qui contient déjà la donnée à migrer"
    merged: "le fichier final fusionné. Il peut-être vide et n'oubliez pas de le créer avant"
keyHeader:
    - {receiver: "la clé de comparaison dans le fichier receiver", host: "la clé de comparaison dans le fichier host"}
    - {receiver: "la deuxième clé de comparaison si vous jugez que la première ne risque pas de matcher", host: "idem"}
    (Ici vous pouvez ajouter autant de nouvelle ligne que de clés de comparaison)
migrationMapping:
    En-tête de le colonne contenant la donnée à migrer du fichier host: "En-tête de le colonne qui va contenir la donnée migrée dans le fichier receiver"
    headerHost2: "headerReceiver2"
    (Ici vous pouvez ajouter autant de nouvelle ligne que de paires de données à migrer)
```

- En ligne de commande faire : `php console.php file:merge config.yaml`





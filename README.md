# csv-merge

## Description
Fusionner deux fichiers CSV en migrant une ou des données d'un fichier dans l'autre en se basant sur une clé présente dans les deux fichiers

## Usage
- Créer un fichier Yaml de configuration appellé : config.yaml et contenant les infos adaptées à votre cas ci-dessous :

filePath:
    receiver: "testFilePath/receiver.csv"
    host: "testFilePath/host.csv"
    merged: "testFilePath/merged.csv"
keyHeader:
    - {receiver: "keyHeaderReceiver", host: "keyHeaderHost"}
    - {receiver: "keyHeaderReceiver2", host: "keyHeaderHost2"}
migrationMapping:
    headerHost1: "headerReceiver1"
    headerHost2: "headerReceiver2"

- En ligne de commande faire : php console.php file:merge config.yaml





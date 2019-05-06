# Technische Berufsschule Zürich Modul 300 Leitsungsbeurteilung 3

1. Persönlicher Wissensstand
   1. Microservice
   2. Containerisierung
   3. Docker
2. Multi Service Container Stack mit Docker-Compose
   1. Vorbereitungen Docker Install
   2. Vorbereitungen Docker Compose Install
   3. Verschiedene Services
      1. PiHole
      2. PHPmyAdmin
      3. mySQL
      4. Apache Server
      5. CadVisor
   4. Sicherheitsmassnahmen
      1. Überwachung
      2. Sicherheitsmassnahmen
         1. Massnahme 1
         2. Massnahme 2
         3. Massnahme 3
3. Tests
    1. Testfall 1
    2. Testfall 2
    3. Testfall 3
4. Vergleich Vorwissen und Wissenszuwachs
   1. Vorwissen
   2. Wissenszuwachs
5.  Reflexion


# Persönlicher Wissensstand
Persönlicher Wissenstand zu LB3

## Microservicess
Microservices sind ein Weg, Softwaresysteme so zu entwickeln und zu kombinieren, dass sie aus kleinen, unabhängigen Komponenten bestehen, die untereinander über das Netz interagieren. Das steht im Gegensatz zum klassischen, monolithischen Weg der Softwareentwicklung, bei dem es ein einzelnes, grosses Programm gibt.

## Containerisierung
Entwickler können Software lokal bauen, die woanders genauso laufen wird – sei es ein Rack in der IT-Abteilung, der Laptop eines Anwenders oder ein Cluster in der Cloud.

Administratoren können sich auf die Netzwerke, Ressourcen und die Uptime konzentrieren und müssen weniger Zeit mit dem Konfigurieren von Umgebungen und dem Kampf mit Systemabhängigkeiten verbringen.

## Docker
Docker ist ein Programm, das für die Containerisierung genutzt wird. Wenn man das Docker paket herunterlädt bekommt man man einige Features mitinstalliert die man ebenfalls nutzen kann. Docker liefert ein ganzes Set an neuen Kommandos die man sowohl auf der Kommandozeile als auch in Skripts und im Dockerfile nutzen kann. Es hat sehr viele Ähnlichkeiten zu Vagrant. Der grosse unterschied ist nur, dass Vagrant zur Virtualisierung genutzt wird.

# Multi Service Container Stack mit Docker-Compose
## Vorbereitungen Docker Install
Um Später mit dem eigentlichen Aufsetzen des Containers beginnen zu können müssen wir zwei kleine Vorbereitungen treffen. Als erstes die Docker pakete installieren,

First, in order to ensure the downloads are valid, add the GPG key for the official Docker repository to your system:
`curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -`

Add the Docker repository to APT sources:
`sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"`

Next, update the package database with the Docker packages from the newly added repo:
`sudo apt-get update`

Make sure you are about to install from the Docker repo instead of the default Ubuntu 16.04 repo:
`apt-cache policy docker-ce`

Finally, install Docker:
`sudo apt-get install -y docker-ce`

Docker should now be installed, the daemon started, and the process enabled to start on boot. Check that it's running:
`sudo systemctl status docker`

## Vorbereitungen Docker Compose Install
Curl installieren
`sudo apt-get install curl`

Run this command to download the current stable release of Docker Compose:
`sudo curl -L "https://github.com/docker/compose/releases/download/1.24.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose`

Apply executable permissions to the binary:
`sudo chmod +x /usr/local/bin/docker-compose`.


## Konfiguration der docker-compose Datei
In dieser Datei setzen wir nun alle Komnfigurationen fest die wir haben wollen. Am ende sieht diese datei so aus (Achtung! Da diese Datei die YAML Syntax nutzt, muss man auf Zeilenumbrüche und Einschläge besonders acht geben!):

![docker-compose.yml](lb3_screenshots/dockercomposeyaml2.PNG) 

## Verschiedene Services
Hier sind die verschiedenen Services aufgelistet welche nun in Container laufen.

### PiHole
Der Pi Hole Service ist nicht funktionsfähig

##### Container Pihole
Dieser Container beinhaltet die Applikation Pihole, welcher als lokaler DNS Server dient. 

| <tab>             | <tab>                                                       |
| ----------------- | ----------------------------------------------------------- |
| **Configuration** | Value                                                       |
| Container Name    | pihole                                                      |
| Image             | pihole/pihole:latest                                        |
| Ports             | 53:53/tcp , 53:53/udp , 67:67/udp , 80:80/tcp , 443:443/tcp |
| Volumes           | -                                                           |
| DNS               | 127.0.0.1, 1.1.1.1                                          |

![docker-compose.yml](lb3_screenshots/pihole.PNG)

### PHPmyAdmin
Der PHPmyAdmin service ist funktionstüchtig

##### Container phpmyadmin
Dieser Container beinhaltet PHP MyAdmin, welche auf den Contaienr db_mysql verlinkt ist. 

| <tab>             | <tab>                  |
| ----------------- | ---------------------- |
| **Configuration** | Value                  |
| container_name    | phpmyadmin             |
| Image             | phpmyadmin/phpmyadmin. |
| Ports             | 8080:80                |
| Volumes           | -                      |

![docker-compose.yml](lb3_screenshots/phpmyadmin.PNG)

### mySQL
mySQL Service ist auch betriebsbereit

##### Container DB
Dieser Container beinhaltet eine MySQL Datenbank

| <tab>               | <tab>     |
| ------------------- | --------- |
| **Configuration**   | Value     |
| Container Name      | db_mysql  |
| Image               | mysql:5.7 |
| Ports               | 9906:3306 |
| Volumes             | -         |
| MYSQL_ROOT_PASSWORD | 1234      |
| MYSQL_DATABASE      | dbteset   |
| MYSQL_USER          | dbuser    |
| MYSQL_PASSWORD      | 1234      |


![docker-compose.yml](lb3_screenshots/mysqlservice.PNG)

### Apache Server
Webserver/Apacheserver ist betriebsbereit

##### Container Web
Dieser Container beinhaltet einen Apache2 Webserver

| <tab>             | <tab>                 |
| ----------------- | --------------------- |
| **Configuration** | Value                 |
| container_name    | php_web               |
| Image             | php:7.2.2-apache      |
| Ports             | 8100:80               |
| Volumes           | ./php/:/var/www/html/ |


![docker-compose.yml](lb3_screenshots/phpstandardseite.PNG)

### cAdvisor
cAdvisor ist auch aufrufbar

##### Container cadvisor
Dieser Container beinhaltet das Überwachungstool Cadvisor. 

| <tab>             | <tab>                                                                                      |
| ----------------- | ------------------------------------------------------------------------------------------ |
| **Configuration** | Value                                                                                      |
| container_name    | cadvisor                                                                                   |
| Image             | google/cadvisor:v0.29.0                                                                    |
| Ports             | 8888:8080                                                                                  |
| Volumes           | /:/rootfs:ro ,/var/run:/var/run:rw ,  /sys:/sys:ro , /var/lib/docker/:/var , lib/docker:ro |

![docker-compose.yml](lb3_screenshots/cAdvisor.PNG)


## Der letzte Schritt
Nun, da wir alle Konfigurationen gemacht haben, können wir die Container starten. `docker-compose up`. Dabei darauf achten, dass wir im gleichen Verzeichnis sind, wie die docker-compose.yml Datei.

Wenn alles korrekt läuft, sehen wir nun folgende Seite, wenn wir im Browser auf unseren Server gehen.

![PHPIndex](lb3_screenshots/phpstandardseite.PNG)

## Sicherheitsmassnahmen
###  Überwachung
Software wie "Rancher" kann genutzt werden im die Container zu überwachen und Meldungen zu erzeugen.

### Sicherheitsaspekte & Sicherheitsmassnahme

#### Massnahme 1: Kernel Exploits
Um Kernel exploits zu verhindern wurden die zugewiesenen System Ressourcen festgelegt.

#### Massnahme 2: Vergiftete Images
Images werden nur von Docker Hub und Dockerverifizierte Sites geladen. Somit ist vereringert das Images Viren und weiteres beinhalten.

#### Massnahme 3: Benachrichtigungen
Mit Überwachungssoftware können überlastungen und anderes unnatürliches verhalten verhindert werden.


## Tests
### Testfall 1
__Titel:__ Start der Container

__Datum:__ 6.5.19

__Beschreibung:__ Die Container werden gestartet.

__Erwartetes Ergebnis:__ Die Erwartung ist, dass verschiedene Container erstellt werden und nachher aufrufbar sind.

__Eigenliches Ergebnis:__ Bis auf den pihole container können alle Container Starten.

![docker-compose.yml](lb3_screenshots/pihole.PNG)

### Testfall 2
__Titel:__ Stop der Container

__Datum:__ 6.5.19

__Beschreibung:__ Stoppen der Container.

__Erwartetes Ergebnis:__ Container werden gestoppt und können nacher wieder Gestartet werden.

__Eigenliches Ergebnis:__ Container werden erfolgreich gestoppt. (Ausgenommen der pihole container, welcher nicht starten kann)

![docker-compose.yml](lb3_screenshots/test2stop.PNG)

### Testfall 3
__Titel:__ Funktionalität

__Datum:__ 6.5.19

__Beschreibung:__ Container Services können via Browser erreicht werden.

__Erwartetes Ergebnis:__ Alle Services sind via Browser erreichbar.

__Eigenliches Ergebnis:__ Alle Containerservices sind erreichbar. Ausgenommen pihole

![docker-compose.yml](lb3_screenshots/test3funk.PNG)

# Vergleich Vorwissen und Wissenszuwachs & Reflexion
## Vorwissen
Mein Vorwissen zum Containerisierung war minimal. Aus geschäftsevents kurz angehaucht. Jedoch spielte ich schon längeren damit zuhause mal damit zu spielen.

## Wissenszuwachs
Ich konnte mit der Gitumgebung und den unterlagen gut mich an Containerisierung herantasten. Vagrant, Docker und vorallem das arbeiten mit Git ist mir sehr nützlich geworden. Das File managment mit git werde ich sicherlich weiterhin bei Projekten verwenden.

In der LB3 konnte ich mein Wissen in Docker sehr erweitern, da dies ebenfalls Neuland für mich war.

## Reflexion
In der LB3 konnte ich sehr viel lernen. So lernte ich die Funktionsweise von Docker und Docker-Compose. Ebenfalls lernte ich, wie mein ein docker-compose.yml file erstellt und definiert. Die Verknüpfungen von einzelnen Containern sowie auch das Angeben von Volumes war mir völlig neu. 

### Reflexion Modul
Ich habe sehr viel im Modul gelernt. Jedoch konnte ich aus persönlichen gründen nicht so viel Effizienz aufwenden um mich ganz mit dem Modul zu beschäftigen. Ich war in den Stunden unproduktiv und kam nicht voran. Vorallem hatte ich grosse Probleme mit Git und dem bereitgestellten netzwerk welche mich negativ beeinflussten.

Ich hätte besseres Leisten können und erwartete auch mehr als ich geleistet habe. Jedoch führte das Modul dazu, dass ich vielleicht auch meine Individuelle praktische arbeit mit containerisierung machen werde.

Auch Bedanke ich mich sehr bei meinen Mitschülern welche mich unterstütz haben und ihre Zeit und ihr Wissen mit mir geteilt haben.
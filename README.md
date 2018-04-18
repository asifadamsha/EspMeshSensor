# EspMeshSensor


Ce projet a pour but de créer une solution permettant de gérer un nombre variable de capteurs connectés sur des [Wemos D1 mini]( https://wiki.wemos.cc/products:d1:d1_mini) et communiquant sur une API web récupérant les différentes données reçues.


Les wemos destinées à la récupération des informations sont connectés sur un réseau ayant une topologie [Mesh](https://fr.wikipedia.org/wiki/Topologie_mesh)
 afin de transmettre des données dans une large zone pouvant être pertubée par des obstacles  tel que :
   * Des murs ;
   * Des portes ;
   * Etc.


 Le code de ces weemos est disponible dans le dossier [espMaster](./espMaster).

Une Wemos D1 mini aura un rôle plus central en faisant office de relai entre celles ayant des capteurs et l'API.

 Le code de cette weemos est disponible dans le dossier [espMaster](./EspMeshSensor).

 L'API recevant les différentes données se trouve dans le dossier [symfony4_admin_wemos](./symfony4_admin_wemos).


Libraries Arduino utilisées :
  * ESP8266WiFiMesh (communication sur le réseau Mesh);
  * ESP8266WiFi (communication WIFI);
  * DHT (Mesure des capteurs).

Bundle utilisées par l'API Symfony 4 :
  * Annotations ;
  * Twig ;
  * Profiler ;
  * Doctrine ;
  * Marker ;

Template utilisé pour le panel d'administration :
  * [Gentela](https://github.com/puikinsh/gentelella)

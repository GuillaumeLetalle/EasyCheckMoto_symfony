# EasyCheckMoto_symfony
Appli full symfony

Nom de la BDD: easycheckmoto
Création migration via entity: php bin/console make:migration
Creation table via migration : php bin/console doctrine:migrations:migrate
Lancement fixture: php bin/console doctrine:fixtures:load

- Chemin localhost:8000/technicien/login
      *log  admin:
 	         g.letalle
           TrucdeOuf

      *log technicien:
          tech1
          TrucdeOuf

- Chemin localhost:8000/client/login
          user1
          TrucdeOuf


Set up and run
1. Install dependencies: `composer install` 

1. Set to `.env` file mysql access url

1. Run migration: `php bin/console doctrine:migrations:migrate` 

1. Seed database by seed.sql

1. Start script with verbose `php bin/console app:worker -vvv`


What could be better, but not implemented, because is not part of real application, but could be done with requirement:
1. Pack application with dependencies to docker containers
1. Docker-compose file for comfortable local work
1. Dependency injection by interfaces (in some cases)
1. Unit and Integration tests 
1. Migration and seeding by an other container or framework tools
1. CI/CD with build, test, and deploy stages

This demo project is based on ddev and the general TYPO3 install guide
https://docs.typo3.org/m/typo3/tutorial-getting-started/main/en-us/Installation/Install.html#install

simple steps:
- ddev config --php-version 8.4 --docroot public --project-type typo3
-  ddev start

The composer file is already existing, thus a `composer install` is enough to get started.

To ensure functionality dev context is recommended:
`cp docker-compose.context.yaml .ddev/docker-compose.context.yaml`
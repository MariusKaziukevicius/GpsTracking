# GpsTracker
This project includes:
  - A public form that allows to add gps devices by latitude, longtitude.
  - A login page to get to the admin area
  - An admin area that has a map with all the devices shown as pins. Each pin also has a popup that shows more information. There is also an Add Device button that allows to enter a device id and then scrolls to it on the map, if such an id exists.

### Tech used
* [Symfony] - the crowd favorite php framework
* [jQuery] - the only way to use JavaScript
* [Leaflet] - a JavaScript library for interactive maps
* [Composer] - for managing php dependencies
* [npm] - for managing javascript dependencies
* [Webpack] - for optimizing  and including css/js assets

### Installation
After cloning the repository, install all dependencies:

```sh
$ composer install
$ npm install
```
Now let's edit the .env file with valid mysql login credentials.
If the database we entered in the .env file is not yet created, then we run:
```sh
$ php bin/console doctrine:database:create
```
Finally we create the database structure and build our assets:
```sh
$ php bin/console doctrine:schema:create
$ ./node_modules/.bin/encore production
```
That's it, the application is ready! Now either configure a custom apache/nginx server or the much easier option:
```sh
$ php bin/console server:run
```

### Cheatsheet
URLs:
```sh
/ - contains public form to add gps devices
/login - login page to access the admin area
/admin - the admin page that contains a map with all devices pinned and more info in popups
/logout - for logging out
```
Admin users(username:password):
```sh
PeterPan:NeverLand
SaturnV:apollo
Potter:hogwarts
```

### Final thoughts and todos
Here's a few things this project still lacks and also a few thoughts/changes I would implement:
 - Use nodejs to implement realtime communication between the form and the map, so that the pins can appear as soon as they are added. Without the need for refreshing the page.
 - Instead of hardcoding users straight into the configuration itself, hook up a user provider and store users in the db.
 - Add a frontend framework like bootstrap or foundation for some better looks.
 - Calculate which two devices are furthest apart.
 - Send an e-mail when added device is selected as "work".
 - Fix latitude and longtitude validation constraints. They currently exist in the project, but they've been disabled in the validator configuration, because some valid coordinates were being rejected.
 - Create a deeper folder structure for controllers/templates and etc., to separate different parts of the site and functionality.
 - Add a Dockerfile for easy development environment setup.
 - Write unit tests.

License
----

MIT

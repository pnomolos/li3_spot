li3\_spot offers integration between [the most RAD PHP framework] [lithium]
and possibly the best PHP 5.3 ORM out there: [Spot] [spot]

# License #

li3\_spot is released under the [BSD License] [license].

# Installation #

It is recommended that you install li3\_spot as a GIT submodule, in order
to keep up with the latest upgrades. To do so, switch to the core directory
holding your lithium application, and do:

```bash
$ git submodule add https://github.com/pnomolos/li3_spot.git libraries/li3_spot
$ cd libraries/li3_spot
$ git submodule update --init --recursive
```

# Usage #

## Adding the li3\li3_spot library ##

Once you have downloaded li3\li3_spot and placed it in your main `libraries`
folder, or your `app/libraries` folder, you need to enable it by placing the 
following at the end of your `app/config/bootstrap/libraries.php` file:

```php
Libraries::add('li3_spot');
```

## Defining a connection ##

Setting up a connection with li3\_spot is easy. All you need to do is
add the following to your `app/config/bootstrap/connections.php` file (make
sure to edit the settings to match your host, without altering the `type`
setting):

```php
Connections::add('default', array(
	'type' => 'Spot',
	'driver' => 'mysql',
	'host' => 'localhost',
	'user' => 'root',
	'password' => 'password',
	'dbname' => 'my_db'
));
```

## Working with models ##

### Creating models ###

Models should be extended from 

```php
\li3_spot\models\Model
```

[lithium]: http://lithify.me
[spot]: https://github.com/vlucas/Spot/
[license]: http://www.opensource.org/licenses/bsd-license.php
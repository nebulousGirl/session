CHANGELOG
-------------
### Opis Session 2.3.0, 2014.11.23

* Added an autoload file.
* Changed how the `regenerate` method in `Opis\Session\Session` works. If the argument passed
to the method is `true` the the old data are kept, otherwise the old data are deleted.

### Opis Session 2.2.1, 2014.11.16

* Fixed a bug in `Opis\Session\Storage\Redis`

### Opis Session 2.2.0, 2014.10.23

* Updated `opis/database` library dependency to version `2.0.*`

### Opis Session 2.1.0, 2014.06.26

* Updated `opis/database` library dependency to version `1.3.*`

### Opis Session 2.0.0, 2014.05.27

* Started changelog
* Removed `Opis\Session\SessionStorage` class
* Removed `Opis\Session\SessionInterface` interface
* Removed `Opis\Session\Storage\Native` class
* Modified `Opis\Session\Session` constructor.
    You can now set various options like session name, cookie domain, path or cookie lifetime
* Added a destructor method to Opis\Session\Session class
* Added new method `set` to `Opis\Session\Session`
* Added new method `load` to `Opis\Session\Session`
* Added new method `delete` to `Opis\Session\Session`
* Deprecated `remember` method in `Opis\Session\Session`
* Deprecated `forget` method in `Opis\Session\Session`
* Deprecated `dispose` method in `Opis\Session\Session`
* Added new method `load` to `Opis\Session\Flash`
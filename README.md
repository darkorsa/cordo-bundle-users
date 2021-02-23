# cordo-bundle-users

Users bundle for [Cordo microframework](https://github.com/darkorsa/cordo).

## Install

Go to your [Cordo](https://github.com/darkorsa/cordo) project folder root dir and type:

``` bash
$ composer require darkorsa/cordo-bundle-users
```

Next register bundle install command in `./cordo` file:

``` php
$application->add(new \Cordo\Bundle\Users\InstallCommand($container));
```

and execute command:

``` bash
$ php cordo cordo-bundle-users:install <context>
```

where `<contex>` is your context in which you wish to install this bundle, for example: `Client`, `Shop`, `Backoffice`, etc.

That command will:
* copy all the files to your `./app/<context>` folder
* update `./app/Register.php` file
* create the DB schemas

Great! Users bundle now is installed and ready to use.

## Security

If you discover any security related issues, please email dkorsak@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

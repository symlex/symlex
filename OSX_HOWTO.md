How to install PHP, Composer and Docker on Mac OS X
===================================================

Mac OS X is shipped with outdated PHP versions. You can download the latest version from [Liip](https://php-osx.liip.ch/).

After installing a custom PHP version, you must add its path to `~/.bash_profile`:

```
export PATH="/usr/local/bin:/usr/local/php5/bin:$PATH"
```

Composer is available for download at https://getcomposer.org/download/ (follow the instructions). Please add `/usr/local/bin` to your path in `~/.bash_profile` and move composer there instead of keeping composer.phar in your local project directory:

```
sudo mv composer.phar /usr/local/bin/composer
```

Docker - a free tool that provides easy-to-use container virtualization - is available for download at https://download.docker.com/mac/stable/Docker.dmg

To work with JavaScript, you should also install [NodeJS](https://nodejs.org/en/download/) (includes npm), [Bower](https://bower.io/) and other common tools like RequireJS:

```
sudo npm install -g bower requirejs
```

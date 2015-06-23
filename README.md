# About

Simple PHP class for authenticating with the Snapchat™ API.

# Installing

* `sudo apt-get -y install php5-dev`
* `git clone https://github.com/allegro/php-protobuf.git`
* `cd php-protobuf`
* `phpize`
* `./configure`
* `make`
* `make test`
* `sudo make install`

### Adding the module to php5-fpm

* `sudo vi /etc/php5/fpm/conf.d/20-protobuf.ini`  
Add the following line to the file: `extension=protobuf.so`
* `sudo service php5-fpm restart`

### Adding the module to Apache2's PHP

* `sudo vi /etc/php5/apache2/conf.d/20-protobuf.ini`  
Add the following line to the file: `extension=protobuf.so`
* `sudo service apache2 restart`

Tested on Debian 8.1, your mileage may vary, submit an issue if you encounter a problem.

# License

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see http://www.gnu.org/licenses/

# Credits

* [php-protobuf](https://github.com/allegro/php-protobuf) - allegro
* liamcottle
* billybobs

# Disclaimer

This project is in no way affiliated with or endorsed by Snapchat™.

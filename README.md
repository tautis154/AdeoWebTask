# About
Adeo Web PHP Developer task\
Weather information is taken from LHMT API:​ https://api.meteo.lt/. \
Tautvydas Rušas

# Project description
Project is done on the Symfony framework. Using PHP.

# How to use it
Download the project.

> git clone https://github.com/tautis154/AdeoWebTask

Go into the cloned directory

> cd AdeoWebTask

Install dependencies using composer.

> composer update

Execute migrations in order to set up database for the project.

> bin/console doctrine:migrations:migrate

Generate fixture data.

> bin/console doctrine:fixtures:load

Now open in browser: http://127.0.0.1:8001/api/products/recommended/vilnius

# How it works
- User can decide which city he wants to enter in this url: http://127.0.0.1:8001/api/products/recommended/{city name}
- After entering the city he is presented with a current date and two upcoming ones
- Each date has the weather condition that is likely happen on that day which is gathered from an API
- Each date has 2 products are that are recommended for the weather on that date
# Problems
- In the program logic after a month passes it's maximum days the following date doesn't go to the next month
- In the program logic after a year passes it's maxomum months the following date doesn't go to the next year and reset the months

# Contacts
tautis63@gmail.com\
+37067987256

# Thanks for your attention

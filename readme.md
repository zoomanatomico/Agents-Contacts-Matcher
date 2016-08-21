# Agents Contacts Matcher

Agents Contact Matcher is an app to match the nearest Agent to each contact provided by a CSV file.
A short video of the demo can be found [here](http://recordit.co/i9Lk5azpfv)

##  [Transducers](https://github.com/mtdowling/transducers.php)
Used to optimize the iterations of the CSV file, Transducers help to reduce memory consumption in PHP bucles.
more info about this [here](http://blog.cognitect.com/blog/2014/8/6/transducers-are-coming)

##  [Guzzle](https://github.com/guzzle/guzzle)
De facto standard to make http calls in PHP, in this case I used it to make GET calls to [http://zipcodeapi.com/](http://zipcodeapi.com/)

##  [THE PHP LEAGUE - CSV](https://github.com/thephpleague/csv)
To load the csv file in an easy way

## TODOS
1. Add Behat to make behavior-driven testing for future features.
2. Add integration tests for reading the CSV file and for calling the zipcodeapi API.
3. Improve UI by adding Bootstrap and AngularJS
4. Better handling exceptions when calling the zipcodeapi API, for example what to do when the zip code doesn't exist because right now only the string "Error" is present when something weird happens in the call.

## Important Folders & Files
1. **app/Calculators/**
2. **app/Http/MainController.php**
3. **app/Matchers/**
4. **app/Readers/**
5. **app/ValueObjects**
6. **app/AgentsContactsMatchersTest.php**
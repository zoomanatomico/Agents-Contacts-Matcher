# Agents Contact Matcher

Agents Contact Matcher is an app to match the nearest Agent to each contact provided by a CSV file.


![alt tag](http://g.recordit.co/HzNHusmDLx.gif)

##  [Transducers](https://github.com/mtdowling/transducers.php)
Used to optimize the iterations of the CSV file, Transducers help to reduce memory consumption in PHP bucles.
more info about this [here](http://blog.cognitect.com/blog/2014/8/6/transducers-are-coming)

##  [Guzzle](https://github.com/guzzle/guzzle)
De facto standard to make http calls in PHP, in this case I used it to make GET calls to [http://zipcodeapi.com/](http://zipcodeapi.com/)

##  [THE PHP LEAGUE - CSV](https://github.com/thephpleague/csv)
To load the csv file in an easy way

## Improvements
1. Cache the response of the API call.
2. Add Behat to make behavior-driven testing for future features.
3. Add integration tests for reading the CSV file and for calling the zipcodeapi API.
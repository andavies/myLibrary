------------------------------------------
'myLibrary' - a website that allows users to share and lend books in their local community  
Originally my final project for the Harvard University course CS50 (cs50.harvard.edu)

Andrew Davies
originally submitted 15/12/15
------------------------------------------

TODO in next version:

FEATURES:

- add ability to request books through the site (instead of user emailing manually)
- add groups/regions so that the site can be used across different locations (see public/request.php)

BUGS:

- some books not found on isbn search eg. "The Demolished Man 9781407239934" - why? 
- json_decode() issue. For example The Dark Tower 9780340829752 is returned correctly by API but 
  json_decode() doesn't work. Why??

UPDATE 25/05/16:

Seems there may be an issue with the Google Books API not being maintained (https://productforums.google.com/forum/#!topic/books-api/R5DvlRh-EKo), which might scupper this project altogether!





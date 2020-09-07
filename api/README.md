# Corporate Contact API
We use the following PHP files to access our database. We will also include what key/value pairs (case-sensitive) each is expecting in the form of a JSON object.

## Login.PHP
This file handles login requests. It expects the following keys:
- **username** - The account's username.
- **password** - The account's password.

## createUser.PHP
This file handles the creation of new user accounts. It expects the following keys:
- **username** - The account's desired username. Note that the username is unique, so if it already exists in the database, the account creation will fail.
- **password** - The account's desired password.
- **name** - The user's preferred name.
- **companyName** - The user's company name.
- **position** - The user's job position.
- **address** - The user's address.
- **email** - The user's e-mail address.
- **phone** - The user's phone number.

## addContact.PHP
This file handles creating new contacts for users. It expects the following keys:
- **userId** - The account's user ID to associate the new contact with.
- **contactName** - The contact's name.
- **companyName** - The contact's company name.
- **address** - The contact's address.
- **email** - The contact's e-mail address.
- **phone** - The contact's phone number.

## Delete.PHP
This file handles removing contacts for users. It expects the following fields.
- **idArr** - An array of contact IDs. These should be fetched when the user selects contacts to remove when accessing his/her contacts table.

## Search.PHP
This file handles searching for contacts. This is a work-in-progress.

### Old

- Login.php will likely be what the finish login api is based off of.  Currently tests to see if database is connected and can read out the login info.
  When frontend is connected it will check to see if inputted data and database match.
- userLogin.php was used to test if all username was used to see if all usernames could be read, probably useless as passwords cant be read
  possibly due to being too large for php array.
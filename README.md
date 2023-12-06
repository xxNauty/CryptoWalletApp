# CryptoWalletApp
## Description
This app was designed to help you with simulation of your investments at Cryptocurrency market. 
If you want to start investing, but you don't know how market works, you can virtually buy some 
currencies, and take a look how it's value changes over time. You can check which currencies are 
the best for you, determining the degree of risk for currencies you are interested in. 

---

## How it works?

### Set up container
This app is build using Docker containers. So, in order to run it you'll have to install Docker engine. \
The next step is to download this repo: ``git clone git@github.com:xxNauty/CryptoWalletApp.git``. After that, go to the folder
``docker`` and run this command:

```bash
docker compose --env-file=../src/.env up
```

After few minutes, you'll have working application, so you can start working with it using for example Postman application.

### Database 
If you want to look into the database, just type this command into your terminal:

```bash
psql postgresql://postgres:password@127.0.0.1:15432/database
```

---

## Api documentation

### Create user

``/api/users/create``

```json
{
    "firstName": "Jan",
    "lastName": "Kowalski",
    "email": "Jan@Kowalski.pl",
    "password": "Qwerty123",
    "currency": "PLN"
}
```
The currency field is the field in which user wants to see all prices and values(**not implemented yet**).
This endpoint is available for everyone, authorization not required.

### Update user

``/api/users/update/{id}``

```json
{
    "firstName": "Jan",
    "lastName": "Kowalski",
    "email": "Jan@Kowalski.pl",
    "password": "Qwerty123",
    "currency": "PLN"
}
```

In this endpoint you cannot change your password, because it is used here for security reasons. Before update, it is compared
with password in database, and only if it's correct, update will be made. You don't have to pass all of these fields. Only fields you want
to update, and correct password is required. 

### Change user password

``/api/users/password``

```json
{
    "password": "Qwerty123",
    "newPassword": "Qwertyuiop"
}
```

Password field is current password. 












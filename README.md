# CryptoWalletApp

This app allows You to execute simple simulations on cryptocurrency market. You can make your account, virtually buy 
some cryptocurrency and see how the market works. 

## 1. Make your account

```shell
curl -X 'POST' \
  'http://localhost/api/users' \
  -H 'accept: application/ld+json' \
  -H 'Content-Type: application/ld+json' \
  -d '
  {
  "email": "user@example.com",
  "firstName": "string",
  "lastName": "string",
  "password": "string123"
  }
'
```

## 2. Check currently available cryptocurrencies

```shell
curl -X 'GET' \
  'http://localhost/api/currencies?page=1' \
  -H 'accept: application/ld+json'
```

## 2.1. Or get data of one chosen currency

```shell
curl -X 'GET' \
  'http://localhost/api/currencies/{id}' \
  -H 'accept: application/ld+json'
```

## 3. Get USD to other currencies ratios
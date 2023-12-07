## Normal
### DATABASE_URL
```bash
psql postgresql://postgres:password@127.0.0.1:15432/database
```

### DOCKER COMMAND(normal start)
```bash
docker compose --env-file=../src/.env up
```

---

## Test
### DATABASE_URL
```bash
psql postgresql://postgres:password@127.0.0.1:15432/test_db
```

### DOCKER COMMAND
```bash
docker compose --env-file=../src/.env.test up
```

---

## Commands
### CODETEST
```bash
composer codetest
```

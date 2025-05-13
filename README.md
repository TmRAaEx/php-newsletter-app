# CodeIgniter Newsletter App

Det här projektet är en CodeIgniter-applikation som körs i Docker. Den använder **MariaDB** som databas och **phpMyAdmin** för att hantera databasen. Följ stegen nedan för att sätta upp och köra applikationen.

---

## Förutsättningar

Innan du börjar, se till att följande är installerat på din dator:

- **Docker**  
  [Installera Docker](https://docs.docker.com/get-docker/)
- **Docker Compose**  
  [Installera Docker Compose](https://docs.docker.com/compose/install/)

---

## Installera och köra applikationen

Följ dessa steg för att bygga och starta applikationen:

### 1. Klona projektet

Om du inte redan har klonat projektet, gör det med följande kommando:

```bash
git clone <repository-url>
cd <project-directory>
```

### 2. Bygg Docker-imagen

Bygg Docker-imagen för PHP-applikationen genom att köra följande kommando i projektets rotmapp:

```bash
docker build -t php-local:local .
```

Detta kommando bygger din PHP-applikation med Apache och alla nödvändiga beroenden.

### 3. Starta containrarna med Docker Compose

När bilden är byggd, starta alla tjänster med Docker Compose:

```bash
docker compose -p php up
```

Detta kommando startar de tre tjänsterna som definieras i Docker Compose:

- **MariaDB (db):** Databastjänsten som används av applikationen.  
- **phpMyAdmin (phpmyadmin):** Ett webbaserat gränssnitt för att hantera databasen.  
- **PHP-applikationen (site):** Din CodeIgniter-applikation som körs på Apache.

### 4. Åtkomst till applikationen

När containrarna har startat kan du nå applikationen på följande adresser:

- **CodeIgniter Applikation:** [http://localhost:8080](http://localhost:8080)  
- **phpMyAdmin:** [http://localhost:8081](http://localhost:8081)

---

## Felsökning

Om du stöter på problem, kontrollera följande:

- Är Docker och Docker Compose korrekt installerade?  
- Är portarna 8080 och 8081 lediga på din dator?  
- Kontrollera loggarna för containrarna med:  
  ```bash
  docker compose logs
  ```

---

## Licens

Det här projektet är licensierat under [MIT-licensen](LICENSE).
# arc-books

#### Briefly introduce the directory structure main
```
∝ - App/- App Code Catalog
│∝ -- Common/-- Some class beans with independent functions (DB, Log, Model, etc.)
│∝ - Console/- Command line code directory (script directory)
│∝ - Exception/---- Define exception class directory
││└ - Handler/---- Define exception handling class directory
│∝ -- HTTP/-- HTTP Service Code Catalog
│   │   ├── Controller/
│   │   └── Middleware/
│∝ - Helper/---- Assistant Function
│∝ - Listener/- Event listener directory
│∝ - Model/---- Code directory for models, logic, etc
│   │   ├── Dao/
│   │   ├── Logic/
│   │   └── Entity/
│∝ -- Rpc/-- RPC Service Code Catalog
│   │   └── Service/
│   │   └── Middleware/
│∝ - Validator/- Logical Validator
│∝ - Application. php - Application class files inherit from the swoft core
│∝ - Autoloader. php - Project scanning and other information (the application itself is also considered a component)
│   └── bean.php
├── bin/
│   ├── bootstrap.php
│└-- swoft -- Swoft Entry File
∝ - config/- Application configuration directory
│∝ - base.exe - Basic Configuration
│└ - db.chp - Database Configuration
∝ - runtime/- temporary file directory (logs, uploaded files, file cache, etc.)
└── composer.json
```

#### How to start a project, code testing and debugging
Service startup Docker compose up
The main/app/console/Command/TestCommand. php provides a simple example of a mock call to a method;
docker exec -it books php bin/swoft test:test
RPC service mode, communication requires interface calling, service implementation example; The above methods can be used to debug and verify existing methods;

#### MySQL is chosen as the database server for this design;
Choosing MySQL database for PHP development is because MySQL has significant advantages in terms of usability, performance, cost, security, and scalability.
Simple installation and configuration, rich documentation and community support, multiple storage engines, fast query speed, and concurrent processing capabilities;

#### Project implementation ideas and technologies used
The considerations for high concurrency are as follows:
1. Limit the number of visits, such as allowing one visit within five seconds,
2. Use Redis cache. Ensure high availability of Redis and avoid avalanches, penetrations, etc. For example, for the current sales statistics, considering a one month expiration time, calculate the sales volume within the month;
   
The following design has been made for high load:
1. Use Redis for caching and calculating ranking data, cleverly utilizing the sorting concept of ordered sets.
2. Pre Calculation: Update the sales ranking in a timely manner after book sales, rather than calculating in real-time.
3. Asynchronous processing: After ensuring the consistency and persistence of sales information, message queues or asynchronous tasks can be used to process ranking updates in the future to avoid blocking HTTP requests
4. The use of Docker provides faster replication convenience for high concurrency deployment. In distributed deployment, high availability load balancing is achieved through service expansion
5. Optimize queries: optimize database queries by using indexes, etc
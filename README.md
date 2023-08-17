# Installation


- Move the source code to your PHP Local Development Server.
  > As for **WAMP Server**. i'll be <code>path/to/wamp64/www/</code>

- Execute the **SQL Queries** provided with the source code in order to create the required database tables and insert and default admin user.
  > Please find  the <code>testdb.sql</code> file in <code>path-to-project-root/testdb.sql</code>

- Update the <code>.env</code> file in the project root directory with your credentials.
  > <code>APP_URL=http://localhost8080/  DB_CONNECTION=mysql  DB_HOST=localhost  DB_PORT=3306  DB_DATABASE=testdb  DB_USERNAME=root  DB_PASSWORD=  DB_CHARSET=utf8mb4</code>
  
- Run this command in the project root directory.
    > <code>php -S localhost:8080 -t public</code>

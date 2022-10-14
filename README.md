# DeepEZ
A life assistant app to help people with their everyday tasks

## How to install
1. Build and run docker containers:
    ```bash
    docker-compose up -d --build
    ```

2. Install project dependencies by running:

    Connect to the symfony container
    ```bash
        docker exec -it deepez_symfony bash
    ```

    and install project dependencies from inside
    ```bash
        composer install
    ```

3. Setup the database from inside the Symfony container


    Create the database :
    ```bash
        symfony console doctrine:database:create
    ```

    Update the schema :
    ```bash
        php bin/console doctrine:schema:update
    ```

    [Optional] Install datafixtures to create admin ready user accounts :
    ```bash
        php bin/console doctrine:fixtures:load
    ```

    Install eventual database migrations :
    ```bash
        symfony console doctrine:migrations:migrate
    ```

4. Now you should be able to access the website from your browser on 
http://localhost/

## What you can do from inside the symfony container ?
- Manage dependencies via **Composer**
- Use Symfony commands via `php bin/console` commands or with the **Symfony CLI** via `symfony console`
- Execute **Symfony CLI** specific commands


## Upcoming features
- Planner
- TODO list manager
- Password manager

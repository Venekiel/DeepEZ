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

3. Install database migrations
    
    From insdie the Symfony container:
    ```bash
        php bin/console doctrine:migrations:migrate
    ```
    **OR** 
    ```bash
        symfony console doctrine:migrations:migrate
    ```

4. Load project fixtures

    From inside the container:
    ```bash
        php bin/console doctrine:fixtures:load
    ```
    **OR** 
    ```bash
        symfony console doctrine:fixtures:load
    ```

3. Now you should be able to access the website from your browser on the following url:
http://localhost/


## What you can do from inside the symfony container ?
- Manage dependencies via **Composer**
- Use Symfony commands via `php bin/console` commands or with the **Symfony CLI** via `symfony console`
- Execute **Symfony CLI** specific commands
- Manage project versionning with **GIT** (coming soon)


## Upcoming features
- Planner
- TODO list manager
- Password manager

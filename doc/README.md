# Arquitectura Bàsica

* **Back-end (servidor)**: Utilitzem Laravel com a API per gestionar la comunicació amb una base de dades. Aquesta API és responsable de servir tota la informació que necessita el front-end, així com de gestionar operacions com la creació, lectura, actualització i eliminació de dades (CRUD). Per un altre banda també utilitzem Node.js amb Socket.IO per a l'actualització de les dades a temps real. Aquesta arquitectura no gestiona dades sensibles dels clients.

* **Front-end (client)**: Utilitzem Vue 3 per gestionar la interfície d'usuari. Vue s'encarrega de la part interactiva i visual de l'aplicació, proporcionant una experiència d'usuari dinàmica i reactiva.
* **Part d'Administració**: Laravel també s'utilitza per a la part d'administració, on es permet als usuaris gestionar el CRUD dels productes (afegir, editar, eliminar i visualitzar productes) a través d'una interfície.

## Tecnologies
* **Vue 3**: Framework JavaScript per crear interfícies d'usuari reactives i components reutilitzables.
* **Laravel 11**: Framework PHP que facilita el desenvolupament d'aplicacions web robustes, amb una sintaxi elegant i orientada a objectes.
* **Node.js**: Entorn d'execució de JavaScript del costat del servidor que permet crear aplicacions escalables i eficients. Basat en el motor V8 de Google, Node.js és conegut per la seva arquitectura asíncrona i basada en esdeveniments, ideal per a aplicacions amb necessitats d'entrada/sortida intensives.
* **JavaScript**: Llenguatge de programació utilitzat per afegir interactivitat i comportament a l'aplicació al front-end.
* **CSS**: Utilitzat per estilitzar la interfície d'usuari, millorant la presentació visual de l'aplicació.
* **PHP 8**: Llenguatge de programació utilitzat al back-end, especialment per a Laravel.
* **HTML**: Llenguatge de marcat per estructurar les pàgines web al front-end.

## Plugins
* Per fer proves i verificar que la comunicació amb l'API funcioni correctament quan es realitzen peticions HTTP, hem utilitzat:
   * **Thunder Client**: Plugin de VS Code que permet realitzar peticions HTTP des de l'editor.
   * **Postman**: Eina per provar APIs de manera fàcil i visual, permetent enviar peticions HTTP i veure les respostes.

## Com Desplegar l'Aplicació a l'Entorn de Desenvolupament
Segueix aquests passos per configurar i executar l'aplicació en un entorn de desenvolupament:

1. **Instal·lació de Dependències**:
   * Accedeix al directori back/Syncblend-Laravel i executa composer install per instal·lar totes les dependències necessàries per a Laravel.

2. **Configuració de l'Arxiu .env**:
   * Crea una còpia de l'arxiu .env.example i anomena'l .env.
   * Dins del .env, defineix les configuracions de la base de dades descomentant i ajustant les següents línies:
     
```env
DB_HOST=el_teu_host
DB_PORT=el_teu_port
DB_DATABASE=el_nom_de_la_teva_base_de_dades
DB_USERNAME=el_teu_usuari
DB_PASSWORD=la_teva_contrassenya
```
   * Substitueix el_teu_host, el_teu_port, el_nom_de_la_teva_base_de_dades, el_teu_usuari i la_teva_contrassenya pels valors corresponents del teu entorn.

3. **Iniciar el Servei del Servidor de Base de Dades**:
   * Assegura't que el servei de la base de dades (per exemple, MySQL o MariaDB) estigui en funcionament i crea la base de dades especificada al fitxer .env.

4. **Migracions, Generació de Clau i Inserció de Dades**:
   * Per configurar les taules a la base de dades, genera la clau de l'aplicació i insereix dades de mostra:
      * php artisan key:generate: Genera una clau única per a l'aplicació en l'arxiu .env, necessària per a la seguretat.
      * php artisan migrate:rollback: Esborrarà totes les taules existents si n'hi ha, preparant la base de dades per començar de nou.
      * php artisan migrate:reset: Alternativa a rollback que elimina les migracions aplicades i deixa la base de dades com si fos nova.
      * php artisan migrate: Crea les taules a la base de dades segons les migracions definides.

5. **Neteja de Caché**:
   * Per evitar problemes de configuració i garantir que es carreguin els últims canvis, neteja el caché amb aquests camandes:
      * php artisan config:clear: Neteja la caché de la configuració.
      * php artisan view:clear: Neteja la caché de les vistes de Blade.
      * php artisan cache:clear: Neteja la caché general de l'aplicació.

6. **Iniciar el Servidor de Laravel**:
   * Per executar l'aplicació i accedir a ella des del teu navegador, inicia el servidor de desenvolupament de Laravel amb:
     
```bash
php artisan serve
```
   * Per producció, pot ser més adient configurar un servidor web com Nginx o Apache.

## Com Desplegar Node.js en Entorn de Desenvolupament
1. **Instal·lació de Node.js**:
   * Descarrega i instal·la Node.js des de [nodejs.org](https://nodejs.org/).

2. **Iniciar el Servidor Node.js**:
   * Accedeix al directori del projecte que utilitza Node.js.
   * Executa la següent comanda per iniciar l'aplicació en mode desenvolupament:
     ```bash
     node app.js
     ```
     o si utilitzes un gestor de tasques com `nodemon`, pots iniciar-lo amb:
     ```bash
     npx nodemon app.js
     ```

3. **Configuració del Port**:
   * Assegura't que el port especificat al fitxer de configuració o al codi (`process.env.PORT` o un port per defecte, com ara 3000) estigui disponible.

4. **Verifica la Connexió**:
   * Accedeix a l'aplicació des del navegador utilitzant l'URL corresponent, com `http://localhost:3000`.


### Desplegar amb Docker Compose en desenvolupament

Si vols desplegar l'aplicació utilitzant Docker, segueix aquests passos per configurar i executar l'aplicació de manera senzilla utilitzant Docker Compose. Aquest mètode ja inclou tot el necessari per a l'entorn de desenvolupament (base de dades, Laravel, Node.js, etc.), excepte la configuració de ports.

1. **Instal·lació de Docker i Docker Compose**:
   * Abans de començar, assegura't que tens Docker i Docker Compose instal·lats al teu sistema. Pots descarregar-los des de:
     * [Docker](https://www.docker.com/get-started)
     * [Docker Compose](https://docs.docker.com/compose/install/)
     * [Docker Desktop](https://www.docker.com/products/docker-desktop): (per a usuaris de Windows i Mac)


2. **Configuració del fitxer `.env`**:
   * Abans de començar, assegura't de configurar el fitxer `.env` amb les teves dades de la base de dades i altres configuracions específiques. El fitxer `.env` ja està present dins del projecte, però has de verificar les configuracions de la base de dades:
     ```env
     DB_HOST=db
     DB_PORT=3306
     DB_DATABASE=el_nom_de_la_teva_base_de_dades
     DB_USERNAME=el_teu_usuari
     DB_PASSWORD=la_teva_contrassenya
     ```
     * **Nota**: `DB_HOST` es refereix al servei de base de dades que es definirà dins de Docker Compose com a `db`.

3. **Iniciar el projecte amb Docker Compose**:
   * Des del directori arrel del projecte (on es troba el fitxer `docker-compose.yml`), executa la següent comanda per iniciar tots els serveis (laravel, node.js i base de dades) de manera automàtica:
     ```bash
     docker-compose up -d
     ```
     Aquesta comanda descarregarà les imatges necessàries i iniciarà els contenidors en segon pla.

4. **Migracions i configuració inicial**:
   * Un cop el contenidor de Laravel estigui en funcionament, pots executar les migracions per configurar les taules de la base de dades. Executa aquesta comanda per accedir al contenidor de Laravel i realitzar les migracions:
     ```bash
     docker-compose exec app bash
     php artisan migrate
     php artisan key:generate
     ```
     Això generarà la clau d'aplicació i crearà les taules a la base de dades.

5. **Accés a l'aplicació**:
   * Un cop els serveis estiguin en funcionament, pots accedir a l'aplicació a través del navegador mitjançant l'URL configurat. Recorda que hauràs de configurar els ports a l'arxiu `docker-compose.yml` segons els teus requisits.

6. **Parar els serveis**:
   * Si necessites aturar l'aplicació i tots els serveis associats, executa:
     ```bash
     docker-compose down
     ```

### Desplegar Vue 3 en Producció

1. **Construir l'Aplicació per a Producció**:
    * Accedeix al directori del projecte Vue:
      ```bash
      cd front
      ```
    * Executa la següent comanda per generar els arxius optimitzats per a producció:
      ```bash
      npm run build
      ```
    * Això generarà una carpeta `dist/` amb tots els arxius optimitzats.

2. **Pujar els Fitxers al Servidor**:
    * Puja el contingut de la carpeta `dist/` al servidor dins de la carpeta `public_html` o la ubicació on es vol desplegar l'aplicació.

3. **Configuració d'un Servidor Web (Nginx o Apache)**:
    * Si utilitzes Nginx, configura un virtual host:
      ```nginx
      server {
          listen 80;
          server_name el_teu_domini.com;
 
          location / {
              root /var/www/html/front-end/dist;
              index index.html;
              try_files $uri /index.html;
          }
      }
      ```
    * Si utilitzes Apache, crea o modifica `.htaccess` dins `dist/`:
      ```apache
      <IfModule mod_rewrite.c>
          RewriteEngine On
          RewriteBase /
          RewriteRule ^index\.html$ - [L]
          RewriteCond %{REQUEST_FILENAME} !-f
          RewriteCond %{REQUEST_FILENAME} !-d
          RewriteRule . /index.html [L]
      </IfModule>
      ```

4. **Assegurar-se que el Servei està en Funcionament**:
    * Reinicia el servidor web per aplicar els canvis:
      ```bash
      sudo systemctl restart nginx  # Per Nginx
      sudo systemctl restart apache2  # Per Apache
      ```
    * Accedeix a l'URL corresponent (`http://el_teu_domini.com`) per verificar que l'aplicació Vue 3 està funcionant correctament.

Ara l'aplicació Vue 3 estarà desplegada correctament en producció.


## Com Mantenir el Port Obert de NodeJS en Producció
Per mantenir obert el port de Node.js en producció, segueix aquests passos:

1. **Instal·lació de `pm2`**:
   * `pm2` és un gestor de processos que ajuda a mantenir les aplicacions de Node.js en funcionament.
   * Instal·la `pm2` globalment:
     ```bash
     npm install -g pm2
     ```

2. **Iniciar l'Aplicació amb `pm2`**:
   * Inicia l'aplicació amb la comanda:
     ```bash
     pm2 start app.js
     ```
   * Per assegurar que l'aplicació es reinicia automàticament després d'un reinici del servidor:
     ```bash
     pm2 startup
     ```

3. **Supervisió i Gestió**:
   * Consulta l'estat de les aplicacions:
     ```bash
     pm2 list
     ```
   * Per veure els registres:
     ```bash
     pm2 logs
     ```
   * Per reiniciar l'aplicació:
     ```bash
     pm2 restart app.js
     ```

4. **Configuració del Tallafocs**:
   * Obre el port del servidor per permetre l'accés des de l'exterior. Per exemple, amb `ufw` (Ubuntu Firewall):
     ```bash
     sudo ufw allow 25000
     ```

5. **Configuració del Domini (Opcional)**:
   * Utilitza un servidor web com Nginx per servir l'aplicació Node.js darrere d'un proxy invers, per exemple:
     ```nginx
     server {
         listen 80;
         server_name el_teu_domini.com;

         location / {
             proxy_pass http://localhost:3000;
             proxy_http_version 1.1;
             proxy_set_header Upgrade $http_upgrade;
             proxy_set_header Connection 'upgrade';
             proxy_set_header Host $host;
             proxy_cache_bypass $http_upgrade;
         }
     }
     ```

## Com Desplegar l'Aplicació a Producció
Segueix aquests passos per configurar i executar l'aplicació en un entorn de producció:

1. **Preparar i Pujar el Projecte**:
   * Comprimeix la carpeta del projecte.
   * Puja el fitxer comprimit al servidor.

2. **Estructuració de Fitxers**:
   * Descomprimeix el projecte.
   * Mou la carpeta web a public_html.
   * Mou la carpeta back a una ubicació segura, com private.
   * Mou la carpeta public (dins de back/Syncblend-Laravel) a public_html.

3. **Configuració del Fitxer .env**:
   * Copia el fitxer .env.example i renombra'l com .env.
   * Configura les credencials de la base de dades i altres variables segons el teu entorn de producció.

4. **Modificar el Fitxer index.php**:
   * A l'arxiu index.php dins de public_html, modifica les rutes per apuntar correctament a la ubicació del back-end.
   * Copia la ruta completa fins a private/back/Syncblend-Laravel/ i substitueix totes les referències que comencin amb .. amb la nova ruta copiada.

5. **Actualitzar communicationManager per a la Comunicació d'API**:
   * Dins de public_html/web/js, obre communicationManager i assegura't que la URL apunti correctament a /public/api/el_que_sigui.

6. **Configuració de la Base de Dades**:
   * Crea una nova base de dades.

7. **Actualitzar utils.js per les Variables d'Entorn**:
   * Obre utils.js i canvia la variable d'entorn laravel perquè apunti a la ruta /public.

## Consideracions Finals
* **Verifica les Configuracions d'Entorn**: Assegura't que les configuracions de l'arxiu .env coincideixin amb l'entorn on es desplega l'aplicació (producció o desenvolupament).
* **Seguretat**: Mai comparteixis l'arxiu .env públicament, ja que conté informació sensible com les credencials de la base de dades.
* **Optimització**: Si estàs desplegant en un entorn de producció, pots utilitzar php artisan config:cache per millorar el rendiment un cop estigui tot configurat correctament, però fes-ho només quan no estiguis fent canvis freqüents a les configuracions.
* **Optimització de Node.js en Producció**: Sempre utilitza eines com `pm2` o Docker per garantir un rendiment estable.
* **Monitorització**: Configura sistemes de monitorització com ara `pm2 monit` o altres eines per assegurar que l'aplicació està activa i funcionant correctament.

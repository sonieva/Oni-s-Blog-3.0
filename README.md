# Oni's Blog 2.0

## Descripció del projecte

Oni's Blog 2.0 és una aplicació web centrada en la gestió i visualització d'articles sobre gats. Els usuaris poden registrar-se, iniciar sessió, afegir, editar i eliminar els seus propis articles. Els articles es poden visualitzar tant a la pàgina principal com al tauler de control de cada usuari. A més, inclou una vista prèvia interactiva dels articles i la possibilitat de visualitzar-ne el contingut complet a través d'un diàleg modal.

## Funcionalitats principals

- **Registre i Autenticació d'Usuaris**: Registre d'usuaris, inici de sessió, autenticació amb Google, GitHub, Reddit o Discord (mitjançant HybridAuth) i opció de recordar credencials amb cookies.
- **Gestió d'Articles**: Afegir, modificar i eliminar articles des del tauler de control de l'usuari.
- **Vista Prèvia**: Vista prèvia interactiva del títol, cos i imatge d'un article abans de publicar-lo.
- **Lectura Completa amb Modal**: Els articles llargs (més de 100 caràcters) es poden expandir per a una lectura completa en una finestra modal.
- **Paginació i Ordenació**: Visualització dels articles amb opció de paginació i selecció del nombre d'articles per pàgina.
- **Gestió d'Imatges**: Suport per a la pujada d'imatges associades als articles, incloent la validació d'extensions permeses.
- **Recuperació i Confirmació de Contrasenya**: Possibilitat de recuperar la contrasenya amb un correu electrònic de recuperació.
- **Canvi de Perfil**: Possibilitat de canviar la contrasenya, àlies, nom complet i foto de perfil.
- **Gestió d'Usuaris per Administradors**: Pàgina de gestió d'usuaris per a administradors amb capacitat per eliminar usuaris.
- **Barra de Cerca amb AJAX**: Cerca d'articles en temps real amb AJAX.
- **Generació de QR**: Generació de codis QR per als articles, facilitant-ne l'accés des de dispositius mòbils.

## Requeriments

- **PHP** 8.2 o superior
- **MySQL** 8
- **Servidor web** (Apache, Nginx, etc.)
- **Composer**

## Instal·lació

1. **Clone el repositori**

   ```bash
   git clone <URL del repositori>
   ```

2. **Instal·la les dependències amb Composer**

   ```bash
   composer install
   ```

3. **Configuració de l'entorn**

   - Renombrar el fitxer `.env.example` a `.env`.
   - Omple les variables del `.env` amb els valors corresponents (exemple: credencials de la base de dades).

4. **Importa la base de dades**

   - Utilitza el fitxer SQL proporcionat per crear les taules necessàries a la teva base de dades MySQL.

5. **Configura el servidor web**

   - Assegura't que el servidor web apunti al directori principal del projecte.

## Credencials d'Usuaris Existents

| Usuari | Correu electrònic     | Contrasenya  |
|--------|----------------------|--------------|
| admin  | admin@oni.cat        | P@lete2103   |

> **Nota**: Les contrasenyes es guarden de manera segura amb `password_hash()`.

## Funcionalitats de Sessió

- **Caducitat de Sessió**: La sessió d'usuari caduca després de 40 minuts d'inactivitat per motius de seguretat.

## Contacte

Per a més informació sobre el projecte, pots contactar amb **Santi Onieva** a través del correu **admin@oni.cat**.

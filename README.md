# WhassapM7

En primer lugar, nos encontramos con una pantalla donde un usuario tendrá las opciones de hacer login o de registrarse en la web.

a) Cuando un usuario registrado hace login al sitio web, dispondrá de las siguientes funcionalidades:
<ol>
<li>Un <strong>formulario de búsqueda de usuarios</strong>. El usuario podrá buscar por "username" o por "nombre real". El sistema detectará si la cadena de caracteres de búsqueda se encuentra en cualquier parte de ambos campos. Una vez localizado un usuario, éste podrá lanzarle una solicitud de amistad, que el otro usuario deberá aceptar para establecer la relación entre ambos.</li>
<li>Un <strong>listado con las solicitudes de amistad </strong>que un usuario ha recibido y una opción para aceptarla o rechazarla. </li>
<li>Un <strong>listado con los usuarios con los que tiene amistad.</strong></li>
<li>Al hacer clic en un usuario con el que se tiene amistad, aparecerá una pantalla con un <strong>chat</strong> en el que se podrá enviar un mensaje (máximo 250 caracteres). Este chat tendrá dos partes:
<ul>
  <li>Una parte <strong>donde se presentarán los mensajes anteriores entre ambos usuarios</strong> en orden descendente (el mas nuevo arriba), indicando el emisor de cada uno de los mensajes</li>
<li>Otra parte con el formulario donde el usuario podrá enviar un mensaje nuevo al chat.</li>

</ul>
</ol>
<hr>

Se valorará especialmente los siguientes apartados:

La correcta configuración de la base de datos, que permita la ejecución de todas las opciones indicadas en el enunciado anteriormente.
La validación y saneamiento de todos los datos está presente en todos los formularios SIEMPRE.
Todas las inserciones y consultas de datos han de estar correctamente configuradas con protección contra ataques de inyección SQL,
El proceso de creación de usuario con encriptación de la contraseña (BCRYPT 😉).
Que junto a cada mensaje del chat aparezca el emisor de dicho mensaje. 


<strong>IMPORTANTE: USAR SOLO PHP PROCEDURAL VISTO EN M7 CON ALBERTO. NO USAR PDO NI JAVASCRIPT.
Evaluación

  
50% (Ejecución de la actividad)</strong>

15% Correcta construcción y funcionamiento de los formularios de búsqueda de usuarios.
15% Correcto funcionamiento de las solicitudes de amistad (envío y aceptación).
15% Correcto funcionamiento del chat.
15% Correcta validación y saneamiento de datos de todos los formularios
10% Diseño de la base de datos y consultas adecuadas.
15% Protección contra ataques SQL en todos los formularios
15% Encriptación de contraseñas (registro y login)
50% (Validación de la actividad)
Defensa final o validación individual de la autoría de la actividad.

# SERVICIOS GET

### GET http://localhost/tpecsrestful/api/api/equipo (Muestra todos los equipos)
### GET http://localhost/tpecsrestful/api/api/jugador (Muestra todos los jugadores ordenado por ID)
### GET http://localhost/tpecsrestful/api/api/equipos/[ID DESEADA] (Muestra el equipo con la id ingresada)
### GET http://localhost/tpecsrestful/api/api/equipos/[RANKING DESEADO] (Filtro por ranking de equipo)
### GET http://localhost:/tpecsrestful/api/api/jugador?show=x&page=x (Show= numero de jugadores | Page= numero de pagina)
### GET http://localhost:80/tpecsrestful/api/api/jugador?orderBy=

#SERVICIO POST

 INSERT http://localhost/tpecsrestful/api/api/equipo
     {
        "nombre_equipo": "EquipoDePrueba",
        "ranking": "[ranking del equipo]",
        "region": "[Region del equipo]"
    }


#SERVICIO PUT
PUT http://localhost/tpecsrestful/api/api/jugador/[ID JUGADOR]
{
    "nombre_jugador": "NOMBRE",
    "posicion": "x",
    "kd":"x",
    "fk_equipo":"[ID DEL EQUIPO DESEADO]"
}




# Autorizacion
### Para poder editar (PUT), insertar (POST) el usuario debe estar autorizado, para esto el usuario a traves del endpoint GET /auth/token debe hacer una "Basic Auth" ingresando usuario (web admin) y password (admin). Una vez consiguida la token, el usuario debe ingresar a "Headers" e ingresar "Authorization" en el campo "Key" y Bearer {token obtenida} en el campo Value, y ademas en la pestana "Authorization" seleccionar "Bearer Token" e ingresar el token. Una vez seguido estos pasos el usuario podra editar (PUT), insertar (POST) durante una hora, una vez pasado el tiempo tendra que repetir el proceso de autorizacion.

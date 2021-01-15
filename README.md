# ACTFAST

## Descripción del Sistema

El sistema ACTFAST tiene como propósito tener el control total del inventario de la institución facilitando a la comprobación de inventario, control de activos y generación de actas, adicional a esto se añadió el módulo de credenciales digitales el cual permite generar actas de las credenciales en base al estándar ISO FO-01(DG-SM-AD-09). 

## Tecnologías usadas
### Desarrollo

```
- StarUML (Diagramación de Base de datos)
- Visual Studio Code (Editor de código)
- Servidor WAMP Versión 3.2.3 
    -Apache 2.4.46
    -MySQL 8.0.21
    -PHP 7.3.21
-DevTools de Google Chrome para debugging
-Git (Para el control de versiones del Software)

```

•	
### Producción 🚀
```
-SQLyog (Administración de la base de datos del servidor Linux)
-Cyberduck (Administración de directorios dentro del servidor Linux)

```
## Metodología 

Se utilizó la metodología de ingeniería de software XP debido al desconocimiento del tema sobre el sistema, se tuvo la asistencia total del directo del CPE, el cual conoce toda la lógica del sistema.
El software esta creado en base a MVC (Modelo – Vista – Controlador), el cual nos permitió desarrollar el sistema de forma ágil y modular, con ello hacemos referencia a separar las funciones de la aplicación en modelos, vistas y controladores hace que la aplicación sea muy ligera.

## Requerimientos Mínimos 📋
### Servidor

El servidor se lo puede implementar tanto el Windows como en Linux, lo único importante aquí es tener en cuenta las versiones de las tecnologías usadas para no tener problemas con la compatibilidad.

```
-Core i3
-8RAM
-256GB

```

### Usuario

El usuario tendrá que entrar a una URL desde un navegador donde se encontrara publicada el sistema.

```
-Core i3
-4RAM
-256GB

```

## Instalación dentro del Servidor

El sistema tiene que ser publicado dentro del Public del servidor Apache, esto quiere decir donde las aplicaciones son de acceso público.
Ejemplo (Para Wamp) -> C:\wamp64\www
 
### Cargar Base de datos

Para cargar la base datos, se tiene que ubicar el archivo actfastProduccion.sql que se encuentra dentro de la carpeta BD, este archivo contiene todo el modelo y la configuración inicial del sistema, para hacer la importación del script se puede hacer desde cualquier gestor de base de datos, puede ser phpmyadmin o SQLyog si se trabaja con un servidor Linux.
Una vez cargada la Base de datos.

# Summa Test Php Developer

Api Test.

## Instalación

Clonar proyecto.

```bash
 git clone https://github.com/spalacios/Summa.git summa_spalacios/
```
Instalar Symfony y dependencias.

```bash
 composer install
```
Correr servidor local.

```bash
 summa_spalacios/> php bin/console server:run
                                                                                                                        
 [OK] Server listening on http://127.0.0.1:8000                                                                         
                                                                                                                        
 // Quit the server with CONTROL-C.               
```
## Observaciones.
- El proyecto incluye una base de datos sqlite con datos precargados, puede ser necesario instalar el driver para PHP.
```bash
 apt-get install php-sqlite3 
```

## Uso

### Recursos disponibles

#### - Company

GET         /api/company
GET         /api/company/{id}                       
POST        /api/company                                        
PUT         /api/company/{id}
DELETE      /api/company/{id}

body: 
{
   "name": "Summa Solutions"
} 

#### - Developer

GET     /api/developer
GET     /api/developer/{id}                     
POST    /api/developer                   
PUT     /api/developer/{id}                
DELETE  /api/developer/{id}                

body: 
{
   "name": "Jose",
   "lastName": "Prueba",
   "age": 35,
   "company_id": 1,
   "language_id": 1
}

#### - Designer

GET     /api/designer 
GET     /api/designer/{id}                     
POST    /api/designer                      
PUT     /api/designer/{id}                 
DELETE  /api/designer/{id} 
              
body: 
{
	"name": "Juan",
	"lastName": "Pablo",
	"age": 28,
	"company_id": 1,
	"desing_type_id": 1
}


#### - Language

GET      /api/language  
GET      /api/language/{id}                    
POST     /api/language                    
PUT      /api/language/{id}                 
DELETE   /api/language/{id} 
              
body: 
{
   "name": "PHP"
}

#### - Designer Type

GET      /api/designer-type  
GET      /api/designer-type/{id}                           
POST     /api/designer-type                 
PUT      /api/designer-type/{id}            
DELETE   /api/designer-type/{id}
              
body: 
{
   "name": "Web"
}

## License
[MIT](https://choosealicense.com/licenses/mit/)

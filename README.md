# TCR Kerntaak 3 voorbereiding - 2018/2019

## Installation

1. Download or clone the git installation
2. Setup an own database (name, user and password)
3. Copy the file /lib/DatabaseSettings.example.php to /lib/DatabaseSettings.php
4. Alter the /lib/DatabaseSettings.php with the correct username, password and database
5. Change/ add the name/user/password
6. Open the database in an application of your choice (phpmyadmin/ sequel pro or e.d.)
7. Open the file /sql/database_init.sql 
8. Copy and paste the information into the database to have a first set ready.
9. Point your webserver/ programm to the /public/index.php file and check if things work.

To see if your installation works you can check if the usage is the same as on the test website: https://kerntaak3.tcr.mncr.nl

## Basic usage
### Routing
The application does not have a web.php or routing file. Routing is done thru the URL with 2 GET-variables:
* page=&lt;Controller-name&gt;
    * Specifying a page searches for that name in the controllers folder as controller
    * So page=user will execture/ fire up the UserController.php in /controllers
* action=[method_name]
    * If this variable of method is not there it will search for an index method in the controller specified in the above variabel

``` c
    http://kerntaak3.tcr.mncr.nl/?page=user&action=edit&id=1
```
This will trigger the UserController and the edit function. You can add other variables which you can use with the PHP ```$_GET['id']``` command.

## Models
### Attribute methods
You can add methods (functions) in the Model that will be attached to the attribute (as method, not variable) to the model-object.

```c
    Class User extends Model
    {
        function showNumberTwo() {
            return 2;
        }
    }
```
The above function is a attribute-method on the $user-models. So you can use ```$user->showNumberTwo()``` in your code (mind the () on the end for Laravel users). This will result in '2' in this case since that is returned.

### Relations
The models that extend have sweet functions on getting connected models (like foreign keys in databases). There are three common functions you can use within a model to access the connected tables.
* ```hasOne($model, $primary_key, $foreign_key),```
    * This function returns the first instance of the connected ```$model``` using the ```$primary_key``` of the model that extends on the ```$foreign_key``` of the ```$model``` table
    * ``` return $this->hasOne('UserEducation', 'id', 'user_id'); ```  
* ```hasMany($model, $primary_key, $foreign_key),```
    * This function returns an array with ALL the instances of the connected ```$model``` using the ```$primary_key``` of the model that extends on the ```$foreign_key``` of the ```$model``` table
    * ``` return $this->hasMany('UserEducation', 'id', 'user_id'); ```  
* ```belongsTo($model, $primary_key, $foreign_key)```
    * This is the opposite of the hasOne, it will return the first instance of the connected ```$model``` using the ```$foreign_key``` of the model to connect to the ```$primary_key```
    * ``` return $this->belongsTo('User', 'id', 'user_id');```
    
### Stacking model functions on relations
You can directly address attributes of a connected (related) model. ```$user->role()->name``` will return the name of the role connected to the user.
If you have an instance on your model that is another model, you can use the 'other' models attribute-methods on that model. This only works if the connection is a hasOne or belongsTo (those return one instance) it does not work on hasMany since that returns an array. 
   

## Special functions
In the /lib/ folder there is a helper_functions.php file, there are 3 handy-dandy functions for you to use.
* ```Old($post_data, $variable)```
    * This function works just like Laravels old functions. It checks if the PHP _POST variable exists. If it does, it will return that variable, if not it will return the second variable

* ```StoreMessage(['status', 'message'])``` (Mind the array)
    * Stores a PHP ```_SESSION['messages']['status']``` variable. This variable is emptied every connection, but can be used for danger/success messages (and more if you code it in)
    * An example can be found in the UserController/ store method and in the views/layouts/header.phtml file.
* ```Redirect($url, $permanent)```
    * This will redirect the application to the chosen URL. If you set ```$permanent``` to true (default false) then it mark the redirect permanent (Google/ SEO working)
* ```Back()```
    * The back function will go back to the previous page (as specified in the PHP ```$_SERVER['HTTP_REFERER']``` variable. If the current call is a POST/PUT or DELETE method then it will also store the _POST variable data in a session variable. In the next call (so on the redirected page) this data is put back into the _POST variable.

## Folder information
* /controllers
    * This folder contains all the Controllers of the system. 
* /lib
    * This folder contains helper and Database class files
* /model
    * This folder contains the models (references to database tables)
* /public
    * This folder holds all publicly accessable files (index.php, images, css, js, etc.)
* /sql
    * Do not touch this folder, it holds the initial mysql-database file
* /views
    * Here are all the views in .phtml files. You can use PHP code in the views, but just for simple usages of showing information. 


## Notice to all who use this
### This software is for educational purpose only, do not use it in anyway in a live environment for it is not safe!
This software was written by me (Michiel Auerbach) for the use of the students of the Techniek College Rotterdam (TCR)
to study/ learn for their exams. This software has limited to zero security checks or in anyway is safe to
use in any environment other then running on your own laptop/ SOHO location without direct internet access to the
software application. 

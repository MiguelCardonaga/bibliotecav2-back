composer install

se debe mdoifciar el .env, el proyecto por dewfepcto lo corri con xampp por el puerto 8080.

bibliotecav2-back


con el comando php artisan migrate --seed se puede crear las tablas en base de datos.


con el siguiente comando podemos crear un usuario que nos devuvelve el token para probar el api

php artisan tinker
>>> $u = \App\Models\Usuario::create([
...   'nombre'=>'Admin',
...   'email'=>'admin@test.com',
...   'password'=>bcrypt('secret'),
...   'estado'=>'activo'
... ]);
>>> $token = $u->createToken('api')->plainTextToken;
>>> $token

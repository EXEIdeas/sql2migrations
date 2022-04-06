# sql2migrations
Convert your .sql dump database file (only structure) into Laravel Migration files separate for each table with rollback options.

## Description

When generating laravel migrations, it can sometimes be a bit confusing as to the correct way to add columns or fields to your tables. There are a large amount of methods to use within the Schema and Blueprint classes to wrap your heads around. Many times, you might even have a database in place, but you would like to move this instance to another host, or simply have a blueprint of the database in a set of laravel migration files. Wouldn’t it be great if we had a way to handle doing this for us automatically? In fact we do it now for you. Let’s see how to put this in action.😘

## How To Use?

- Choose your .SQL file.
.sql dump database file (only structure)
- Click on "Generate Migrations".
Wait few sec...
- Download your Migration Files".
Download one by one or .zip at once

## Laravel DataType Covered

Visit [https://laravel.com/docs/8.x/migrations#columns](https://laravel.com/docs/8.x/migrations#columns) for more info.

```php
$table->bigIncrements('id'); 	Incrementing ID using a "big integer" equivalent.
$table->bigInteger('votes'); 	BIGINT equivalent to the table
$table->binary('data'); 	BLOB equivalent to the table
$table->boolean('confirmed'); 	BOOLEAN equivalent to the table
$table->char('name', 4); 	CHAR equivalent with a length
$table->date('created_at'); 	DATE equivalent to the table
$table->dateTime('created_at'); 	DATETIME equivalent to the table
$table->decimal('amount', 5, 2); 	DECIMAL equivalent with a precision and scale
$table->double('column', 15, 8); 	DOUBLE equivalent with precision, 15 digits in total and 8 after the decimal point
$table->enum('choices', array('foo', 'bar')); 	ENUM equivalent to the table
$table->float('amount'); 	FLOAT equivalent to the table
$table->increments('id'); 	Incrementing ID to the table (primary key).
$table->integer('votes'); 	INTEGER equivalent to the table
$table->longText('description'); 	LONGTEXT equivalent to the table
$table->mediumInteger('numbers'); 	MEDIUMINT equivalent to the table
$table->mediumText('description'); 	MEDIUMTEXT equivalent to the table
$table->morphs('taggable'); 	Adds INTEGER taggable_id and STRING taggable_type
$table->nullableTimestamps(); 	Same as timestamps(), except allows NULLs
$table->smallInteger('votes'); 	SMALLINT equivalent to the table
$table->tinyInteger('numbers'); 	TINYINT equivalent to the table
$table->softDeletes(); 	Adds deleted_at column for soft deletes
$table->string('email'); 	VARCHAR equivalent column
$table->string('name', 100); 	VARCHAR equivalent with a length
$table->text('description'); 	TEXT equivalent to the table
$table->time('sunrise'); 	TIME equivalent to the table
$table->timestamp('added_on'); 	TIMESTAMP equivalent to the table
$table->timestamps(); 	Adds created_at and updated_at columns
$table->rememberToken(); 	Adds remember_token as VARCHAR(100) NULL
->nullable() 	Designate that the column allows NULL values
->default($value) 	Declare a default value for a column
->unsigned() 	Set INTEGER to UNSIGNED
```

## Check It Online Now

View it Live on [https://exeideas.github.io/sql2migrations/](https://exeideas.github.io/sql2migrations/)

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[GPL 3.0](https://choosealicense.com/licenses/gpl-3.0/)

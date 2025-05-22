# Recipe Tracker
This is a basic CRUD App written in PHP with laravel.

## Domain
### Recipe
- name
- description
- ingredients - many to many via pivot table containing quantity, unit
- instructions - one to many

### Ingredient
- name

### Instruction
- step
- instruction

## Testing
I implemented some basic testing as I had never done testing in PHP and I was
curious to explore it.
### Unit Testing
I implemented Unit testing for the Ingredient Service 
(tests/Unit/IngredientServiceTest.php). This necessitated implementing a 
repository pattern so that it could be mocked. I'm not sure how useful these
tests are as I am not used to so tightly using an ORM in testing. The Eloquent
model is the model used in the Service, so by mocking the repository im not
sure how much is actually being tested. I am curious to see correct/good 
implementation of this.
### Feature Testing
I implemented Feature testing for all the Recipe Controller methods
(tests/Feature/RecipeFeatureTest.php). this made much more sense testing full 
end to end functionality. In laravel this was very easy to setup also using an
sqlite database which doesn't persist data. 

## Postman
In the root dir there is a Postman Collection Export for all implemented
endpoints.

## Docker
Docker Compose file in the root dir sets up a basic postgres database with no
volume for easy local development. .env.example is setup for this docker compose
file.
## Database Setup
there is a database seeder file at database/seeders/DatabaseSeeder.php
once the database is set up run:
```php artisan migrate``` to implement the database structure
then run:
```php artisan db:seed --class=DatabaseSeeder```
to have a simple recipe added to the DB with ingredients and instructions.


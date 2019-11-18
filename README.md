# happy-plants-app

```
# To install the project:
git clone https://github.com/blackbird38/happy-plants-app.git

cd happy-plants-app
npm install
composer install
npm run dev
replace in .env, DATABASE_URL: DATABASE_URL=mysql://root:@127.0.0.1:3306/happy-plant-db
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:update --force
php bin/console server:run
```


# Plant Tracker

The purpose of this application is to track the watering and the health of our green plants.

- Each green plant is defined by a name, a species, a date of birth, etc... We record also in what it is planted (soil, hydropony, etc...)
- Each plant has states with a certain date by state: planted, germination, flowering, fruit, etc...
- Each green plant is located in a place (room, garden, etc...). We can define information on these places: orientation, average temperature, etc...
- We can associate photos to our plant, to follow the visual evolution. Each photo is taken on a specific date.
- For each green plant, we add actions for watering. We water a plant on a specific date and with a certain amount
- Watering is done by a person. A person is defined by their email. A person has a name, a first name, etc... We can have a user account management system (with password).

## Features:
    - Ability to add a new plant, edit and delete it
    - Ability to add a new place, edit and delete it
    - Ability to add different states, edit and delete them
    - Ability to add, edit and delete users
    - Ability to water a plant
    - Ability to add or remove a plant from a place
    - Ability to add or remove a photo of a plant
    - List all plants by location. Know for how long a plant has not been watered.
    
 ![alt text](https://raw.githubusercontent.com/blackbird38/happy-plants-app/master/steps/printscreens/Capture23.PNG?token=AMGZT2Q2X3ZN7PKT3KFDQHS52HRQE "Printscreen")
 
 ![alt text](https://raw.githubusercontent.com/blackbird38/happy-plants-app/master/steps/printscreens/Capture26.PNG?token=AMGZT2UHUDYJLHVMWPWKAH252HRLY "Printscreen")
 
  
 ![alt text](https://raw.githubusercontent.com/blackbird38/happy-plants-app/master/steps/printscreens/Capture27.PNG?token=AMGZT2WKK6LHA5XRJ64DJHK52HSBW "Printscreen")
 
![alt text](https://raw.githubusercontent.com/blackbird38/happy-plants-app/master/steps/printscreens/Capture22.PNG?token=AMGZT2S6GAO2F7IOIZSEZKK52HROG "Printscreen")





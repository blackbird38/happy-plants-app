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
    
 ![alt text](https://lh3.googleusercontent.com/-NzGkcnyEZnr1iTLwUHV5_EKCbcfCA8FganvzYhFjWTRhfjzSJC0ivIeRF2qOdiYsYiiR0WkcGSuwMtpTH182R9EJu51DhIpCl69G0wE2F7rOroNPrvmPCoV2MRUL8BFH1KRUx2Y4cvKSApAS2oyO8s7LHjJSHLA6R-LfjD2MvF7ofhOK6QRszQYUuaTQIS98JJF2V1qhZRibEieZiduuxbBYtQURik8vQBiIK3mmYx4W-PMBWHfwizhbpsggxLr7qcngT6yV60tL5BhptSLDDUj8vcTCDyFIiSS6tHUaooYhOKaFov72_Wod7zdrXkKFIehuXWOcwZOR3G2Q-JHVYg6b2ZC9nwPquOTmOOzyZmOyQtP0c6huqW9mbdv7bEorhCb6cuqHqYxFTTm3o6kYT7DwqwakJ4go3E557Hw9lMEMS9r7vJt5rbseMLdD3x6jgQfbg44hSTwxZzs3CwUUg01rA8qLe4lgF87GAXxvuRE9K7pc8h5sP8AUWazGpcwe0wXxAbVR9RYeC0hQ-Q_a9nRgOJtPVygxFHeIhMtE5jO3ZXOeUlbh-Mx8m8viUsU_VnUXNiVKn1Jv8Rz_M93aHD2LeW0UjlWAEp1qvBUUXnm6rMODjzqwnKp4KTucUbs9KXqP5fi2NRpLUHEDFfNKkGnOX9Gms-lk8AASSudd-Fktqs9wIEuLQ=w1980-h1356-no "Printscreen")
 
 ![alt text](https://raw.githubusercontent.com/blackbird38/happy-plants-app/master/steps/printscreens/Capture26.PNG?token=AMGZT2UHUDYJLHVMWPWKAH252HRLY "Printscreen")
 
  
 ![alt text](https://raw.githubusercontent.com/blackbird38/happy-plants-app/master/steps/printscreens/Capture27.PNG?token=AMGZT2WKK6LHA5XRJ64DJHK52HSBW "Printscreen")
 
![alt text](https://raw.githubusercontent.com/blackbird38/happy-plants-app/master/steps/printscreens/Capture22.PNG?token=AMGZT2S6GAO2F7IOIZSEZKK52HROG "Printscreen")





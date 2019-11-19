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
  

## Printscreens:

 ![alt text](https://1.bp.blogspot.com/-zz4cxdDRiDk/XdREW2FhNRI/AAAAAAAAACs/BsXBB9i2gcoTj39uITaCQw22SrJcx4QvACKgBGAsYHg/s1600/Capture23.PNG "Printscreen")
 
  ![alt text](https://1.bp.blogspot.com/-3O2RU44pozg/XdREW1GpmOI/AAAAAAAAACs/1eFlGGPpe6IEX9x1olWruBaVG2_FClT1wCKgBGAsYHg/s1600/Capture27.PNG "Printscreen")
 
 ![alt text](https://1.bp.blogspot.com/-vvSmGPH72pM/XdREW4a10cI/AAAAAAAAACs/Wu_mGtSaIHs3g-haRm-6epJybNdZvw6DQCKgBGAsYHg/s1600/Capture26.PNG "Printscreen")
 
![alt text](https://1.bp.blogspot.com/-WsYk0xWrEFI/XdREW2_G8rI/AAAAAAAAACs/YCeQJLrS5oc_rMgXhtUvGgwpIVvBm-DsACKgBGAsYHg/s1600/Capture25.PNG "Printscreen")

![alt text](https://1.bp.blogspot.com/-B80m-4wfFkU/XdREWxDeKlI/AAAAAAAAACs/KHPt8GO6fGo_I_fX8OlfcCgJ_ZVT2QNOACKgBGAsYHg/s1600/Capture22.PNG "Printscreen")


![alt text](https://1.bp.blogspot.com/-5g692bQh03g/XdR_4CJ4AfI/AAAAAAAAADQ/xJ1whGaKPWwY8yHs_-8t-8ROOSnajoZ5gCKgBGAsYHg/s1600/Capture28.PNG "Printscreen")

/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/happy-style.scss');
require('../css/app.css');
require('../css/style.css');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

const $ = require('jquery');
require('bootstrap');

import Cropper from 'cropperjs/dist/cropper';
require('cropperjs/dist/cropper.css');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router';
import Routes from './routes.json';
import axios from 'axios';

import 'tailwindcss/base.css';
import 'tailwindcss/components.css';
import 'tailwindcss/utilities.css';
import 'tailwindcss/dist/tailwind.css';

Routing.setRoutingData(Routes);

$(document).ready(function() {

    /*cropper place*/
    let preview = document.getElementById('photoPlaceCropper');
    let file_input = document.getElementById('place_photoFile');
    let cropper;
    let form = document.getElementById('place_form');

    /*cropper plant*/
    let plant_preview = document.getElementById('photoPlantCropper');
    let plant_file_input = document.getElementById('plant_photoFile');
    let plant_cropper;
    let plant_form = document.getElementById('plant_form');

    /*cropper stage*/
    let stage_preview = document.getElementById('photoStageCropper');
    let stage_file_input = document.getElementById('stage_history_photoFile');
    let stage_cropper;
    let stage_form = document.getElementById('stage_history_form');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

    console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab
    })

    $('.custom-file-input').on('change', function (e) {
        let inputFile = e.currentTarget;
        $(inputFile).parent()
            .find('.custom-file-label')
            .html(inputFile.files[0].name);
    });

    /*------------------------------cropper Place--------------------------------------*/
    window.previewFile = function previewFile() {
        let file = file_input.files[0];
        let reader = new FileReader();
        reader.addEventListener('load', function (event) {
            preview.src = reader.result;
            //console.log(preview.src);
        }, false);
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    if (preview) {
        preview.addEventListener('load', function (event) {
            if (cropper) {
                cropper.destroy();
            }
            // console.log('load');
            cropper = new Cropper(preview, {
                viewMode: 1,
                responsive: true,
                aspectRatio: 1 / 1,
                background: false,
                autoCropArea: 1,
                movable: false,
                //cropBoxMovable: false,
                zoomable: false
                //   crop: function (event)
                //    {
                //       console.log(event);
                //   }
            })
        })
    }

    if (form) {
//for both the new place and edit place forms
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            //cropper.zoomTo(1);
            cropper.getCroppedCanvas({
                maxHeight: 1000,
                maxWidth: 1000,
                imageSmoothingEnabled: false,
                imageSmoothingQuality: 'high',
            }).toBlob(function (blob) {
                console.log(blob);
                ajaxWithAxios(blob);
            });
        })
    }

    function ajaxWithAxios(blob) {
        //reading the url to see if it's for adding a new place or for editing a place
        let full_url = document.URL
        let url_array = full_url.split('/')
        let url_id = url_array[url_array.length - 1]
        let url
        let method
        if (!isNaN(url_id)) { //it's for 'edit place' form, for the place with id url_id
            url = Routing.generate('user-edit-place', {id: url_id})
            method = 'post'
        } else { //it's for 'add new place' form
            url = Routing.generate('user-add-place')
            method = 'post'
        }
        let data = new FormData(form)
        data.append('file', blob)
        axios({
            method: method,
            url: url,
            data: data,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        })
            .then((response) => {
                console.log(response);
              //  window.location = '/user/account'; //to redirect to /user/account page (the route was exposed)
                window.location = '/user/account/places';
            })
            .catch((error) => {
                console.error(error)
            })
    }


    /*---------------------------------cropper Plant---------------------------------*/

    window.previewPlantFile = function previewPlantFile() {
        let file = plant_file_input.files[0];
        let reader = new FileReader();
        reader.addEventListener('load', function (event) {
            plant_preview.src = reader.result;
            //console.log(preview.src);
        }, false);
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    if (plant_preview){
        plant_preview.addEventListener('load', function (event) {
            if (plant_cropper) {
                plant_cropper.destroy();
            }
            // console.log('load');
            plant_cropper = new Cropper(plant_preview, {
                viewMode: 1,
                responsive: true,
                aspectRatio: 1 / 1,
                background: false,
                autoCropArea: 1,
                movable: false,
                //cropBoxMovable: false,
                zoomable: false
                //   crop: function (event)
                //    {
                //       console.log(event);
                //   }
            })
        })
}

    if (plant_form) {
//for both the new place and edit place forms
        plant_form.addEventListener('submit', function (event) {
            event.preventDefault();
            //cropper.zoomTo(1);
            plant_cropper.getCroppedCanvas({
                maxHeight: 1000,
                maxWidth: 1000,
                imageSmoothingEnabled: false,
                imageSmoothingQuality: 'high',
            }).toBlob(function (blob) {
                console.log(blob);
                ajaxWithAxiosForPlants(blob);
            });
        })
    }


    function ajaxWithAxiosForPlants(blob) {
        //reading the url to see if it's for adding a new plant or for editing a plant
        let full_url = document.URL
        let url_array = full_url.split('/')
        let url_id = url_array[url_array.length - 1]
        let url
        let method
        if (!isNaN(url_id)) { //it's for 'edit plant' form, for the plant with id url_id
            //the url can be: user/add/plant/to/the/place/with/{id}
            //adding a plant to a place with id = 'id'
            if ((url_array[url_array.length - 3] == "place"))
            {
                url = Routing.generate('user-add-plant', {id: url_id})
                method = 'post'
            }

            //the url can be: /user/edit/the/plant/with/{id}
            //editing the plant with the id 'id'
            //(the url can be /user/add/photo/and/stage/of/the/plant/with/{id})
            if ((url_array[url_array.length - 3] == "plant") && (url_array[url_array.length - 5] == "edit"))
            {
                url = Routing.generate('user-edit-plant', {id: url_id})
                method = 'post'
            }

       /*     //the url can be /user/add/photo/and/stage/of/the/plant/with/{id}
            if ((url_array[url_array.length - 3] == "plant") && (url_array[url_array.length - 6] == "stage"))
            {
                url = Routing.generate('user-plant-add-photos-and-stage', {id: url_id})
                method = 'post'
            }*/
        }
        let data = new FormData(plant_form)
        data.append('file', blob)
        axios({
            method: method,
            url: url,
            data: data,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        })
            .then((response) => {
                console.log(response);
               // window.location = '/user/account'; //to redirect to /user/account page (the route was exposed) v1
                window.location = '/user/account/places';
            })
            .catch((error) => {
                console.error(error)
            })
    }

    /*------------------------------cropper Stage--------------------------------------*/
    window.previewStageFile = function previewStageFile() {
        let file = stage_file_input.files[0];
        let reader = new FileReader();
        reader.addEventListener('load', function (event) {
            stage_preview.src = reader.result;
            //console.log(preview.src);
        }, false);
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    if (stage_preview) {
        stage_preview.addEventListener('load', function (event) {
            if (stage_cropper) {
                stage_cropper.destroy();
            }
            // console.log('load');
            stage_cropper = new Cropper(stage_preview, {
                viewMode: 1,
                responsive: true,
                aspectRatio: 1 / 1,
                background: false,
                autoCropArea: 1,
                movable: false,
                //cropBoxMovable: false,
                zoomable: false
                //   crop: function (event)
                //    {
                //       console.log(event);
                //   }
            })
        })
    }

    if (stage_form) {
//for both the new place and edit place forms
        stage_form.addEventListener('submit', function (event) {
            event.preventDefault();
            //cropper.zoomTo(1);
            stage_cropper.getCroppedCanvas({
                maxHeight: 1000,
                maxWidth: 1000,
                imageSmoothingEnabled: false,
                imageSmoothingQuality: 'high',
            }).toBlob(function (blob) {
                console.log(blob);
                ajaxWithAxiosForStage(blob);
            });
        })
    }

    function ajaxWithAxiosForStage(blob) {
        //reading the url to see if it's for adding a new plant or for editing a plant
        let full_url = document.URL
        let url_array = full_url.split('/')
        let url_id = url_array[url_array.length - 1]
        let url
        let method
        if (!isNaN(url_id)) { //it's for 'edit stage' form, for the plant with id 'url_id'
             //the url can be /user/add/photo/and/stage/of/the/plant/with/{id}
             if ((url_array[url_array.length - 3] == "plant") && (url_array[url_array.length - 6] == "stage"))
                 {
                     url = Routing.generate('user-plant-add-photos-and-stage', {id: url_id})
                     method = 'post'
                 }
        }
        let data = new FormData(stage_form)
        data.append('file', blob)
        axios({
            method: method,
            url: url,
            data: data,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        })
            .then((response) => {
                console.log(response);
               // window.location = '/user/account'; //to redirect to /user/account page (the route was exposed) v1
                window.location = '/user/account/places';
            })
            .catch((error) => {
                console.error(error)
            })
    }


    /*------------------------animate.css-----------------------------------------*/

    $("#happy-fadeIn p").addClass("load");


    /* places - accordion- add new plant*/
/*
    let forms = document.querySelectorAll( '.add-new-plant form' );
    for (const form of forms) {
        form.addEventListener( 'submit', function( event ) {
            event.preventDefault();
            alert(this.getAttribute('data-value'));
        });
    }
*/
});
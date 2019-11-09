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

Routing.setRoutingData(Routes);

$(document).ready(function(){

let preview = document.getElementById('photoPlaceCropper');
let file_input = document.getElementById('place_photoFile');
let cropper;
let form = document.getElementById('place_form');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    e.target // newly activated tab
    e.relatedTarget // previous active tab
})

$('.custom-file-input').on('change', function(e){
    let inputFile = e.currentTarget;
    $(inputFile).parent()
            .find('.custom-file-label')
            .html(inputFile.files[0].name);
});

window.previewFile = function previewFile(){
    let file = file_input.files[0];
    let reader = new FileReader();
    reader.addEventListener('load', function (event){
        preview.src = reader.result;
        //console.log(preview.src);
    }, false);
    if (file){
        reader.readAsDataURL(file);
    }
}

preview.addEventListener('load', function (event){
    if (cropper) {
        cropper.destroy();
    }
   // console.log('load');
     cropper = new Cropper(preview, {
         viewMode: 1,
         responsive: true,
         aspectRatio: 1/1,
         background:false,
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

//for both the new place and edit place forms
form.addEventListener('submit', function(event){
    event.preventDefault();
    //cropper.zoomTo(1);
    cropper.getCroppedCanvas({
        maxHeight: 1000,
        maxWidth: 1000,
        imageSmoothingEnabled: false,
        imageSmoothingQuality: 'high',
    }).toBlob(function(blob){
        console.log(blob);
        ajaxWithAxios(blob);
    });
})

function ajaxWithAxios(blob)
{
    //reading the url to see if it's for adding a new plant or for editing a plant
    let full_url = document.URL
    let url_array = full_url.split('/')
    let url_id = url_array[url_array.length-1]
    let url
    let method
    if (!isNaN(url_id)) { //it's for 'edit place' form, for the place with id url_id
        url = Routing.generate('user-edit-place', { id: url_id })
        method = 'post'
    }else { //it's for 'add new place' form
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
            window.location = '/user/account'; //to redirect to /user/account page (the route was exposed)
        })
        .catch((error) => {
            console.error(error)
        })
}

});
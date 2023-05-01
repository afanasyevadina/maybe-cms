/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import {createApp} from 'vue';
import router from './router'
import store from './store'

import App from "./App.vue";

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

window.app = createApp(App);

app.use(router)
app.use(store)

import ManyToOne from "./components/relations/ManyToOne.vue";
import ManyToMany from "./components/relations/ManyToMany.vue";
import OneToMany from "./components/relations/OneToMany.vue";

import Field from './components/fields/Field.vue';
import TextField from './components/fields/TextField.vue';
import SingleLineTextField from './components/fields/SingleLineTextField.vue';
import MarkdownField from "./components/fields/MarkdownField.vue";
import LinkField from "./components/fields/LinkField.vue";
import ImageField from "./components/fields/ImageField.vue";
import VideoField from "./components/fields/VideoField.vue";
import SelectField from "./components/fields/SelectField.vue";

import TreeItem from "./components/tree/TreeItem.vue";

app.component('field', Field);
app.component('text-field', TextField);
app.component('single-line-text-field', SingleLineTextField);
app.component('markdown-field', MarkdownField);
app.component('link-field', LinkField);
app.component('image-field', ImageField);
app.component('video-field', VideoField);
app.component('select-field', SelectField);

app.component('many-to-one', ManyToOne);
app.component('many-to-many', ManyToMany);
app.component('one-to-many', OneToMany);

app.component('tree-item', TreeItem);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.globEager('./**/*.vue')).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
import http from './mixins/http.js'
import str from './mixins/str.js'
import media from './mixins/media.js'
import util from './mixins/util.js'

app.mixin(http)
app.mixin(str)
app.mixin(media)
app.mixin(util)

app.mount('#app');

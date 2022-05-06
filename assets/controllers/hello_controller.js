import { Controller } from "@hotwired/stimulus";
/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */

import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "../../src/router/index.js";

import App from "../../src/components/App.vue";
const app = createApp(App);
app.use(createPinia());
app.use(router);
app.mount("#app2");

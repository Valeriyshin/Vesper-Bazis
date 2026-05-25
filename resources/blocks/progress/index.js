import {createApp} from "vue";
import App from "./Modal.vue";

const el = document.getElementById("pgm");
if (el) {
  const lang = JSON.parse(el.dataset.lang);
  const milestones = JSON.parse(el.dataset.milestones);
  createApp(App, {lang, milestones}).mount(el);
}

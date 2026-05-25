import {createApp} from "vue";
import App from "./App.vue";

const el = document.getElementById("plans");
if (el) {
  const plans = JSON.parse(el.dataset.plans);
  const lang = JSON.parse(el.dataset.lang);
  createApp(App, {plans, lang}).mount(el);
}

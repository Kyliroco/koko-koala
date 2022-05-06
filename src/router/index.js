import { createRouter, createWebHashHistory } from "vue-router";
import App from "../components/App.vue";

const routes = [
  // À compléter
  {
    path: "/",
    name: "exercice",
    component: App,
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;

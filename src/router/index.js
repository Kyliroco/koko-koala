import { createRouter, createWebHashHistory } from "vue-router";
import App from "../components/App.vue";
import Exercice from "../components/Exercice.vue";

const routes = [
  // À compléter
  // {
  //   path: "/",
  //   name: "exercice",
  //   component: Exercice,
  // },
  {
    path: "/:exercice/:niveau",
    name: "exercice_niveau",
    component: Exercice,
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;

import { defineStore } from "pinia";
import Axios from "axios";

export const useKokoStore = defineStore({
  id: "koko",
  state: () => ({
    users: [],
    categories: [],
    classes: [],
    exercices: [],
    exercice: 0,
    niveaux: [],
    niveau: 0,
  }),
  getters: {},
  actions: {
    getNiveauExercice() {
      let exercice_niveau = document.location.href.substring(
        document.location.href.indexOf("exercices/")
      );
      exercice_niveau = exercice_niveau
        .replace("exercices/", "")
        .replace("#/", "");
      this.niveau = exercice_niveau.substring(exercice_niveau.indexOf("/") + 1);
      this.exercice = exercice_niveau.substring(
        0,
        exercice_niveau.indexOf("/")
      );
    },
    async fetchUsers() {
      try {
        const data = await Axios.get("http://localhost:8000/api/users?page=1");
        this.users = data.data["hydra:member"];
      } catch (error) {
        alert(error);
        console.log(error);
      }
    },
    async fetchCategorie() {
      try {
        const data = await Axios.get(
          "http://localhost:8000/api/categories?page=1"
        );
        this.categories = data.data["hydra:member"];
      } catch (error) {
        alert(error);
        console.log(error);
      }
    },
    fetchClasses() {
      Axios.get("http://localhost:8000/api/classes?page=1")
        .then((response) => response.data)
        .then((donneesClasses) => {
          this.classes = donneesClasses["hydra:member"];
        });
      // console.log(data.data["hydra:member"]);
    },
    fetchExercices() {
      Axios.get("http://localhost:8000/api/exercices?page=1")
        .then((response) => response.data)
        .then((donneesExercices) => {
          this.exercices = donneesExercices["hydra:member"];
        })
        .then();
    },
    async fetchNiveaux() {
      try {
        const data = await Axios.get(
          "http://localhost:8000/api/niveaus?page=1"
        );
        // console.log(data.data["hydra:member"]);
        this.niveaux = data.data["hydra:member"];
      } catch (error) {
        alert(error);
        console.log(error);
      }
    },
  },
});

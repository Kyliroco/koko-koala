<template>
  <div id="main_header">
    <div class="flex">
      <h1
        class="exercice_title"
        v-for="(niveau, index) in exercice.niveaux"
        :key="index"
      >
        <p></p>
        <h1 v-if="niveau.numero == route.params.niveau">
          {{ exercice.nom }} ({{ niveau.nom }})
        </h1>
      </h1>
      <div>
        <a class="button exit" href="/enfant">x</a>
      </div>
    </div>
    <div class="flex" id="exercice_information">
      <div class="main_information">
        <div class="information_class_questions">
          <div class="alt_information_content">
            <div>
              <p class="alt_information">• {{ exercice.matiere.nom }}</p>
            </div>
            <div>
              <p class="alt_information">• {{ exercice.categorie.nom }}</p>
            </div>
            <div>
              <p class="alt_information">• {{ exercice.classe.nom }}</p>
            </div>
          </div>
          <div>
            <p class="questions">
              <!-- <span id="questionEnCours">{{ questionEnCours }}</span> -->

              <!-- <span id="nbQuestions">{{ nbQuestions }}</span> -->
            </p>
          </div>
        </div>
        <div>
          <progress value="1.0" max="100"></progress>
        </div>
      </div>
      <div class="count">
        <!-- <p id="points">{{ points }}</p> -->
        <img
          id="count_icon"
          src="/img/icons/eucalyptus_leaves.png"
          style="filter: hue-rotate(-6deg)"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { useKokoStore } from "../stores/index";
import { useRoute, useRouter } from "vue-router";
console.log("lancement HeaderExercice");
const store = useKokoStore();
const route = useRoute();
console.log(route.params.exercice);
const router = useRouter();

const props = defineProps({
  exercice: Object,
});
</script>
<style></style>

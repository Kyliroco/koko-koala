<template>
  <div id="main_header" v-if="exercice">
    <div class="flex">
      <h1
        class="exercice_title"
        v-for="(niveau, index) in exercice.niveaux"
        :key="index"
      >
        <p></p>
        <h1 v-if="niveau.numero == props.niveau">
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
              <span id="questionEnCours">{{ exoParam.questionEnCours }}</span>
              /
              <span id="nbQuestions">{{ exoParam.nbQuestions }}</span>
            </p>
          </div>
        </div>
        <div>
          <progress value="0" max="100"></progress>
        </div>
      </div>
      <div class="count">
        <p id="points">{{ exoParam.points }}</p>
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
const store = useKokoStore();

const props = defineProps({
  exercice: Object,
  exoParam: Object,
  niveau: String
});
</script>
<style></style>

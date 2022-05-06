<template>
  <div id="main_header">
    <div class="flex">
      <h1 class="exercice_title">{{ exercice.nom }} ({{ niveau.nom }})</h1>
      <div>
        <a class="button exit" href="/enfant">x</a>
      </div>
    </div>
    <div class="flex" id="exercice_information">
      <div class="main_information">
        <div class="information_class_questions">
          <div class="alt_information_content">
            <div>
              <p class="alt_information">• {{ matiere.nom }}</p>
            </div>
            <div>
              <p class="alt_information">• {{ categorie.nom }}</p>
            </div>
            <div>
              <p class="alt_information">• {{ classe.nom }}</p>
            </div>
          </div>
          <div>
            <p class="questions">
              <span id="questionEnCours">{{ questionEnCours }}</span>
              /
              <span id="nbQuestions">{{ nbQuestions }}</span>
            </p>
          </div>
        </div>
        <div>
          <progress value="10" max="100"></progress>
        </div>
      </div>
      <div class="count">
        <p id="points">{{ points }}</p>
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
const props = defineProps({
  classe: {
    type: Object,
    required: true,
  },
  questionEnCours: {
    type: Number,
    required: true,
  },
  nbQuestions: {
    type: Number,
    required: true,
  },
  points: {
    type: Number,
    required: true,
  },
  exercice: {
    type: Object,
    required: true,
  },
  categorie: {
    type: Object,
    required: true,
  },
  niveau: {
    type: Object,
    required: true,
  },
});
</script>
<style></style>

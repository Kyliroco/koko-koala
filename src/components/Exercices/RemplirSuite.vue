<template>
  <div id="exercice" data-form-type="other">
    <div class="blank_3"></div>
    <div id="liste">
      <ul class="horizontal_list">
        <li><p class="letter_box_1">0</p></li>
        <li>
          <input class="blank" data-form-type="other" />
        </li>
        <li><p class="letter_box_1">2</p></li>
        <li>
          <input class="blank" data-form-type="other" />
        </li>
        <li>
          <input class="blank" data-form-type="other" />
        </li>
        <li><p class="letter_box_1">5</p></li>
        <li><p class="letter_box_1">6</p></li>
        <li><p class="letter_box_1">7</p></li>
        <li><p class="letter_box_1">8</p></li>
        <li>
          <input class="blank" data-form-type="other" />
        </li>
      </ul>
    </div>
    <div class="blank_6"></div>
    <div id="actions">
      <div class="action_button">
        <button
          id="checkButton"
          class="button_large"
          style="display: inline-block"
          data-dashlane-label="true"
          data-dashlane-rid="4335cac74b0124f7"
          data-form-type="other"
        >
          Vérifier
        </button>
        <button id="nextButton" class="button_large" style="display: none">
          Continuer
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useKokoStore } from "../../stores/index";
import { useRoute, useRouter } from "vue-router";
import { ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
console.log("lancement HeaderExercice");
const store = useKokoStore();
const route = useRoute();
console.log(route.params.exercice);
const router = useRouter();
const nbChiffres = 10;
const nbChiffresATrouve = 4;
const niveau = ref({});
const props = defineProps({
  exercice: Object,
});
onMounted(() => {
  for (let index = 0; index < exercice.niveaux.length; index++) {
    if (exercice.niveaux[index].numero == route.params.niveau) {
      niveau.value = exercice.niveaux[index];
    }
  }
  const suite_a_remplir = ref([
    Math.floor(
      Math.random() * (niveau.value.max - (nbChiffres - 1) - niveau.value.min)
    ) + niveau.value.min,
  ]);
  for (let index = 0; index < nbChiffresATrouve; index++) {
    let chiffre = 0;
    let limiteWhile = 20;
    do {
      chiffre = Math.floor(Math.random() * nbChiffres) + premierChiffre;
      limiteWhile -= 1;
    } while (suite_a_remplir.value.includes(chiffre) && limiteWhile != 0);
    Math.floor(Math.random);
    suite_a_remplir.value.push(chiffre);
  }
});
console.log(suite_a_remplir.value);
</script>
<style></style>

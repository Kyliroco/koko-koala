<template>
  <div id="main_header">
    <div class="flex">
      <h1 class="exercice_title">Remplir une suite (jusqu'à 10)</h1>
      <div>
        <a class="button exit" href="/enfant">x</a>
      </div>
    </div>
    <div class="flex" id="exercice_information">
      <div class="main_information">
        <div class="information_class_questions">
          <div class="alt_information_content">
            <div>
              <p class="alt_information">• Mathématiques</p>
            </div>
            <div>
              <p class="alt_information">• Nombre et Calculs</p>
            </div>
            <div>
              <p class="alt_information">• CP</p>
            </div>
          </div>
          <div>
            <p class="questions">
              <span id="questionEnCours">2</span>
              /
              <span id="nbQuestions">10</span>
            </p>
          </div>
        </div>
        <div>
          <progress value="10" max="100"></progress>
        </div>
      </div>
      <div class="count">
        <p id="points">54</p>
        <img
          id="count_icon"
          src="/img/icons/eucalyptus_leaves.png"
          style="filter: hue-rotate(-6deg)"
        />
      </div>
    </div>
  </div>
</template>

<script setup></script>
<style></style>

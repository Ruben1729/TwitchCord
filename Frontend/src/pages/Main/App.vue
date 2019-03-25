<template>
  <div id="app">
    <Navbar />
    <b-jumbotron header="Streams" lead="Like a content creator? Join their community!"> 
    </b-jumbotron>

    <b-row class="centerText">
        <b-col>1 of 3</b-col>
        <b-col>2 of 3</b-col>
        <b-col>3 of 3</b-col>
    </b-row>
  </div>
</template>

<script>
import Navbar from "../../components/Navbar.vue"
export default {
  name: "app",
  components: {
    Navbar
  }
};
</script>

<style>
</style>

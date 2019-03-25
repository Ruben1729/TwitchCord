<template>
  <div>
    <!--Check if the session is set-->
    <template v-if=false>
      <p> NICE </p>
    </template>
    <template v-else> 
      <!-- User isn't logged in-->
      <b-navbar type="dark" variant="dark">
        <b-navbar-brand href="#">Home</b-navbar-brand>
        <b-navbar-nav class="ml-auto">
          <a href="User/Login" class="btn btn-light" role="button">Login</a>
          <a href="User/Register" class="btn btn-dark" role="button">Register</a>
        </b-navbar-nav>
      </b-navbar>
    </template>
  </div>
</template>

<script>
export default {
  name: "NavBar",
  components: {}
};
</script>

<style scoped>
a {
  margin: 5px;
}
</style>

<style>
.centerText {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>

<template>
  <header class="container header">
      <h2>Sono l'header</h2>
      <a href="/admin/home">Area Riservata</a>
      <nav>
        <li>
          <router-link :to="{ name: 'home' }">Home</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'about' }">Chi Siamo</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'categories' }">Categorie</router-link>
        </li>
      </nav>
  </header>
</template>

<script>
export default {
    name: "Header"
}
</script>

<style lang="scss" scoped>
.header {
  margin-bottom: 20px;
  border-bottom: 2px solid;
}
</style>
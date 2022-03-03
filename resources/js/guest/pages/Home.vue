<template>
  <div>
    <h1>Home Page</h1>
    <Posts/>
  </div>
</template>

<script>
import Posts from '../components/sections/Posts.vue';

export default {
  name: "Home",
  components: {
    Posts
  }
}
</script>
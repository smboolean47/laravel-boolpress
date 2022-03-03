<template>
  <div>
      <h1>{{category.name}}</h1>

      <ul v-if="category.posts.length > 0">
          <li v-for="post in category.posts" :key="post.id">
              <router-link :to="{name: 'single-post', params: {slug: post.slug}}">{{post.title}}</router-link>
            </li>
      </ul>
      <p v-else>Non ci sono posts associati a questa categoria</p>
  </div>
</template>

<script>
export default {
    name: "SingleCategory",
    data() {
        return {
            category: {}
        }
    },
    created() {
        axios.get(`/api/categories/${this.$route.params.slug}`)
            .then( (response) => {
                this.category = response.data;
            })
            .catch( () => {
                this.$router.push({name: 'page-404'});
            });
    }
}
</script>

<style>

</style>
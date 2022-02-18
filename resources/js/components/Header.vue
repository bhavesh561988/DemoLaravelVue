<template>
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <!-- <router-link to="/" class="navbar-brand">Shop</router-link> -->
    <div class="collapse navbar-collapse">
      <div class="navbar-nav">
        <router-link to="/" class="nav-item nav-link" v-if="this.$route.name !== 'admin'">Products</router-link>
        <router-link to="/orders" class="nav-item nav-link" v-if="this.$route.name !== 'admin'">My Orders</router-link>

        <router-link to="/admin" class="nav-item nav-link" v-if="this.$route.name == 'admin'">Orders</router-link>
      </div>
    </div>
  </nav>
</template>
<script>
export default {};
</script>


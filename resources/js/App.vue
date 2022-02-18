<template>
    <div>
        <Header />
        <div class="container"> 
            <router-view> </router-view>
        </div>
    </div>
</template>
 
<script>
import Header from './components/Header.vue';
export default {
    return: {},
    components: {
        Header
    }
}
</script>
<style scoped>
.cont{
    margin: 10px;;
}
</style>

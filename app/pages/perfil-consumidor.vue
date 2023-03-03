<template>
    <div class="container-perfil">

        <CapaPerfil></CapaPerfil>

        <nav>
            nav
        </nav>
    </div>
</template>


<script>
import CapaPerfil from '~~/components/perfil-consumidor/capa-foto-perfil.vue';

export default {
    layout: 'auth',

    components:{
        CapaPerfil
    }
}
</script>


<style scoped>
    .container-perfil{
        max-width: 70%;
        margin: 0 auto;
    }

    @media(max-width: 960px){
        .container-perfil{
            max-width: 100%;
        }
    }
</style>
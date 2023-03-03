<template>

    <div>
        <MainContainerLogin></MainContainerLogin>
    </div>

</template>


<script>
import MainContainerLogin from '~/components/login/main-login.vue'

    export default{
        data(){
            return{
                Input: true
            }
        },

        components:{
            MainContainerLogin
        }
    }
</script>


<style>

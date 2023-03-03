<template>
    <div>
        <nuxt></nuxt>
    </div>
</template>


<script>
import axios from 'axios';

export default {
    mounted(){
        this.VerificarToken();
    },

    methods:{

        VerificarToken(){
            axios.post('http://localhost/projetos/ex01/backend/public/auth/auth.php', JSON.stringify({
                'token': sessionStorage.getItem('key')
            })).then( Response => { 
                if(Response.data != 'falha na verificação de token'){
                    this.$router.push('/')
                }
            })
        }


        
        
    }


    
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap');


    html{
        font-size: 62.5%;
    }

    body{
        font-size: 1.6rem;
        font-family: 'Nunito', sans-serif;
    }

    


</style>
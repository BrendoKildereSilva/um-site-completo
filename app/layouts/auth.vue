<template>
    <div>
        
        <ComponentHeader></ComponentHeader>

        <div>
            <nuxt></nuxt>
        </div>
    </div>
</template>


<style>

html{
    font-size: 62.5%;
}

body{
    font-size: 1.6rem;
    font-family: 'Nunito', sans-serif;
    list-style: none;
    text-decoration: none;
}

</style>





<script>
import axios from 'axios';
import ComponentHeader from '~/components/layouts/auth/header.vue'

export default {

    mounted(){
        this.VerificarToken();
    },

    components:{
        ComponentHeader
    },



    methods:{
        VerificarToken(){
            axios.post('http://localhost/projetos/ex01/backend/public/auth/auth.php', JSON.stringify({
                'token': sessionStorage.getItem('key')

            })).then( Response => { 
                if(Response.data != 'falha na verificação de token'){
                    var dados = {
                        dados: Response.data
                    }
                    this.$store.dispatch('ArmazenarDadosDeSession', dados)
                }
                else
                {
                    this.$router.push('/login')
                }
            })
        },

      

        

       

        
    }
    
}
</script>


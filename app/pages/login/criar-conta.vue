<template>
    <div>
            <h2>Criar conta</h2>

            <ContainerMainRegistro></ContainerMainRegistro>
            
            
    </div>
</template>



<script>
import ContainerMainRegistro from '~/components/criar-conta/main-registro.vue'

export default{
    

    components:{
        ContainerMainRegistro
    }



}

</script>



<style>

h2{
    font-size: 2rem;
    margin: 1rem 0rem 2rem 0rem;
    color: rgb(255, 255, 255);
    
}







</style>

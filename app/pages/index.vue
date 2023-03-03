<template>


  <main>  
        <ContainerPublicacoes :PROPSPaginaAtual="PaginaAtual"/>
        <NuxtChild/>
  </main>


</template>




<script>
import ContainerPublicacoes from '~/components/publicações/publicacoes.vue';

export default {
  name: 'IndexPage',

  components:{
        ContainerPublicacoes
  },

  data(){
    return{
      PaginaAtual: ""
    }
  },

  mounted(){

    this.IndentificarPgAtual()

  },

  methods:{
    

    IndentificarPgAtual(){
      
      if(!this.$router.history.current.query.page){
        this.PaginaAtual = 1
      }
      else
      {
        this.PaginaAtual = this.$router.history.current.query.page
      }




    }

  },

   

  layout: 'auth'
}
</script>


<style scoped>
  main{
    width: 100vw;
    height: 100vh;
    background: rgb(246, 253, 255);
    max-width: 100%;
  }

</style>

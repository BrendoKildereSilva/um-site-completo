<template>
    <div>
        <div class="container-publicações">
            <section v-for="Dados in this.publicacoes" :key="Dados.id" >
                <NuxtLink :to="'public/' + Dados.link">

                    <div class="header_publi">

                        <div class="usuario_info">
                            <img :src="Dados.src_imagem_perfil_user" alt="foto_perfil_usuario">

                            <p>
                                {{ Dados.nome_user }}
                            </p>
                        </div>

                        <p class="data_publicação">
                            {{Dados.data_publicada}}
                        </p>

                    </div>

                    <p class="nome_publicação">
                        {{Dados.nome_publicação}}
                    </p>

                    <div>
                        <img :src="Dados.imagem_src" alt="Imagem_publicação">
                    </div>

                    <div>
                        <p>
                            {{ Dados.preço_valor}}
                        </p>

                        
                        <p v-if="Dados.frete == 'null'" class="p-frete-grates">
                            Frete grátis
                        </p>
    
                    </div>

                </NuxtLink>
            </section>
        </div>

        <nav class="container-paginação" v-if="this.PageAtual != null">
            <ul>
                <li @click="AtualizarPage" v-if="this.NavegarPaginacao01 != null">
                    <NuxtLink class="paginacao-cetas"  :to="'/?page=' + 1"> &#60;&#60; </Nuxtlink>
                </li>
                <li @click="AtualizarPage" class="paginacao-cetas" v-if="this.NavegarPaginacao02 != null">
                    <NuxtLink class="paginacao-cetas" :to="'/?page=' + (this.PageAtual - 1)"> 	&#60; </Nuxtlink>
                </li>
            
                <li @click="AtualizarPage" v-if="this.NavegarPaginacao01 != null">
                    <NuxtLink  :to="'/?page=' + NavegarPaginacao01">{{NavegarPaginacao01}}</Nuxtlink>
                </li>
                <li @click="AtualizarPage" v-if="this.NavegarPaginacao02 != null">
                    <NuxtLink  :to="'/?page=' + NavegarPaginacao02">{{NavegarPaginacao02}}</Nuxtlink>
                </li>
                <li class="PaginaAtual">
                    {{ PageAtual}}
                </li>
                <li @click="AtualizarPage" v-if="this.NavegarPaginacao03 != null">
                    <NuxtLink  :to="'/?page=' + NavegarPaginacao03">{{NavegarPaginacao03}}</Nuxtlink>
                </li>
                <li @click="AtualizarPage" v-if="this.NavegarPaginacao04 != null">
                    <NuxtLink  :to="'/?page=' + NavegarPaginacao04">{{NavegarPaginacao04}}</Nuxtlink>
                </li>

                <li @click="AtualizarPage" class="paginacao-cetas" v-if="this.NavegarPaginacao03 != null">
                    <NuxtLink  class="paginacao-cetas" :to="'/?page=' +  (parseInt(this.PageAtual) + 1) "> &#62; </Nuxtlink>
                </li>
                <li @click="AtualizarPage" class="paginacao-cetas" v-if="this.NavegarPaginacao04 != null">
                    <NuxtLink  class="paginacao-cetas" :to="'/?page=' + this.QuantidadeDePaginas"> &#62;&#62; </Nuxtlink>
                </li>
                
            </ul>

        </nav>
    </div>
</template>


<script>

import axios from 'axios';
export default {

    data(){
        return{
            publicacoes: [],
            // 
            PageAtual: null,
            NavegarPaginacao01: null,
            NavegarPaginacao02: null,
            NavegarPaginacao03: null,
            NavegarPaginacao04: null,
            QuantidadeDePaginas: null,
            // 
            rows: 100,
            perPage: 10,
            currentPage: 1
            
            
        }
    },

    async mounted(){
        this.IndentificarPaginaAtual();
        await this.ResgatarQuantidadeDePublicacoes();
        this.ResgatarPublicacoes()
        this.paginacao();
        
    },


    methods:{
        

        ResgatarPublicacoes(){   
            var form = new FormData();
            form.append('NumeroDaPagina', this.PageAtual)
            axios.post('http://localhost/projetos/ex01/backend/public/publicações/ExibirPublicações.php', form)
             .then(Response => { 
                this.publicacoes = Response.data 
            })

        },
        
        IndentificarPaginaAtual(){
            if(!this.$router.history.current.query.page){
                this.PageAtual = 1
            }
            else
            {
                this.PageAtual = this.$router.history.current.query.page

            }
        },

        async ResgatarQuantidadeDePublicacoes(){
            await axios.get('http://localhost/projetos/ex01/backend/public/publicações/Paginacao.php').
            then(Response=> { 
                this.QuantidadeDePaginas = Response.data
            })
        },

        paginacao(){
            this.NavegarPaginacao01 = this.PageAtual - 2
            this.NavegarPaginacao02 = this.PageAtual - 1
            this.NavegarPaginacao03 = parseInt(this.PageAtual) + 1
            this.NavegarPaginacao04 = parseInt(this.PageAtual) + 2


            if(this.PageAtual == 1){
                this.NavegarPaginacao01 = null
                this.NavegarPaginacao02 = null
            }

            if(this.PageAtual == 2){
                this.NavegarPaginacao01 = null
            }


            if(this.PageAtual == this.QuantidadeDePaginas){
                this.NavegarPaginacao03 = null
                this.NavegarPaginacao04 = null
            }


            if(this.PageAtual == (this.QuantidadeDePaginas - 1)){
                this.NavegarPaginacao04 = null
            }

            if(this.PageAtual > this.QuantidadeDePaginas){
                this.PageAtual = null
                this.NavegarPaginacao01 = null
                this.NavegarPaginacao02 = null
                this.NavegarPaginacao03 = null
                this.NavegarPaginacao04 = null
            }


        },


       AtualizarPage(){
            window.location.reload();
        }


        

        

       
    
    }

}

</script>


<style scoped>
    
    .container-publicações{
        display: grid;
        grid-template-columns: repeat(auto-fill, 30rem);
        justify-content: center;
        grid-gap: 1rem;
    }

    
    section{
        padding: 1rem;
        margin-top: 1rem;
        background: #fff;
        border-radius: 1rem;
        border: 0.1rem solid #ccc;
        cursor: pointer;

    }

    section:hover{
        box-shadow: 0.1rem 0.1rem 1rem 0.1rem rgba(0,0,0, 0.2);

    }

  

    

    section img{
        width: 28rem;
    }

    a{
        background: #ccc;
        text-decoration: none;
        color: #000;
    }

    .header_publi{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        width: 100%;
    }

    

    .usuario_info img{

        border-radius: 50%;
        width: 2.5rem;
        height: 2.5rem;
    }

    .data_publicação{
        font-size: 1.3rem;
        margin-left: 1rem;
    }

    .nome_publicação{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .container-paginação{
        padding: 4rem 0rem;
        display: flex;
        justify-content: center;
    }

    .p-frete-grates{
        color: rgb(41, 182, 69);
        font-size: 1.3rem;
    }

   .container-paginação ul{
       list-style: none;
    display: flex;
    align-items: center;

   }

   .container-paginação ul li{
    margin: 0rem 0.1rem;

   }

   .container-paginação ul li a{
    padding: 0.3rem;
    color: rgb(0, 149, 255);
    font-weight: 100;
    background: transparent;
    border: 0.1rem solid #ccc;
    font-size: 2rem;

   }

   .container-paginação ul li a:hover{
        border: 0.1rem solid rgb(0, 149, 255);

   }

   .container-paginação ul .PaginaAtual{
        padding: 0.3rem;
        font-weight: 100;
        font-size: 2rem;
        color: #fff;
        background: rgb(0, 149, 255);

   }


    .container-paginação ul li .paginacao-cetas{
        font-size: 1.5rem;
        padding: 0.7rem 0rem;
    }

   




    
    


</style>
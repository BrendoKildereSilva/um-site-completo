<template>
    <header>
            <nav>
                <Nuxt-link to="/">
                    <img class="miniatura" src="~~/img/header-layout-auth/logo.png" alt="logo">
                </Nuxt-link>
                
                <ul>
                    <Nuxt-link to="/publicar-produto">
                        <img  class="icon" src="~~/img/header-layout-auth/upload.svg" alt="perfil">
                    </Nuxt-link>

                    <Nuxt-link to="/perfil-consumidor">
                        <img class="miniatura" :src=" $store.state.user.FotoPerfil " alt="perfil">
                    </Nuxt-link>

                    <img @click="AbrirOptions" id="icon-options" class="button-options" src="~~/img/header-layout-auth/menu-pontos-vertical.svg" alt="menu">
                    

                    <div class="container-options" id="container-options" v-if="this.ContainerOptionsAtivo == true">
                        <div class="options" id="options">
                            Configurações <img class="icon" src="~~/img/header-layout-auth/engrenagem.svg" alt="">
                        </div>
                        <div class="options" id="options" @click="EncessarSessao">
                            Encessar sessao <img class="icon" src="~~/img/header-layout-auth/saida.svg" alt="">
                        </div>
                    </div>
                </ul>




                <!-- MENU MEDIA QUERY -->

                <div class="menu">

                    <img @click="AbrirOptions" class="icon" id="icon-options" src="~~/img/header-layout-auth/menu-hamburguer.svg" alt="menu">
                    

                    <div class="background-cinza" v-if="this.ContainerOptionsAtivo == true">

                        
                        <ul v-if="this.ContainerOptionsAtivo == true" id="container-options">

                            <img @click="AbrirOptions" class="icon" id="icon-options" src="~~/img/header-layout-auth/cruz.svg" alt="menu">

                            <Nuxt-link to="/perfil-consumidor">
                                <p>
                                    {{ $store.state.user.nome }}
                                    {{ $store.state.user.sobrenome }}
                                </p>

                                <img class="miniatura" :src=" $store.state.user.FotoPerfil " alt="perfil">
                            </Nuxt-link>
                            <Nuxt-link to="/publicar-produto">
                            publicar produto
                            <img  class="icon" src="~~/img/header-layout-auth/upload.svg" alt="perfil">
                            </Nuxt-link>

                            <div class="option" @click="EncessarSessao">Encerrar Sessão <img class="icon" src="~~/img/header-layout-auth/saida.svg" alt=""></div>
                        </ul>
                    </div>

                </div>

            </nav>
    </header>
</template>



<script>

export default {
    data(){
        return{
            ContainerOptionsAtivo: false
        }
    },

    mounted(){
        document.addEventListener('click' , (e) => {

            if(e.target.id != 'container-options' && e.target.id != 'icon-options' && e.target.id != 'options'){
                this.ContainerOptionsAtivo = false
            }
        })
    },


    layout: 'auth',

    methods:{

        AbrirOptions(){
            if(this.ContainerOptionsAtivo == false)
            {
                this.ContainerOptionsAtivo = true
            }
            else
            {
                this.ContainerOptionsAtivo = false
            }
        },

        EncessarSessao(){
            sessionStorage.removeItem('key')
            this.$router.push('/login')
        }
    }
    
}
</script>


<style scoped>
    

    header{
        background: rgb(245, 245, 245);
        border-bottom: 1px solid #ccc;
        padding: 10px 0px;
    }

    .menu{
        display: none;
        z-index: 100;
    }

    nav{
        max-width: 70%;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        
    }

    ul{
        display: flex;
        align-items: center;
        position: relative;
    }

    ul a{
        margin-right: 2rem;
    }

    nav a{
        color: #fff;
        text-decoration: none;
    }

    .button-options{
        color: rgb(0, 0, 0);
        height: 2rem;
        width: 2rem;
        border-radius: 50%;

        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .container-options{
        z-index: 1000;
        position: absolute;
        top: 6rem;
        right: 0rem;
        background: rgb(255, 255, 255);
    }

    .options{
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 5rem;
        width: 20rem;
        cursor: pointer;
        background: rgb(244, 246, 255);
        padding: 1rem 1rem;
    }

    .options:hover{
        background: rgb(27, 164, 255);
        color: #fff;
    }


    li{
        list-style: none;
    }

    /*  */

    .miniatura{
        border: 0.1rem solid rgb(255, 255, 255);
        border-radius: 50%;
        height: 4rem;
        width: 4rem;
    }

    .icon{
        height: 2rem;
        width: 2rem;
    }

    .button-options .icon{
        height: 1.5rem;
        width: 1.5rem;
    }

    .background-cinza{
        background: #ffffff90;
        height: 100vh;
        width: 100vw;
        position: fixed;
        top: 0rem;
        right: 0rem;

        display: flex;
        justify-content: flex-end;
    }


    @media(max-width: 960px){

        nav{
            max-width: 90%;
        }

        ul{
            display: none;
        }

        .menu{
            display: flex;
            align-items: center;
        }

        .menu .icon{
            cursor: pointer;
            height: 3rem;
            width: 3rem;
        }


        .menu ul{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            right: 0rem;
            background: rgb(245, 245, 245);
            height: 100vh;
            width: 30vw;
            padding: 0rem;
        }

        .menu ul .iconX{
            margin: 0 auto;
        }

        .menu a, .menu .option{
            cursor: pointer;
            color: #000;
            padding: 1rem 4rem;
            height: 5rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 0.1rem solid #ccc
        }

        .menu a:hover, 
        .menu .option:hover{
            background: rgb(27, 164, 255);
            color: #fff;
        }

        

        
    }

    @media(max-width: 860px){
        .menu .icon{
            width: 2rem;
            height: 2rem;
        }

        .menu ul .icon{
            margin-right: 1rem;

        }

       

        .menu ul {
            width: 50vw;
        }
    }

    @media(max-width: 560px){
        .menu a,
        .menu .option
        {
            padding: 1rem 1.5rem;
        }

        .menu ul{
            width: 100vw;
        }
    }



   

    
</style>
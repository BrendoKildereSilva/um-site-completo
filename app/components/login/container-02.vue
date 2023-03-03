<template>


    <div>

        <div class="header">
            <h2>Login</h2>


            <button @click.prevent="ButtonVoltar">voltar</button>
            
        </div>

        <div class="container-main">


            
            <div class="container-01">
                <div class="container-info">
                    <p>Esse conta pertece a você?</p>
                    <p> {{ email }}</p>
                </div>
                <div class="container-imagem">
                    <img :src="FotoPerfilUserContainer02" alt="imagem_perfil">
                </div>
            </div>

            <div class="container-02">

                <div class="container-senha">
                    <b-form-input id="input-senha" placeholder="Digite sua senha..." v-model="senha"></b-form-input>
                    <label for="senha">senha</label> 
                </div>

                <p class="mensagem-de-erro" v-if="this.MensagemDeErro">
                    {{ MensagemDeErro }}
                </p>


                <div class="container-button">
                    
                    <button @click.prevent="VerificarDados">Entrar</button>
                </div>

            </div>
            
        </div>

    </div>



    
</template>


<script>
import axios from 'axios';

export default {
    props:{
        email: String,
        FotoPerfilUserContainer02: String,
    },

    data(){
        return{
            FotoPerfil: "",
            MensagemDeErro: "",
            senha: ""
        }
    },

    methods:{
        ButtonVoltar(){
            this.$emit('Voltar')
        },

        async VerificarDados(){

                
                var form = new FormData()
                form.append('email', this.email)
                form.append('senha', this.senha)

        
                await axios.post('http://localhost/projetos/ex01/backend/public/login/login.php', form).then(Response => { 
                    
                    if(Response.data.mensagem  == 'Dados invalidos' || Response.data.mensagem == 'Apenas o Email valido'){
                            this.MensagemDeErro = 'senha incorreta'
                    }
                    else if(Response.data.mensagem == 'Dados validos')
                    {   
                        this.$emit("DadoValidos", Response.data.token)
                    }

                    // Email valido
                    //Dados Validos
                    //Dados invalidos

                })



        }
    }
}
</script>


<style scoped>  

    button{
        border: 0px;
        height: 3rem;
        background: #3737f9;
        color: #fff;
        cursor: pointer;
    }

    button:hover{
        background: #2626ff;
    }

    .header{
        align-items: center;
        width: 100%;
        display: flex;
        justify-content: space-between;
    }


    .container-01
    {
        width: 80%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .container-02{
        width: 100%;
    }

    .container-01 img{
        width: 3rem;
        height: 3rem;
    }
  

    .container-main{
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 70%;
        margin: 0 auto;
    }

    .container-button{
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .container-button button{
        margin: 1rem 0rem;
        width: 100%;
    }


    /*  */

    .container-info p{
        margin: 0px;
        text-align: center;
        font-size: 1.3rem;
    }

    .container-imagem{
        width: 15rem;
        height: 15rem;
        
    }

    .container-imagem img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: flex;
        justify-content: center;
    }

    /*  */

    .container-senha{
        width: 100%;
        display: flex;
        flex-direction: column-reverse;
    }
    
    label{
        margin: 0px 0px;
        font-size: 2rem;
    }

    .form-control{
        font-size: 1.3rem;
        width: 100%;
    }

    .mensagem-de-erro{
        color: red;
        font-size: 1.2rem;
        margin-bottom: 0px;
        font-weight: bold;
    }


    @media(max-width: 1000px){
        .header{
            margin-bottom: 1rem;
        }
    }

    @media(max-width: 760px){
        .container-01{
            width: 60%;
        }
    }

    @media(max-width: 500px){
        

        .container-main{
            max-width: 70%;
        }

        .container-01{
            width: 100%;
        }
    }

    @media(max-width: 420px){
        .container-main{
            max-width: 100%;
        }
    }

    

   

   

    
</style>
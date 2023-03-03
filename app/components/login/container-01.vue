<!--  CONTAINER PADRÃO QUE REQUER EMAIL E SENHA !--->
<template>
    <div>
        <h2>Login</h2>
        <div v-if="this.MensagemDeErro == false" class="container-mensagem-de-erro">
            <p>
                Dados invalidos
            </p>
        </div>

        <div class="container-email">
            <p class="mensagem-de-erro" v-if="this.StatusEmail == false">Preencha esse campo</p>
            <b-form-input id="input-email" v-model="email" placeholder="Digite seu email..."></b-form-input>
            <label for="input-email">E-mail</label>
        </div>

        <div class="container-senha">
            <p class="mensagem-de-erro" v-if="this.StatusSenha == false" >Preencha esse campo</p>
            <b-form-input id="input-senha" v-model="senha" placeholder="Digite sua senha..."  type="password"></b-form-input>
            <label for="input-senha">senha</label>

        </div>

        <div>
            <input type="checkbox" v-model="StatusCheckBox" @click="VisualizarSenha">
            <span>Visualizar senha</span>
        </div>

        <div class="container-button" >
            <button @click.prevent="VerificarDados">Entrar</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data(){
        return{
            // 
            MensagemDeErro: null,
            StatusEmail: null,
            StatusSenha: null,
            // 
            StatusCheckBox: "",
            senha: "",
            // 
            StatusErro: null
            
        }
    },

    props:{
        email: String,
    },

    methods:{
        MensagemDeErroDosCampos(){
            if(!this.email)
            {
                this.StatusEmail = false
            }
            else
            {
                this.StatusEmail = true
            }


            if(!this.senha)
            {
                this.StatusSenha = false
            }
            else
            {
                this.StatusSenha = true
            }
        },

        async VerificarDados(){

            this.MensagemDeErroDosCampos();

            if(!this.email || !this.senha)
            {   
                this.StatusErro = false
                this.MensagemDeErro = 'Preencha todos os campos'
            }
            else
            {
                var form = new FormData()
                form.append('email', this.email)
                form.append('senha', this.senha)

                await axios.post('http://localhost/projetos/ex01/backend/public/login/login.php', form).then(Response => { 


                    if(Response.data.mensagem == 'Dados invalidos'){
                            this.MensagemDeErro = false
                    }

                    else if(Response.data.mensagem == 'Apenas o Email valido')
                    {   
                        var dados = {
                            'foto_perfil': Response.data.foto_perfil,
                            'email': this.email
                        }
                        this.$emit('AcionarContainerLoginApartirDoEmail', dados);
                    }
                    
                    else if(Response.data.mensagem == 'Dados validos')
                    {   
                        this.$emit("DadoValidos", Response.data.token)
                    }

                })
            }


        },
        
        VisualizarSenha(){
            
            if(this.StatusCheckBox == false){
                document.getElementById('input-senha').setAttribute('type', 'text')
            }
            else
            {
                document.getElementById('input-senha').setAttribute('type', 'password')
            }
        }
    }
}
</script>


<style scoped>
    label{
        margin: 0px;
    }

    .form-control{
        background: #ffffff90;
        height: 3rem;
        font-size: 1.3rem;
    }

    .form-control:focus{
        border: 0px;
        box-shadow: 0px 0px 0px 0px !important;
    }

    .container-email,
    .container-senha
    {
        margin-bottom: 2rem;
        display: flex;
        flex-direction: column-reverse;
    }

    .form-control:focus + label{
        color: #568fff;
    }

    button{
        margin: 3rem 0rem;
        width: 100%;
        height: 3rem;
        background: #3737f9;
        color: #fff;
        border: 0px;
    }

    button:hover{
        background: #2323bd;
    }

    input[type=checkbox]{
        cursor: pointer;
    }

    span{
        font-size: 1.5rem;
    }

    p{
        margin-bottom: 0px;
    }
    .mensagem-de-erro{
        color: red;
        font-size: 1.2rem;
        margin-bottom: 0px;
        font-weight: bold;
    } 

    .container-mensagem-de-erro{
        background: red;
        color: #fff;
        width: 40%;
        text-align: center;
        margin: 1rem auto;
    }
     
</style>
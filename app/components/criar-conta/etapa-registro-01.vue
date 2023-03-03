<template>
    <div>
        <div class="container-nomes">

            <div>
                <b-form-input 
                id="input-nome" 
                :state="StatusNome" 
                required  v-model="nome"
                @keyup="ValidarCampoNome"></b-form-input>
                <label for="input-nome">Nome</label>

                <p class="mensagem-de-erro">
                    {{ MensagemDeErroNome }}
                </p>
            </div>
            <div>
                <b-form-input id="input-sobrenome" 
                :state="StatusSobrenome" required
                @keyup="ValidarCampoSobrenome"
                v-model="sobrenome"
                ></b-form-input>
                <label for="input-sobrenome">Sobrenome (Opicional)</label>

                <p class="mensagem-de-erro"> {{ MensagemDeErroSobrenome }}</p>
            </div>

        </div>

        <div class="container-email">
                <b-form-input id="input-email" 
                @keyup="ValidarCampoEmail" v-model="email"
                :state="StatusEmail" required></b-form-input>
                <label for="input-email">E-mail</label>
                
                <p class="mensagem-de-erro" > {{ MensagemDeErroEmail }}</p>            
        </div>
        

        <div class="container-senhas">            
            <div>
                <b-form-input id="input-senha"  type="password" :state="StatusSenha" 
                required v-model="senha" @keyup="ValidarCampoSenha"></b-form-input>
                <label for="input-senha">Senha</label>

                <p class="mensagem-de-erro"> {{ MensagemDeErroSenha }}</p>

            </div>
            <div>
                <b-form-input id="input-confirmar-senha" type="password"
                :state="StatusConfirmarSenha"
                required
                v-model="confirmarsenha"
                @keyup="ValidarCampoConfirmarSenha"></b-form-input>

                <label for="input-confirmar-senha">Confirmar senha</label>
                <p class="mensagem-de-erro"> {{ MensagemDeErroConfirmarSenha }}</p>

            </div>
        </div>

        <div class="container-checkbox">
            <input type="checkbox" id="checkbox-senhas" required @change="VisualizarOUesconderSenhas">
            <label for="checkbox-senhas">Visualizar senhas</label>
        </div>

        <div class="container-button">
          <button @click.prevent="ProximaEtapa">Proxima etapa</button>
        </div>

    </div>
</template>

<script>
import axios from 'axios'

    export default{
        data(){
            return{
                MensagemDeErroNome: '',
                MensagemDeErroSobrenome: '',
                MensagemDeErroEmail: '',
                MensagemDeErroSenha: '',
                MensagemDeErroConfirmarSenha: '',
                // 
                VisualizarSenhas: false
            }
        },
        props:{
            nome: String,
            sobrenome: String,
            email: String,
            senha: String,
            confirmarsenha: String,
            // 
            StatusNome: Boolean,
            StatusSobrenome: Boolean,
            StatusEmail: Boolean,
            StatusSenha: Boolean,
            StatusConfirmarSenha: Boolean,
            // 
            CampoConfirmarSenhaAcionado:  Boolean,
            // 
            EmailEmUso: Boolean
        },

        methods:{
            ProximaEtapa(){
                
                if(this.StatusSobrenome == null){
                    this.StatusSobrenome = true
                }

                if(this.StatusNome && this.StatusSobrenome && this.StatusEmail && this.StatusSenha && this.StatusConfirmarSenha){
                    
                        var dados = {
                            nome: this.nome,
                            sobrenome: this.sobrenome,
                            email: this.email,
                            senha: this.senha,
                            confirmarsenha: this.confirmarsenha,
                            // 
                            StatusNome: this.StatusNome,
                            StatusSobrenome: this.StatusSobrenome,
                            StatusEmail: this.StatusEmail,
                            StatusSenha: this.StatusSenha,
                            StatusConfirmarSenha: this.StatusConfirmarSenha,
                            // 
                            CampoConfirmarSenhaAcionado: this.CampoConfirmarSenhaAcionado,
                            EmailEmUso: this.EmailEmUso
                        }
                        
                        this.$emit('ProximaEtapa', dados)
                }
                else
                {
                    this.ValidarCampoNome()
                    this.ValidarCampoSobrenome()
                    this.ValidarCampoEmail()
                    this.ValidarCampoSenha()
                    this.ValidarCampoConfirmarSenha()     
                }
            },


            RegexCaracteresEspeciais(Regex){
                var regex = /\W|_/g
                return regex.test(Regex)
            },

            RegexNumeros(Regex){
                var regex = /[0-9]/g
                return regex.test(Regex)
            },

            RegexLetraMaiuscula(Regex){
                var regex = /[A-Z]/g
                return regex.test(Regex)
            },

            RegexLetraMinuscula(Regex){
                var regex = /[a-z]/g
                return regex.test(Regex)
            },

            ValidarCampoNome(){
                if(!this.nome){
                    this.MensagemDeErroNome = 'Preencha esse campo',
                    this.StatusNome = false
                }
                else if(this.RegexCaracteresEspeciais(this.nome))
                {
                    this.MensagemDeErroNome = 'Insira apenas letras e numeros',
                    this.StatusNome = false
                }
                else if(this.nome.length < 6)
                {
                    this.MensagemDeErroNome = 'Insira no minimo 06 caractere',
                    this.StatusNome = false
                }
                else if(this.nome.length > 15)
                {
                    this.MensagemDeErroNome = 'Nome muito grande!',
                    this.StatusNome = false
                }
                else
                {
                    this.MensagemDeErroNome = '',
                    this.StatusNome = true
                }
                
            },

            ValidarCampoSobrenome(){
                if(this.sobrenome == '' || this.sobrenome == null || !this.sobrenome){
                    this.MensagemDeErroSobrenome = ""
                    this.StatusSobrenome = null
                }
                else if(this.RegexCaracteresEspeciais(this.sobrenome))
                {
                    this.MensagemDeErroSobrenome = "Insira apenas letras e numeros"
                    this.StatusSobrenome = false  
                }
                else if(this.sobrenome.length < 5)
                {
                    this.MensagemDeErroSobrenome = "Insira no minimo 06 caractere"
                    this.StatusSobrenome = false
                }
                else if(this.sobrenome.length > 15)
                {
                    this.MensagemDeErroSobrenome = "Sobrenome muito grande!"
                    this.StatusSobrenome = false
                }
                else
                {
                    this.MensagemDeErroSobrenome = ""
                    this.StatusSobrenome = true
                }
            },

            async ValidarCampoEmail(){
                var email = ''
                email = this.email
                email += '@gmail.com'
                // 
                var form = new FormData();
                form.append('email', email);
                //
                await axios.post('http://localhost/projetos/ex01/backend/public/criar-conta/email-em-uso.php', form).then(Response => { 
                    if(Response.data == 'já tem uma conta registrada com esse email'){
                        this.EmailEmUso = true
                    }
                    else if('não tem uma conta registrada com esse email')
                    {
                        this.EmailEmUso = false
                    }
                })


    



                if(!this.email)
                {
                    this.MensagemDeErroEmail = "Preencha esse campo"
                    this.StatusEmail = false
                }
                else if(this.RegexCaracteresEspeciais(this.email))
                {
                    this.MensagemDeErroEmail = "Insira apenas letras e numeros"
                    this.StatusEmail = false
                }
                else if(this.EmailEmUso)
                {
                    this.MensagemDeErroEmail = "Esse email já está em uso"
                    this.StatusEmail = false
                }
                else if(this.email.length >= 30)
                {
                    this.MensagemDeErroEmail = "Insira no maximo 30 caracterers"
                    this.StatusEmail = false
                }
                else
                {
                    this.MensagemDeErroEmail = ""
                    this.StatusEmail = true
                }
            },

            ValidarCampoSenha(){
                if(!this.senha)
                {
                    this.MensagemDeErroSenha = 'Preencha esse campo'
                    this.StatusSenha = false
                }
                else if(this.senha.length < 6)
                {   
                    this.MensagemDeErroSenha = 'Insira no minimo 06 caractere'
                    this.StatusSenha = false
                }
                else if(this.senha.length >= 15)
                {
                    this.MensagemDeErroSenha = 'Insira no maximo 15 caractere'
                    this.StatusSenha = false
                }
                else if(!this.RegexCaracteresEspeciais(this.senha))
                {
                    this.MensagemDeErroSenha = 'Insira algum caractere especial Ex: (!@#$%&*)'
                    this.StatusSenha = false
                }
                else if(!this.RegexNumeros(this.senha))
                {
                    this.MensagemDeErroSenha = 'Insira um numero [0-9]'
                    this.StatusSenha = false
                }
                else if(!this.RegexLetraMinuscula(this.senha))
                {
                    this.MensagemDeErroSenha = 'Insira uma letra minúscula (a-z)'
                    this.StatusSenha = false
                }
                else if(!this.RegexLetraMaiuscula(this.senha))
                {
                    this.MensagemDeErroSenha = 'Insira uma letra maiúscula (A-Z)'
                    this.StatusSenha = false
                }
                else{
                    this.MensagemDeErroSenha = ''
                    this.StatusSenha = true
                }


                if(this.CampoConfirmarSenhaAcionado)
                {
                    this.ValidarCampoConfirmarSenha()
                }
            },

            ValidarCampoConfirmarSenha(){
                this.CampoConfirmarSenhaAcionado = true
                if(!this.confirmarsenha)
                {
                    this.MensagemDeErroConfirmarSenha = "Preencha esse campo"
                    this.StatusConfirmarSenha = false
                }
                else if(this.confirmarsenha != this.senha)
                {
                    this.MensagemDeErroConfirmarSenha = "Erro na confirmação de senha"
                    this.StatusConfirmarSenha = false
                }
                else 
                {
                    this.MensagemDeErroConfirmarSenha = ""
                    this.StatusConfirmarSenha = true
                }
            },

            VisualizarOUesconderSenhas(){
                

                if(!this.VisualizarSenhas){
                    document.getElementById('input-senha').setAttribute('type', 'text')
                    document.getElementById('input-confirmar-senha').setAttribute('type', 'text')
                    this.VisualizarSenhas = true
                }
                else
                {
                    document.getElementById('input-senha').setAttribute('type', 'password')
                    document.getElementById('input-confirmar-senha').setAttribute('type', 'password')
                    this.VisualizarSenhas = false
                }

            }

        }
    }
</script>


<style scoped>
    /* =============================================================CONTAINER NOMES */
    .container-nomes{
        display: flex;
        justify-content: space-between;
    }

    .container-nomes div{
        width: 47%;
    }

    /* =============================================================CONTAINER SENHAS */

    .container-senhas{
        display: flex;
        justify-content: space-between;
    }

    .container-senhas div{
        width: 47%;
    }
    
    /* =============================================================container-checkbox */

    .container-checkbox{
        display: flex;
        align-items: center;
    }

    

    


    /* =============================================================Input, label globais, mensagem-de-erro checkbox*/
    
    .form-control{
        background: #ffffff40 !important;
        border: 1px solid #fff !important;
    }
    .container-nomes div, .container-senhas div, .container-email{
        position: relative;
    }

    label{
        top: 0.6rem;
        left: 0.5rem;
        position: absolute;
        z-index: 5;
        transition: 0.2s;
        white-space: nowrap;
        font-size: 1.3rem;
        font-weight: 100;
    }

    .form-control:focus{
        outline: none;
        box-shadow: 0px 0px 0px !important;
        border: 1px solid #4571ef !important;
    }

    input:focus + label
    {
        top: -1.5rem;
        left: 0.3rem;
        font-size: 1.3rem;
        transition: 0.2s;
        color: #6688f5;

    }

    input:valid + label{
        top: -1.5rem;
        left: 0.3rem;
        font-size: 1.3rem;
        transition: 0.2s;

    }
    
    .form-control.is-valid{
        border: 1px solid #6688f5;
        background-image: url('../../img/page-login/verificar.svg');
    }


    .form-control.is-invalid
    {
       border:1px solid #ff7664;
       background-image: url('../../img/page-login/cruz.svg');
       background-size: 0.8rem;
    }

    .form-control{
        height: 3rem;
        font-size: 1.3rem;
    }

    .mensagem-de-erro{
        font-weight: bold;
        color: #ff7664;
        font-size: 1.2rem;
    }

    .container-checkbox input{
        height: 1.5rem;
        width: 1.5rem;
        cursor: pointer;
    }

    .container-checkbox label{
        cursor: pointer;
        position: relative;
        top: 0.3rem;
        left: 1rem;
        font-size: 1.5rem;
    }

    

    .container-checkbox input:valid + label
    {
        top: 0.3rem;
        left: 1rem;
        font-size: 1.5rem;
        color:#4571ef;
    }

    .container-checkbox input:focus + label{
        top: 0.3rem;
        left: 1rem;
        font-size: 1.5rem;

    }

    
    /* CONTAINER BUTTON */
    .container-button{
        display: flex;
        margin: 3rem 0rem;
        justify-content: flex-end;
    }

    .container-button button{
        height: 3rem;
        background: #3737f9;
        color: #fff;
        border: 0px;
        border-radius: 0.6rem;
        font-size: 1.3rem;
    }

    .container-button button:hover{
        background: #2323bd;
    }


    

    


    


    /* =============================================================Margin entre inputs*/



    .container-email{
        margin-top: 2rem;
        margin-bottom: 3rem;
    }

    @media(max-width: 430px){
        .container-nomes{
            flex-direction: column;

        }

        .container-nomes div{
            margin: 1rem 0rem;
            width: 100%;
        }
    }



    

</style>




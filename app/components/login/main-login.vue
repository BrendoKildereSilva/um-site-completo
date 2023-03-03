<template>
    <div>

        <ContainerLogin01 v-if="this.container01 == true" 
        :email='email'
        @AcionarContainerLoginApartirDoEmail="AtivarContainer02"

        @DadoValidos="DadoValidos"

        />

        <ContainerLogin02 v-if="this.container02 == true"
        :email='email'
        :FotoPerfilUserContainer02="FotoPerfilUserContainer02"

        @Voltar="ButtonVoltarContainer02"
        @DadoValidos="DadoValidos"
        />

        
    </div>
</template>


<script>
import ContainerLogin01 from '~/components/login/container-01.vue'
import ContainerLogin02 from '~/components/login/container-02.vue'
export default {
    
    data(){
        return{
            container01: true,
            container02: false,
            email: '',
            FotoPerfilUserContainer02: ""
        }
    },

    methods:{
        AtivarContainer02(EmailContainer01){
            this.FotoPerfilUserContainer02 = EmailContainer01.foto_perfil
            this.email = EmailContainer01.email
            // 
            this.container01 = false
            this.container02 = true
        },

        ButtonVoltarContainer02(){
            this.container01 = true
            this.container02 = false
        },

        DadoValidos(token){
            sessionStorage.setItem('key', token);
            this.$router.push('/')
        }
    },

    components:{
        ContainerLogin01,
        ContainerLogin02
    },


}
</script>


<style scoped>
    h2{
        margin: 0.5rem 0px 0.5rem 0px;
    }
</style>
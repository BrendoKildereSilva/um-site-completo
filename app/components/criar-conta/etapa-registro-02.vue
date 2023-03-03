<template>
    <div>
        <div class="container-cargos">
            <p>Qual seu interrese com o nosso site?</p>

            <div class="cargos">   
                <div @click="FocusNoInputCargoConsumidor">
                    <p>Sou consumidor,eu quero conhecer e comprar novos</p>
                    <img src="../../img/page-login/icon-consumidor.png" alt="imagem-ilustrativa-consumidor">
                    <input type="radio" name="cargo" value="consumidor" v-model="cargo" @change="EscolherCargo" id="input-consumidor">
                </div>

                <div @click="FocusNoInputCargoProdutor">
                    <p>Sou produtor, eu quero publicar e vender os meus produtos</p>
                    <img src="../../img/page-login/icon-produtor.png" alt="imagem-ilustrativa-produtor">
                    <input type="radio" name="cargo" value="produtor" v-model="cargo" @change="EscolherCargo" id="input-produtor">
                </div>
            </div>

            <p class="mensagem-de-erro">
                    {{ MensagemDeErroEtapa02 }}
                </p>

            
            <div class="container-button">
                <button @click.prevent="VoltarEtapa">Voltar</button>
                <button @click.prevent="ProximaEtapa">Proxima etapa</button>
            </div>

            
            
        </div>
    </div>
</template>


<script >
    export default{
        

        props:{
            cargo: String,
            EscolheuCargo: Boolean,
            MensagemDeErroEtapa02: String

        },

        methods:{
            ProximaEtapa(){
                if(this.EscolheuCargo == false || !this.cargo || this.cargo == '')
                {
                    this.MensagemDeErroEtapa02 = 'Escolha uma opção para prosseguir'
                }
                else
                {
                    var dados = {
                        cargo: this.cargo,
                        EscolheuCargo: this.EscolheuCargo
                    }
                    this.$emit('ProximaEtapa', dados)
                }
            },

            VoltarEtapa(){
                var dados = {
                    cargo: this.cargo,
                    EscolheuCargo: this.EscolherCargo,
                    MensagemDeErroEtapa02: this.MensagemDeErroEtapa02
                }

                    this.$emit('VoltarEtapa', dados)
                
            },

    

            EscolherCargo(){
                this.EscolheuCargo = true
                this.MensagemDeErro = ''
            },


            FocusNoInputCargoConsumidor(){
                document.getElementById('input-consumidor').click()
            },

            FocusNoInputCargoProdutor(){
                document.getElementById('input-produtor').click()
            }
        }
    }
</script>

<style scoped>

p{
    text-align: center;
    color: #fff;
    font-weight: bold;
    font-size: 1.7rem;
}

.cargos{
    display: flex;
    justify-content: space-between;
}

.cargos img{
    height: 3rem;
    width: 3rem;
    margin: 1rem 0rem;
}

.cargos p{
    text-align: center;
    color: rgb(0, 0, 0);
    font-weight: 300;
    font-size: 1.3rem;
}

.cargos div{
    border: 1px solid #fff;
    background: #ffffff80;
    border-radius: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    width: 47%;
    padding: 1rem 0rem;
    cursor: pointer;
    
}

.cargos input{
    width: 1.5rem;
    height: 1.5rem;
    cursor: pointer;
}


.container-button{
    display: flex;
    margin: 3rem 0rem;
    justify-content: space-between;
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

.mensagem-de-erro{
    color: rgb(255, 95, 95);
}




</style>
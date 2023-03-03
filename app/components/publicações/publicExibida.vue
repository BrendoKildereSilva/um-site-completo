<template>
    <div class="container-public" v-if="this.ContainerPublicAtivo == true">   
        <section>   


            <div class="buttons">
                <button @click.prevent="RouterVoltar">
                    <img src="~~/img/publicacoes/seta-esquerda.svg" alt="Voltar">
                </button>
                <button @click.prevent="AbrirEFecharContainerMaisOptions" class="button-abrir-options">
                    <img src="~~/img/publicacoes/pontos-vetical.svg" alt="Mais opções" class="button-abrir-options">
                </button>
            </div>

            <div id="container-mais-options" class="container-mais-options" v-if="this.ContainerMaisOptionsAtivo == true">
                <li id="options">
                    Compartilhar publicação
                </li>
                <li id="options">
                    Adicionar aos favoritos
                </li>
                <li id="options" v-if="this.infoUser.email == this.$store.state.user.email">
                    Excluir publicação
                </li>
                <li id="options" v-if="this.infoUser.email == this.$store.state.user.email">
                    EditarPublicação
                </li>


            </div>

            <div class="container-main">

                <div class="container-01">

                    <div class="info-user-dono">
                        <div>

                            <img :src="infoUser.local_imagem + infoUser.foto_perfil " alt="foto de perfil do dono da publicação">
                            {{ infoUser.nome_user }}

                        </div>

                            {{ infoPublic.data_publicada }} 

                    </div>

                    <div class="container-fotos-public">

                        <div class="foto-exibida">
                            <img :src="DiretorioFotosPublic + this.ImagensPublic[0]" alt="Foto Exibida" v-if="this.FotoExibida == null">
                            <img :src="FotoExibida" alt="Foto Exibida" v-else>
                        </div>


                        <div class="container-carousel-fotos">

                             <div class="carousel-fotos" v-for="fotos in this.ImagensPublic" :key="fotos.id">
                                    <input v-model="FotoExibida"  :id="'input-' + fotos" type="radio" :value="DiretorioFotosPublic + fotos" name="carousel-foto">
                                    <label :for="'input-' + fotos">
                                        <img :src="DiretorioFotosPublic + fotos" alt="carousel-fotos">
                                    </label>
                             </div>

                        </div>

                        

                    </div>


                </div>

                <form class="container-02">

                    <p class="p-nome-public">
                       {{infoPublic.nome_publicação}}
                    </p>


                    <div  class="inputs-radios" v-if="this.ModoPrecoUnico != true">
                        <div v-for="Precos in this.PrecosPublic.nomes" :key="Precos.id" >
                                <div>
                                    <input :id="'input-radio-value-' + Precos" type="radio" :value="Precos" @change="SelecionouProduto" v-model="ValueProdutoSelecionado">
                                    <label :for="'input-radio-value-' + Precos">{{Precos}}</label>
                                </div>
                        </div>
                    </div>

                    <div v-if="this.PrecoProduto || this.ModoPrecoUnico">

                        R$ {{ PrecoTotal }}

                        <div class="container-quantidades">
                            <p>
                                Quantidade 
                            </p>
                            <button @click.prevent="ButtonDiminuirQuantidade">-</button>
                            <p>
                                {{Quantidade}}
                            </p>
                            <button @click.prevent="ButtonAumentarQuantidade">+</button>
                        </div>
                    </div>

                    <p v-if="this.frete == 'null'" class="p-frete-grates">
                        frete grátis
                    </p>
                    <p v-else  class="p-frete">
                        Frete : R$ {{ frete }} 
                    </p>

                    


                    

                    <div class="buttons">
                            enviar para carrinho -
                    </div>
                </form>
            </div>

            <div class="container-descricao" v-if="this.infoPublic.descricao_publicação != 'null'">
                <label>Descrição</label>
                <p>
                    {{infoPublic.descricao_publicação }}
                </p>
            </div>

            <div class="container-comentarios">
                <ComponentComentarios/>
            </div>

        </section>
    </div>
</template>



<script>
import ComponentComentarios from '~/components/publicações/comentarios.vue';
import axios from 'axios';

export default {

    mounted(){

        this.AtivarOuDesativarContainerPublic();
        // this.ResgatarDadosDaPublic();

        // Ao clicar fora do container mais options o container sera fechado!
        document.addEventListener('click', (e) => {
            if(e.target.id != 'container-mais-options' && e.target.className != 'button-abrir-options'){
                this.ContainerMaisOptionsAtivo = false
            }
        }) 

        this.ResgatarDadosDaPublic();





    },

    data(){
        return{
            ContainerPublicAtivo: false,
            ContainerMaisOptionsAtivo: false,
            // 
            infoUser: [],
            // 
            infoPublic: [],
            // 
            ImagensPublic: [],
            // 
            FotoExibida: null,
            DiretorioFotosPublic: null,
            //
            ModoPrecoUnico: undefined,
            PrecosPublic: [],
            ValueProdutoSelecionado: null,
            PrecoSelecionado: null,
            Quantidade: 1,
            PrecoProduto: undefined,
            PrecoTotal: undefined,
            // 
            frete: null
            
        }
    },

    components:{
        ComponentComentarios 
    },


    methods:{
        // Container public é o container principal !
        AtivarOuDesativarContainerPublic(){
            if(this.$router.history.current.params.slug){
                this.ContainerPublicAtivo = true
            }
            else
            {
                this.ContainerPublicAtivo = false
            }
        },

        AbrirEFecharContainerMaisOptions(){
            if(!this.ContainerMaisOptionsAtivo){
                this.ContainerMaisOptionsAtivo = true
            }
            else
            {
                this.ContainerMaisOptionsAtivo = false
            }
        },

        async ResgatarDadosDaPublic(){

        var form = new FormData();
        form.append('link_public', this.$route.params.slug)

            await axios.post('http://localhost/projetos/ex01/backend/public/publicações/ExibirPublicação.php', form).then(Response => {
                // APENAS SEPERANDO DADOS E ADICIONANDO EM SEUS ARRAY!
                    this.frete = Response.data.frete
                    this.infoUser = Response.data.infos_user
                    this.infoPublic = Response.data.infos_public
                    // 
                    var ValoresPreçosPublic = {}   
                    var NomesPreçosPublic = {}

                    var IdNomes = 0
                    var IdValores = 0

                    
                    for(var i in Response.data.preços.nomes_preços){

                        if(Response.data.preços.nomes_preços[i] != ""){

                            IdNomes++
                            
                            NomesPreçosPublic[IdNomes] = Response.data.preços.nomes_preços[i]

                        }
                        else
                        {
                            break
                        }
                    }

                    


                    
                    for(var i in Response.data.preços.valores_preços){

                        if(Response.data.preços.valores_preços[i] != ""){
                            IdValores++

                            ValoresPreçosPublic[IdValores] = Response.data.preços.valores_preços[i]
                        }
                        else
                        {
                            break
                        }
                    }
                    
                    this.PrecosPublic.nomes = NomesPreçosPublic
                    this.PrecosPublic.valores = ValoresPreçosPublic

                    // Se tiver apenas 1 valor então vou ativar o modo preço unico

                    if(IdValores > 1){
                        this.ModoPrecoUnico = false

                    }
                    else
                    {
                        this.ModoPrecoUnico = true
                        this.PrecoTotal = Response.data.preços.valores_preços.nome_valor_01 
                        this.PrecoProduto = Response.data.preços.valores_preços.nome_valor_01

                    }



                    


                    this.DiretorioFotosPublic = Response.data.imagens_public.local_imagem + Response.data.imagens_public.diretorio + '/'
                    // 
                    for(var i in Response.data.imagens_public){
                    
                        if(Response.data.imagens_public[i] != ""){
                            this.ImagensPublic.push(Response.data.imagens_public[i])
                        }
                        else
                        {
                            break

                        }
                    }

                 })

        },

        
        

        // Se tiver mais de um preço!
        SelecionouProduto(){

            for(var i in this.PrecosPublic.nomes){
                if(this.PrecosPublic.nomes[i] ==  this.ValueProdutoSelecionado){
                    this.PrecoTotal = this.PrecosPublic.valores[i]
                    this.PrecoProduto = this.PrecosPublic.valores[i]
                    this.Quantidade = 1
                }
            }
        },

        ButtonAumentarQuantidade(){
            this.Quantidade++
            this.MultiplicarPreco();
        },

        ButtonDiminuirQuantidade(){
            
            if(this.Quantidade > 1){
                this.Quantidade--
            }

            this.MultiplicarPreco();
        },

        MultiplicarPreco(){
            var Calculo = this.PrecoProduto*this.Quantidade
            var CalculoString = Calculo.toString()

            // esse códico é pra deixar o preço nesse formato 00.00, as vezes o calulo sai assim : 00.0000000...infinito
            var RegexSelecionarUltimosNumeros = /\.\d{1,2}/
            var NumerosFinaisResultado = CalculoString.match(RegexSelecionarUltimosNumeros)
            
            // 

            if(NumerosFinaisResultado == null){
                this.PrecoTotal = Calculo + '.00'
            }
            else
            {
                var RegexSelecionaTODOSNumerosFinais = /\.\d{0,10000}$/
                var ResultadoFinal =  CalculoString.replace(RegexSelecionaTODOSNumerosFinais, NumerosFinaisResultado)
                this.PrecoTotal = ResultadoFinal

            }


        },

        RouterVoltar(){
            this.$router.go(-1)
        }
    }
}
</script>




<style scoped>
    .container-public{
        top: 0rem;
        position: fixed;
        background: #ffffff90;
        height: 100vh;
        width: 100vw;

        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }


    section{
        padding: 1rem;
        background: #fff;
        border: 0.1rem solid rgb(44, 129, 255);
        width: 90%;
        height: 90%;
        position: relative;
        overflow: auto;
    }



    /*  */


    .buttons{
        width: 100%;
        display: flex;
        justify-content: space-between;
    }


    .buttons button{
        border: 0px;
        background: transparent;
    }

    .buttons img{
        height: 2rem;
    }

    .container-mais-options{
        position: absolute;
        background: #fff;
        border: 0.1rem solid #3ca0fe;
        top: 4rem;
        right: 2.5rem;
    }

    .container-mais-options li{
        padding: 1rem 2rem;
        cursor: pointer;
    }

    .container-mais-options li:hover{
        background: #3ca0fe;
        color: #fff;
    }

    

    .info-user-dono{
        display: flex;
        justify-content: space-between;
        align-items: center;

    }

    .info-user-dono img{
        height: 4rem;
        width: 4rem;
        border-radius: 50%;
    }


    .container-main{
        margin-top: 3rem;
        display: flex;
        justify-content: space-between;
    }

    .container-main .container-01{
        width: 60%;

    }

    .container-main .container-02{
        padding: 0rem 1rem 1rem 1rem;
        width: 39%;
        border-left: 0.4rem solid rgb(56, 185, 255);

    }
    
    .container-fotos-public{
        margin-top: 3rem;
    }

    .foto-exibida{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .foto-exibida img{
        width: 35rem;

    }
    
   

    .container-carousel-fotos{
        display: flex;
        justify-content: center;
        overflow: auto;
        width: 100%;
    }

    input[type=radio]{
        display: none;
    }

    .container-carousel-fotos{
        display: flex;
    }

    .carousel-fotos img{
        margin: 0.5rem;
        cursor: pointer;
        border: 0.1rem solid #707070;
        width: 6rem;
        height: 6rem;
    }

    .container-02 .p-nome-public{
        font-weight: bold;
    }

    .inputs-radios{
        margin-top: 4rem;
        margin-bottom: 4rem;
        width: 100%;
        display: flex !important; 
    }

    .inputs-radios label{
        padding: 0rem 1rem;
        margin-right: 1rem;
        border: 0.1rem solid rgb(15, 15, 52);
        cursor: pointer;
    }
    .container-quantidades{
        display: flex;
        font-size: 1.3rem;  
    }


    .container-quantidades p, 
    .container-quantidades button{
        margin-right: 1rem;
    }

    .container-quantidades button{
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 0.1rem solid rgb(15, 15, 52);
        border-radius: 50%;
        height: 1.5rem;
        width: 1.5rem;
    }

    .p-frete{
        font-size: 1.3rem;
    }

    .p-frete-grates{
        color:rgb(41, 182, 69);
        font-size: 1.3rem;
    }

    .container-descricao label{
        font-size: 3rem;
    }

    .container-descricao p{
        font-size: 1.4rem;
    }

    .novo-comentario{
        background: rgb(240, 240, 240);
        width: 61%;
        height: 3rem;
        border-radius: 0.6rem;
    }

   
    
    




    @media(max-width: 960px){
        section{
            width: 100%;
            height: 100%;
        }

        .container-main{
            flex-direction: column;
        }

        .container-fotos-public{
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container-fotos-public .foto-exibida{
            width: 50rem;
        }

        .container-main .container-01{
            width: 100%;

        }

        .container-main .container-02{
            width: 100%;
            border-left: 0rem solid rgb(56, 185, 255);
        }

        .container-descricao{
            border-top: 0.4rem solid rgb(56, 185, 255);
        }
    }

    
</style>


<style>
/* STYLE GLOBAL */

  @media(max-width: 400px){
        html{
             font-size: 52.5%;
        }
        
    }
</style>



<template>
    <div class="container-main">
        <form>

            <h2>Publicar produto</h2>

            <div class="container-input-infos">

                <div class="container-input-nome-e-preco">

                    <div>
                        <p class="mensagem-de-erro">
                            {{ MensagemDeErroNome }}
                        </p>
                        <input  @keyup="ValidarCampoNome" v-model="nome" type="text" id="input-nome-produto" required>
                        <label for="input-nome-produto">Nome do produto</label>
                    </div>

                    <div>

                        <p class="mensagem-de-erro">
                            {{ MensagemDeErroPreco }}
                        </p>

                        <button @click.prevent="FecharEAbrirContainerAddPreco">Adicionar Valores</button>
                    </div>

                    <div class="container-add-preço" v-if="this.ContainerAddPreçoAtivo == true">

                        <button class="iconX" @click.prevent="FecharEAbrirContainerAddPreco">
                            <img src="~~/img/publicar-produto/excluir.png" alt="ExcluirImagem"> 
                        </button>

                        <label>Criar novo preço</label>

    
                        <div class="novo-preco">
                            <div class="novo-preco-name">
                                <label for="input-preco-name">nome</label>
                                <input type="text" id="input-preco-name" placeholder="Ex: cor, tipo, tamanho, etc..">
                            </div>
                            <div class="novo-preco-valor">
                                <label for="input-preco-valor">valor</label>
                                <input type="number" id="input-preco-valor" placeholder="00.00 R$" required>
                            </div>
                            <div class="novo-preco-button">
                                <button @click.prevent="CriarNovoPreco" v-if="this.ModoEditarPreco == false">Criar</button>
                                <button @click.prevent="EditarPreco" v-else>Editar</button>
                            </div>
                        </div>
                        <p class="mensagem-de-erro">
                            {{ MensagemDeErroCriarPreco }}
                        </p>


                         <div class="novo-preco-frete">
                            <label for="input-frete" >Frete:</label>
                            <input type="Number" placeholder="00.00 R$" @change="ValidarFrete" v-model="Precofrete" id="input-frete">
                        </div>

                        <p class="mensagem-de-erro">
                            {{ MensagemDeErroFrete }}
                        </p>

                         

                        <div class="precos">
                            
                            <div v-for="precos in this.precos" :key="precos.id"  class="box-preco">

                                <label  :for="'preco-'+precos.nome"> {{ precos.nome }}</label>
                                <input v-model="PrecoValueChecked" type="radio" :id="'preco-'+precos.nome" :value="precos.valor" name="preco">


                                <div class="edits">
                                    <button :id="'button-editar-' + precos.id" @click.prevent="ResgatarIdPreco">
                                        <img src="~~/img/publicar-produto/lapis.svg" alt="Editar">
                                        
                                    </button>
                                    <button :id="'button-excluir-' + precos.id" @click.prevent="ExcluirPreco">
                                        <img src="~~/img/publicar-produto/excluir.png" alt="Excluir"> 
                                    </button>
                                </div>

                            </div>
                        </div>

                         <p id="preco-checked" class="preco" v-if="this.PrecoValueChecked">
                            {{ PrecoValueChecked }} R$ 
                        </p>

                        

                    </div>
                </div>


                <div class="container-input-descricao">
                    <p class="mensagem-de-erro">
                        {{ MensagemDeErroDescricao }}
                    </p>
                    <textarea @keyup="ValidarCampoDescricao" v-model="descricao" name="descrição" id="input-descrição-produto" cols="30" rows="10" required></textarea>
                    <label for="input-descrição-produto">Descrição do produto</label>
                </div>
            </div>



            <div class="container-input-imagem-principal">
                <p>Adicione uma foto de capa para o seu produto</p>

                <div class="AddImagem" v-if="this.PreviewFotoPrincipal == null" @click="ClickInputFileFotoPrincipal">
                        <img src="~~/img/publicar-produto/mais.svg" alt="AddFoto">
                        <input ref="InputFileFotoPrincipal" type="file" @change="AddImagemPrincipal" id="input-file-foto-principal">
                </div>

                <div class="PreviewImagem" v-else>
                    <button>
                        <img @click="ExcluirFotoPrincipal" class="iconX" src="~~/img/publicar-produto/excluir.png" alt="ExcluirImagem">
                    </button>
                    <img :src="PreviewFotoPrincipal" alt="PreviewImagemPrincipal">
                </div>

                <p class="mensagem-de-erro">
                    {{ MensagemDeErroFotoPrincipal }}
                </p>
            </div>


            <div class="container-input-imagens">
                <p>Adiciona imagens do produto</p>
                <p class="mensagem-de-erro">
                    {{ MensagemDeErroFotos }}
                </p>

                <div class="input-imagens">
                    


                    <div class="AddImagem" @click="ClickInputFilesFotos">
                        <img src="~~/img/perfil-consumidor/mais.svg" alt="">
                        <input type="file" id="input-file-fotos" @change="AddImagensPubli">
                    </div>

                    <div class="PreviewImagem"  v-for="Imagens in this.PreviewImagens" :key="Imagens.id" :id="Imagens.id">

                        <button @click.prevent="BuscarIdImagem">
                                <img class="iconX" src="~~/img/publicar-produto/excluir.png" alt="ExcluirImagem">
                        </button>

                        <img :src="Imagens.src" alt="PreviewImagem">
                    </div>

    

                    

                    <div class="container-carousel" v-if="this.PreviewImagens.length > 0">

                            <button class="Carousel-buttonX" @click.prevent="BuscarIdImagem">
                                <img class="Carousel-img-Icon-X" src="~~/img/publicar-produto/excluir.png" alt="ExcluirImagem">
                            </button>

                            <b-carousel
                            controls
                            indicators
                            :interval="null"
                            >
                            
                                <b-carousel-slide
                                v-for="imagens in this.PreviewImagens" :key="imagens.id"
                                >
                                
                                    <template #img>
                                    <img
                                        :id="imagens.id"
                                        style="
                                        height: 25rem;
                                        width: 25rem;
                                        "
                                        :src="imagens.src"
                                        alt="image slot"
                                    >
                                    </template>
                                </b-carousel-slide>



                            </b-carousel>


                            
                            

                            
                     
                    </div> 

                </div>
            </div>

            <div class="container-carregando" v-if="this.ContainerLoadingAtivo == true">
                <div>
                    <img src="~~/img/publicar-produto/carregando.gif" alt="carregando...">
                    Carregando
                </div>
            </div>


            <div class="container-button">
                <button @click.prevent="PublicarProduto">Publicar Produto</button>
            </div>


            <div class="container-background-cinza" v-if="this.ContainerBackGroundCinzaAtivo == true">
            </div>


        </form>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    layout: 'auth',

    data(){
        return{
            nome: null,
            // 
            precos: [],
            PrecoValueChecked: null,
            IdPreco: 0,
            IdPrecoParaEditar: null,
            ModoEditarPreco: false,
            Precofrete: null,
            // 
            descricao: null,
            // 
            PreviewFotoPrincipal: null,
            FileFotoPrincipal: null,
            IdImagem: 0,
            PreviewImagens: [],
            FilesImagens: [],
            // 
            StatusErroCampoNome: false,
            StatusErroCampoPreco: false,
            StatusErroCampoDescricao: true,
            StatusErroCampoFotoPrincipal: false,
            StatusErroCampoFotos: false,
            StatusErroCampoFrete: true,
            // 
            MensagemDeErroNome: "",
            MensagemDeErroPreco: "",
            MensagemDeErroCriarPreco: "",
            MensagemDeErroDescricao: "",
            MensagemDeErroFotoPrincipal: "",
            MensagemDeErroFotos: "",
            MensagemDeErroFrete: "",
            // 
            ContainerLoadingAtivo: false,
            ContainerBackGroundCinzaAtivo: false,
            ContainerAddPreçoAtivo: false
        }
    },

   


    methods:{

        PublicarProduto(){

            if(!this.StatusErroCampoNome || !this.StatusErroCampoPreco || !this.StatusErroCampoDescricao || !this.StatusErroCampoFotoPrincipal || !this.StatusErroCampoFotos || !this.StatusErroCampoFrete){
                this.ValidarCampoNome();
                this.ValidarCampoPreco();
                this.ValidarCampoDescricao();
                this.ValidarCampoImagemPrincipal();
                this.ValidarCampoFotos();
            }
            else
            {
                var form = new FormData();
                // 
                form.append('email_user', this.$store.state.user.email)
                form.append('nome_publicação', this.nome)
                form.append('descricao_publicação', this.descricao)
                form.append('foto_capa', this.FileFotoPrincipal)
                form.append('preço_frete', this.Precofrete)
                // 
                for(var i in this.precos)
                {
                    form.append('preço_nome_' + i , this.precos[i].nome)
                    form.append('preço_valor_' + i, this.precos[i].valor)
                }

                for(var i in this.FilesImagens)
                {
                    form.append('foto_' + i, this.FilesImagens[i])
                }


                axios.post('http://localhost/projetos/ex01/backend/public/publicar-produto/publicar-produto.php',
                form
                ).then(Response => { console.log(Response.data )})

                this.$router.push('/');

            }

            

           
        },

        ValidarCampoNome(){
            if(!this.nome){
                this.MensagemDeErroNome  = 'Preencha esse campo'
                this.StatusErroCampoNome = false
            }
            else if(this.nome.length > 300)
            {
                this.MensagemDeErroNome  = 'Insira apenas 300 caracteres'
                this.StatusErroCampoNome = false
            }
            else
            {
                this.MensagemDeErroNome  = ''
                this.StatusErroCampoNome = true
            }
        },

        ValidarCampoImagemPrincipal(){
            if(!this.FileFotoPrincipal)
            {
                this.StatusErroCampoFotoPrincipal = false
                this.MensagemDeErroFotoPrincipal = 'Insira uma imagem'
            }
            else
            {
                this.StatusErroCampoFotoPrincipal = true
                this.MensagemDeErroFotoPrincipal = ''
            }
        },

        ValidarCampoPreco(){

            if(this.precos.length < 1 ){
                this.MensagemDeErroPreco = 'Adicione um preço'
                this.StatusErroCampoPreco = false
            }
            else
            {
                this.MensagemDeErroPreco = ''
                this.StatusErroCampoPreco = true
            }
        },

        ValidarCampoDescricao(){
            if(!this.descricao){
                this.StatusErroCampoDescricao = true
            }
            else if(this.descricao.length > 2000)
            {
                this.MensagemDeErroDescricao = 'Insira apenas 2000 caracteres'
                this.StatusErroCampoDescricao = false
            }
            else
            {
                this.MensagemDeErroDescricao = ''
                this.StatusErroCampoDescricao = true
            }
        },

        ValidarCampoFotos(){

                if(this.FilesImagens.length < 3){
                    this.MensagemDeErroFotos = 'Insira no minimo 3 fotos'
                    this.StatusErroCampoFotos = false
                }
                else
                {
                    this.MensagemDeErroFotos = ''
                    this.StatusErroCampoFotos = true
                }


        },


        RegexPrecoValido(Preco){
                var regex = /^\d{1,9}\.\d{2}$/
                return regex.test(Preco);
        },
        
    

        ValidarFrete(){
            if(this.Precofrete.length == 0){
                this.MensagemDeErroFrete = ''
                this.StatusErroCampoFrete = true
            }
            else if(this.Precofrete.length > 12)
            {
                this.MensagemDeErroFrete = 'No maximo 12 caracteres!'
                this.StatusErroCampoFrete = false
            }
            else if(!this.RegexPrecoValido(this.Precofrete))
            {
                this.MensagemDeErroFrete = 'Formato de preço incorreto'
                this.StatusErroCampoFrete = false
            }
            else
            {
                this.MensagemDeErroFrete = ''
                this.StatusErroCampoFrete = true
            }

           
        },


        

        ClickInputFileFotoPrincipal(){
            document.getElementById('input-file-foto-principal').click();
        },

        AddImagemPrincipal(e){

            if(this.$refs.InputFileFotoPrincipal.files[0] != undefined){

                var NameImagem = this.$refs.InputFileFotoPrincipal.files[0].name.toLowerCase() 
                var RegexCapturarNumerosFinais = /[a-z]+$/
                var extensaoImg = NameImagem.match(RegexCapturarNumerosFinais)

                if(extensaoImg != 'png' && extensaoImg != 'jpg' && extensaoImg != 'webp'){
                    this.MensagemDeErroFotoPrincipal = 'Apenas imagem png ou jpg';
                }
                else
                {
                    var Reader = new FileReader();

                    Reader.onload = () => {
                        this.PreviewFotoPrincipal = Reader.result;
                        
                    }

                    
                    this.FileFotoPrincipal = this.$refs.InputFileFotoPrincipal.files[0]
                    Reader.readAsDataURL(e.target.files[0]);
                    this.ValidarCampoImagemPrincipal();
                }

            }


        },

        ClickInputFilesFotos(){
            document.getElementById('input-file-fotos').click();
        },

        ExcluirFotoPrincipal(){
            this.PreviewFotoPrincipal = null
            this.FileFotoPrincipal = null
            this.ValidarCampoImagemPrincipal();
        },

         AddImagensPubli(e){

                if(document.getElementById('input-file-fotos').files[0] != undefined){
                    
                    var NameImagem = document.getElementById('input-file-fotos').files[0].name.toLowerCase()
                    var RegexCapturarNumerosFinais = /[a-z]+$/
                    var extensao = NameImagem.match(RegexCapturarNumerosFinais)

                    if(extensao != 'png' && extensao != 'jpg' && extensao != 'webp'){
                        this.MensagemDeErroFotos = 'Insira apenas fotos png e jpg';
                    }
                    else if(this.FilesImagens.length >= 10)
                    {
                        this.MensagemDeErroFotos = 'Apenas 10 fotos são permitidas';
                    }
                    else if(document.getElementById('input-file-fotos').files[0].size > 1500000)
                    {
                        this.MensagemDeErroFotos = 'Apenas imagem com 15kb ou menos';
                    }
                    else
                    {
                        var Reader = new FileReader();

                        this.IdImagem++

                        Reader.onload = () => {
                            var dados =
                                { 
                                    id: this.IdImagem,
                                    src: Reader.result
                                }
        
                            this.PreviewImagens.push(dados);
                        }

                        Reader.readAsDataURL(e.target.files[0]);
                        
                        var img = document.getElementById('input-file-fotos').files[0]
                        img['id'] = this.IdImagem;
                        this.FilesImagens.push(img);
                        
                        document.getElementById('input-file-fotos').value = null
                        this.ValidarCampoFotos();

                    }


                }
                






        },

        // buscar id da imagem pra poder exlucir
        BuscarIdImagem(e){
           

            if(e.target.className == 'iconX'){
                var IdImg = e.target.parentElement.parentElement.id
                this.ExcluirFotoPubli(IdImg)
            }
            // carousel aparece no media query de width 600px
            else if(e.target.className == 'Carousel-img-Icon-X')
            {
                 this.ContainerLoadingAtivo = true

                setTimeout(() => {
                    var idImg = document.getElementsByClassName('carousel-item active')

                    var dados = [
                        idImg[0].children[0].id
                    ]

                    
                    this.ExcluirFotoPubli(dados)
                    
                }, 1000);


                
               
        }
            

            

        },

        ExcluirFotoPubli(IdImg){
            this.ContainerLoadingAtivo = false



            var idImg = IdImg

            for(var i in this.PreviewImagens){
                if(idImg == this.PreviewImagens[i].id){
                    this.PreviewImagens.splice(i, 1);
                    break;
                }
            }

            for(var i in this.FilesImagens){
                if(idImg == this.FilesImagens[i].id){
                    this.FilesImagens.splice(i, 1);
                    break;
                }

            }


            this.ValidarCampoFotos();

        },

        FecharEAbrirContainerAddPreco(){

            if(this.ContainerAddPreçoAtivo == false){
                this.ContainerAddPreçoAtivo = true
                this.ContainerBackGroundCinzaAtivo = true

            }
            else
            {
                this.ContainerAddPreçoAtivo = false
                this.ContainerBackGroundCinzaAtivo = false
            }

                this.ModoEditarPreco = false

        },


        ValidarCamposCriarPreco(resposta){
            resposta = false
            
            var nome = document.getElementById('input-preco-name').value
            var valor = document.getElementById('input-preco-valor').value


            if(!nome || !valor){
                this.MensagemDeErroCriarPreco = 'Preencha os campos'
            }
            else if(nome.length > 30)
            {
                this.MensagemDeErroCriarPreco = 'Campo nome: Insira no minimo 15 caractere'
            }
            else if(valor.length > 12 )
            {
                this.MensagemDeErroCriarPreco = 'Campo preço: Insira no minimo 12 caracteres!'
            }
            else if(!this.RegexPrecoValido(valor))
            {
                this.MensagemDeErroCriarPreco = 'Formato de preço invalido'
            }
            else if(this.precos.length == 10)
            {
                this.MensagemDeErroCriarPreco = 'Apenas 10 preços é permitido '
            }
            else
            {
                this.MensagemDeErroCriarPreco = ''
                return resposta = true
            }
        },

        CriarNovoPreco(){

            if(this.ValidarCamposCriarPreco())
            {
                var nome = document.getElementById('input-preco-name').value
                var valor = document.getElementById('input-preco-valor').value
                this.MensagemDeErroCriarPreco = ''
                this.IdPreco++

                var dados = {
                    id: this.IdPreco,
                    nome: nome,
                    valor: valor
                }

                this.precos.push(dados)




                document.getElementById('input-preco-name').value = ''
                document.getElementById('input-preco-valor').value = ''
                this.PrecoValueChecked = null
                this.ValidarCampoPreco();

            }


        },


        ResgatarIdPreco(e){
        
            if(e.target.localName == 'img')
            {
                var idInput = e.target.parentElement.id
            }
            else if(e.target.localName == 'button')
            {
                var idInput = e.target.id
            }

            var RegexSelecionarNumerosFinais = /\d{0,10}$/
            var id = idInput.match(RegexSelecionarNumerosFinais)

            this.ModoEditarPreco = true

            for(var i in this.precos){
                if(id == this.precos[i].id)
                {
                    document.getElementById('input-preco-name').value = this.precos[i].nome
                    document.getElementById('input-preco-valor').value = this.precos[i].valor
                }
            }

            this.IdPrecoParaEditar = id
        },

        EditarPreco(){
            
            if(this.ValidarCamposCriarPreco())
            {
                for(var i in this.precos){
                        
                    if(this.IdPrecoParaEditar == this.precos[i].id)
                    {
                        this.precos[i].nome = document.getElementById('input-preco-name').value 
                        this.precos[i].valor = document.getElementById('input-preco-valor').value
                    }
                }

                this.ModoEditarPreco = false
                this.IdPrecoParaEditar = null
                document.getElementById('input-preco-name').value = null
                document.getElementById('input-preco-valor').value = null
                this.PrecoValueChecked = null
            }

        },

        ExcluirPreco(e){
            if(e.target.localName == 'img')
            {
                var idInput = e.target.parentElement.id
            }
            else if(e.target.localName == 'button')
            {
                var idInput = e.target.id
            }

            var RegexSelecionarNumerosFinais = /\d{0,10}$/
            var id = idInput.match(RegexSelecionarNumerosFinais)
            
            for(var i in this.precos)
            {
                if(id == this.precos[i].id)
                {
                    this.precos.splice(i, 1);
                }
            }

            this.ValidarCampoPreco();
            this.PrecoValueChecked = null
        },


        


       


    

        


        


    }
}
</script>


<style  scoped>
    .container-main{
        max-width: 70%;
        margin: 0 auto;
    }

    form{
        width: 100%;
    }

    h2{
        text-align: center;
        font-size: 2.5rem;
        padding: 3rem 0rem;
        color: rgb(35, 149, 255);
    }


    .container-input-infos{
        display: flex;
        justify-content: space-between;
        padding: 3rem 0rem;
        border-bottom: 0.3rem solid rgb(72, 127, 255);

    }

    .container-input-infos .container-input-nome-e-preco,
    .container-input-infos .container-input-descricao{
        width: 47%;
    }

    .container-input-nome-e-preco{
        display: flex;
        flex-direction: column;
        justify-content: space-between;

    }

    .container-input-nome-e-preco div,
    .container-input-descricao
    {
        display: flex;
        flex-direction: column-reverse;
    }

    .container-input-descricao textarea{
        max-height: 12rem;
        min-height: 12rem;
    }

    

    .container-input-nome-e-preco button{
        background: rgb(33, 162, 255);
        color: #fff;
        border: 0.1rem solid rgb(33, 162, 255);
        transition: 0.7s;
    }

    .container-input-nome-e-preco button:hover{
        background: transparent;
        color: rgb(33, 162, 255);
        transition: 0.7s;
    }


    .container-input-nome-e-preco .container-add-preço{
        position: fixed;

        background: #fff;
        border: 0.2rem solid rgb(33, 162, 255);
        padding: 1rem;
        z-index: 100;

        
        width: 35vw;
        height: 90vh;


        margin-left: auto;
        margin-right: auto;
        margin-top: auto;
        margin-bottom: auto;

        right: 0;
        left: 0;
        bottom: 0;
        top: 0;

        display: flex; 
        flex-direction: column;
        
        
    }


    

    .container-add-preço .iconX{
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: transparent;
        border: 0px;
    }

    .container-add-preço .iconX img{
        height: 3rem;
        width: 3rem;
    }


    .container-add-preço div{

        display: flex;
        flex-direction: row;
        width: 100%;
    }

    .precos input[type=radio]{
        display: none;
    }

    .container-add-preço .precos{
        display: flex;
        flex-direction: column;
    }

     .precos .edits{
        width: auto;
     }
    
    .precos .box-preco{
        width: 100%;
        border-bottom: 0.1rem solid rgb(53, 169, 236);

        display: flex;
        justify-content: space-between;

    }

    .edits button{
        background: transparent;
        border: 0px;
    }

    .edits img{
        width: 2rem;
    }

    .precos label{
        padding: 0.5rem;
        cursor: pointer;

        display: flex;
        align-items: center;
    } 

   


    .novo-preco{
        margin-top: 4rem;
        width: 100%;
        justify-content: space-between;
    }

    .container-add-preço .novo-preco-frete{
        flex-direction: column;
        margin-top: 2rem;
    }

    .novo-preco .novo-preco-name {
        flex-direction: column;
        width: 57%;
    }

    .novo-preco .novo-preco-valor{
        flex-direction: column;
        width: 20%;
    }

    .novo-preco .novo-preco-button{
        display: flex;
        align-items: flex-end;
        width: 20%;
    }
    

     .novo-preco .novo-preco-button button{
        width: 100%;
        height: 3rem;
    }

    .container-add-preço .preco{
        margin-top: 2rem;
        font-weight: bold;
        font-size: 2rem;
    }

    
    
    input, textarea{
        width: 100%;
        outline: none;
        border: 1px solid #ccc;
        border-radius: 0.3rem;
    }

    input{
        height: 3rem;
    }

    input:focus, 
    textarea:focus{
        border: 0.1rem solid rgb(132, 173, 255);
    }

    input:focus + label, 
    textarea:focus + label{
        color: rgb(132, 173, 255);
    }

    label{
        margin: 0px;
    }

    input[type=file]{
        display: none;
    }

    .container-input-imagem-principal{
        text-align: center;
        padding: 5rem 0rem;
        display: flex;
        align-items: center;
        flex-direction: column;
        border-bottom: 0.3rem solid rgb(72, 127, 255);
    }

    .container-input-imagem-principal .AddImagem{
        width: 25rem;
        height: 25rem;
    }


    .container-input-imagens{
        margin-top: 5rem;
    }

    .container-input-imagens p{
        text-align: center;
    }

    .input-imagens{
        margin-top: 3rem;
        display: grid;
        flex-wrap: wrap;
        row-gap: 1rem; 
        grid-gap: 5rem;
        justify-content: center;
        grid-template-columns: repeat(auto-fill, 25rem);
    }

    

    .AddImagem{
        height: 25rem;
        border: 0.3rem dashed #ccc;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer; 
    }

    .AddImagem img{
        height: 3rem;
        width: 3rem;
    }

    .PreviewImagem{
        width: 25rem;
        height: 25rem;
        position: relative;
    }

    

    .PreviewImagem .iconX
    {
        cursor: pointer;
        height: 4rem;
        width: 4rem;
        position: absolute;
        filter: contrast(130%);
        z-index: 90;
    }

    .PreviewImagem button{
        position: absolute;
        top: -1rem;
        right: 2rem;
        border: 0px;

    }

    .PreviewImagem .iconX:hover{
        filter: contrast(180%);
    }


    .container-carousel{
        position: relative;
    }

    .Carousel-buttonX{
       border: 0px;
       background: transparent;
       position: absolute;
       z-index: 90;
       top: -1rem;
       right: -1rem;
    }

    .Carousel-buttonX img{
        height: 4rem;
        width: 4rem;
    }

    .PreviewImagem img{
        height: 25rem;
        width: 25rem;
    }


    

    .container-button{
        display: flex;
        justify-content: center;
        padding: 5rem 0rem;
    }

    .container-button button{
        background: rgb(33, 162, 255);
        color: #fff;
        border: 0px;
        font-size: 2rem;
        height: 5rem;
        width: 25rem;
    }

    .container-button button:hover{
        background: rgb(12, 133, 220);
    }


    .mensagem-de-erro{
        height: 1rem;
        color: red;
        font-size: 1.3rem;
    }

    .container-carousel{
        display: none;
    }


    .container-carregando{
        top: 0vh;
        right: 0vw;

        display: flex;
        align-items: center;
        justify-content: center;

        width: 100%;
        height: 100%;
        background: #ffffff90;
        position: fixed;

        z-index: 1000;
    }

    .container-carregando div{
        background: #fff;
        padding: 2rem 5rem;
        border-radius: 2rem;
        border: 0.1rem solid #707070;

    }

    .container-carregando div img{
        width: 3rem;
        height: 3rem;
    }


    .container-background-cinza{
        background: #ffffff90;

        top: 0rem;
        right: 0rem;

        height: 100vh;
        width: 100vw;

        z-index: 90;


        position: fixed;
    }



    @media(max-width: 960px){
        .container-main{
            max-width: 90%;
        }

        .container-input-nome-e-preco .container-add-preço{
            width: 60vw;
        }

    }

    @media(max-width: 630px){
        .container-input-infos{
            flex-direction: column;
        }

        .container-input-infos .container-input-nome-e-preco,
        .container-input-infos .container-input-descricao{
        width: 100%;
        }

        .container-input-nome-e-preco .container-add-preço{
            padding: 1rem 2rem;
        }

        .container-input-nome-e-preco .container-add-preço{

            width: 100vw;
            height: 100vh;
            overflow: auto;
        }

    }   


    @media(max-width: 600px){
        .container-input-imagens .PreviewImagem{
            display: none;
        }

        .input-imagens{
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .AddImagem{
            width: 25rem;
            height: 25rem;
        }


        .container-carousel{
            display: flex;
            width: 25rem;
            height: 25rem;
        }

        

        

        


    
    }

    @media(max-width: 400px){
        
        .container-input-nome-e-preco .novo-preco{
            flex-direction: column;
        }

        .container-input-nome-e-preco .novo-preco-name,
        .container-input-nome-e-preco .novo-preco-valor,
        .container-input-nome-e-preco .novo-preco-button{
            width: 100%;
        }

        .container-input-nome-e-preco .novo-preco-button{
            margin-top: 1rem;
        }


    }
    
    
    

    

</style>
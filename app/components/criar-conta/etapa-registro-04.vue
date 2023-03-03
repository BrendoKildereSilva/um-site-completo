<template>
    <div>

        <div class="container-main">
            
                <p v-if="!this.preview">Que tal Adicionar uma foto de perfil?</p>
                <div class="container-preview" v-if="!this.TemImagem" @click="FocusNoInputFile">
                    <img class="img-add-img" src="../../img/page-login/adicionar.svg" alt="adicionar foto">
                </div>

                <div class="container-preview" v-else>
                    <button><img src="../../img/page-login/excluir.png" alt="Exlcuir imagem" @click.prevent="ExlcuirImagem"></button>
                    <img :src="preview" alt="preview-imagem" class="imagem-preview">
                </div>

                <div>
                    <input type="file" id="input-file" ref="FileArquivo" @change="RenderizarImagemAdicionada">
                    <label for="input-file">Adicionar foto</label>
                </div>

                <p class="mensagem-de-erro">{{ MensagemDeErroEtapa04 }}</p>
        </div>

        <div class="container-button">
            <button @click.prevent="VoltarEtapa">Voltar</button>
            <button @click.prevent="ProximaEtapa">Criar Conta</button>
        </div>
    </div>

</template>

<script>
export default {
    props:{
        TemImagem: Boolean,
        preview: String,
        ImagemArquivo: Array,
        MensagemDeErroEtapa04: String,

    },

    methods:{
        ProximaEtapa(){
            this.$emit('ProximaEtapa', this.ImagemArquivo)
        },

        VoltarEtapa(){
            var dados = {
                TemImagem :this.TemImagem,
                preview : this.preview,
                ImagemArquivo: this.ImagemArquivo,
                MensagemDeErroEtapa04: this.MensagemDeErroEtapa04

            }

            this.$emit('VoltarEtapa', dados)
        },


        FocusNoInputFile(){
            document.getElementById('input-file').click();
        },

        RenderizarImagemAdicionada(e){
            if(this.$refs.FileArquivo.files[0] != undefined){
                var extensaoDaImagem = this.$refs.FileArquivo.files[0].name.slice(-4).toLowerCase() 
                var TamanhoDaImagem = this.$refs.FileArquivo.files[0].size
                // 

                if(extensaoDaImagem != '.jpg' && extensaoDaImagem != '.png' )
                {
                    this.TemImagem = false
                    this.preview = ""
                    this.ImagemArquivo = ""

                    this.MensagemDeErroEtapa04 = 'insira apenas fotos jpg ou png'

                }
                else if(TamanhoDaImagem > 20000)
                {
                    this.TemImagem = false
                    this.preview = ""
                    this.ImagemArquivo = ""

                    this.MensagemDeErroEtapa04 = 'Imagem muito grande'
                }
                else
                {
                    var render = new FileReader();

                    render.onload = () =>{
                        this.preview = render.result
                    }


                    this.TemImagem = true
                    this.MensagemDeErroEtapa04 = ""
                    this.ImagemArquivo = this.$refs.FileArquivo.files[0]
                    render.readAsDataURL(e.target.files[0])

                }
            }


        },

        ExlcuirImagem(){
            this.TemImagem = false
            this.preview = ""
            this.ImagemArquivo = ""

        }
    }
}
</script>


<style scoped>
    
    .container-main{
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        height: 100%;
    }
    .container-preview{
        width: 18rem;
        height: 18rem;
        cursor: pointer;
        border-radius: 50%;
        background: #ffffff90;
        border: 1px dashed #3737f9;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }



    .imagem-preview{
        border-radius: 50%;
        width: 100%;
        height: 100%;
        object-fit: fill;
    }

    .container-preview button{
        position: absolute;
        top: 0rem;
        right: 2rem;

        background: transparent;
        border: 0px;
    }

    


    .container-preview button img{
        height: 3.5rem;
    }


    .container-preview .img-add-img{
        height: 5rem;
        width: 5ren;
    }

    input[type=file]{
        display: none;
    }

    label{
        margin-top: 1rem;
        transition: 0.4s;
        cursor: pointer;
        border: 0.1rem solid #3737f9;
        background: #3737f9;
        border-radius: 5rem;
        color: #fff;
        display: flex;
        justify-content: center;
        width: 20rem;
    }

    label:hover{
        transition: 0.4s;
        background: transparent;
    }

    p{
        color: #000000;
        text-align: center;

    }

    .mensagem-de-erro{
        color: red;
        font-weight: 600;
    }

    /* CONTAINER BUTTON */

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




@media(max-width: 300px){
    .container-preview{
        width: 20rem;
        height: 20rem;
    } 

    

    .imagem-preview{
        border-radius: 50%;
        width: 20rem;
        height: 20rem;
        object-fit: fill;
    }
}





</style>
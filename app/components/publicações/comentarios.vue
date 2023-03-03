<template>
    <div class="container-main-comentarios">
       

        <h2>
            Comentarios : {{ QuantidadesDeComentarios }}
        </h2>
       

        <div class="container-novo-comentario" >
            <input type="text" v-model="NovoComentario" required placeholder="adicione um comentario...">
            <button @click="NewComentario">comentar</button>
        </div>



        <div v-for="InfoComentario in this.ArrayComentarios" :key="InfoComentario.id" class="container-comentarios">
            <div class="info-user-comentario">
                <img :src="InfoComentario.foto_perfil_user" alt="">
                <p>
                    {{ InfoComentario.nome_user }}
                </p>
                <p>
                    {{ InfoComentario.data_publicada }}
                </p>
    
            </div>

            <p class="comentario" :id="InfoComentario.id_da_public" @click.prevent="VisualizarTodoText">
                    {{InfoComentario.comentario }}
            </p>

            <div class="container-buttons">
                <button>Responder</button>
            </div>

        </div> 
        

       

    </div>
</template>

<script>

import axios from 'axios';

export default {
    data(){
        return{
            NovoComentario: null,
            ArrayComentarios: null,
            QuantidadesDeComentarios: 0,
        }
    },

    
    mounted(){
        
        this.BuscarComentarios();
        this.AtualizarComentariosACada1seg()
        this.ResgatarTodosElementP();
    },

    methods:{
        AtualizarComentariosACada1seg(){
            setInterval(() => {
                this.BuscarComentarios();
            }, 2000);
        },

        ResgatarTodosElementP(){
            var  ElementsP = document.getElementsByClassName('comentario')
            const LIMITSTRING = 250


            // Infelizmente tem que ter esse delei
            setTimeout(() => {
                for(var i of ElementsP)
                if(i.innerText.length > LIMITSTRING){
                    i.innerHTML = i.innerHTML.substring(0, LIMITSTRING) + 
                    '<span style="color: #4C45DB; text-decoration: underline; padding: 0px; margin: 0px; cursor: pointer"> ver mais </span>'
                }
            }, 300);
            
        },


        VisualizarTodoText(e){
            
            var idText = e.target.parentElement.id

            for(var i in this.ArrayComentarios){
                if(this.ArrayComentarios[i].id_da_public == idText){
                    document.getElementById(idText).innerHTML = this.ArrayComentarios[i].comentario +
                    '<span style="color: #4C45DB; text-decoration: underline; padding: 0px; margin: 0px; cursor: pointer"> ver menos </span>'
                }
            }
            
            
        },


        async NewComentario(){
            if(this.NovoComentario){

                var form = new FormData();
                form.append( "link_public", this.$route.params.slug)
                form.append( "email_user", this.$store.state.user.email)
                form.append( "comentario", this.NovoComentario)


                await axios.post('http://localhost/projetos/ex01/backend/public/comentarios/novo-comentario.php', form)
                this.NovoComentario = ""

                this.BuscarComentarios()

            }
        },

        async BuscarComentarios(){
            var form = new FormData();
            form.append('link_public',  this.$route.params.slug)
            await axios.post('http://localhost/projetos/ex01/backend/public/comentarios/buscar-comentarios.php', form).then(Response => { 
                this.ArrayComentarios = Response.data 
                this.QuantidadesDeComentarios = this.ArrayComentarios.length
                })

        },
    }
}
</script>

<style scoped>
   
    .container-main-comentarios{
        width: 100%;
    }

    .container-novo-comentario{
        display: flex;
        margin: 2rem 0rem;
    }

    input{
        border: 0px;
        width: 100%;
        border: 0.1rem solid #ccc;
        border-radius: 1rem;
        outline: none;
    }

    .container-novo-comentario button{
        display: none;
        background: #1d8aff;
        color: #fff;
        border-radius: 1rem;
        border: 0px;
    }

    .container-novo-comentario button:hover{
        background: #1174dd;
    }


    input:focus{
        border:0.1rem solid  #1d8aff;
    }

    .container-novo-comentario input:focus + button,
    .container-novo-comentario input:valid + button
    {
        display: flex;
    }
    
    .info-user-comentario{
        width: 100%;
    }

    .info-user-comentario img{
        height: 3rem;
        width: 3rem;
        border-radius: 50%;
        margin-right: 1rem;
    }

    .info-user-comentario p
    {
        font-weight: bold;
        margin-right: 1rem;
    }

    .info-user-comentario{
        display: flex;
        align-items: center;
    }
    .container-comentarios{
        word-break: break-all;
        background: #cccccc30;
        border-radius: 3rem;
        padding: 1rem;
        margin: 1rem 0rem;
    }

   
    .container-comentarios .comentario{
        margin-left: 3rem;
    }

   

    
    .container-comentarios .container-buttons button{
        background: transparent;
        border: 0px;
    }

    .container-buttons{
        margin: 0rem 0rem 0rem 3rem;
        padding: 0rem;
        font-size: 1.3rem;
    }

    

   





   
   

   
</style>





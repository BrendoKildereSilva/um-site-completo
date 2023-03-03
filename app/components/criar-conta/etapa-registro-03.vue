<template>
    <div>
        <p class="paragrafo-contato">O Bk produtos usara o seu numero de contato apenas para meios de segurança.</p>
        <div class="container-contato">
            <div class="container-ddd">


                <div :class="CLASSSelectDDI" @click="AbrirEFecharContainerOptions">

                    <div id="SelectPai" v-if="!this.DDDescolhido" >
                        <p id="SelectFilho"> {{ ParagrafoSelectDDI }}</p>
                        <img id="SelectFilho" src="../../img/page-login/seta-desativada.svg" alt="imagem-select">
                    </div>

                    <div v-else id="SelectPai">
                        <img id="SelectFilho" :src="imgPaisSelecionado" alt="imagem-select">
                        <p id="SelectFilho"> {{ NomePaisSelecionado }}</p>
                        <img id="SelectFilho" class="imagem-pais" src="../../img/page-login/seta-desativada.svg" alt="imagem-select">
                    </div>
                </div>

                <div  v-if="this.ContainerOptionsDDIAtivo" @click="SelecinarDDI">

                    <div class="container-options">
                        <div id="OptionPai" class="options" v-for="Dados in DadosSelectDDI.ddi_todos_paises" :key="Dados.id" :value="Dados.id">
                            
                            <img :src=" UrlLocalDDIs + Dados.bandeira_imagem_nome"  id="OptionFilho">
                            <p  id="OptionFilho"> {{ Dados.nome_pais }}</p>
                            <p  id="OptionFilho"> (+{{ Dados.ddi_pais }})</p>    
                        </div>
                    </div>

    
                </div>

                
                

            </div>

           <div class="container-tel">
                    <b-form-input type="tel"
                     required id="input-tel" v-model="InputNumeroContato"
                     @change="ValidarNumeroContato"
                     :state="StatusTel"
                     ></b-form-input>
                    <label for="input-tel">N° Contato</label>
                    <p class="mensagem-de-erro">{{ MensagmeDeErroTel }}</p>
            </div>
        </div> 

        <div class="container-date">
            <p>Nos informe sua data de nascimento</p>
            <b-form-input type="date"  v-model="InputDate" :state="StatusInputDate" @change="ValidarDataNascimento" >
            </b-form-input>
            <p class="mensagem-de-erro">{{ MensagmeDeErroInputDate }}</p>

        </div>
         
        <div class="container-genero">
            <b-form-select :options="OptionsGenero" required id="input-genero" v-model="Genero" :state="StatusInputGenero" @change="ValidarCampoGenero"></b-form-select>
            <label>Genêro</label>
        </div>

        <div class="container-button">
            <button @click.prevent="VoltarEtapa">Voltar</button>
            <button @click.prevent="ProximaEtapa">Proxima etapa</button>
        </div>
    </div>
</template>


<script>
import axios from 'axios';


    export default{
        data(){
            return{
                OptionsGenero: [
                    {value:"Masculino", text:"Masculino"},
                    {value:"Feminino", text:"Feminino"},
                    {value:"Indefinido", text:"Indefinido"}
                ],
                DadosSelectDDI: "",
                UrlLocalDDIs: "",
                
                
            }

        },

        props:{
            StatusDDI: Boolean,
            StatusTel: Boolean,
            StatusInputDate: Boolean,
            StatusInputGenero: Boolean,
            // 
            MensagmeDeErroTel: String,
            MensagmeDeErroInputDate: String,
            // 
            InputNumeroContato: String,
            ddd: String,
            NumeroContato: String,
            NumeroContatoEmUsO: Boolean,
            InputDate: String,
            Genero: String,
            // 
            idDDI: Boolean,
            imgPaisSelecionado: String,
            NomePaisSelecionado: String,
            DDiSelecionado: String,
            //
            CLASSSelectDDI: String,
            ParagrafoSelectDDI: String,
            DDDescolhido: Boolean,
            ContainerOptionsDDIAtivo: Boolean,
        },



        mounted(){
            this.ResgatarDadosJson()
            
            // fechar container options ddi ao clicar fora dele
            document.addEventListener('click', (e) => {
      
                if(e.target.id != 'OptionPai' && e.target.id != 'OptionFilho' && e.target.id != 'SelectPai' && e.target.id != 'SelectFilho'){
                    this.ContainerOptionsDDIAtivo = false
                }
                this.CSSselectDDI();


            })


        },

        methods:{
            ProximaEtapa(){
                
                if(this.StatusDDI && this.StatusTel && this.StatusInputDate && this.StatusInputGenero)
                {
                    var RegexMarcarOsNumerosFinais = /[0-9]+$/
                    var BuscarNumero = this.InputNumeroContato.match(RegexMarcarOsNumerosFinais)

                   this.NumeroContato = BuscarNumero[0]

                    var dados = {
                        StatusDDI: this.StatusDDI,
                        StatusTel: this.StatusTel,
                        StatusInputDate: this.StatusInputDate,
                        StatusInputGenero: this.StatusInputGenero,
                        // 
                        MensagmeDeErroTel: this.MensagmeDeErroTel,
                        MensagmeDeErroInputDate: this.MensagmeDeErroInputDate,
                        // 
                        InputNumeroContato: this.InputNumeroContato,
                        ddd: this.ddd,
                        NumeroContato: this.NumeroContato,
                        NumeroContatoEmUsO: this.NumeroContatoEmUsO,
                        InputDate: this.InputDate,
                        Genero: this.Genero,
                        // 
                        idDDI: this.idDDI,
                        imgPaisSelecionado: this.imgPaisSelecionado,
                        NomePaisSelecionado: this.NomePaisSelecionado,
                        DDiSelecionado: this.DDiSelecionado,
                        //
                        CLASSSelectDDI: this.CLASSSelectDDI,
                        ParagrafoSelectDDI: this.ParagrafoSelectDDI,
                        DDDescolhido: this.DDDescolhido,
                        ContainerOptionsDDIAtivo: this.ContainerOptionsDDIAtivo,
                    }
                    
                    this.$emit('ProximaEtapa', dados)


                }
                else{
                    


                    this.ValidarDDI()
                    this.ValidarNumeroContao()
                    this.ValidarDataNascimento()
                    this.ValidarCampoGenero()
                }
            },

            VoltarEtapa(){
                


                var dados = {
                    StatusDDI: this.StatusDDI,
                    StatusTel: this.StatusTel,
                    StatusInputDate: this.StatusInputDate,
                    StatusInputGenero: this.StatusInputGenero,
                    // 
                    MensagmeDeErroTel: this.MensagmeDeErroTel,
                    MensagmeDeErroInputDate: this.MensagmeDeErroInputDate,
                    // 
                    InputNumeroContato: this.InputNumeroContato,
                    ddd: this.ddd,
                    NumeroContato: this.NumeroContato,
                    NumeroContatoEmUsO: this.NumeroContatoEmUsO,
                    InputDate: this.InputDate,
                    Genero: this.Genero,
                    // 
                    idDDI: this.idDDI,
                    imgPaisSelecionado: this.imgPaisSelecionado,
                    NomePaisSelecionado: this.NomePaisSelecionado,
                    DDiSelecionado: this.DDiSelecionado,
                    //
                    CLASSSelectDDI: this.CLASSSelectDDI,
                    ParagrafoSelectDDI: this.ParagrafoSelectDDI,
                    DDDescolhido: this.DDDescolhido,
                    ContainerOptionsDDIAtivo: this.ContainerOptionsDDIAtivo,
                }


                this.$emit('VoltarEtapa', dados)

            },

            ResgatarDadosJson(){
               this.DadosSelectDDI =  require('../../JSON/select-ddi.json')
               this.UrlLocalDDIs = this.DadosSelectDDI.banco_de_imagens[0].url_todos_ddi
            },
            
            AbrirEFecharContainerOptions(){
                if(this.ContainerOptionsDDIAtivo == false)
                {
                    this.ContainerOptionsDDIAtivo = true
                }
                else
                {
                    this.ContainerOptionsDDIAtivo = false
                }

                this.CSSselectDDI(); 
            },


            CSSselectDDI(){
                if(this.DDDescolhido == null)
                {
                    this.CLASSSelectDDI = 'container-select'
                }
                else if(this.DDDescolhido || this.ContainerOptionsDDIAtivo)
                {
                    this.CLASSSelectDDI = 'container-select-status-true'
                }
                else if(!this.DDDescolhido)
                {
                    this.CLASSSelectDDI = 'container-select-status-false'
                }
            },

            SelecinarDDI(e){
                if(e.target.id == 'OptionPai')
                {
                  
                    this.imgPaisSelecionado = e.target.children[0].currentSrc
                    this.NomePaisSelecionado = e.target.children[1].innerText
                    this.DDiSelecionado = e.target.children[2].innerText
                    this.idDDI = e.target.attributes[2].value
                    
                    
                }
                else if(e.target.id == 'OptionFilho')
                {
                    
                    this.imgPaisSelecionado = e.target.parentElement.children[0].currentSrc
                    this.NomePaisSelecionado = e.target.parentElement.children[1].innerText
                    this.DDiSelecionado = e.target.parentElement.children[2].innerText
                    this.idDDI = e.target.parentElement.attributes[2].value
                    
                    
                }

                
                this.ContainerOptionsDDIAtivo = false
                this.CLASSSelectDDI = "container-select"
                this.IncrementarDDINoInputTel();
                document.getElementById('input-tel').focus()
                this.ValidarDDI()
            },

            IncrementarDDINoInputTel(){
                if(!this.RegexCaracteresDDI(this.InputNumeroContato))
                {
                    this.InputNumeroContato = this.DDiSelecionado + this.InputNumeroContato
            
                }
                else
                {
                    var RegexCaracteresDDI = /^\(\+\d{0,10}\)|^\(\+\d{0,10}|^\+\d{0,10}\)|^\(\d{0,10}\)|^\d{0,10}\)|^\(\d{0,10}|^\+\d{0,10}|^\d{0,3}\s/

                    var SubstituirDDI = this.InputNumeroContato.replace(RegexCaracteresDDI, this.DDiSelecionado)
                    this.InputNumeroContato = SubstituirDDI
                }
            },


            RegexCaracteresDDI(DDI){
                var regex = /^\(\+\d{0,10}\)|^\(\+\d{0,10}|^\+\d{0,10}\)|^\(\d{0,10}\)|^\d{0,10}\)|^\(\d{0,10}|^\+\d{0,10}|^\d{0,3}\s/

                return regex.test(DDI)
            },

            RegexTelValidos(Tel){
                var regex = /^\d{8,9}$|^9\d{4}-\d{4}$|^\d{4}-\d{4}$/
                return regex.test(Tel)
            },

            DDIValido(DDIValido){
                var regex = /\(\+\d{1,3}\)/
                return regex.test(DDIValido)
            },

            ValidarDDI(){
                if(!this.DDIValido(this.InputNumeroContato))
                {
                    this.DDDescolhido = false
                    this.ParagrafoSelectDDI = "Selecione o seu DDI"
                }
                else
                {
                    this.DDDescolhido = true
                    this.ParagrafoSelectDDI = ""
                }


                // Isolando O ddi
                var Regexddi = /^\(\+\d{0,3}\)/
                var ddi = this.InputNumeroContato.match(Regexddi);

                if(ddi != undefined){
                    // Retirando os caracteres especiais do ddi
                    var RegexSelecionarCaracteresEspeciaisDDi = /\(|\)|\+/g
                    var ddisolado = ddi[0].replace(RegexSelecionarCaracteresEspeciaisDDi,'')
                    this.ddd = ddi[0]
                }


                for(var i in this.DadosSelectDDI.ddi_todos_paises)
                {   


                    // Impedir que quando seja feita alguma alteração do input tel o DDI (+1) seja alterado por outro DDI (+1)
                    if(this.idDDI != undefined){

                        if(ddisolado == 1 && this.DadosSelectDDI.ddi_todos_paises[this.idDDI].ddi_pais == 1 ){

                        this.imgPaisSelecionado = this.UrlLocalDDIs + this.DadosSelectDDI.ddi_todos_paises[this.idDDI].bandeira_imagem_nome
                        this.NomePaisSelecionado = this.DadosSelectDDI.ddi_todos_paises[this.idDDI].nome_pais


                        this.DDDescolhido = true
                        this.StatusDDI = true
                        break
                        
                        }


                    }

                    if(ddisolado == this.DadosSelectDDI.ddi_todos_paises[i].ddi_pais)
                    {

                        this.imgPaisSelecionado = this.UrlLocalDDIs + this.DadosSelectDDI.ddi_todos_paises[i].bandeira_imagem_nome
                        this.NomePaisSelecionado = this.DadosSelectDDI.ddi_todos_paises[i].nome_pais


                        this.DDDescolhido = true
                        this.StatusDDI = true
                        break
                    }
                    else
                    {
                        this.ParagrafoSelectDDI = 'DDI invalido' 
                        this.DDDescolhido = false
                        this.StatusDDI = false
                    }



                }

                this.CSSselectDDI();

                
                
            },

            async ValidarNumeroContato(){
                this.ValidarDDI()
                var RegexCaracteresDDI = /^\(\+\d{0,50}\)|^\(\+\d{0,50}|^\+\d{0,50}\)|^\(\d{0,50}\)|^\d{0,50}\)|^\(\d{0,50}|^\+\d{0,50}|^\d{0,50}\s/
                // 
                var ValueNumeroContatoSemDDI = this.InputNumeroContato.replace(RegexCaracteresDDI, '').trim()
                // 
                var form = new FormData();
                var RegexMarcarHifren = /-/gm
                var ValueTelLimpo =  ValueNumeroContatoSemDDI.replace(RegexMarcarHifren, '')
                form.append('numero_contato', ValueTelLimpo)

                await axios.post('http://localhost/projetos/ex01/backend/public/criar-conta/numero_contato_em_uso.php', form )
                .then(Response => {
                    
                    if(Response.data == 'numero de contato não esta em uso')
                    {
                        this.NumeroContatoEmUsO = false
                    }
                    else if('numero de contato em uso')
                    {
                        this.NumeroContatoEmUsO = true
                    }

                })

                if(ValueNumeroContatoSemDDI.length == 0){
                    this.MensagmeDeErroTel = "Insira um numero de contato"
                    this.StatusTel = false

                }
                else if(!this.RegexTelValidos(ValueNumeroContatoSemDDI)){
                    this.MensagmeDeErroTel = "Insira um numero valido"
                    this.StatusTel = false
                }
                else if(this.NumeroContatoEmUsO)
                {
                    this.MensagmeDeErroTel = "Esse numeo já está em uso por outro usuario"
                    this.StatusTel = false
                }
                else
                {
                    this.MensagmeDeErroTel = ""
                    this.StatusTel = true
                }
            },

            ValidarDataNascimento(){
                var Data = new Date();
                var ano = Data.getFullYear();
                // 
                var RegexBuscarPrimeirosIndices = /^\d{4,5}/
                var BuscaDataAno = this.InputDate.match(RegexBuscarPrimeirosIndices)
                // 
                var ValueDataAno = 0
                // 
                var AnoNascimentoParaPoderCadastrar1 = ano - 14
                var AnoNascimentoParaPoderCadastrar2 = ano - 120

                
                if(BuscaDataAno != undefined)
                {
                    ValueDataAno = BuscaDataAno[0]
                }

                if(!this.InputDate){
                    this.StatusInputDate = false
                }
                else if( ValueDataAno > ano )
                {
                    this.StatusInputDate = false
                }
                else if( ValueDataAno < AnoNascimentoParaPoderCadastrar2)
                {
                    this.StatusInputDate = false
                    this.MensagmeDeErroInputDate = 'Data invalida'
                }
                else if(ValueDataAno > AnoNascimentoParaPoderCadastrar1 )
                {
                    this.StatusInputDate = false
                    this.MensagmeDeErroInputDate = 'Você não tem idade suficiente para se cadastrar'
                }
                else 
                {
                    this.StatusInputDate = true
                    this.MensagmeDeErroInputDate = ''
                }
            },

            ValidarCampoGenero(){
                if(!this.Genero)
                {
                    this.StatusInputGenero = false
                }
                else
                {
                    this.StatusInputGenero = true
                }
            },


            
            
        }
    }

</script>

<style scoped>

p{
    font-size: 1.2rem;
    font-weight: 400;
    margin-bottom: 1rem;
   
}


/* CONTAINER  CONTATO*/




.container-contato{
    display: flex;
    justify-content: space-between;
}

.container-contato .container-ddd{
    width: 40%;
}

.container-contato  .container-tel{
    width: 60%;

}

.container-ddd{
    position: relative;
    display: flex;
}

.container-ddd div{
    display: flex;
}



.container-select div img,
.container-select-status-false div img,
.container-select-status-true div img
{
    width: 2rem;
    height: 1.5rem;
}


.container-select{
    justify-content: center;
    background: #ffffff40;
    border: 0.1rem solid #fff;
    height: 3rem;
    cursor: pointer;
    border-radius:0.3rem;
    width: 90%;
}

.container-select-status-false{
    justify-content: center;
    background: #ffffff40;
    border: 0.1rem solid rgb(255, 7, 7);
    height: 3rem;
    cursor: pointer;
    border-radius: 0.3rem;
    width: 90%;
}

.container-select-status-true{
    justify-content: center;
    background: #ffffff40;
    border: 1px solid #4571ef;
    height: 3rem;
    cursor: pointer;
    border-radius: 0.3rem;
    width: 90%;
}

.container-select div,
.container-select-status-false div,
.container-select-status-true div
{
    justify-content: space-around;
    align-items: center;
    width: 100%;
}


.container-select div p,
.container-select-status-false div p,
.container-select-status-true div p
{
    margin-bottom: 0rem;
    font-weight: bold;   
    text-align: center;

}





.container-select p,
.container-select-status-true p,
.container-select-status-false p{
    font-size: 1rem;
}


.container-options{
    width: 25rem;
    height: 20rem;
    position: absolute;
    top: 3.3rem;
    left: 0rem;
    display: flex;
    flex-direction: column;
    border: 1px solid rgb(91, 113, 255);
    overflow: auto;
    z-index: 1000;
}

.options{
    width: 100%;
    height: 3rem;
    padding: 2rem 1rem;
    background: rgb(255, 255, 255);
    cursor: pointer;

    display: flex;
    align-items: center;
    justify-content: space-between;
}


.options p{
    margin-bottom: 0px;
    text-align: center;
}


.options img{
    width: 2rem;
    height: 1.5rem;
}


.options:hover{
    background:  #202fff;
    color: #fff;

}




/* ==============================inputs, label, selects */
.mensagem-de-erro{
        font-weight: bold;
        color: #ff1e00;
        font-size: 1.2rem;
}

.form-control,
.custom-select{
    background: #ffffff40 !important;
    border: 1px solid #fff;
    height: 3rem;
    cursor: pointer;
}



.container-tel, .container-genero
{
    position: relative;

}



label{
    position: absolute;
    top: 0.4rem;
    cursor: pointer;
    left: 0.3rem;
}

input:focus{
    cursor: auto;
}

input:focus + label,
select:focus + label
{
    top: -1.6rem;
    color: #6688f5;
    font-size: 1.3rem;
    transition: 0.2s;

}

input:valid + label,
select:valid + label

{
    top: -1.6rem;
    font-size: 1.3rem;

}



.form-control:focus,
select:focus{
    outline: none;
    box-shadow: 0px 0px 0px !important;
    border: 0.1rem  solid #4571ef !important;
}


.form-control.is-valid,
.custom-select.is-valid:valid {
    border:0.1rem  solid #6688f5;
    background-image: url('../../img/page-login/verificar.svg');
}


.form-control.is-invalid,
.custom-select.is-invalid
{
    border: 0.1rem solid #ff1e00;
    background-image: url('../../img/page-login/cruz.svg');
    background-size: 0.8rem;
}

.custom-select
{
    font-size: 1.3rem !important;
    cursor: pointer;
    
}

.custom-select option{
    cursor: pointer !important;
}

/* =====================margin entre containers */

.container-contato{
    margin: 2rem 0rem 1rem 0rem;
}

.container-date{
    margin-bottom: 2rem;
}

.container-date p{
    margin: 0px;
}

.container-genero{
    margin-bottom: 2rem;
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



@media(max-width: 500px){
    .container-select-status-true p{
        display: none;
    }
}





</style>
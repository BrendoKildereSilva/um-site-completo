<template>
    <div>
        

        <CriarContaEtapa01 v-if="this.etapa01"

            :nome="nome" :sobrenome="sobrenome"
            :email="email" 
            :senha="senha" :confirmarsenha="confirmarsenha"
            
            :StatusNome="StatusNome" 
            :StatusSobrenome="StatusSobrenome"
            :StatusEmail="StatusEmail"
            :StatusSenha="StatusSenha"
            :StatusConfirmarSenha="StatusConfirmarSenha"

            :EmailEmUso="EmailEmUso"

            :CampoConfirmarSenhaAcionado="CampoConfirmarSenhaAcionado"


            @ProximaEtapa="EmicaoProximaEtapa01"


        ></CriarContaEtapa01>


        <CriarContaEtapa02 v-if="this.etapa02"

        :cargo="cargo"
        :EscolheuCargo="EscolheuCargo"
        :MensagemDeErroEtapa02="MensagemDeErroEtapa02"
        
        @ProximaEtapa="EmicaoButtonProxaEtapa02"
        @VoltarEtapa="EmicaoButtonVoltarEtapa02"
        
        ></CriarContaEtapa02>
        
        
        <CriarContaEtapa03 v-if="this.etapa03"

        :StatusDDI="StatusDDI"
        :StatusTel="StatusTel"
        :StatusInputDate="StatusInputDate"
        :StatusInputGenero="StatusInputGenero"

        :MensagmeDeErroTel="MensagmeDeErroTel"
        :MensagmeDeErroInputDate="MensagmeDeErroInputDate"

        :ddd="ddd"
        :InputNumeroContato="InputNumeroContato"
        :NumeroContato="NumeroContato"
        :NumeroContatoEmUsO="NumeroContatoEmUsO"
        :InputDate="InputDate"
        :Genero="Genero"

        :idDDI="idDDI"
        :imgPaisSelecionado="imgPaisSelecionado"
        :NomePaisSelecionado="NomePaisSelecionado"
        :DDiSelecionado="DDiSelecionado"

        :CLASSSelectDDI="CLASSSelectDDI"
        :ParagrafoSelectDDI="ParagrafoSelectDDI"
        :DDDescolhido="DDDescolhido"
        :ContainerOptionsDDIAtivo="ContainerOptionsDDIAtivo"


        @VoltarEtapa="EmicaoButtonVoltarEtapa03"
        @ProximaEtapa="EmicaoButtonProximaEtapa03"
        ></CriarContaEtapa03>

        <CriarContaEtapa04 v-if="this.etapa04"

        :TemImagem="TemImagem"
        :preview="preview"
        :ImagemArquivo="ImagemArquivo"
        :MensagemDeErroEtapa04="MensagemDeErroEtapa04"

        @VoltarEtapa="EmicaoButtonVoltarEtapa04"
        @ProximaEtapa="EmicaoButtonCriarContaEtapa04">
        </CriarContaEtapa04>


    </div>
</template>

<script>
import CriarContaEtapa01 from '~/components/criar-conta/etapa-registro-01.vue'
import CriarContaEtapa02 from '~/components/criar-conta/etapa-registro-02.vue'
import CriarContaEtapa03 from '~/components/criar-conta/etapa-registro-03.vue'
import CriarContaEtapa04 from '~/components/criar-conta/etapa-registro-04.vue'
import axios from 'axios'

export default {
    data(){
            return{
                etapa01: true,
                etapa02: false,
                etapa03: false,
                etapa04: false,
                // Dados do component ETAPA 01
                DadosEtapa01: {},
                nome: "",
                sobrenome: "",
                email: "",
                senha: "",
                confirmarsenha: "",
                EmailEmUso: null,
                // 
                MensagemDeErroNome: "",
                MensagemDeErroSobrenome: "",
                MensagemDeErroEmail: "",
                MensagemDeErroSenha: "",
                MensagemDeErroConfirmarSenha: "",
                // 
                StatusNome: null,
                StatusSobrenome: null,
                StatusEmail: null,
                StatusSenha: null,
                StatusConfirmarSenha: null,
                // 
                CampoConfirmarSenhaAcionado: false,
                // 
                VisualizarSenhas: false,
                // Dados do component ETAPA 02
                DadosEtapa02: {},
                cargo: '',
                EscolheuCargo: false,
                MensagemDeErroEtapa02: "",
                // Dados do component ETAPA 03
                DadosEtapa03:{},
                StatusDDI: null,
                StatusTel: null,
                StatusInputDate: null,
                StatusInputGenero: null,
                // 
                MensagmeDeErroTel: "",
                MensagmeDeErroInputDate :"",
                // 
                InputNumeroContato: "",
                ddd: "",
                NumeroContato: "",
                NumeroContatoEmUsO: null,
                InputDate: "",
                Genero: "",
                // 
                idDDI: undefined,
                imgPaisSelecionado: "",
                NomePaisSelecionado: "",
                DDiSelecionado: "",
                //
                CLASSSelectDDI: "container-select",
                ParagrafoSelectDDI: "Selecione o seu DDI",
                DDDescolhido: null,
                ContainerOptionsDDIAtivo: false,
                // Dados do component ETAPA 03
                DadosEtapa04:{},                
                TemImagem: false,
                preview: "",
                ImagemArquivo: "",
                MensagemDeErroEtapa04: ""


                
                
            }
        },

        components:{
            CriarContaEtapa01,
            CriarContaEtapa02,
            CriarContaEtapa03,
            CriarContaEtapa04,
        },

        methods:{


            // ETAPA 01
            AtualizandoDadosEtapa01(){
                this.nome = this.DadosEtapa01.nome
                this.sobrenome = this.DadosEtapa01.sobrenome
                this.email = this.DadosEtapa01.email
                this.senha = this.DadosEtapa01.senha
                this.confirmarsenha = this.DadosEtapa01.confirmarsenha
                // 
                this.StatusNome = this.DadosEtapa01.StatusNome 
                this.StatusSobrenome = this.DadosEtapa01.StatusSobrenome
                this.StatusEmail = this.DadosEtapa01.StatusEmail 
                this.StatusSenha = this.DadosEtapa01.StatusSenha
                this.StatusConfirmarSenha = this.DadosEtapa01.StatusConfirmarSenha
                // 
                this.CampoConfirmarSenhaAcionado = true
            },

            EmicaoProximaEtapa01(DadosEtapa01){
                
                
                // Proxima etapa
                this.etapa01 = false
                this.etapa02 = true
                this.etapa03 = false
                this.etapa04 = false

                this.DadosEtapa01 = DadosEtapa01
                this.AtualizandoDadosEtapa01();

                
            },

            // ETAPA 02
            AtualizandoDadosEtapa02(){
                this.cargo = this.DadosEtapa02.cargo
                this.EscolheuCargo = this.DadosEtapa02.EscolheuCargo
                this.MensagemDeErroEtapa04 = this.DadosEtapa02.MensagemDeErroEtapa04
            },

            EmicaoButtonVoltarEtapa02(DadosEtapa02){
                this.etapa01 = true
                this.etapa02 = false
                this.etapa03 = false
                this.etapa04 = false

                this.DadosEtapa02 = DadosEtapa02
                this.AtualizandoDadosEtapa02()
            },

            EmicaoButtonProxaEtapa02(DadosEtapa02){
                // Proxima etapa
                this.etapa01 = false
                this.etapa02 = false
                this.etapa03 = true
                this.etapa04 = false

                this.DadosEtapa02 = DadosEtapa02
                this.AtualizandoDadosEtapa02()

                

            },
            
            // ETAPA 03

            AtualizandoDadosEtapa03(){
                this.StatusDDI = this.DadosEtapa03.StatusDDI 
                this.StatusTel= this.DadosEtapa03.StatusTel
                this.StatusInputDate= this.DadosEtapa03.StatusInputDate
                this.StatusInputGenero= this.DadosEtapa03.StatusInputGenero
                // 
                this.MensagmeDeErroTel= this.DadosEtapa03.MensagmeDeErroTel
                this.MensagmeDeErroInputDate = this.DadosEtapa03.MensagmeDeErroInputDate
                // 
                this.ddd = this.DadosEtapa03.ddd
                this.InputNumeroContato= this.DadosEtapa03.InputNumeroContato
                this.NumeroContato= this.DadosEtapa03.NumeroContato
                this.InputDate= this.DadosEtapa03.InputDate
                this. Genero= this.DadosEtapa03.Genero
                // 
                this.idDDI = this.DadosEtapa03.idDDI
                this.imgPaisSelecionado = this.DadosEtapa03.imgPaisSelecionado
                this.NomePaisSelecionado = this.DadosEtapa03.NomePaisSelecionado
                this.DDiSelecionado = this.DadosEtapa03.DDiSelecionado
                //
                this.CLASSSelectDDI= this.DadosEtapa03.CLASSSelectDDI
                this.ParagrafoSelectDDI= this.DadosEtapa03.ParagrafoSelectDDI
                this.DDDescolhido = this.DadosEtapa03.DDDescolhido
                this.ContainerOptionsDDIAtivo= this.DadosEtapa03.ContainerOptionsDDIAtivo
                this.ExibirTodosOsDDI= this.DadosEtapa03.ExibirTodosOsDDI
            },

            EmicaoButtonVoltarEtapa03(DadosEtapa03){
                this.etapa01 = false
                this.etapa02 = true
                this.etapa03 = false
                this.etapa04 = false

                // salvando dados alterados
                this.DadosEtapa03 = DadosEtapa03
                this.AtualizandoDadosEtapa03();

            },

            EmicaoButtonProximaEtapa03(DadosEtapa03){
                this.etapa01 = false
                this.etapa02 = false
                this.etapa03 = false
                this.etapa04 = true

                // salvando dados alterados
                this.DadosEtapa03 = DadosEtapa03
                this.AtualizandoDadosEtapa03();
                
                

            },


            // ETAPA 04

            AtualizandoDadosEtapa04(){
                this.TemImagem = this.DadosEtapa04.TemImagem
                this.preview = this.DadosEtapa04.preview
                this.ImagemArquivo = this.DadosEtapa04.ImagemArquivo
                this.MensagemDeErroEtapa04 = this.DadosEtapa04.MensagemDeErroEtapa04
            },

            EmicaoButtonVoltarEtapa04(DadosEtapa03){
                this.etapa01 = false
                this.etapa02 = false
                this.etapa03 = true
                this.etapa04 = false

                this.DadosEtapa04 = DadosEtapa03
                this.AtualizandoDadosEtapa04()
            },

            async EmicaoButtonCriarContaEtapa04(DadosEtapa04){
                this.DadosEtapa04 = DadosEtapa04 
                var RegexMarcarHifren = /-/gm
                var NumeroContatoLimpo = this.NumeroContato.replace( RegexMarcarHifren ,'')
                // 
                var dia_nasc = this.InputDate.slice(8)
                var mes_nasc = this.InputDate.slice(5, -3)
                var ano_nasc = this.InputDate.slice(0, -6)
                // 
                this.email += '@gmail.com'
                // 
                var form = new FormData();
                form.append('nome', this.nome)
                form.append('sobrenome', this.sobrenome)
                form.append('email', this.email)
                form.append('senha', this.senha)
                // 
                form.append('cargo', this.cargo)
                // 
                form.append('ddi', this.ddd)
                form.append('numero_contato', NumeroContatoLimpo)
                form.append('dia_nasc', dia_nasc)
                form.append('mes_nasc', mes_nasc)
                form.append('ano_nasc', ano_nasc)
                form.append('genero', this.Genero)
                form.append('foto_perfil', DadosEtapa04)

    

                await axios.post('http://localhost/projetos/ex01/backend/public/criar-conta/CriarConta.php', form)
                this.$router.push('/login')

  
            }
        }
}
</script>



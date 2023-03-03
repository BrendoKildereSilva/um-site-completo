export const state = {
    user: {
        nome: "",
        sobrenome: "",
        email: "",
        cargo: "",
        FotoPerfil: ""
    }
}

export const mutations = {
    ArmazenarDadosDeSession(state, payload){
        state.user.nome = payload.dados.nome
        state.user.email = payload.dados.email
        state.user.sobrenome = payload.dados.sobrenome
        state.user.cargo = payload.dados.cargo
        state.user.FotoPerfil = payload.dados.foto_perfil
        
    }
}

export const actions = {
    ArmazenarDadosDeSession(context, payload){
        context.commit('ArmazenarDadosDeSession', payload)
    },

    GoodMonning(){
        var p = document.querySelectorAll('p')
        console.log(p)
    }
}


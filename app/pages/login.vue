<template>


    <div class="body">

        <div class="icons-geometricos">
            <div class="icon-01">
            </div>

            <div class="icon-02">
            </div>

            
            <div class="icon-03">
            </div>

            
            <div class="icon-04">
            </div>
        </div>

        <div class="backgorund">

            <form novalidate>
                <h1>BK produtos</h1>

                <nav>
                    <NuxtLink to="/login">Login</NuxtLink>
                    <NuxtLink to="/login/criar-conta">Criar conta</NuxtLink>
                </nav>

                
                
                <NuxtChild></NuxtChild>
                
            </form>


        </div>
    </div>


</template>


<script>
    export default{
        layout: 'default'
    }

</script>

<style scoped>

.body{
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: 100vh;
    background: #4340e6;
    overflow: hidden;

}

.backgorund{
    width: 70%;
    height: 85%;
    border-radius: 4rem;
    background: url('../img/page-login/backgorund.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: -1px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    z-index: 2;
}

form{
    background: #f5f5f595;
    backdrop-filter: blur(5px);
    width: 40%;
    height: 90%;
    border: 1px solid #fff;
    margin-right: 3rem;
    padding: 1rem;
    border-radius: 1rem;
    overflow: auto;
}



h1{
    font-weight: bold;
    text-align: center;
    font-size: 2rem;
    color: #4571ef
}



nav{
    width: 100%;
    display: flex;
    justify-content: space-between;
}

nav a{
    text-decoration: none;
    text-align: center;
    color: #fff;
    border-bottom: 0.3rem solid #fff;
    width: 47%;
    font-weight: bold;
    font-size: 1.5rem;
}

nav a.nuxt-link-exact-active{
    color: #4571ef;
    border-bottom: 0.3rem solid #4571ef;
}
.icons-geometricos{
    position: relative;
}
.icon-01{
    position: absolute;
    width: 20rem;
    height: 20rem;
    background: #fff;
    border-radius: 50%;
    top: -35rem;
    left: -9rem;
    z-index: 1;
    box-shadow: 5px 11px 5px 5px rgba(0, 0, 0, 0.2);
}

.icon-02{
    position: absolute;
    width: 20rem;
    height: 42rem;
    background: #fff;
    top: -10rem;
    left: 80rem;
    z-index: 1;
    box-shadow: 5px 11px 5px 5px rgba(0, 0, 0, 0.2);
}

.icon-03{
    position: absolute;
    width: 15rem;
    height: 15rem;
    background: #fff;
    top: -35rem;
    left: 70rem;
    z-index: 1;
    box-shadow: 5px 11px 5px 5px rgba(0, 0, 0, 0.2);
}

.icon-04{
    position: absolute;
    width: 20rem;
    height: 20rem;
    background: #fff;
    top: 10rem;
    left: -18rem;
    z-index: 1;
    box-shadow: 5px 11px 5px 5px rgba(0, 0, 0, 0.2);
}



/* media query */




@media(max-width: 1000px){
    .backgorund{
        width: 100%;
        height: 100%;
        border-radius: 0px;
    }

    .icons-geometricos{
        display: none;
    }
}


@media(max-width: 1000px) and (min-height: 1000px){
    

    .backgorund{
        justify-content: center;
    }


    form{
        margin-right: 0px;
        width: 70%;
    }
}

@media(max-width: 760px){
     

    .backgorund{
        justify-content: center;
    }


    form{
        margin-right: 0px;
        width: 100%;
        height: 100%;
        border-radius: 0px;
        overflow: auto;

    }
}


@media(max-height: 560px){


    .backgorund{
        width: 100%;
        height: 100%;
        border-radius: 0px;
        justify-content: flex-end;
    }

    form{
        margin-right: 0px;
        height: 100%;
        width: 50%;
        border-radius: 0px;
    }
}

@media(max-height: 560px) and (max-width: 560px){
    

    form{
        height: 100%;
        width: 100%;
    }
}






















</style>
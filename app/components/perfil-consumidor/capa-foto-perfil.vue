<template>
    <div>
        <div class="container-capa">




            <div class="container-foto">
                <div class="background-cinza">
                </div>
            </div>


            

        </div>
    </div>
</template>


<style scoped>
    .container-capa{
        width: 100%;
        height: 20rem;
    }

    .container-foto{
        width: 100%;
        height: 100%;        
    }

    

    .background-cinza{
        width: 100%;
        height: 100%;
        background: #ccc;
        cursor: pointer;
    }

    .background-cinza:hover{
        background-image: url('~~/img/perfil-consumidor/camera.svg');
        background-size: 3rem;
        background-repeat: no-repeat;
        background-position: top 5% right 5%;
    }
</style>
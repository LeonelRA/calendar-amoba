<template>
    <div id="routes" class="col-md-12 col-lg-3 bg-white">
        <h3>Rutas disponibles</h3>
        <ul class="mt-4">
            <li v-for="(route, index) in routes" :key="index" :class="{'bg-route' : routeIndex == index}">
                <a href="#" class="text-dark" @click="filterRoutes(index)">
                    {{ route[1].title }}
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                routes: [],
                routeIndex: null
            }
        },
        mounted(){
            this.getRoutes();
        },
        methods: {
            getRoutes(){
                axios.get('/api/routes').then(resp => {
                    this.routes = resp.data.data;
                })
                .catch(error => {
                    alert('Ha ocurrido un fallo, intenta nuevamente.'+ error);
                }) 

            },
            filterRoutes(route){
                this.routeIndex == route ? this.routeIndex = null : this.routeIndex = route;

                if (this.routeIndex !== null) {
                    this.$emit('filterRoutes', {
                        startDate : this.routes[this.routeIndex][0].date_init,
                        endDate : this.routes[this.routeIndex][0].date_finish
                    });   
                }
            },
        }
    }
</script>
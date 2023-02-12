<template>
    <div id="filter" class="d-flex justify-content-between">
        <div id="filter-date">
            <p class="mb-2">Seleccione Fecha</p>
            <div class="bg-white" style="cursor: pointer;" @click="() => showModal = false">
                <span v-if="filter.startDay && filter.endDay">{{ filter.startDay}} / {{ filter.endDay}}</span>
                <span v-if="filter.startDay && !filter.endDay">{{ filter.startDay}}</span>
                <span class="ml-4"><i class="fa-solid fa-calendar"></i></span>
            </div>

            <div id="filter-modal" @click="closeModal" :class="{'d-none' : showModal}">
                <form action="">
                    <h2 class="mb-4">Selecciona una fecha</h2>
                    <div>
                        <label for="startDay">Fecha inicial</label>
                        <input type="date" id="startDay" v-model="startDate">
                    </div>
                    <div class="mt-4">
                        <label for="endDay">Fecha final</label>
                        <input type="date" id="endDay" v-model="endDate">
                    </div>
                    <button class="btn bg-primary mt-4" @click.prevent="filterCalendar">Filtrar por fecha</button>
                </form>
            </div>
        </div>
        <div id="filter-route">
            <p class="mb-2">Seleccione el calendario</p>
            <div>
                <select class="custom-select" v-model="calendar" @change="filterCalendar">
                    <option :value="null" disabled>Seleccionar...</option>
                    <option :value="0" selected>Todos</option>
                    <option v-for="(calendar, index) in calendars" :key="index" :value="calendar.id">{{ calendar.name }}</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            filter:{
                type: Object,
                required: true
            },
        },
        data() {
            return {
                calendars: [],
                showModal: true,
                calendar: null,
                startDate: '',
                endDate: ''
            }
        },
        mounted(){
            this.getCalendars();
        },
        methods: {
            getCalendars(){
                axios.get('/api/get-calendars').then(resp => {
                    this.calendars = resp.data.data;
                })
                .catch(error => {
                    alert('Ha ocurrido un fallo, intenta nuevamente.'+ error);
                }) 
            },
            closeModal(event){
                if (!event.target.closest("#filter-modal form")) {
                        this.showModal = true;
                }
            },
            filterCalendar(){

                let dataFilter = {};

                if (!this.validateDates()) {
                    return;
                }

                if (this.startDate !== '') {
                    dataFilter = {
                        startDate: this.startDate,
                        endDate: this.endDate
                    }

                    this.showModal = true;
                }

                if (this.calendar > 0) {
                    dataFilter = {
                        calendarId: this.calendar,
                    }
                }

                this.$emit('filterValues', dataFilter);

            },
            validateDates() {
                if (this.startDate == '' && this.calendar == null) {
                    alert("debes elegir por lo menos una fecha");
                    return false;
                }

                if (this.startDate !== '') {
                    let startDate = new Date(this.startDate);
                    let endDate = new Date(this.endDate);

                    if (startDate && endDate && startDate.getTime() > endDate.getTime()) {
                        alert("La fecha final debe ser mayor a la inicial");
                        return false;
                    }
                }

                return true;
            }








        }
    }
</script>
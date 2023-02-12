<template>
    <div class="row justify-content-between m-0">
        <div class="col-md-12 col-lg-8 mt-4 p-0" style="position: inherit">
            <Filters @filterValues="filterCalendar" :filter="filter" />

            <div id="calendar">
                
                <div id="header-calendar" class="d-flex justify-content-between align-items-center">
                    <h2>{{ monthName }} {{ year }}</h2>
                    <div>
                        <button v-on:click="prevMonth" :disabled="calendar.index == 0"><i class="fa-solid fa-chevron-left"></i></button>
                        <button v-on:click="nextMonth" :disabled="calendar.index == (calendar.months.length - 1)"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
                <div id="content-calendar">
                    <ul id="days">
                        <li>Sunday</li>
                        <li>Monday</li>
                        <li>Tuesday</li>
                        <li>Wednesday</li>
                        <li>Thursday</li>
                        <li>Fruday</li>
                        <li>Saturday</li>
                    </ul>
                    <ul id="dates">

                        <li v-for="(day, index) in calendar.days" :key="index" :class="{'disabled-day' : day.month !== calendar.month}">
                            <span v-if="!day.day_disabled && !day.reservation && day.is_working_day && !day.full_capacity" >{{ day.day }}</span>
                            <span v-if="day.day_disabled" class="disabled">{{ day.day }}</span>
                            <span v-if="day.full_capacity" class="full-route">{{ day.day }}</span>
                            <span v-if="day.reservation" class="reserved">{{ day.day }}</span>
                            <span v-if="!day.is_working_day && !day.day_disabled && !day.reservation && !day.full_capacity" class="off-frequency">{{ day.day }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <FilterRoutes @filterRoutes="filterCalendar" />
    </div>
</template>

<script>
    import Filters from "./components/filter.vue";
    import FilterRoutes from "./components/routes.vue";

    export default {
        components: {
            Filters,
            FilterRoutes
        },
        data(){
            return {
                calendar: {
                    index: 0,
                    months: [],
                    days: [],
                    month: 1
                },
                monthName: "",
                year: '',
                filter: {
                    calendarId: null,
                    startMonht: 1,
                    endMonht: 1,
                    startYear: 2021,
                    endYear: 2021,
                    startDay: '2021-01-01',
                    endDay: '2021-01-31'
                }
            }
        },
        mounted() {
            this.getDatesCalendar();
        },
        methods: {
            getDatesCalendar(){

                const data = {
                    calendarId : this.calendarId,
                    startMonht : this.filter.startMonht,
                    endMonht   : this.filter.endMonht,
                    startYear  : this.filter.startYear,
                    endYear    : this.filter.endYear
                }

                axios.post('/api/calendar', {data}).then(resp => {
                    this.calendar.months = resp.data.data;
                    this.calendar.days = resp.data.data[this.calendar.index];

                    const searchMonth = this.calendar.days.filter(day => day.day == 1);
                    this.calendar.month = searchMonth[0].month;
                    this.year = searchMonth[0].year;

                    this.nameMonth();
                })
                .catch(error => {
                    alert('Ha ocurrido un fallo, intenta nuevamente.'+ error);
                }) 


            },
            nameMonth(){
                this.monthName = new Intl.DateTimeFormat('es-ES', { month: 'long'}).format(new Date(`${this.calendar.month}`));
                this.monthName = this.monthName.charAt(0).toUpperCase() + this.monthName.slice(1);
            },

            prevMonth() {
                this.year -= (this.calendar.month == 1) ? 1 : 0;
                this.calendar.month = (this.calendar.month - 1 + 12) % 12 || 12;
                this.calendar.index--;
                this.calendar.days = this.calendar.months[this.calendar.index];
                this.nameMonth();
            },
            nextMonth() {
                this.calendar.month = (this.calendar.month % 12) + 1;
                this.year += (this.calendar.month == 1) ? 1 : 0;
                const next =++ this.calendar.index;
                this.calendar.days = this.calendar.months[next];
                this.nameMonth();
            },

            filterCalendar(object){

                if(object.startDate){
                    this.filter.startDay = object.startDate.substring(0,10);
                    this.filter.endDay   = object.endDate.substring(0,10);

                    this.filter.startMonht = object.startDate.substring(5,7);
                    this.filter.startYear  = object.startDate.substring(0,4);
                    this.filter.endMonht   = object.endDate.substring(5,7);
                    this.filter.endYear    = object.endDate.substring(0,4);
                }

                this.calendarId = object.calendarId ?? null;

                this.getDatesCalendar();
            }

        }
    }
</script>

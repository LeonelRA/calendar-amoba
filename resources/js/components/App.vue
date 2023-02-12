<template>
    <div class="mt-4 mb-4 d-flex justify-content-center">
        <AsideMenu />

        <div id="content">

            <Header />

            <Calendar />
            
        </div>
    </div>
</template>

<script>
    import AsideMenu from "./AsideMenu/View.vue"
    import Header from "./Header/View.vue"
    import Calendar from "./Calendar/View.vue"

    export default {
        components: {
            AsideMenu,
            Header,
            Calendar
        }
    }
</script>

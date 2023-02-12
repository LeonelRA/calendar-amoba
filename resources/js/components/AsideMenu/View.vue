<template>
    <div id="aside-menu" class="bg-primary">
        <button @click="showNavbar = !showNavbar"><i class="fa-solid fa-bars"></i></button>
        <div :class="{'menu-show' : showNavbar}">
            <ul class="menu">
                <li class="mb-3">
                    <a href="#" class="text-white"><span><i class="fa-solid fa-chart-pie"></i></span> Dashboard</a>
                </li>
                <li class="mb-3">
                    <a href="#" class="text-white"><span><i class="fa-solid fa-tags"></i></span> Transactions</a>
                </li>
                <li class="mb-3">
                    <a href="#" class="text-white font-weight-bold"><span><i class="fa-solid fa-calendar-days"></i></span> Schedules</a>
                </li>
                <li class="mb-3">
                    <a href="#" class="text-white"><span><i class="fa-solid fa-circle-user"></i></span> Users</a>
                </li>
                <li class="mb-3">
                    <a href="#" class="text-white"><span><i class="fa-solid fa-gear"></i></span> Settings</a>
                </li>
            </ul>

            <ul class="about">
                <li class="mb-3">
                    <a href="#" class="text-white">Help</a>
                </li>
                <li class="mb-3">
                    <a href="#" class="text-white">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showNavbar: false
            }
        }
    }
</script>

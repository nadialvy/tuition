<template>
    <div id="wrapper">
        <SidebarComp />
        <NavbarComp />
    </div>
</template>

<script>
import NavbarComp from '../components/template/Navbar.vue'
import SidebarComp from '../components/template/Sidebar.vue'

export default{
    name: 'dashboard-component',
    components: {
        NavbarComp,
        SidebarComp
    }
}
</script>

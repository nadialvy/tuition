<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'app-component',
    methods: {
        CheckToken(){
            if(localStorage.getItem('Authorization') === null){
                this.$store.commit('logout')
                this.$router.push('/login')
            }else {
                let token = {
                    headers: { "Authorization" : "Bearer " + localStorage.getItem('Authorization') }
                }

                axios.get('http://localhost:8000/api/loginCheck', token)
                .then( response => {
                    if(response.data.status === 1){
                        this.$store.commit('setToken', localStorage.getItem('Authorization'))
                        this.$store.commit('setUser', response.data.data)
                    }else{
                        this.$store.commit('logout')
                        this.$router.push('/login')
                    }
                })
                .catch( error => {
                    this.$store.commit('logout')
                    this.$router.push('/login')
                    console.log(error);
                })
            }
        }
    },
    mounted(){
        this.CheckToken()
    }
}
</script>
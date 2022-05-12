<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-evenly align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Officer Data</h6>
                <button class="btn btn-primary ml-5" v-on:click="addData()" type="button" data-toggle="modal" data-target="#addEditModal">Add Data</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(officer, i) in officers" :key="i">
                                <td> {{ i + 1 }} </td>
                                <td> {{ officer.officer_name }} </td>
                                <td> {{ officer.username }} </td>
                                <td> {{ officer.level }} </td>
                                <td>
                                    <div class="d-flex justify-content-around align-items-center">
                                        <button class="btn btn-primary" v-on:click="editData(officer)" type="button" data-toggle="modal" data-target="#addEditModal"><i class="far fa-edit"></i></button>
                                        <button class="btn btn-danger" v-on:click="removeData(officer.officer_id)"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

         <!-- Modal add data  -->
        <div class="modal fade" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{this.action}} Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input id="name" type="text" v-model="officer_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input id="username" type="text" v-model="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="pass">Password</label>
                        <input id="pass" type="password" v-model="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="level">Level</label>
                        <select class="form-control" id="class" v-model="level" required>
                            <option value="officer">Officer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button v-on:click="saveData()" type="button" class="btn btn-primary" data-dismiss="modal">{{this.action}}</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'officer-component',
        data(){
            return{
                officers: [],
                action: '',

                // v-model 
                officer_id: '',
                officer_name: '',
                username: '',
                password: '',
                level: '',

            }
        },
        methods: {
            getData(){
                this.axios.get('http://localhost:8000/api/officer')
                .then(response => {
                    this.officers = response.data
                })
            },
            addData(){
                this.action = 'Add',
                this.officer_id = '',
                this.officer_name = '',
                this.username = '',
                this.password = '',
                this.level = ''
            },
            editData(officer){
                this.action = 'Edit',
                this.officer_id = officer.officer_id,
                this.officer_name = officer.officer_name,
                this.username = officer.username,
                this.password = officer.password,
                this.level = officer.level
            },
            saveData(){
                let form = {
                    'officer_name': this.officer_name,
                    'username': this.username,
                    'password': this.password,
                    'level': this.level
                }

                if(this.action === 'Add'){
                    this.axios.post('http://localhost:8000/api/officer', form)
                    .then(() => {
                        this.$swal({
                            title: 'Success' ,
                            text: 'Data has been added',
                            icon: 'success'
                        })
                        this.getData()
                    })
                }else {
                    this.axios.put('http://localhost:8000/api/officer/' + this.officer_id, form)
                    .then(() => {
                        this.$swal({
                            title: 'Success' ,
                            text: 'Data has been updated',
                            icon: 'success'
                        })
                        this.getData()
                    })
                }
            },
            removeData(id){
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    buttons: [true, 'Yes delete it']
                }).then(value => {
                    if(value.isConfirmed){
                        this.axios.delete('http://localhost:8000/api/officer/' + id)
                        .then(resp => {
                            if(resp.data.status === 'success'){
                                this.$swal({
                                    title: 'Success' ,
                                    text: 'Data has been added',
                                    icon: 'success'
                                })
                            }
                            this.getData()
                        })
                    }
                })
            }
        },
        mounted(){
            this.getData()
        }
    }
</script>
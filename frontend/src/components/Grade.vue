<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-evenly align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Grade Data</h6>
                <button class="btn btn-primary ml-5" v-on:click="addData()" type="button" data-toggle="modal" data-target="#addEditModal">Add Data</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Major</th>
                                <th>Generation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(grade, i) in grades" :key="i">
                                <td> {{ i + 1 }} </td>
                                <td> {{ grade.name }} </td>
                                <td> {{ grade.major }} </td>
                                <td> {{ grade.generation }} </td>
                                <td>
                                    <div class="d-flex justify-content-around align-items-center">
                                        <button class="btn btn-primary" v-on:click="editData(grade)" type="button" data-toggle="modal" data-target="#addEditModal"><i class="far fa-edit"></i></button>
                                        <button class="btn btn-danger" v-on:click="removeData(grade.grade_id)"><i class="far fa-trash-alt"></i></button>
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
                        <input id="name" type="text" v-model="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="major">Major</label>
                        <input id="major" type="text" v-model="major" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="generation">Generation</label>
                         <select class="form-control" id="class" v-model="generation" required>
                            <option 
                                v-for="tuition in tuitions" :key="tuition" 
                                :value="tuition.tuition_id"
                            > 
                                    {{ tuition.generation }} 
                            </option>
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
        name: 'grade-component',
        data(){
            return {
                grades: [],
                action: '',
                tuitions: [],

                // v-model 
                grade_id: '',
                name: '',
                major: '',
                generation: ''
            }
        },
        methods:{
            getData(){
                this.axios.get('http://localhost:8000/api/grade')
                .then(response => {
                    this.grades = response.data
                })

                this.axios.get('http://localhost:8000/api/tuition')
                .then(response => {
                    this.tuitions = response.data
                })
            },
            addData(){
                this.action = 'Add'
                this.name = ''
                this.major = ''
                this.generation = ''
            },
            editData(grade){
                console.log(grade);
                this.action = 'Edit',
                this.grade_id = grade.grade_id,
                this.name = grade.name
                this.major = grade.major
                this.generation = grade.tuition_id
            },
            saveData(){
                let form = {
                    'name': this.name,
                    'major': this.major,
                    'generation': this.generation
                }

                if(this.action == 'Add'){
                    this.axios.post('http://localhost:8000/api/grade', form)
                    .then( () => {
                        this.$swal({
                            title: 'Success' ,
                            text: 'Data has been added',
                            icon: 'success'
                        })
                        this.getData()
                    })
                }else {
                    this.axios.put('http://localhost:8000/api/grade/' + this.grade_id, form)
                    .then( () => {
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
                        this.axios.delete('http://localhost:8000/api/grade/' + id)
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
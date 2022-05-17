<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-evenly align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Tuition Data</h6>
                <button class="btn btn-primary ml-5" v-on:click="addData()" type="button" data-toggle="modal" data-target="#addDataModal">Add Data</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Generation</th>
                                <th>Year</th>
                                <th>Nominal</th>
                                <th>Start Payment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(tuition, i) in tuitions" :key="i">
                                <td> {{ i + 1 }} </td>
                                <td> {{ tuition.generation }} </td>
                                <td> {{ tuition.year }} </td>
                                <td> {{ tuition.nominal }} </td>
                                <td> {{ tuition.start_payment }} </td>
                                <td>
                                    <button class="btn btn-primary act disabled" v-on:click="editData(tuition)" type="button" data-toggle="modal" data-target="#editDataModal"><i class="far fa-edit"></i></button>
                                    <button class="btn btn-danger act disabled"><i class="far fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- modal add data  -->
        <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Generation</label>
                        <input type="text" v-model="generation" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Year</label>
                        <input type="text" v-model="year" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Nominal</label>
                        <input type="number" v-model="nominal" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Start Payment</label>
                        <input type="date" v-model="start_payment" class="form-control" v-on:keyup.enter="saveData()" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button v-on:click="saveData()" type="button" class="btn btn-primary" data-dismiss="modal">{{this.action}}</button>
                </div>
                </div>
            </div>
        </div>

        <!-- edit data modal  -->
        <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="" id="" v-model="tuition_id" class="form-control">

                    <div class="mb-3">
                        <label for="">Generation</label>
                        <input type="number" v-model="generation" class="form-control" required v-on:keyup.enter="saveData()" >
                    </div>

                    <div class="mb-3">
                        <label for="">Year</label>
                        <input type="number" v-model="year" class="form-control" required v-on:keyup.enter="saveData()" >
                    </div>

                    <div class="mb-3">
                        <label for="">Nominal</label>
                        <input type="number" step="50000" v-model="nominal" class="form-control" required v-on:keyup.enter="saveData()" >
                    </div>

                    <div class="mb-3">
                        <label for="">Start Payment</label>
                        <input type="date" v-model="start_payment" class="form-control" required v-on:keyup.enter="saveData()" >
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
import useVuelidate from '@vuelidate/core'
import { required } from '@vuelidate/validators'
export default {
    name: 'tuition-component',

    setup () {
        return { v$: useVuelidate() }
    },
    
    data() {
        return {
            tuitions: [],
            action: '',

            //v-model
            generation: '',
            year: '',
            nominal: '',
            start_payment: '',
            tuition_id: '',


        }
    },

    validations(){
        return{
            generation : { required },
            year : { required },
            nominal : { required },
            start_payment : { required },
        }
    },

    methods: {
        getData(){
            let token = {
                    headers : { "Authorization" : "Bearer " + localStorage.getItem("Authorization")}
            }

            this.axios.get('http://localhost:8000/api/tuition', token)
            .then( resp => {
                this.tuitions = resp.data
                console.log(this.tuitions);
            })
        },
        
        addData(){
            this.action = 'Add',
            this.generation = '',
            this.year = '',
            this.nominal = '',
            this.start_payment = ''
        },

        editData(tuition){
            this.action = 'Edit',
            this.generation = tuition.generation,
            this.year = tuition.year,
            this.nominal = tuition.nominal,
            this.start_payment = tuition.start_payment,
            this.tuition_id = tuition.tuition_id
        },

        saveData(){
            let data = {
                'tuition_id': this.tuition_id,
                'generation': this.generation,
                'year': this.year,
                'nominal': this.nominal,
                'start_payment': this.start_payment
            }

            if(this.action == 'Add'){
                let token = {
                    headers : { "Authorization" : "Bearer " + localStorage.getItem("Authorization")}
                }

                this.axios.post('http://localhost:8000/api/tuition', data, token)
                .then(() => {
                    this.$swal({
                        title: 'Success' ,
                        text: 'Data has been added',
                        icon: 'success'
                    })
                }) 
            }else {
                let token = {
                    headers : { "Authorization" : "Bearer " + localStorage.getItem("Authorization")}
                }

                this.axios.put('http://localhost:8000/api/tuition/' + this.tuition_id, data, token)
                .then(() => {
                    this.$swal({
                        title: 'Success' ,
                        text: 'Data has been updated',
                        icon: 'success'
                    })
                })
            }

            this.getData()
        }
    },
    mounted(){
        this.getData();
    }
}
</script>

<style scoped>
    .act{
        margin-left: 10px;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }

    input[type=number] {
        -moz-appearance:textfield; /* Firefox */
    }
</style>

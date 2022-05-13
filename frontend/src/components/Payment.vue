<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-evenly align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Payment History</h6>
                <button class="btn btn-primary ml-5" v-on:click="addData()" type="button" data-toggle="modal" data-target="#addDataModal">Add Data</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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
                    <div class="modal-body">
                    <div class="alert alert-primary" role="alert">
                        Payment date will be automatically set today
                    </div>

                    <div class="mb-3">
                        <label for="officer">Officer Name</label>
                        <select class="form-control" id="officer" v-model="officer_id" required>
                            <option 
                                v-for="officer in officers" :key="officer"
                                :value="officer.officer_id"
                            >
                                {{officer.username}} - {{officer.level}}  
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="student">Student Name</label>
                        <select class="form-control" id="student" v-model="student_id" @change="studentChange($event)">
                            <option 
                                v-for="student in students" :key="student"
                                :value="student.student_id"
                            >
                                {{student.student_name}} - {{student.name}}
                            </option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nominal">Nominal</label>
                        <input type="number" step="this.nominalPay" class="form-control" v-model="nominal" required>
                    </div>

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
    export default{
        name: 'payment-component',
        data(){
            return{
                payments: [],
                officers: [],
                students: [],
                action: '',
                selectedStudent: '',
                nominalPay: '',

                //v-model
                officer_id: '',
                student_id: '',
                nominal: '',
            }
        },
        methods:{
            getData(){
                this.axios.get('localhost:8000/api/payment')
                .then((resp) => {
                    this.payments = resp.data
                })

                this.axios.get('http://localhost:8000/api/officer')
                .then(response => {
                    this.officers = response.data
                    console.log(this.officers);
                })

                this.axios.get('http://localhost:8000/api/student')
                .then((resp) => {
                    this.students = resp.data
                })
            },
            studentChange(e){
                this.selectedStudent = e.target.selectedOptions[0].value;
                console.log(this.selectedStudent);
            },
            payMultiples(){
                //get nominal from student that being select from user
                this.axios.get('http://localhost:8000/api/student/' + this.selectedStudent)
                .then((resp) => {
                    this.nominalPay = resp.data.nominal
                    console.log(this.nominalPay);
                })
            },
            addData(){
                this.action = 'Add';
                
            },

        },
        mounted(){
            this.getData()
        }
    }
</script>

<style scoped>
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
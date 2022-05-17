<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-evenly align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Students Data</h6>
                <button class="btn btn-primary ml-5" v-on:click="addData()" type="button" data-toggle="modal" data-target="#addEditModal">Add Data</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Generation</th>
                                <th>Bill</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(student, i) in students" :key="i">
                                <td> {{i+1}} </td>
                                <td> {{student.student_name}} </td>
                                <td> {{student.grade_name}} </td>
                                <td> {{student.tuition_generation}} </td>
                                <td> Rp.{{student.bill}} </td>
                                <td>
                                    <div class="d-flex justify-content-around align-items-center">
                                        <!-- <template v-if="user_type === 'admin'"> -->
                                            <button class="btn btn-success" v-if="user_type === 'admin'? '' : 'disabled' " v-on:click="detailData(student)" type="button" data-toggle="modal" data-target="#detailModal"><i class="far fa-address-card"></i></button>
                                            
                                            <template v-if="student.image == null">
                                                <button class="btn btn-warning" v-on:click="editData(student)" type="button" data-toggle="modal" data-target="#photoModal"><i class="far fa-file-image"></i></button>
                                            </template>
                                            <template v-else>
                                                <button class="btn btn-success" v-on:click="editData(student)" type="button" data-toggle="modal" data-target="#photoModal"><i class="far fa-file-image"></i></button>
                                            </template>
                                            
                                            <button class="btn btn-info" type="button" data-toggle="modal" data-target="#detailPayment" v-on:click="getDetailPayment(student.student_id)"><i class="bi bi-card-list"></i></button>
                                            <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#historyPayment" v-on:click="getHistoryPayment(student.student_id)"><i class="bi bi-clock-history"></i></button>
                                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addEditModal" v-on:click="editData(student)"><i class="far fa-edit"></i></button>
                                            <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                        <!-- </template> -->
                                        <!-- <template v-else>
                                            <button class="btn btn-success" disabled v-on:click="detailData(student)" type="button" data-toggle="modal" data-target="#detailModal"><i class="far fa-address-card"></i></button>
                                            
                                            <template v-if="student.image == null">
                                                <button class="btn btn-warning" disabled v-on:click="editData(student)" type="button" data-toggle="modal" data-target="#photoModal"><i class="far fa-file-image"></i></button>
                                            </template>
                                            <template v-else>
                                                <button class="btn btn-success" disabled v-on:click="editData(student)" type="button" data-toggle="modal" data-target="#photoModal"><i class="far fa-file-image"></i></button>
                                            </template>
                                            
                                            <button class="btn btn-info" disabled type="button" data-toggle="modal" data-target="#detailPayment" v-on:click="getDetailPayment(student.student_id)"><i class="bi bi-card-list"></i></button>
                                            <button class="btn btn-secondary" disabled type="button" data-toggle="modal" data-target="#historyPayment" v-on:click="getHistoryPayment(student.student_id)"><i class="bi bi-clock-history"></i></button>
                                            <button class="btn btn-primary" disabled type="button" data-toggle="modal" data-target="#addEditModal" v-on:click="editData(student)"><i class="far fa-edit"></i></button>
                                            <button class="btn btn-danger" disabled><i class="far fa-trash-alt"></i></button>
                                        </template> -->
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- modal detail  -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{student.student_name}} - {{student.grade_name}}</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <img :src="'http://localhost:8000/' + 'student_images/' + student.image" alt="" class="img-fluid">
                        </div>
                        <div class="col-md">
                            <ul class="list-group">
                                <li class="list-group-item"><strong>NISN : </strong> {{student.nisn}} </li>
                                <li class="list-group-item"><strong>NIS : </strong> {{student.nis}} </li>
                                <li class="list-group-item"><strong>Major : </strong> {{student.major}} </li>
                                <li class="list-group-item"><strong>Phone : </strong> {{student.phone}} </li>
                                <li class="list-group-item"><strong>Address : </strong> {{student.address}} </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
        </div>

        <!-- student photo modal  -->
        <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Photo </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <!-- <label for="">Student Photo</label> -->
                        <input type="file" ref="file" @change="uploadPhoto()" class="form-control" required>
                    </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button v-on:click="upload(student_id)" type="button" class="btn btn-primary" data-dismiss="modal">Upload</button>
                </div>
                </div>
            </div>
        </div>

        <!-- modal add data  -->
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
                        <label for="">NISN</label>
                        <input type="text" v-model="nisn" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="">NIS</label>
                        <input type="text" v-model="nis" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" v-model="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Grade</label>
                        <select class="form-control" id="class" v-model="grade" required>
                            <option 
                                v-for="grade in grades" :key="grade" 
                                :value="grade.grade_id"
                            > 
                                    {{ grade.name }} 
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="">Address</label>
                        <input type="text" v-model="address" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Phone</label>
                        <input type="text" v-model="phone" class="form-control" required>
                    </div>
                        
                </div>
                <div class="modal-footer">
                    <button v-on:click="saveData()" type="button" class="btn btn-primary" data-dismiss="modal">{{this.action}}</button>
                </div>
                </div>
            </div>
        </div>

        <!-- modal detail payment  -->
        <div class="modal fade" id="detailPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Payment</h5>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Nominal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(detail, i) in detailPayment" :key="i">
                                <td> {{ i + 1 }} </td>
                                <td> {{ detail.date }} </td>
                                <td> {{ detail.nominal }} </td>
                                <td>
                                    <span class="badge badge-danger">Not Paid</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
                </div>
            </div>
        </div>

        <!-- modal history Payment -->
        <div class="modal fade" id="historyPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">History Payment</h5>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Payment Date</th>
                                <th>Nominal</th>
                                <th>Tuition For</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, i) in historyPayment" :key="i">
                                <td> {{ i + 1 }} </td>
                                <td> {{ data.payment_date }} </td>
                                <td> {{ data.nominal }} </td>
                                <td> {{ data.tuition_date }} </td>
                                <td>
                                    <span class="badge badge-success">Paid</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    export default {
        name: 'student-component',
        data(){
            return{
                students: [],
                student : '',
                grades: [],
                action: '',
                noPhoto: [],
                detailPayment: [],
                historyPayment: [],
                chekPaymentStatus : '',
                user_type: '',

                //v-model
                nisn: '',
                nis: '',
                name: '',
                grade: '',
                address: '',
                phone: '',
                student_photo: '',
                
            }
        },
        methods: {
            getUserType(){
                this.user_type = localStorage.getItem('user_type')
            },
            getData(){
                let token = {
                    headers : { "Authorization" : "Bearer " + localStorage.getItem("Authorization")}
                }

                this.axios.get('http://localhost:8000/api/student', token)
                .then( resp => {
                    this.students = resp.data.data
                })

                this.axios.get('http://localhost:8000/api/grade', token)
                    .then( resp => {
                        this.grades = resp.data
                })

            },
            getDetailPayment(id){
                let token = {
                    headers : { "Authorization" : "Bearer " + localStorage.getItem("Authorization")}
                }
                this.axios.get('http://localhost:8000/api/studentBill/' + id, token)
                .then( resp => {
                    this.detailPayment = resp.data
                })
            },
            getHistoryPayment(id){
                let token = {
                    headers : { "Authorization" : "Bearer " + localStorage.getItem("Authorization")}
                }

                this.axios.get('http://localhost:8000/api/historyPayment/' + id, token)
                .then( resp => {
                    this.historyPayment = resp.data.data
                    console.log(this.historyPayment);
                })
            },
            detailData(student){
                this.student = student;
            },
            addData(){
                this.nisn = '',
                this.nis = '',
                this.name = '',
                this.grade = '',
                this.address = '',
                this.phone = '',
                this.action = 'Add'
            },
            editData(student){
                this.student_id = student.student_id,
                this.nisn = student.nisn,
                this.nis = student.nis,
                this.name = student.student_name,
                this.grade = student.grade_id,
                this.address = student.address,
                this.phone = student.phone,
                this.action = 'Edit'
            },
            saveData(){
                let form = {
                    'nisn': this.nisn,
                    'nis': this.nis,
                    'name': this.name,
                    'grade_id': this.grade,
                    'address': this.address,
                    'phone': this.phone
                }

                if(this.action === 'Add'){
                    let token = {
                        headers : { "Authorization" : "Bearer " + localStorage.getItem("Authorization")}
                    }

                    this.axios.post('http://localhost:8000/api/student', form, token)
                    .then( () => {
                        this.$swal({
                            title: 'Success' ,
                            text: 'Data has been added',
                            icon: 'success'
                        })
                        this.getData()
                    })
                }else {
                    let token = {
                        headers : { "Authorization" : "Bearer " + localStorage.getItem("Authorization")}
                    }

                    this.axios.put('http://localhost:8000/api/student/'+this.student_id, form, token)
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

            uploadPhoto(){
                 this.student_photo = this.$refs.file.files[0];
            },

            upload(id){
                let form = new FormData();
                form.append('student_photo', this.student_photo)
                
                let token = {
                    headers : { "Authorization" : "Bearer " + localStorage.getItem("Authorization")}
                }

                this.axios.post('http://localhost:8000/api/student/' + id, form, token)
                .then( () => {
                    this.$swal({
                        title: 'Success',
                        text: 'Upload Photo Success',
                        icon: 'success',
                        button: 'Ok'
                    })
                    this.getData()
                })

  
            },

            checkPhoto(){
                let token = {
                    headers : { "Authorization" : "Bearer " + localStorage.getItem("Authorization")}
                }

                this.axios.get('http://localhost:8000/api/cekPhoto/', token)
                .then( resp => {
                    this.noPhoto = resp.FormData
                })
            },

            chekPayment(id){
                let token = {
                    headers : { "Authorization" : "Bearer " + localStorage.getItem("Authorization")}
                }

                this.axios.get('http://localhost:8000/api/cekPayment/' + id, token)
                .then( resp => {
                    this.chekPaymentStatus = resp.data
                })
            },
            
        },
        mounted(){
            this.getData()
            this.checkPhoto()
        }
    }
</script>

<style scoped>
    .act{
        margin-left: 10px;
    }
</style>
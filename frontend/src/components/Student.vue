<template>
    <div>
        <!-- Page Heading -->
        <!-- <h1 class="h3 mb-2 text-gray-800">Students Data</h1> -->
       
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Student's Data</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Address</th>
                                <th>Bill</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(student, i) in students" :key="i">
                                <td> {{i+1}} </td>
                                <td> {{student.student_name}} </td>
                                <td> {{student.grade_name}} </td>
                                <td> {{student.address}} </td>
                                <td> Rp.{{student.bill}} </td>
                                <td>
                                    <button class="btn btn-success act" v-on:click="detailData(student)" type="button" data-toggle="modal" data-target="#detailModal"><i class="far fa-address-card"></i></button>
                                    <button class="btn btn-info act" v-on:click="editData(student)" type="button" data-toggle="modal" data-target="#photoModal"><i class="far fa-file-image"></i></button>
                                    <button class="btn btn-primary act"><i class="far fa-edit"></i></button>
                                    <button class="btn btn-danger act"><i class="far fa-trash-alt"></i></button>
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
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
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
                                <!-- <li class="list-group-item"><strong>Address : </strong> {{student.address}} </li> -->
                                <li class="list-group-item"><strong>Phone : </strong> {{student.phone}} </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                        <input type="file" ref="file"  @change="uploadPhoto()" class="form-control" required>
                    </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button v-on:click="upload(student_id)" type="button" class="btn btn-primary" data-dismiss="modal">Upload</button>
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
            }
        },
        created(){
            this.axios.get('http://localhost:8000/api/student')
            .then( resp => {
                console.log(resp.data);
                this.students = resp.data
            })
        },
        methods: {
            detailData(student){
                console.log(student);
                
                this.student = student;
            }
        }
    }
</script>

<style scoped>
    .act{
        margin-left: 10px;
    }
</style>
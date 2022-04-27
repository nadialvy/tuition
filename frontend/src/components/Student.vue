<template>
    <div>
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Students Data</h1>
       
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
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
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(student, i) in students" :key="i">
                                <td> {{i+1}} </td>
                                <td> {{student.student_name}} </td>
                                <td> {{student.grade_name}} </td>
                                <td> {{student.address}} </td>
                                <td> {{student.phone}} </td>
                                <td>
                                    <button class="btn btn-primary act"><i class="far fa-edit"></i></button>
                                    <button class="btn btn-danger act"><i class="far fa-trash-alt"></i></button>
                                    <button class="btn btn-info act"><i class="far fa-file-image"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                students: []
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

        }
    }
</script>

<style scoped>
    .act{
        margin-left: 10px;
    }
</style>
<template>
<div class="container">

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ 'Company Branches' }}</h3>

                    <div class="card-tools">
                        <button class="btn btn-success" @click="newModal">{{'Add New Branch'}}
                            <i class="fas fa-user-plus fa-fw"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ 'SNO.' }}</th>
                                <th>{{ 'Branch Name' }}</th>
                                <th>{{ 'Branch Email' }}</th>
                                <th>{{ 'Branch Contact' }}</th>
                                <th>{{ 'Branch Address' }}</th>
                                <th>{{ 'Branch City' }}</th>
                                <th>{{ 'Branch Manager' }}</th>
                                <th>{{ 'Action' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="branch in branch.data" :key="branch.id">
                                <td>{{ branch.id }}</td>
                                <td>{{ branch.branchname }}</td>
                                <td>{{ branch.branchemail }}</td>
                                <td>{{ branch.branchphone }}</td>
                                <td>{{ branch.branchaddress| upText}}</td>
                                <td>{{ branch.branchcity| upText}}</td>
                                <td>{{ branch.branchmanager| upText}}</td>

                                <td>
                                    <a href="#" @click="editModal(branch)">
                                        <i class="fas fa-edit" style="display:inline-block;margin-right:1em;color:blue"></i>
                                    </a>

                                    <a href="#" @click="deleteBranch(branch.id)">
                                        <i class="fas fa-trash" style="color:red"></i>
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                   <div class="card-footer">
                    <pagination :data="branch" @pagination-change-page="getResults"></pagination>
        </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewlLabel">{{ 'New Branch ' }}</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewlLabel">{{ 'Edit Branch' }}</h5>
                </div>

                <form @submit.prevent="editmode ? updateBranch() : createBranch()">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" v-model="form.branchname" class="form-control" id="branchname" aria-describedby="nameHelp" placeholder="Branch Name" :class="{ 'is-invalid': form.errors.has('branchname') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <input type="email" v-model="form.branchemail" class="form-control" id="branchemail" aria-describedby="emailHelp" placeholder="Branch Email" :class="{ 'is-invalid': form.errors.has('branchemail') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <input type="tel" v-model="form.branchphone" class="form-control" id="branchphone" aria-describedby="phoneHelp" placeholder="Branch Phone number " :class="{ 'is-invalid': form.errors.has('branchphone') }">
                            <has-error :form="form" field="phone"></has-error>
                        </div>

                        <div class="form-group">
                            <input type="textarea" v-model="form.branchaddress" class="form-control" id="branchaddress" aria-describedby="branchHelp" placeholder="Branch Address " :class="{ 'is-invalid': form.errors.has('branchaddress') }">
                            <has-error :form="form" field="address"></has-error>
                        </div>

                        <div class="form-group">
                            <input type="text" v-model="form.branchcity" class="form-control" id="branchcity" aria-describedby="cityHelp" placeholder="Branch City " :class="{ 'is-invalid': form.errors.has('branchcity') }">
                            <has-error :form="form" field="city"></has-error>
                        </div>

                        <div class="form-group">
                            <input type="text" v-model="form.branchmanager" class="form-control" id="branchmanager" aria-describedby="branchmanagerHelp" placeholder="Branch Manager Name " :class="{ 'is-invalid': form.errors.has('branchmanager') }">
                            <has-error :form="form" field="manager"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ 'Close' }}</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">{{ 'Add Branch' }}</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">{{ 'Update Branch' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
</template>

<script>
import Vue from 'vue'
import {
    Form,
    HasError,
    AlertError
} from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

export default {
    data() {
        return {
            editmode: false,
            branch: {},
            form: new Form({
                id: '',
                branchname: '',
                branchemail: '',
                branchphone: '',
                branchaddress: '',
                branchcity: '',
                branchmanager: ''

            })
        }
    },

    methods: {

         getResults(page = 1) {
			axios.get('api/branch?page=' + page)
				.then(response => {
					this.branch = response.data;
				});
		},

        updateBranch() {
            this.$Progress.start();
            this.form.put('api/branch/' + this.form.id)
                .then(() => {

                    $('#addNew').modal('hide');
                    Refresh.$emit('RefreshResult');
                    swal.fire(
                        'Updated!',
                        'Branch has been Updated.',
                        'success'
                    );

                    this.progress.finish();

                })
                .catch(() => {
                    //this.$Progress.fail();
                    this.$Progress.fail();

                        toast.fire({
                                    icon: 'warning',
                                    title: 'Something wrong....',
                                 });
                    //swal("Failed", "Something Went wrong.", "warning");
                });
        },

        editModal(branch) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(branch);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        deleteBranch(id) {

            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                //send request to server
                if (result.value) {
                    this.form.delete('api/branch/' + id)
                        .then(() => {

                            swal.fire(
                                'Deleted!',
                                'Branch has been deleted.',
                                'success'
                            )

                            Refresh.$emit('RefreshResult');
                        })
                        .catch(() => {
                            this.$Progress.fail();

                        toast.fire({
                                    icon: 'warning',
                                    title: 'Something wrong....',
                                 });
                           // swal("Failed", "Something Went wrong.", "warning");
                        });
                }

            })

        },

        loadBranch() {
            axios.get("api/branch").then(({
                data
            }) => (this.branch = data));
        },
        createBranch() {
            this.$Progress.start();
            this.form.post('api/branch')
                .then(() => {

                    Refresh.$emit('RefreshResult');
                    $('#addNew').modal('hide');

                    toast.fire({
                        icon: 'success',
                        title: 'Branch created successfully'
                    })

                    this.$Progress.finish();

                })
                .catch(() => {
                    this.$Progress.fail();

                        toast.fire({
                                    icon: 'warning',
                                    title: 'Something wrong....',
                                 });
                    //swal("Failed", "Something Went wrong.", "warning");
                })

        }

    },
    created() {
        this.loadBranch();
        Fire.$on('searching', () => {
             let query=this.$parent.search;
            axios.get('api/findBranch?q='+ query)
            .then((data)=>{
                this.branch = data.data
            })
            .catch(()=>{

            });
        });
        Refresh.$on('RefreshResult', () => {
            this.loadBranch();
        });
        //setInterval(() => this.loadCompany(), 1000);
    }
}
</script>

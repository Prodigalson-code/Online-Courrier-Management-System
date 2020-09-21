<template>
<div class="container">

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ 'Company Details' }}</h3>

                    <div class="card-tools">
                        <button class="btn btn-success" @click="newModal">{{'Add New Company'}}
                            <i class="fas fa-user-plus fa-fw"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>

                                <th>{{ 'Name' }}</th>
                                <th>{{ 'Logo' }}</th>
                                <th>{{ 'Address' }}</th>
                                <th>{{ 'City' }}</th>
                                <th>{{ 'Phone' }}</th>
                                <th>{{ 'Email' }}</th>
                                <th>{{ 'Gst' }}</th>
                                <th>{{ 'Action' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="company in company" :key="company.id">

                                <td>{{ company.companyname }}</td>
                                <td><img class="img-circle elevation-2 " :src="getPhoto(company.companylogo)" style="max-height: 100px; max-width: 100px;" alt="User Avatar"></td>
                                <td>{{ company.companyaddress | upText }}</td>
                                <td>{{ company.companycity | upText }}</td>
                                <td>{{ company.companyphone }}</td>
                                <td>{{ company.companyemail }}</td>
                                <td>{{ company.companygst}}</td>

                                <td>
                                    <a href="#" @click="editModal(company)">
                                        <i class="fas fa-edit" style="display:inline-block;margin-right:1em;color:blue"></i>
                                    </a>

                                    <a href="#" @click="deleteCompany(company.id)">
                                        <i class="fas fa-trash" style="color:red"></i>
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewlLabel">{{ 'New Company ' }}</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewlLabel">{{ 'Edit Company' }}</h5>
                </div>

                <form @submit.prevent="editmode ? updateCompany() : createCompany()" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" v-model="form.companyname" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <input type="file" class="form-control" id="logo" @change="onFileChange" aria-describedby="logoHelp" placeholder="Logo" :class="{ 'is-invalid': form.errors.has('logo') }">

                            <has-error :form="form" field="logo"></has-error>
                        </div>

                        <div class="form-group">
                            <input type="text" v-model="form.companyaddress" class="form-control" id="address" aria-describedby="addressHelp" placeholder="address " :class="{ 'is-invalid': form.errors.has('address') }">
                            <has-error :form="form" field="address"></has-error>
                        </div>

                        <div class="form-group">
                            <input type="text" v-model="form.companycity" class="form-control" id="city" aria-describedby="cityHelp" placeholder="city" :class="{ 'is-invalid': form.errors.has('city') }">
                            <has-error :form="form" field="city"></has-error>
                        </div>

                        <div class="form-group">
                            <input type="tel" v-model="form.companyphone" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="phone" :class="{ 'is-invalid': form.errors.has('phone') }">
                            <has-error :form="form" field="phone"></has-error>
                        </div>

                        <div class="form-group">
                            <input type="email" v-model="form.companyemail" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <input type="text" v-model="form.companygst" class="form-control" id="gst" aria-describedby="gstHelp" placeholder="gst " :class="{ 'is-invalid': form.errors.has('gst') }">
                            <has-error :form="form" field="gst"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ 'Close' }}</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">{{ 'Add Company' }}</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">{{ 'Update Company' }}</button>
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

            company: {},
            form: new Form({
                id: '',
                companyname: '',
                companylogo: '',
                companyaddress: '',
                companycity: '',
                companyphone: '',
                companyemail: '',
                companygst: '',

            })
        }
    },

    methods: {

        getPhoto(event) {
            let companylogo = (event.length > 50) ? event : "img/logo/" + event;
            return companylogo;
        },

        onFileChange(event) {
            let file = event.target.files[0];
            console.log(file);
            let reader = new FileReader();
            if (file['size'] < 2111775) {

                reader.onloadend = (file) => {
                    // console.log('RESULT', reader.result)
                    this.form.companylogo = reader.result;
                }
                reader.readAsDataURL(file);

            } else {
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'the file size is larger than 2MB',
                })
            }

        },

        updateCompany() {
            //onFileChange(this.form.companylogo);
            this.$Progress.start();
            this.form.put('api/company/' + this.form.id)
                .then(() => {

                    $('#addNew').modal('hide');
                    Refresh.$emit('RefreshResult');
                    swal.fire(
                        'Updated!',
                        'Company has been Updated.',
                        'success'
                    );

                    this.$progress.finish();

                })
                .catch(() => {
                    this.$Progress.fail();
                      toast.fire({
                        icon: 'warning',
                        title: 'Something went wrong...'
                    });
                    //swal("Failed", "Something Went wrong.", "warning");

                });
        },

        editModal(company) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(company);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        deleteCompany(id) {

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
                    this.form.delete('api/company/' + id)
                        .then(() => {

                            swal.fire(
                                'Deleted!',
                                'Company has been deleted.',
                                'success'
                            )

                            Refresh.$emit('RefreshResult');
                        })
                        .catch(() => {
                            this.$Progress.fail();
                              toast.fire({
                                        icon: 'warning',
                                        title: 'Something went wrong...'
                                    });
                           // swal("Failed", "Something Went wrong.", "warning");
                        });
                }

            })

        },

        loadCompany() {
            axios.get("api/company").then(({
                data
            }) => (this.company = data.data));
        },
        createCompany() {
            this.$Progress.start();
            // form.append('companylogo', this.companylogo);
            this.form.post('api/company')
                .then(() => {

                    Refresh.$emit('RefreshResult');
                    $('#addNew').modal('hide');

                    swal.fire(
                                'Created!',
                                'Company has been created successfully.',
                                'success'
                            );

                    this.$Progress.finish();

                })
                .catch(() => {
                    this.$Progress.fail();
                     toast.fire({
                        icon: 'warning',
                        title: 'Something went wrong...'
                    });
                   // swal("Failed", "Something Went wrong.", "warning");
                });

        }

    },
    created() {
        this.loadCompany();
        Refresh.$on('RefreshResult', () => {
            this.loadCompany();
        });
        //setInterval(() => this.loadCompany(), 1000);
    }
}
</script>

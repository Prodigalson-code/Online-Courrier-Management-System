<template>
<div class="container">

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ 'About a Company' }}</h3>

                    <div class="card-tools">
                        <button class="btn btn-success" @click="newModal">{{'Create'}}
                            <i class="fas fa-user-plus fa-fw"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                    <div class="col-md-12 mt-2">

            <!-- Profile Image -->

            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{ 'About Us' }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" v-for="about in about.data" :key="about.id">
               <strong><i class="fas fa-book mr-1"></i>{{ 'Title' }}</strong>

                <p class="text-muted">
                  {{ about.title }}
                </p>

                <hr>
                <strong><i class="fas fa-book mr-1"></i>{{ 'Mission' }}</strong>

                <p class="text-muted">
                  {{ about.mission }}
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> {{ 'Vision' }}</strong>

                <p class="text-muted">{{ about.vision }}</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i>{{ 'Value' }}</strong>

                <p class="text-muted">
                 {{ about.value }}
                </p>

                <hr>


                <strong><i class="far fa-file-alt mr-1"></i> {{ 'Briefly Summary' }}</strong>

                <p class="text-muted">{{ about.description }}</p>

                 <button @click="editModal(about)" class="btn btn-primary">{{ 'edit' }}</button>

                 <button  @click="deleteAbout(about.id)" class="btn btn-danger">{{ 'Delete' }}</button>


              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
                    <h5 v-show="!editmode" class="modal-title" id="addNewlLabel">{{ 'create ' }}</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewlLabel">{{ 'Edit' }}</h5>
                </div>

                <form @submit.prevent="editmode ? updateAbout() : createAbout()">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" v-model="form.title" class="form-control" id="title" aria-describedby="nameHelp" placeholder="title" :class="{ 'is-invalid': form.errors.has('title') }">
                            <has-error :form="form" field="title"></has-error>
                        </div>

                        <div class="form-group">
                         <textarea class="form-control" v-model="form.mission" id="address" rows="10"  placeholder="mission" :class="{ 'is-invalid': form.errors.has('mission') }"></textarea>
                            <has-error :form="form" field="mission"></has-error>
                        </div>

                         <div class="form-group">
                         <textarea class="form-control" v-model="form.vision" id="address" rows="10"  placeholder="vision" :class="{ 'is-invalid': form.errors.has('vision') }"></textarea>
                            <has-error :form="form" field="vivion"></has-error>
                        </div>

                         <div class="form-group">
                         <textarea class="form-control" v-model="form.value" id="value" rows="10"  placeholder="value" :class="{ 'is-invalid': form.errors.has('value') }"></textarea>
                            <has-error :form="form" field="value"></has-error>
                        </div>

                         <div class="form-group">
                         <textarea class="form-control" v-model="form.description" id="description" rows="20"  placeholder="description" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                            <has-error :form="form" field="description"></has-error>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ 'Close' }}</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">{{ 'Save' }}</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">{{ 'Update' }}</button>
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
            about: {},
            form: new Form({
                id: '',
                title: '',
                mission: '',
                vision: '',
                value: '',
                description: '',
            })
        }
    },

    methods: {

         getResults(page = 1) {
			axios.get('api/about?page=' + page)
				.then(response => {
					this.branch = response.data;
				});
		},

        updateAbout() {
            this.$Progress.start();
            this.form.put('api/about/' + this.form.id)
                .then(() => {

                    $('#addNew').modal('hide');
                    Refresh.$emit('RefreshResult');
                    swal.fire(
                        'Updated!',
                        'Data has been Updated.',
                        'success'
                    );

                    this.$Progress.finish();

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

        editModal(about) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(about);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        deleteAbout(id) {

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
                    this.form.delete('api/about/' + id)
                        .then(() => {

                            swal.fire(
                                'Deleted!',
                                'Data has been deleted.',
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

        loadAbout() {
            axios.get("api/about").then(({
                data
            }) => (this.about = data));
        },
        createAbout() {
            this.$Progress.start();
            this.form.post('api/about')
                .then(() => {

                    Refresh.$emit('RefreshResult');
                    $('#addNew').modal('hide');

                    toast.fire({
                        icon: 'success',
                        title: 'Data saved successfully'
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
        this.loadAbout();
        Fire.$on('searching', () => {
             let query=this.$parent.search;
            axios.get('api/findAbout?q='+ query)
            .then((data)=>{
                this.about = data.data
            })
            .catch(()=>{

            });
        });
        Refresh.$on('RefreshResult', () => {
            this.loadAbout();
        });
        //setInterval(() => this.loadCompany(), 1000);
    }
}
</script>

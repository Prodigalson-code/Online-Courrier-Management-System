<template>
<div class="container">

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white"  style="background-color: #3d99f5;">
                    <h3 class="card-title">{{ 'Services of the  Company' }}</h3>

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
                <h3 class="card-title">{{ 'Our Services' }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" v-for="service in service.data" :key="service.id">
               <strong><i class="fas fa-book mr-1"></i>{{ 'Service Name' }}</strong>

                <p class="text-muted">
                  {{ service.service_name }}
                </p>

                <hr>
                <strong><i class="fas fa-book mr-1"></i>{{ 'Service Description' }}</strong>

                <p class="text-muted">
                  {{ service.description }}
                </p>

                <hr>

                 <button @click="editModal(service)" class="btn btn-primary">{{ 'edit' }}</button>

                 <button  @click="deleteAbout(service.id)" class="btn btn-danger">{{ 'Delete' }}</button>


              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
                <!-- /.card-body -->
                   <div class="card-footer">
                    <pagination :data="service" @pagination-change-page="getResults"></pagination>
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

                <form @submit.prevent="editmode ? updateService() : createService()">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" v-model="form.service_name" class="form-control" id="service_name" aria-describedby="nameHelp" placeholder="Name of service" :class="{ 'is-invalid': form.errors.has('service_name') }">
                            <has-error :form="form" field="service_name"></has-error>
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
            service: {},
            form: new Form({
                id: '',
                service_name: '',
                description: '',
            })
        }
    },

    methods: {

         getResults(page = 1) {
			axios.get('api/service?page=' + page)
				.then(response => {
					this.service = response.data;
				});
		},

        updateService() {
            this.$Progress.start();
            this.form.put('api/service/' + this.form.id)
                .then(() => {

                    $('#addNew').modal('hide');
                    Refresh.$emit('RefreshResult');
                    swal.fire(
                        'Updated!',
                        'Service has been Updated.',
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

        editModal(service) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(service);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        deleteService(id) {

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
                    this.form.delete('api/service/' + id)
                        .then(() => {

                            swal.fire(
                                'Deleted!',
                                'Service has been deleted.',
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

        loadService() {
            axios.get("api/service").then(({
                data
            }) => (this.service = data));
        },
        createService() {
            this.$Progress.start();
            this.form.post('api/service')
                .then(() => {

                    Refresh.$emit('RefreshResult');
                    $('#addNew').modal('hide');

                    toast.fire({
                        icon: 'success',
                        title: 'Service saved successfully'
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
        this.loadService();
        Fire.$on('searching', () => {
             let query=this.$parent.search;
            axios.get('api/findService?q='+ query)
            .then((data)=>{
                this.service = data.data
            })
            .catch(()=>{

            });
        });
        Refresh.$on('RefreshResult', () => {
            this.loadService();
        });
        //setInterval(() => this.loadCompany(), 1000);
    }
}
</script>

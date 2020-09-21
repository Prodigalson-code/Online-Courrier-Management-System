<template>
<div class="container">

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ 'Company News' }}</h3>

                    <div class="card-tools">
                        <button class="btn btn-success" @click="newModal">{{'Create News'}}
                            <i class="fas fa-user-plus fa-fw"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                     <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ 'title' }}</th>
                                <th>{{ 'description' }}</th>
                                <th>{{ 'Action' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="blog in blog.data" :key="blog.id">
                                <td>{{ blog.title }}</td>
                                <td>{{ blog.description }}</td>


                                <td>
                                    <a href="#" @click="editModal(blog)">
                                        <i class="fas fa-edit" style="display:inline-block;margin-right:1em;color:blue"></i>
                                    </a>

                                    <a href="#" @click="deleteNews(blog.id)">
                                        <i class="fas fa-trash" style="color:red"></i>
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>
                <!-- /.card-body -->
                   <div class="card-footer">
                    <pagination :data="blog" @pagination-change-page="getResults"></pagination>
        </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewlLabel">{{ 'Add News ' }}</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewlLabel">{{ 'Edit News' }}</h5>
                </div>

                <form @submit.prevent="editmode ? updateNews() : createNews()">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" v-model="form.title" class="form-control" id="title" aria-describedby="nameHelp" placeholder="Title" :class="{ 'is-invalid': form.errors.has('title') }">
                            <has-error :form="form" field="title"></has-error>
                        </div>

                         <div class="form-group">
                            <textarea class="form-control" name="description" v-model="form.description" rows="5" placeholder="description" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                            <has-error :form="form" field="description"></has-error>
                             <div class="validate"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ 'Close' }}</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">{{ 'Create News' }}</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">{{ 'Update News' }}</button>
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
            blog: {},
            form: new Form({
                id: '',
                title: '',
                description: ''
            })
        }
    },

    methods: {

         getResults(page = 1) {
			axios.get('api/blog?page=' + page)
				.then(response => {
					this.blog = response.data;
				});
		},

        updateNews() {
            this.$Progress.start();
            this.form.put('api/blog/' + this.form.id)
                .then(() => {

                    $('#addNew').modal('hide');
                    Refresh.$emit('RefreshResult');
                   toast.fire({
                        icon: 'success',
                        title: 'News Updated successfully'
                    })

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

        editModal(blog) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(blog);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        deleteNews(id) {

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
                    this.form.delete('api/blog/' + id)
                        .then(() => {

                            swal.fire(
                                'Deleted!',
                                'News has been deleted.',
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

        loadNews() {
            axios.get("api/blog").then(({
                data
            }) => (this.blog = data));
        },
        createNews() {
            this.$Progress.start();
            this.form.post('api/blog')
                .then(() => {

                    Refresh.$emit('RefreshResult');
                    $('#addNew').modal('hide');

                    toast.fire({
                        icon: 'success',
                        title: 'News created successfully'
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
        this.loadNews();
        Fire.$on('searching', () => {
             let query=this.$parent.search;
            axios.get('api/findBlog?q='+ query)
            .then((data)=>{
                this.blog = data.data
            })
            .catch(()=>{

            });
        });
        Refresh.$on('RefreshResult', () => {
            this.loadNews();
        });
        //setInterval(() => this.loadCompany(), 1000);
    }
}
</script>

<template>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-3">

            <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username text-left">{{ form.name }}</h3>
                    <h5 class="widget-user-desc text-left">{{ form.email }}</h5>
                </div>

                <div class="widget-user-image">
                    <img class="img-circle elevation-2 " :src="getPhoto()" alt="User Avatar">
                </div>
                <div class="card-footer">
                    <div class="row">

                    </div>
                    <!-- /.row -->
                </div>

            </div>

            <div class="card card-widget widget-user mt-3">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">{{ 'Activity' }}</a></li>
                        <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">{{ 'Settings' }}</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane" id="activity">
                            <!-- Post -->

                            <!-- /.post -->

                            <!-- Post -->

                            <!-- /.post -->

                            <!-- Post -->

                            <!-- /.tab-pane -->

                            <!-- /.timeline-label -->
                            <!-- timeline item -->

                            <!-- END timeline item -->
                            <!-- timeline item -->

                            <!-- END timeline item -->
                            <!-- timeline item -->

                            <!-- END timeline item -->
                            <!-- timeline time label -->

                            <!-- /.timeline-label -->
                            <!-- timeline item -->

                            <!-- END timeline item -->

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane active" id="settings">
                            <!--<form class="form-horizontal">-->

                            <div class="card-header">
                                <h3 class="card-title">Edit Profile</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form">

                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control" v-model="form.name" id="exampleInputText" placeholder="Enter Name" :class="{ 'is-invalid': form.errors.has('name') }">
                                        <has-error :form="form" field="name"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" v-model="form.email" id="email1" placeholder="Enter email" :class="{ 'is-invalid': form.errors.has('email') }">
                                        <has-error :form="form" field="email"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone Number</label>
                                        <input type="tel" class="form-control" v-model="form.phone" id="phone" placeholder="Enter Phone" :class="{ 'is-invalid': form.errors.has('phone') }">
                                        <has-error :form="form" field="phone"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" v-model="form.password" class="form-control" id="password" placeholder="Password" :class="{ 'is-invalid': form.errors.has('password') }">
                                        <has-error :form="form" field="password"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Profile Photo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" @change="updateProfile" id="exampleInputFile" :class="{ 'is-invalid': form.errors.has('image') }">
                                                <has-error :form="form" field="image"></has-error>
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" @click.prevent=" updateInfo" class="btn btn-success">Update</button>
                                </div>
                            </form>

                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->

        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            user: [],
            form: new Form({
                id: '',
                name: '',
                email: '',
                phone: '',
                type: '',
                password: '',
                photo: ''

            })
        }
    },

    methods: {

        getPhoto() {
            let img = (this.form.photo.length > 200) ? this.form.photo : "img/profile/" + this.form.photo;
            return img;
        },
        updateInfo() {
            this.$Progress.start();
            this.form.put('api/profile/')
                .then(() => {
                    this.$Progress.finish();
                    swal.fire(
                        'Updated!',
                        'Profile has been Updated.',
                        'success'
                    );
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },

        fillForm(){
               axios.get("api/profile")
            .then(({
                data
            }) => (this.form.fill(data)));
        },

        updateProfile(event) {
            //console.log('uploading');
            let file = event.target.files[0];
            console.log(file);
            let reader = new FileReader();
            if (file['size'] < 2111775) {

                reader.onloadend = (file) => {
                    // console.log('RESULT', reader.result)
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);

            } else {
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'the file size is larger than 2MB',
                })
            }

        }

    },
    mounted() {
        console.log('Component mounted.')
    },
    created() {
        axios.get("api/profile")
            .then(({
                data
            }) => (this.form.fill(data)));
            //this.fillForm();
            //thus.form.name=this.form.name;

    }
}
</script>

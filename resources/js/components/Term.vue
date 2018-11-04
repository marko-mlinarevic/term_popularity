<template>
    <div class="container">
        <div class="row content-wrapper">
            <div>
                <b-form @submit="onSubmit">
                    <b-form-group id="exampleInputGroup1"
                                  label="Popularity of term on Github(v1)"
                                  label-for="exampleInput1">
                        <b-form-input id="exampleInput1"
                                      v-model="form.term"
                                      placeholder="Enter term">
                        </b-form-input>
                    </b-form-group>
                    <b-button type="submit" variant="primary">Submit</b-button>
                </b-form>
                <div class="card card-default">
                    <div class="card-header">{{termInfo.title}}</div>
                    <div class="card-body">
                        Score: {{termInfo.score}}
                    </div>
                </div>
            </div>
            <div class="apitwo-wrapper">
                <b-form @submit="onSubmit2">
                    <b-form-group id="exampleInputGroup1"
                                  label="Popularity of term on Github(v2)"
                                  label-for="exampleInput1">
                        <b-form-input id="exampleInput1"
                                      v-model="form2.term"
                                      placeholder="Enter term">
                        </b-form-input>
                    </b-form-group>
                    <b-button type="submit" variant="primary">Submit</b-button>
                </b-form>
                <div class="card card-default">
                    <div class="card-header">{{termInfov2.title}}</div>
                    <div class="card-body">
                        Score: {{termInfov2.score}}<br>
                        Link: <a :href="termInfov2.link">{{termInfov2.link}}</a><br>
                        Id: {{termInfov2.id}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data () {
            return {
                form: {
                    term: '',
                },
                form2: {
                    term: '',
                },
                termInfo: {
                    title: '',
                    score: '',
                },
                termInfov2: {
                    title: '',
                    score: '',
                    id: '',
                    link: ''
                }
            }
        },
        methods: {
            onSubmit (evt) {
                evt.preventDefault();
                // Api call that passes data to search endpoint
                axios.post('api/term', {
                    term: this.form.term
                })
                    .then((response) => {
                        let info = response.data;
                        this.termInfo.title = info.term;
                        this.termInfo.score = info.score;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            onSubmit2 (evt) {
                evt.preventDefault();
                // Api call that passes data to search endpoint
                axios.post('api/v2/term', {
                    term: this.form2.term
                })
                    .then((response) => {
                        let info = response.data;
                        this.termInfov2.title = info.attributes.term;
                        this.termInfov2.score = info.attributes.score;
                        this.termInfov2.link = info.links.self;
                        this.termInfov2.id = info.id;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        },
        created(){
            // Api call for receiving auth token
            axios.get('/api/token')
                .then((response) => {
                    axios.defaults.headers.common = {
                        "Authorization": `Bearer ${response.data}`
                    };
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
</script>

<style lang="scss">
    .content-wrapper{
        display: flex;
        min-height: 100%;
        align-items: center;
        align-content: center;
        justify-content: space-around;
    }

    .apitwo-wrapper{
        padding-top: 45px;
    }
</style>
